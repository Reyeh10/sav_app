<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Proforma;
use App\Models\Sale;
use App\Models\Vehicle;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class ProformaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTE DES PROFORMAS
    |--------------------------------------------------------------------------
    */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));
        $status = trim((string) $request->input('status', ''));

        $query = Proforma::query()->with([
            'customer',
            'vehicle',
            'creator',
            'sale',
        ]);

        /*
        |--------------------------------------------------------------------------
        | RECHERCHE
        |--------------------------------------------------------------------------
        */
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $id = null;

                /*
                |--------------------------------------------------------------
                | Recherche par numéro de proforma
                | Exemple :
                | PROFORMA-000001
                | PROFORMA000001
                | 1
                |--------------------------------------------------------------
                */
                if (preg_match('/^PROFORMA[-\s]?0*(\d+)$/i', $search, $m)) {
                    $id = (int) $m[1];
                } elseif (ctype_digit($search)) {
                    $id = (int) $search;
                }

                if ($id) {
                    $q->where('id', $id);
                }

                /*
                |--------------------------------------------------------------------------
                | Recherche client
                |--------------------------------------------------------------------------
                */
                $q->orWhereHas('customer', function ($customerQuery) use ($search) {
                    $customerQuery
                        ->where('name', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });

                /*
                |--------------------------------------------------------------------------
                | Recherche véhicule
                |--------------------------------------------------------------------------
                */
                $q->orWhereHas('vehicle', function ($vehicleQuery) use ($search) {
                    $vehicleQuery
                        ->where('vin', 'like', '%' . $search . '%')
                        ->orWhere('brand', 'like', '%' . $search . '%')
                        ->orWhere('model', 'like', '%' . $search . '%')
                        ->orWhere('engine_number', 'like', '%' . $search . '%');
                });
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTRE PAR STATUT
        |--------------------------------------------------------------------------
        */
        if ($status !== '') {
            $query->where('status', $status);
        }

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */
        $proformas = $query
            ->orderByDesc('proforma_date')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('proformas.index', compact(
            'proformas',
            'search',
            'status'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | FORMULAIRE DE CRÉATION
    |--------------------------------------------------------------------------
    */
    public function create(): View
    {
        return view('proformas.create', [
            /*
            |--------------------------------------------------------------------------
            | Seuls les véhicules disponibles peuvent avoir un proforma
            |--------------------------------------------------------------------------
            */
            'vehicles' => Vehicle::query()
                ->where('status', 'Disponible')
                ->orderBy('brand')
                ->orderBy('model')
                ->get(),

            /*
            |--------------------------------------------------------------------------
            | Liste des clients
            |--------------------------------------------------------------------------
            */
            'customers' => Customer::query()
                ->orderBy('name')
                ->get(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CRÉATION D'UN PROFORMA DEPUIS UN VÉHICULE
    |--------------------------------------------------------------------------
    */
    public function createWithVehicle(
        Vehicle $vehicle
    ): View|RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Vérifier que le véhicule est encore disponible
        |--------------------------------------------------------------------------
        */
        if ($vehicle->status !== 'Disponible') {
            return redirect()
                ->route('vehicles.index')
                ->with(
                    'error',
                    'Ce véhicule n’est pas disponible.'
                );
        }

        return view('proformas.create', [
            'vehicles' => Vehicle::query()
                ->where('status', 'Disponible')
                ->orderBy('brand')
                ->orderBy('model')
                ->get(),

            'customers' => Customer::query()
                ->orderBy('name')
                ->get(),

            'selectedVehicle' => $vehicle,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ENREGISTRER LE PROFORMA
    |--------------------------------------------------------------------------
    */
    public function store(Request $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | NORMALISER LES MONTANTS
        |--------------------------------------------------------------------------
        |
        | Permet d'accepter :
        |
        | 4500000
        | 4 500 000
        | 4 500 000,50
        | 4500000,50
        |
        */

        $request->merge([
            'proforma_price' => $this->normalizeNumber(
                $request->input('proforma_price')
            ),

            'discount_amount' => $this->normalizeNumber(
                $request->input('discount_amount', 0)
            ),
        ]);

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */
        $validated = $request->validate(
            [
                'vehicle_id' => [
                    'required',
                    'integer',
                    'exists:vehicles,id',
                ],

                'customer_id' => [
                    'required',
                    'integer',
                    'exists:customers,id',
                ],

                'type_client' => [
                    'required',
                    'in:Particulier,Gouvernement,Para-public,Privee',
                ],

                'payment_type' => [
                    'required',
                    'in:Cash,Bon de commande,Echeance',
                ],

                'invoice_type' => [
                    'required',
                    'in:with_tax,without_tax',
                ],

                /*
                |--------------------------------------------------------------------------
                | Prix HT
                |--------------------------------------------------------------------------
                */
                'proforma_price' => [
                    'required',
                    'numeric',
                    'gt:0',
                    'max:999999999999.99',
                ],

                /*
                |--------------------------------------------------------------------------
                | Remise directement en montant
                |--------------------------------------------------------------------------
                */
                'discount_amount' => [
                    'nullable',
                    'numeric',
                    'min:0',
                    'max:999999999999.99',
                ],

                'valid_until' => [
                    'nullable',
                    'date',
                    'after_or_equal:today',
                ],

                'notes' => [
                    'nullable',
                    'string',
                    'max:3000',
                ],

                'show_free_services' => [
                    'nullable',
                    'boolean',
                ],
            ],
            [
                /*
                |--------------------------------------------------------------------------
                | Messages de validation
                |--------------------------------------------------------------------------
                */
                'vehicle_id.required' =>
                    'Veuillez sélectionner un véhicule.',

                'vehicle_id.exists' =>
                    'Le véhicule sélectionné est introuvable.',

                'customer_id.required' =>
                    'Veuillez sélectionner un client.',

                'customer_id.exists' =>
                    'Le client sélectionné est introuvable.',

                'type_client.required' =>
                    'Veuillez sélectionner le type de client.',

                'type_client.in' =>
                    'Le type de client sélectionné est invalide.',

                'payment_type.required' =>
                    'Veuillez sélectionner le type de paiement.',

                'payment_type.in' =>
                    'Le type de paiement sélectionné est invalide.',

                'invoice_type.required' =>
                    'Veuillez sélectionner le type de proforma.',

                'invoice_type.in' =>
                    'Le type de proforma sélectionné est invalide.',

                'proforma_price.required' =>
                    'Veuillez saisir le prix HT du véhicule.',

                'proforma_price.numeric' =>
                    'Le prix HT du véhicule doit être numérique.',

                'proforma_price.gt' =>
                    'Le prix HT du véhicule doit être supérieur à zéro.',

                'proforma_price.max' =>
                    'Le prix HT du véhicule est trop élevé.',

                'discount_amount.numeric' =>
                    'Le montant de la remise doit être numérique.',

                'discount_amount.min' =>
                    'Le montant de la remise ne peut pas être négatif.',

                'discount_amount.max' =>
                    'Le montant de la remise est trop élevé.',

                'valid_until.date' =>
                    'La date de validité est invalide.',

                'valid_until.after_or_equal' =>
                    'La date de validité ne peut pas être antérieure à aujourd’hui.',

                'notes.max' =>
                    'Les notes ne peuvent pas dépasser 3000 caractères.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | AFFICHAGE DE LA PARTIE 2
        |--------------------------------------------------------------------------
        |
        | Règle métier :
        |
        | - Proforma avec taxes  : la partie 2 reste toujours affichée.
        | - Proforma sans taxes  : l'utilisateur peut choisir de l'afficher
        |   ou de la masquer.
        |
        | Un checkbox HTML non coché n'est pas envoyé dans la requête.
        | request()->boolean() gère proprement ce cas.
        |
        */
        $showFreeServices =
            $validated['invoice_type'] === 'with_tax'
                ? true
                : $request->boolean('show_free_services');

        /*
        |--------------------------------------------------------------------------
        | CONVERSION DES MONTANTS
        |--------------------------------------------------------------------------
        */
        $price = round(
            $this->parseAmount($validated['proforma_price']),
            2
        );

        $discountAmount = round(
            $this->parseAmount(
                $validated['discount_amount'] ?? 0
            ),
            2
        );

        /*
        |--------------------------------------------------------------------------
        | CONTRÔLE DE LA REMISE
        |--------------------------------------------------------------------------
        |
        | La remise :
        |
        | - ne peut pas être négative
        | - ne peut pas dépasser le prix HT
        |
        */

        if ($discountAmount < 0) {
            return back()
                ->withInput()
                ->withErrors([
                    'discount_amount' =>
                        'Le montant de la remise ne peut pas être négatif.',
                ]);
        }

        if ($discountAmount > $price) {
            return back()
                ->withInput()
                ->withErrors([
                    'discount_amount' =>
                        'Le montant de la remise ne peut pas être supérieur au prix HT du véhicule.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CALCUL DU PROFORMA
        |--------------------------------------------------------------------------
        */

        /*
        | Prix HT après remise
        */
        $subtotalAfterDiscount = round(
            $price - $discountAmount,
            2
        );

        /*
        |--------------------------------------------------------------------------
        | TVA
        |--------------------------------------------------------------------------
        |
        | Proforma avec taxes  = TVA 10 %
        | Proforma sans taxes  = TVA 0 %
        |
        */
        if ($validated['invoice_type'] === 'with_tax') {
            $taxRate = 10;

            $taxAmount = round(
                $subtotalAfterDiscount * 0.10,
                2
            );
        } else {
            $taxRate = 0;
            $taxAmount = 0;
        }

        /*
        |--------------------------------------------------------------------------
        | TOTAL TTC
        |--------------------------------------------------------------------------
        */
        $totalAmount = round(
            $subtotalAfterDiscount + $taxAmount,
            2
        );

        /*
        |--------------------------------------------------------------------------
        | ENREGISTREMENT
        |--------------------------------------------------------------------------
        */
        try {
            $proforma = DB::transaction(
                function () use (
                    $validated,
                    $price,
                    $discountAmount,
                    $subtotalAfterDiscount,
                    $taxRate,
                    $taxAmount,
                    $totalAmount,
                    $showFreeServices
                ) {
                    /*
                    |--------------------------------------------------------------------------
                    | Verrouiller le véhicule
                    |--------------------------------------------------------------------------
                    |
                    | Cela évite que deux utilisateurs créent une transaction
                    | sur le même véhicule exactement au même moment.
                    |
                    */
                    $vehicle = Vehicle::query()
                        ->lockForUpdate()
                        ->findOrFail(
                            $validated['vehicle_id']
                        );

                    /*
                    |--------------------------------------------------------------------------
                    | Vérification finale du statut
                    |--------------------------------------------------------------------------
                    */
                    if ($vehicle->status !== 'Disponible') {
                        throw new \RuntimeException(
                            'Ce véhicule n’est plus disponible.'
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | CRÉER LE PROFORMA
                    |--------------------------------------------------------------------------
                    */
                    return Proforma::create([
                        'vehicle_id' => $vehicle->id,

                        'customer_id' =>
                            $validated['customer_id'],

                        'created_by' =>
                            auth()->id(),

                        /*
                        |--------------------------------------------------------------------------
                        | Prix HT avant remise
                        |--------------------------------------------------------------------------
                        */
                        'proforma_price' =>
                            $price,

                        /*
                        |--------------------------------------------------------------------------
                        | Ancien champ conservé à zéro
                        |--------------------------------------------------------------------------
                        |
                        | Important :
                        | votre ancienne structure utilisait encore
                        | discount_percent.
                        |
                        | Nous le gardons temporairement à 0 pour éviter
                        | une erreur SQL si cette colonne existe et est
                        | obligatoire.
                        |
                        */
                        'discount_percent' => 0,

                        /*
                        |--------------------------------------------------------------------------
                        | Nouvelle remise en montant
                        |--------------------------------------------------------------------------
                        */
                        'discount_amount' =>
                            $discountAmount,

                        'invoice_type' =>
                            $validated['invoice_type'],

                        /*
                        |--------------------------------------------------------------------------
                        | Affichage de la partie 2
                        |--------------------------------------------------------------------------
                        */
                        'show_free_services' =>
                            $showFreeServices,

                        'type_client' =>
                            $validated['type_client'],

                        'payment_type' =>
                            $validated['payment_type'],

                        'status' => 'Validé',

                        'proforma_date' => now(),

                        'valid_until' =>
                            $validated['valid_until'] ?? null,

                        'notes' =>
                            $validated['notes'] ?? null,
                    ]);
                }
            );

            /*
            |--------------------------------------------------------------------------
            | REDIRECTION
            |--------------------------------------------------------------------------
            */
            return redirect()
                ->route(
                    'proformas.show',
                    $proforma
                )
                ->with(
                    'success',
                    'Le proforma a été créé avec succès.'
                );
        } catch (\RuntimeException $e) {
            return back()
                ->withErrors([
                    'vehicle_id' => $e->getMessage(),
                ])
                ->withInput();
        } catch (Throwable $e) {
            Log::error(
                'Création proforma impossible.',
                [
                    'message' => $e->getMessage(),
                    'user_id' => auth()->id(),

                    /*
                    |--------------------------------------------------------------------------
                    | Informations utiles pour le debug
                    |--------------------------------------------------------------------------
                    */
                    'price' => $price,
                    'discount_amount' => $discountAmount,
                    'subtotal_after_discount' => $subtotalAfterDiscount,
                    'tax_rate' => $taxRate,
                    'tax_amount' => $taxAmount,
                    'total_amount' => $totalAmount,
                ]
            );

            return back()
                ->with(
                    'error',
                    'La création du proforma a échoué.'
                )
                ->withInput();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | AFFICHER UN PROFORMA
    |--------------------------------------------------------------------------
    */
    public function show(Proforma $proforma): View
    {
        $proforma->load([
            'customer',
            'vehicle',
            'creator',
            'sale',
        ]);

        return view(
            'proformas.show',
            compact('proforma')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MODIFIER UN PROFORMA
    |--------------------------------------------------------------------------
    |
    | Seuls le prix HT et la date de validité sont modifiables ici.
    | Un proforma annulé ou expiré ne peut plus être modifié.
    |
    */
    public function edit(
        Proforma $proforma
    ): View|RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Vérifier le statut
        |--------------------------------------------------------------------------
        */

       if (
        in_array(
            $proforma->status,
            ['Annulé', 'Expiré'],
            true
        )
    ) {
        return redirect()
            ->route('proformas.show', $proforma)
            ->with(
                'error',
                'Ce proforma ne peut plus être modifié.'
            );
    }

        /*
        |--------------------------------------------------------------------------
        | Charger les relations utiles pour la page d'édition
        |--------------------------------------------------------------------------
        */

        $proforma->load([
            'customer',
            'vehicle',
            'creator',
            'sale',
        ]);

        return view(
            'proformas.edit',
            compact('proforma')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | METTRE À JOUR UN PROFORMA
    |--------------------------------------------------------------------------
    |
    | Modifications autorisées :
    |
    | - prix HT du véhicule
    | - date de validité
    | - affichage/masquage de la partie 2 pour un proforma sans taxes
    |
    | La date maximale reste limitée à 7 jours à compter de la date
    | de création du proforma.
    |
    */
    public function update(
        Request $request,
        Proforma $proforma
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Interdire la modification de certains statuts
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                $proforma->status,
                ['Annulé', 'Expiré'],
                true
            )
        ) {
            return redirect()
                ->route(
                    'proformas.show',
                    $proforma
                )
                ->with(
                    'error',
                    'Ce proforma ne peut plus être modifié.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Normaliser le prix
        |--------------------------------------------------------------------------
        |
        | Exemples acceptés :
        |
        | 4500000
        | 4 500 000
        | 4 500 000,50
        | 4500000,50
        | 4.500.000,50
        |
        */

        $request->merge([
            'proforma_price' => $this->normalizeNumber(
                $request->input('proforma_price')
            ),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Calculer la date maximale de validité
        |--------------------------------------------------------------------------
        */

        $creationDate =
            $proforma->proforma_date
            ?? $proforma->created_at
            ?? now();

        $maximumValidityDate =
            \Carbon\Carbon::parse($creationDate)
                ->startOfDay()
                ->addDays(7)
                ->format('Y-m-d');

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
            [
                'proforma_price' => [
                    'required',
                    'numeric',
                    'gt:0',
                    'max:999999999999.99',
                ],

                'valid_until' => [
                    'required',
                    'date',
                    'after_or_equal:today',
                    'before_or_equal:' . $maximumValidityDate,
                ],

                'show_free_services' => [
                    'nullable',
                    'boolean',
                ],
            ],
            [
                'proforma_price.required' =>
                    'Veuillez saisir le prix HT du véhicule.',

                'proforma_price.numeric' =>
                    'Le prix HT du véhicule doit être numérique.',

                'proforma_price.gt' =>
                    'Le prix HT du véhicule doit être supérieur à zéro.',

                'proforma_price.max' =>
                    'Le prix HT du véhicule est trop élevé.',

                'valid_until.required' =>
                    'Veuillez sélectionner la date de validité.',

                'valid_until.date' =>
                    'La date de validité est invalide.',

                'valid_until.after_or_equal' =>
                    'La date de validité ne peut pas être antérieure à aujourd’hui.',

                'valid_until.before_or_equal' =>
                    'La date de validité ne peut pas dépasser 7 jours après la création du proforma.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | AFFICHAGE DE LA PARTIE 2
        |--------------------------------------------------------------------------
        |
        | Avec taxes :
        | la partie 2 reste toujours affichée.
        |
        | Sans taxes :
        | l'utilisateur peut l'afficher ou la masquer.
        |
        */
        $showFreeServices =
            $proforma->invoice_type === 'with_tax'
                ? true
                : $request->boolean('show_free_services');

        /*
        |--------------------------------------------------------------------------
        | Convertir le prix
        |--------------------------------------------------------------------------
        */

        $price = round(
            $this->parseAmount(
                $validated['proforma_price']
            ),
            2
        );

        /*
        |--------------------------------------------------------------------------
        | Vérifier la remise déjà enregistrée
        |--------------------------------------------------------------------------
        |
        | Si le proforma possède déjà une remise, le nouveau prix ne doit
        | pas devenir inférieur à cette remise.
        |
        */

        $discountAmount = round(
            (float) ($proforma->discount_amount ?? 0),
            2
        );

        if ($discountAmount > $price) {
            return back()
                ->withInput()
                ->withErrors([
                    'proforma_price' =>
                        'Le nouveau prix HT ne peut pas être inférieur à la remise déjà enregistrée sur ce proforma.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | ENREGISTREMENT
        |--------------------------------------------------------------------------
        */

        try {
            DB::transaction(
                function () use (
                    $proforma,
                    $price,
                    $validated,
                    $showFreeServices
                ) {
                    /*
                    |--------------------------------------------------------------------------
                    | Verrouiller le proforma pendant la modification
                    |--------------------------------------------------------------------------
                    */

                    $locked = Proforma::query()
                        ->lockForUpdate()
                        ->findOrFail(
                            $proforma->id
                        );

                    /*
                    |--------------------------------------------------------------------------
                    | Revérifier le statut après verrouillage
                    |--------------------------------------------------------------------------
                    */

                    if (
                        in_array(
                            $locked->status,
                            ['Annulé', 'Expiré'],
                            true
                        )
                    ) {
                        throw new \RuntimeException(
                            'Ce proforma ne peut plus être modifié.'
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Mise à jour des seuls champs autorisés
                    |--------------------------------------------------------------------------
                    */

                    $locked->update([
                        'proforma_price' =>
                            $price,

                        'valid_until' =>
                            $validated['valid_until'],

                        'show_free_services' =>
                            $showFreeServices,
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | Synchroniser la vente si le proforma est déjà converti
                    |--------------------------------------------------------------------------
                    |
                    | Cela évite d'avoir un prix différent entre le proforma
                    | et la facture après modification.
                    |
                    */

                    if (
                        $locked->status === 'Converti'
                        && $locked->sale_id
                    ) {
                        $sale = Sale::query()
                            ->lockForUpdate()
                            ->find(
                                $locked->sale_id
                            );

                        if ($sale) {
                            $sale->update([
                                'sold_price' =>
                                    $price,
                            ]);
                        }
                    }
                }
            );

            return redirect()
                ->route(
                    'proformas.show',
                    $proforma
                )
                ->with(
                    'success',
                    'Le proforma a été modifié avec succès.'
                );
        } catch (\RuntimeException $e) {
            return redirect()
                ->route(
                    'proformas.show',
                    $proforma
                )
                ->with(
                    'error',
                    $e->getMessage()
                );
        } catch (Throwable $e) {
            Log::error(
                'Modification du proforma impossible.',
                [
                    'proforma_id' =>
                        $proforma->id,

                    'user_id' =>
                        auth()->id(),

                    'message' =>
                        $e->getMessage(),

                    'price' =>
                        $price,

                    'valid_until' =>
                        $validated['valid_until'] ?? null,

                    'show_free_services' =>
                        $showFreeServices ?? null,
                ]
            );

            return back()
                ->withInput()
                ->with(
                    'error',
                    'La modification du proforma a échoué.'
                );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | TÉLÉCHARGER LE PDF
    |--------------------------------------------------------------------------
    */
    public function download(Proforma $proforma)
    {
        $proforma->load([
            'customer',
            'vehicle',
            'creator',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Sécuriser le nom du fichier
        |--------------------------------------------------------------------------
        */
        $safeNumber = preg_replace(
            '/[^A-Za-z0-9\-_]/',
            '-',
            $proforma->proforma_number
        );

        /*
        |--------------------------------------------------------------------------
        | Générer le PDF
        |--------------------------------------------------------------------------
        */
        return Pdf::loadView(
            'proformas.pdf',
            [
                'proforma' => $proforma,
                'isPdf' => true,
            ]
        )
            ->setPaper(
                'a4',
                'portrait'
            )
            ->download(
                $safeNumber . '.pdf'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | CONVERTIR LE PROFORMA EN VENTE
    |--------------------------------------------------------------------------
    */
    public function convertToSale(
        Proforma $proforma
    ): RedirectResponse {
        try {
            $sale = DB::transaction(
                function () use ($proforma) {
                    /*
                    |--------------------------------------------------------------------------
                    | Verrouiller le proforma
                    |--------------------------------------------------------------------------
                    */
                    $locked = Proforma::query()
                        ->with('vehicle')
                        ->lockForUpdate()
                        ->findOrFail(
                            $proforma->id
                        );

                    /*
                    |--------------------------------------------------------------------------
                    | Déjà converti
                    |--------------------------------------------------------------------------
                    */
                    if (
                        $locked->status === 'Converti'
                        && $locked->sale_id
                    ) {
                        return Sale::findOrFail(
                            $locked->sale_id
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Proforma annulé
                    |--------------------------------------------------------------------------
                    */
                    if ($locked->status === 'Annulé') {
                        throw new \RuntimeException(
                            'Un proforma annulé ne peut pas être converti.'
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Vérifier expiration
                    |--------------------------------------------------------------------------
                    */
                    if (
                        $locked->valid_until
                        && $locked->valid_until->isPast()
                    ) {
                        $locked->update([
                            'status' => 'Expiré',
                        ]);

                        throw new \RuntimeException(
                            'Ce proforma est expiré.'
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Verrouiller le véhicule
                    |--------------------------------------------------------------------------
                    */
                    $vehicle = Vehicle::query()
                        ->lockForUpdate()
                        ->findOrFail(
                            $locked->vehicle_id
                        );

                    /*
                    |--------------------------------------------------------------------------
                    | Le véhicule doit toujours être disponible
                    |--------------------------------------------------------------------------
                    */
                    if ($vehicle->status !== 'Disponible') {
                        throw new \RuntimeException(
                            'Le véhicule n’est plus disponible.'
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Montant de la remise
                    |--------------------------------------------------------------------------
                    */
                    $discountAmount = round(
                        (float) ($locked->discount_amount ?? 0),
                        2
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | CRÉATION DE LA VENTE
                    |--------------------------------------------------------------------------
                    */
                    $sale = Sale::create([
                        'vehicle_id' =>
                            $vehicle->id,

                        'customer_id' =>
                            $locked->customer_id,

                        'sold_by' =>
                            auth()->id(),

                        /*
                        |--------------------------------------------------------------------------
                        | Prix HT
                        |--------------------------------------------------------------------------
                        */
                        'sold_price' =>
                            $locked->proforma_price,

                        /*
                        |--------------------------------------------------------------------------
                        | Le pourcentage n'est plus utilisé
                        |--------------------------------------------------------------------------
                        |
                        | On conserve 0 pour compatibilité avec l'ancienne
                        | structure de la table sales.
                        |
                        */
                        'discount_percent' => 0,

                        /*
                        |--------------------------------------------------------------------------
                        | Remise directement en montant
                        |--------------------------------------------------------------------------
                        */
                        'discount_amount' =>
                            $discountAmount,

                        'invoice_type' =>
                            $locked->invoice_type,

                        'payment_type' =>
                            $locked->payment_type,

                        'sold_date' => now(),

                        'invoice_status' => 'Vendu',

                        'paid_amount' => 0,
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | Mettre le véhicule à Vendu
                    |--------------------------------------------------------------------------
                    */
                    $vehicle->update([
                        'status' => 'Vendu',
                        'sold_at' => now(),
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | Mettre à jour le proforma
                    |--------------------------------------------------------------------------
                    */
                    $locked->update([
                        'status' => 'Converti',

                        'sale_id' =>
                            $sale->id,

                        'converted_at' =>
                            now(),

                        'converted_by' =>
                            auth()->id(),
                    ]);

                    return $sale;
                }
            );

            /*
            |--------------------------------------------------------------------------
            | Redirection vers la facture
            |--------------------------------------------------------------------------
            */
            return redirect()
                ->route(
                    'sales.invoice',
                    $sale
                )
                ->with(
                    'success',
                    'Le proforma a été transformé en vente.'
                );
        } catch (\RuntimeException $e) {
            return back()
                ->with(
                    'error',
                    $e->getMessage()
                );
        } catch (Throwable $e) {
            Log::error(
                'Conversion du proforma impossible.',
                [
                    'proforma_id' => $proforma->id,
                    'message' => $e->getMessage(),
                ]
            );

            return back()
                ->with(
                    'error',
                    'Une erreur est survenue pendant la conversion.'
                );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | ANNULER UN PROFORMA
    |--------------------------------------------------------------------------
    */
    public function cancel(
        Proforma $proforma
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Un proforma converti ne peut plus être annulé
        |--------------------------------------------------------------------------
        */
        if ($proforma->status === 'Converti') {
            return back()
                ->with(
                    'error',
                    'Un proforma converti ne peut pas être annulé.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Déjà annulé
        |--------------------------------------------------------------------------
        */
        if ($proforma->status === 'Annulé') {
            return back()
                ->with(
                    'info',
                    'Ce proforma est déjà annulé.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Annulation
        |--------------------------------------------------------------------------
        */
        $proforma->update([
            'status' => 'Annulé',
            'cancelled_at' => now(),
            'cancelled_by' => auth()->id(),
        ]);

        return redirect()
            ->route('proformas.index')
            ->with(
                'success',
                'Le proforma a été annulé.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | NORMALISER UN NOMBRE
    |--------------------------------------------------------------------------
    |
    | Exemples acceptés :
    |
    | 4500000
    | 4 500 000
    | 4 500 000,50
    | 4500000,50
    | 4.500.000,50
    |
    */
    private function normalizeNumber(
        mixed $value
    ): string {
        /*
        |--------------------------------------------------------------------------
        | Valeur vide
        |--------------------------------------------------------------------------
        */
        if ($value === null || $value === '') {
            return '0';
        }

        /*
        |--------------------------------------------------------------------------
        | Convertir en chaîne
        |--------------------------------------------------------------------------
        */
        $value = trim(
            (string) $value
        );

        /*
        |--------------------------------------------------------------------------
        | Supprimer les espaces normaux et insécables
        |--------------------------------------------------------------------------
        */
        $value = str_replace(
            [
                "\u{00A0}",
                ' ',
            ],
            '',
            $value
        );

        /*
        |--------------------------------------------------------------------------
        | Cas :
        | 4.500.000,50
        |--------------------------------------------------------------------------
        */
        if (
            str_contains($value, ',')
            && str_contains($value, '.')
        ) {
            return str_replace(
                ',',
                '.',
                str_replace(
                    '.',
                    '',
                    $value
                )
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Cas :
        | 4500000,50
        |--------------------------------------------------------------------------
        */
        return str_replace(
            ',',
            '.',
            $value
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CONVERTIR UNE VALEUR EN MONTANT
    |--------------------------------------------------------------------------
    */
    private function parseAmount(
        mixed $value
    ): float {
        if ($value === null || $value === '') {
            return 0;
        }

        /*
        |--------------------------------------------------------------------------
        | La valeur peut déjà avoir été normalisée
        |--------------------------------------------------------------------------
        */
        $normalized = $this->normalizeNumber(
            $value
        );

        if (!is_numeric($normalized)) {
            return 0;
        }

        return (float) $normalized;
    }
}
