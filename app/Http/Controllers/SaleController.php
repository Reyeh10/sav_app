<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use App\Models\Vehicle;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\SalePayment;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class SaleController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FORMULAIRE DE VENTE AVEC VÉHICULE PRÉSÉLECTIONNÉ
    |--------------------------------------------------------------------------
    */

    public function createWithVehicle(Vehicle $vehicle): View|RedirectResponse
    {
        /*
         * Un vendeur ne doit pas pouvoir vendre un véhicule
         * qui n'est plus disponible.
         */
        if ($vehicle->status !== 'Disponible') {
            return redirect()
                ->route('vehicles.index')
                ->with('error', 'Ce véhicule n’est pas disponible à la vente.');
        }

        $vehiclesForSale = Vehicle::query()
            ->where('status', 'Disponible')
            ->latest()
            ->get();

        $customers = Customer::query()
            ->latest()
            ->get();

        return view('sales.create', [
            'vehicle'        => $vehicle,
            'vehiclesForSale' => $vehiclesForSale,
            'customers'       => $customers,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | FORMULAIRE DE VENTE
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        $vehiclesForSale = Vehicle::query()
            ->where('status', 'Disponible')
            ->latest()
            ->get();

        $customers = Customer::query()
            ->latest()
            ->get();

        return view('sales.create', compact(
            'vehiclesForSale',
            'customers'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | ENREGISTRER UNE VENTE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request): RedirectResponse
    {
        $cleanPrice = str_replace(
            [' ', "\u{00A0}", ','],
            ['', '', '.'],
            (string) $request->input('sold_price')
        );

        $cleanDiscountAmount = str_replace(
            [' ', "\u{00A0}", ','],
            ['', '', '.'],
            (string) $request->input('discount_amount', 0)
        );

        $cleanInitialPayment = str_replace(
            [' ', "\u{00A0}", ','],
            ['', '', '.'],
            (string) $request->input('initial_payment_amount', 0)
        );

        $request->merge([
            'sold_price' => $cleanPrice,
            'discount_amount' => $cleanDiscountAmount === '' ? 0 : $cleanDiscountAmount,
            'initial_payment_amount' => $cleanInitialPayment === '' ? 0 : $cleanInitialPayment,
        ]);

        $validated = $request->validate(
            [
                'vehicle_id' => ['required', 'integer', 'exists:vehicles,id'],
                'customer_id' => ['required', 'integer', 'exists:customers,id'],
                'type_client' => ['required', 'in:Particulier,Gouvernement,Para-public,Privee'],
                'invoice_type' => ['required', 'in:with_tax,without_tax'],
                'payment_type' => ['required', 'in:Cash,Bon de commande,Echeance'],
                'sold_price' => ['required', 'numeric', 'gt:0', 'max:999999999999.99'],
                'discount_amount' => ['nullable', 'numeric', 'min:0', 'max:999999999999.99'],
                'initial_payment_amount' => ['nullable', 'numeric', 'min:0', 'max:999999999999.99'],
            ],
            [
                'vehicle_id.required' => 'Veuillez sélectionner un véhicule.',
                'vehicle_id.exists' => 'Le véhicule sélectionné est introuvable.',
                'customer_id.required' => 'Veuillez sélectionner un client.',
                'customer_id.exists' => 'Le client sélectionné est introuvable.',
                'type_client.required' => 'Veuillez sélectionner le type de client.',
                'type_client.in' => 'Le type de client sélectionné est invalide.',
                'invoice_type.required' => 'Veuillez sélectionner le type de facture.',
                'invoice_type.in' => 'Le type de facture sélectionné est invalide.',
                'payment_type.required' => 'Veuillez sélectionner le type de paiement.',
                'payment_type.in' => 'Le type de paiement sélectionné est invalide.',
                'sold_price.required' => 'Veuillez saisir le prix de vente.',
                'sold_price.numeric' => 'Le prix de vente doit être un nombre valide.',
                'sold_price.gt' => 'Le prix de vente doit être supérieur à zéro.',
                'sold_price.max' => 'Le prix de vente est trop élevé.',
                'discount_amount.numeric' => 'Le montant de la remise doit être un nombre valide.',
                'discount_amount.min' => 'Le montant de la remise ne peut pas être négatif.',
                'discount_amount.max' => 'Le montant de la remise est trop élevé.',
                'initial_payment_amount.numeric' => 'Le montant versé doit être un nombre valide.',
                'initial_payment_amount.min' => 'Le montant versé ne peut pas être négatif.',
                'initial_payment_amount.max' => 'Le montant versé est trop élevé.',
            ]
        );

        try {
            $sale = DB::transaction(function () use ($validated) {
                $vehicle = Vehicle::query()
                    ->lockForUpdate()
                    ->findOrFail($validated['vehicle_id']);

                if ($vehicle->status !== 'Disponible') {
                    throw new \RuntimeException(
                        'Ce véhicule vient d’être vendu ou n’est plus disponible.'
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | REMISE COMMERCIALE EN MONTANT
                |--------------------------------------------------------------------------
                |
                | La remise est saisie directement en FDJ.
                | Elle s'applique uniquement au prix HT du véhicule.
                | Le timbre n'est pas remisé.
                |
                */

                $soldPrice = round(
                    (float) $validated['sold_price'],
                    2
                );

                $discountAmount = round(
                    (float) ($validated['discount_amount'] ?? 0),
                    2
                );

                if ($discountAmount > $soldPrice) {
                    throw ValidationException::withMessages([
                        'discount_amount' =>
                            'Le montant de la remise ne peut pas dépasser le prix HT du véhicule de ' .
                            number_format($soldPrice, 2, ',', ' ') .
                            ' FDJ.',
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | PREMIÈRE VENTE OU REVENTE
                |--------------------------------------------------------------------------
                |
                | IMPORTANT :
                | Lorsqu'un véhicule déjà vendu revient au statut Disponible,
                | l'ancienne ligne de vente reste liée au véhicule.
                |
                | Il ne faut donc PAS créer une deuxième vente avec Sale::create().
                | Sinon la relation $vehicle->sale peut continuer à retourner
                | l'ancienne vente (prix = 0, ancienne date).
                |
                | En cas de revente, on met à jour la vente existante avec :
                | - le nouveau prix
                | - le nouveau client
                | - le nouveau vendeur
                | - la nouvelle date de vente
                | - les nouvelles informations de facture/paiement
                |
                */

                $sale = Sale::query()
                    ->where('vehicle_id', $vehicle->id)
                    ->lockForUpdate()
                    ->latest('id')
                    ->first();

                if ($sale) {

                    /*
                    |--------------------------------------------------------------------------
                    | REVENTE : RÉINITIALISER LES ANCIENS PAIEMENTS
                    |--------------------------------------------------------------------------
                    */

                    SalePayment::query()
                        ->where('sale_id', $sale->id)
                        ->delete();

                    $sale->update([
                        'customer_id' => $validated['customer_id'],
                        'sold_by' => auth()->id(),
                        'sold_price' => $soldPrice,

                        /*
                         * Aucun pourcentage de remise n'est utilisé.
                         */
                        'discount_percent' => 0,

                        'discount_amount' => $discountAmount,
                        'invoice_type' => $validated['invoice_type'],
                        'payment_type' => $validated['payment_type'],

                        /*
                        |--------------------------------------------------------------------------
                        | NOUVELLE DATE DE VENTE
                        |--------------------------------------------------------------------------
                        */
                        'sold_date' => now(),

                        /*
                        |--------------------------------------------------------------------------
                        | RÉINITIALISATION DE LA FACTURE
                        |--------------------------------------------------------------------------
                        */
                        'invoice_status' => 'Vendu',
                        'paid_amount' => 0,
                        'remaining_amount' => 0,
                        'payment_discount_amount' => 0,
                        'paid_at' => null,
                        'cancelled_at' => null,
                        'cancelled_by' => null,
                    ]);

                    $sale = $sale->fresh();

                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | PREMIÈRE VENTE
                    |--------------------------------------------------------------------------
                    */

                    $sale = Sale::create([
                        'vehicle_id' => $vehicle->id,
                        'customer_id' => $validated['customer_id'],
                        'sold_by' => auth()->id(),
                        'sold_price' => $soldPrice,

                        /*
                         * Aucun pourcentage de remise n'est utilisé.
                         */
                        'discount_percent' => 0,

                        'discount_amount' => $discountAmount,
                        'invoice_type' => $validated['invoice_type'],
                        'payment_type' => $validated['payment_type'],
                        'sold_date' => now(),
                        'invoice_status' => 'Vendu',
                        'paid_amount' => 0,
                        'remaining_amount' => 0,
                        'payment_discount_amount' => 0,
                        'paid_at' => null,
                    ]);
                }

                $invoiceTotal = round((float) $sale->total_ttc, 2);
                $initialPayment = round(
                    (float) ($validated['initial_payment_amount'] ?? 0),
                    2
                );

                if ($initialPayment > $invoiceTotal) {
                    throw ValidationException::withMessages([
                        'initial_payment_amount' =>
                            'Le montant versé ne peut pas dépasser le total de la facture de ' .
                            number_format($invoiceTotal, 2, ',', ' ') .
                            ' FDJ.',
                    ]);
                }

                $remainingAmount = max(
                    0,
                    round($invoiceTotal - $initialPayment, 2)
                );

                if ($initialPayment <= 0) {
                    $invoiceStatus = 'Vendu';
                    $vehicleStatus = 'Vendu';
                    $paidAt = null;
                } elseif ($remainingAmount > 0) {
                    $invoiceStatus = 'Partiellement payé';
                    $vehicleStatus = 'Vendu';
                    $paidAt = null;
                } else {
                    $invoiceStatus = 'Payé';
                    $vehicleStatus = 'Payé';
                    $paidAt = now();
                }

                if ($initialPayment > 0) {
                    SalePayment::create([
                        'sale_id' => $sale->id,
                        'amount' => $initialPayment,
                        'payment_method' => $this->paymentMethodFromSaleType(
                            $validated['payment_type']
                        ),
                        'reference' => null,
                        'note' => null,
                        'received_by' => auth()->id(),
                        'payment_date' => now(),
                    ]);
                }

                $sale->update([
                    'paid_amount' => $initialPayment,
                    'remaining_amount' => $remainingAmount,
                    'invoice_status' => $invoiceStatus,
                    'paid_at' => $paidAt,
                ]);

                $vehicle->update([
                    'status' => $vehicleStatus,
                    'sold_at' => now(),
                ]);

                return $sale->fresh();
            });

            return redirect()
                ->route('sales.invoice', $sale)
                ->with(
                    'success',
                    (float) $sale->paid_amount > 0
                        ? (
                            (float) $sale->remaining_amount > 0
                                ? 'La vente et le premier paiement ont été enregistrés. Montant restant : ' .
                                    number_format((float) $sale->remaining_amount, 2, ',', ' ') .
                                    ' FDJ.'
                                : 'La vente a été enregistrée et la facture est entièrement payée.'
                        )
                        : 'La voiture a été vendue avec succès. La facture est disponible.'
                );

        } catch (ValidationException $exception) {
            throw $exception;

        } catch (\RuntimeException $exception) {
            return back()
                ->withErrors([
                    'vehicle_id' => $exception->getMessage(),
                ])
                ->withInput();

        } catch (Throwable $exception) {
            Log::error(
                'Erreur pendant l’enregistrement de la vente.',
                [
                    'message' => $exception->getMessage(),
                    'vehicle_id' => $validated['vehicle_id'] ?? null,
                    'customer_id' => $validated['customer_id'] ?? null,
                    'user_id' => auth()->id(),
                ]
            );

            return back()
                ->with('error', 'Une erreur est survenue pendant l’enregistrement de la vente.')
                ->withInput();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | LISTE DES FACTURES
    |--------------------------------------------------------------------------
    */

   public function invoices(Request $request)
    {
        $search = trim((string) $request->input('search', ''));

        $query = Sale::query()
            ->with([
                'customer',
                'vehicle',
                'seller',
            ]);

        if ($search !== '') {

            $query->where(function ($mainQuery) use ($search) {

                /*
                |--------------------------------------------------------------------------
                | RECHERCHE PAR NUMÉRO DE FACTURE GÉNÉRÉ
                |--------------------------------------------------------------------------
                |
                | Exemple :
                | FACTURE-000027
                |
                | La colonne invoice_number n'existe pas dans la table sales.
                | Le numéro est construit avec l'identifiant de la vente.
                |
                */

                $normalizedSearch = strtoupper($search);

                $invoiceId = null;

                if (preg_match('/^FACTURE[-\s]?0*(\d+)$/i', $normalizedSearch, $matches)) {
                    $invoiceId = (int) $matches[1];
                } elseif (ctype_digit($search)) {
                    $invoiceId = (int) $search;
                }

                if ($invoiceId !== null && $invoiceId > 0) {
                    $mainQuery->where('id', $invoiceId);
                }

                /*
                |--------------------------------------------------------------------------
                | RECHERCHE PAR CLIENT
                |--------------------------------------------------------------------------
                */

                $mainQuery->orWhereHas('customer', function ($customerQuery) use ($search) {

                    $customerQuery
                        ->where('name', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');

                });

                /*
                |--------------------------------------------------------------------------
                | RECHERCHE PAR VÉHICULE
                |--------------------------------------------------------------------------
                */

                $mainQuery->orWhereHas('vehicle', function ($vehicleQuery) use ($search) {

                    $vehicleQuery
                        ->where('vin', 'like', '%' . $search . '%')
                        ->orWhere('brand', 'like', '%' . $search . '%')
                        ->orWhere('model', 'like', '%' . $search . '%')
                        ->orWhere('engine_number', 'like', '%' . $search . '%')
                        ->orWhere('configuration', 'like', '%' . $search . '%');

                });

                /*
                |--------------------------------------------------------------------------
                | RECHERCHE PAR TYPE DE PAIEMENT
                |--------------------------------------------------------------------------
                */

                $mainQuery->orWhere(
                    'payment_type',
                    'like',
                    '%' . $search . '%'
                );
            });
        }

        $sales = $query
            ->orderByDesc('sold_date')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('sales.invoices', compact(
            'sales',
            'search'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | AFFICHER LES DÉTAILS D’UNE VENTE
    |--------------------------------------------------------------------------
    */

    public function show(Sale $sale): View
    {
       $sale->load([
            'customer',
            'vehicle',
            'user',
        ]);

        return view('sales.show', compact('sale'));
    }

    /*
|--------------------------------------------------------------------------
| AFFICHER LA FACTURE DANS LE NAVIGATEUR
|--------------------------------------------------------------------------
*/

public function invoice(Sale $sale): View
{
    $sale->load([
        'customer',
        'vehicle',
        'seller',
        'payments.receiver',
    ]);

    /*
     * Numéro de facture enregistré dans la base de données,
     * ou numéro généré automatiquement.
     */
    $invoiceNumber = $sale->invoice_number;

    return view('sales.invoice', [
        'sale'          => $sale,
        'invoiceNumber' => $invoiceNumber,
        'isPdf'         => false,
    ]);
}

/*
|--------------------------------------------------------------------------
| TÉLÉCHARGER LA FACTURE AU FORMAT PDF
|--------------------------------------------------------------------------
*/

public function downloadInvoice(Sale $sale)
{
    $sale->load([
        'customer',
        'vehicle',
        'seller',
        'payments.receiver',
    ]);

    /*
     * Numéro de facture enregistré dans la base de données,
     * ou numéro généré automatiquement.
     */
    $invoiceNumber = $sale->invoice_number;

    /*
     * Nettoyage des caractères interdits dans le nom du fichier.
     */
    $safeInvoiceNumber = preg_replace(
        '/[^A-Za-z0-9\-_]/',
        '-',
        $invoiceNumber
    );

    $pdf = Pdf::loadView('sales.invoice', [
        'sale'          => $sale,
        'invoiceNumber' => $invoiceNumber,
        'isPdf'         => true,
    ])->setPaper('a4', 'portrait');

    return $pdf->download($safeInvoiceNumber . '.pdf');
}

/*
|--------------------------------------------------------------------------
| PAYER LA FACTURE
|--------------------------------------------------------------------------
*/

public function payInvoice(Request $request, Sale $sale): RedirectResponse
{
    $cleanAmount = str_replace(
        [' ', "\u{00A0}", ','],
        ['', '', '.'],
        (string) $request->input('amount', 0)
    );

    $cleanDiscount = str_replace(
        [' ', "\u{00A0}", ','],
        ['', '', '.'],
        (string) $request->input('discount_amount', 0)
    );

    $request->merge([
        'amount' => $cleanAmount === '' ? 0 : $cleanAmount,
        'discount_amount' => $cleanDiscount === '' ? 0 : $cleanDiscount,
    ]);

    $validated = $request->validate(
        [
            'amount' => [
                'nullable',
                'numeric',
                'min:0',
                'max:999999999999.99',
            ],
            'discount_amount' => [
                'nullable',
                'numeric',
                'min:0',
                'max:999999999999.99',
            ],
            'note' => [
                'nullable',
                'string',
                'max:500',
            ],
        ],
        [
            'amount.numeric' => 'Le montant du paiement doit être numérique.',
            'amount.min' => 'Le montant du paiement ne peut pas être négatif.',
            'amount.max' => 'Le montant du paiement est trop élevé.',
            'discount_amount.numeric' => 'Le montant de la remise doit être numérique.',
            'discount_amount.min' => 'Le montant de la remise ne peut pas être négatif.',
            'discount_amount.max' => 'Le montant de la remise est trop élevé.',
            'note.max' => 'La note ne peut pas dépasser 500 caractères.',
        ]
    );

    $newPayment = round(
        (float) ($validated['amount'] ?? 0),
        2
    );

    $newDiscount = round(
        (float) ($validated['discount_amount'] ?? 0),
        2
    );

    if ($newPayment <= 0 && $newDiscount <= 0) {
        return back()
            ->withInput()
            ->withErrors([
                'amount' => 'Veuillez saisir un montant de paiement ou une remise.',
            ]);
    }

    try {
        DB::transaction(function () use (
            $validated,
            $sale,
            $newPayment,
            $newDiscount
        ) {
            $lockedSale = Sale::query()
                ->with('vehicle')
                ->whereKey($sale->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedSale->invoice_status === 'Annulé') {
                throw ValidationException::withMessages([
                    'amount' => 'Impossible d’enregistrer une opération sur une facture annulée.',
                ]);
            }

            $invoiceTotal = round(
                (float) $lockedSale->total_ttc,
                2
            );

            $historyPaid = round(
                (float) SalePayment::query()
                    ->where('sale_id', $lockedSale->id)
                    ->sum('amount'),
                2
            );

            $storedPaid = round(
                (float) ($lockedSale->paid_amount ?? 0),
                2
            );

            $alreadyPaid = max(
                $historyPaid,
                $storedPaid
            );

            $existingPaymentDiscount = round(
                max(
                    0,
                    (float) ($lockedSale->payment_discount_amount ?? 0)
                ),
                2
            );

            $remainingBeforeOperation = max(
                0,
                round(
                    $invoiceTotal
                    - $alreadyPaid
                    - $existingPaymentDiscount,
                    2
                )
            );

            if ($remainingBeforeOperation <= 0) {
                throw ValidationException::withMessages([
                    'amount' => 'Cette facture est déjà entièrement soldée.',
                ]);
            }

            if ($newDiscount > $remainingBeforeOperation) {
                throw ValidationException::withMessages([
                    'discount_amount' =>
                        'La remise ne peut pas dépasser le montant restant de ' .
                        number_format(
                            $remainingBeforeOperation,
                            2,
                            ',',
                            ' '
                        ) .
                        ' FDJ.',
                ]);
            }

            $operationTotal = round(
                $newPayment + $newDiscount,
                2
            );

            if ($operationTotal > $remainingBeforeOperation) {
                throw ValidationException::withMessages([
                    'amount' =>
                        'Le paiement et la remise ne peuvent pas dépasser le montant restant de ' .
                        number_format(
                            $remainingBeforeOperation,
                            2,
                            ',',
                            ' '
                        ) .
                        ' FDJ.',
                ]);
            }

            if ($newPayment > 0) {
                SalePayment::create([
                    'sale_id' => $lockedSale->id,
                    'amount' => $newPayment,
                    'payment_method' => $this->paymentMethodFromSaleType(
                        $lockedSale->payment_type
                    ),
                    'reference' => null,
                    'note' => $validated['note'] ?? null,
                    'received_by' => auth()->id(),
                    'payment_date' => now(),
                ]);
            }

            $totalPaid = min(
                $invoiceTotal,
                round(
                    $alreadyPaid + $newPayment,
                    2
                )
            );

            $totalPaymentDiscount = min(
                $invoiceTotal,
                round(
                    $existingPaymentDiscount + $newDiscount,
                    2
                )
            );

            $remainingAmount = max(
                0,
                round(
                    $invoiceTotal
                    - $totalPaid
                    - $totalPaymentDiscount,
                    2
                )
            );

            if ($remainingAmount <= 0) {
                $invoiceStatus = 'Payé';
                $paidAt = now();
                $vehicleStatus = 'Payé';
            } else {
                $invoiceStatus = 'Partiellement payé';
                $paidAt = null;
                $vehicleStatus = 'Vendu';
            }

            $lockedSale->update([
                'paid_amount' => $totalPaid,
                'payment_discount_amount' => $totalPaymentDiscount,
                'remaining_amount' => $remainingAmount,
                'invoice_status' => $invoiceStatus,
                'paid_at' => $paidAt,
            ]);

            if ($lockedSale->vehicle) {
                $lockedSale->vehicle->update([
                    'status' => $vehicleStatus,
                ]);
            }
        });

        $sale->refresh();

        $parts = [];

        if ($newPayment > 0) {
            $parts[] =
                'Paiement enregistré : ' .
                number_format($newPayment, 2, ',', ' ') .
                ' FDJ';
        }

        if ($newDiscount > 0) {
            $parts[] =
                'Remise accordée : ' .
                number_format($newDiscount, 2, ',', ' ') .
                ' FDJ';
        }

        if ((float) $sale->remaining_amount <= 0) {
            $parts[] = 'La facture est entièrement soldée.';
        } else {
            $parts[] =
                'Montant restant : ' .
                number_format(
                    (float) $sale->remaining_amount,
                    2,
                    ',',
                    ' '
                ) .
                ' FDJ';
        }

        return redirect()
            ->route('sales.invoice', $sale)
            ->with(
                'success',
                implode(' — ', $parts)
            );

    } catch (ValidationException $exception) {
        throw $exception;

    } catch (Throwable $exception) {
        Log::error(
            'Erreur pendant l’enregistrement du paiement/remise.',
            [
                'sale_id' => $sale->id,
                'payment_amount' => $newPayment,
                'discount_amount' => $newDiscount,
                'message' => $exception->getMessage(),
                'user_id' => auth()->id(),
            ]
        );

        return back()
            ->withInput()
            ->with(
                'error',
                'Une erreur est survenue pendant l’enregistrement du paiement ou de la remise.'
            );
    }
}

    /*
|--------------------------------------------------------------------------
| ANNULER LA FACTURE
|--------------------------------------------------------------------------
*/

public function cancelInvoice(Sale $sale): RedirectResponse
{
    if (auth()->user()->role !== 'admin') {
    abort(403, 'Accès refusé.');
    }

    if ($sale->invoice_status === 'Annulé') {
        return back()->with(
            'info',
            'Cette facture est déjà annulée.'
        );
    }

    try {
        DB::transaction(function () use ($sale) {

            $lockedSale = Sale::query()
                ->with('vehicle')
                ->lockForUpdate()
                ->findOrFail($sale->id);

            if ($lockedSale->invoice_status === 'Annulé') {
                throw new \RuntimeException(
                    'Cette facture est déjà annulée.'
                );
            }

            /*
             * La facture est conservée, mais son statut devient Annulé.
             */
            $lockedSale->update([
                'invoice_status' => 'Annulé',
                'paid_amount' => 0,
                'remaining_amount' => 0,
                'paid_at' => null,
                'cancelled_at' => now(),
                'cancelled_by' => auth()->id(),
            ]);

            /*
             * Le véhicule retourne dans le stock.
             */
            if ($lockedSale->vehicle) {
                $lockedSale->vehicle->update([
                    'status'  => 'Disponible',
                    'sold_at' => null,
                ]);
            }
        });

        return redirect()
            ->route('sales.invoice', $sale)
            ->with(
                'success',
                'La vente a été annulée et le véhicule est retourné dans le stock.'
            );

    } catch (\RuntimeException $exception) {

        return back()->with(
            'error',
            $exception->getMessage()
        );

    } catch (Throwable $exception) {

        Log::error(
            'Erreur pendant l’annulation de la facture.',
            [
                'sale_id' => $sale->id,
                'message' => $exception->getMessage(),
                'user_id' => auth()->id(),
            ]
        );

        return back()->with(
            'error',
            'Une erreur est survenue pendant l’annulation de la vente.'
        );
    }
}

    private function paymentMethodFromSaleType(?string $paymentType): string
    {
        return match ($paymentType) {
            'Cash' => 'cash',
            'Bon de commande' => 'other',
            'Echeance' => 'other',
            default => 'other',
        };
    }

}
