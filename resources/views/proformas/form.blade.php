@php
    /*
    |--------------------------------------------------------------------------
    | MODE ET OBJETS
    |--------------------------------------------------------------------------
    */

    $mode = $mode ?? 'create';

    $isShow = $mode === 'show';

    $current = $proforma ?? null;

    /*
    |--------------------------------------------------------------------------
    | VÉHICULE PRÉSÉLECTIONNÉ
    |--------------------------------------------------------------------------
    |
    | La variable selectedVehicle existe seulement lorsqu’on ouvre le formulaire
    | depuis un véhicule précis. Sur /proformas/create, elle peut ne pas exister.
    |
    */

    $preselectedVehicle = $selectedVehicle ?? null;

    /*
    |--------------------------------------------------------------------------
    | VALEURS DU FORMULAIRE
    |--------------------------------------------------------------------------
    */

    $vehicleId = old(
        'vehicle_id',
        $current?->vehicle_id
            ?? $preselectedVehicle?->id
            ?? null
    );

    $customerId = old(
        'customer_id',
        $current?->customer_id
    );

    $clientType = old(
        'type_client',
        $current?->type_client ?? ''
    );

    $paymentType = old(
        'payment_type',
        $current?->payment_type ?? ''
    );

    $invoiceType = old(
        'invoice_type',
        $current?->invoice_type ?? 'with_tax'
    );

    $price = old(
        'proforma_price',
        $current
            ? number_format(
                (float) $current->proforma_price,
                2,
                ',',
                ' '
            )
            : ''
    );

   $discountAmount = old(
        'discount_amount',
        $current?->proforma_discount_amount ?? 0
    );

   $validUntil = old(
        'valid_until',
        $current?->valid_until
            ? $current->valid_until->format('Y-m-d')
            : now()->addDays(7)->format('Y-m-d')
    );

    $notes = old(
        'notes',
        $current?->notes ?? ''
    );
@endphp

<div class="card proforma-form-card">
    <div class="card-header">
        <h5>
            <i class="ti ti-file-description me-2"></i>
            {{ $isShow ? 'Informations du proforma' : 'Informations commerciales' }}
        </h5>
    </div>

    <div class="card-body">
        <div class="row g-3">

            <div class="col-lg-6">
                <label class="form-label" for="vehicle_id">
                    Véhicule
                    @unless($isShow)<span class="text-danger">*</span>@endunless
                </label>

                @if($isShow)
                    <div class="form-control bg-light">
                        <strong>
                            {{ $current?->vehicle?->brand ?? '-' }}
                            {{ $current?->vehicle?->model ?? '' }}
                        </strong>
                        <br>
                        <small>VIN : {{ $current?->vehicle?->vin ?? '-' }}</small>
                    </div>
                @else
                    <select
                        name="vehicle_id"
                        id="vehicle_id"
                        class="form-select @error('vehicle_id') is-invalid @enderror"
                        required
                    >
                        <option value="">Sélectionner un véhicule</option>

                        @foreach($vehicles as $vehicle)
                            <option
                                value="{{ $vehicle->id }}"
                                @selected((string)$vehicleId === (string)$vehicle->id)
                            >
                                {{ $vehicle->vin }} —
                                {{ $vehicle->brand }} {{ $vehicle->model }}
                                @if($vehicle->model_year)
                                    — {{ $vehicle->model_year }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>

            <div class="col-lg-6">
                <label class="form-label" for="customer_id">
                    Client
                    @unless($isShow)<span class="text-danger">*</span>@endunless
                </label>

                @if($isShow)
                    <div class="form-control bg-light">
                        <strong>{{ $current?->customer?->name ?? '-' }}</strong>
                        <br>
                        <small>
                            Téléphone :
                            {{ $current?->customer?->phone ?? '-' }}
                        </small>
                    </div>
                @else
                    <select
                        name="customer_id"
                        id="customer_id"
                        class="form-select @error('customer_id') is-invalid @enderror"
                        required
                    >
                        <option value="">Sélectionner un client</option>

                        @foreach($customers as $customer)
                            <option
                                value="{{ $customer->id }}"
                                data-type="{{ $customer->type_client }}"
                                @selected((string)$customerId === (string)$customer->id)
                            >
                                {{ $customer->name }}
                                @if($customer->phone)
                                    — {{ $customer->phone }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>

            <div class="col-lg-4 col-md-6">
                <label class="form-label" for="type_client">
                    Type de client
                    @unless($isShow)<span class="text-danger">*</span>@endunless
                </label>

                @if($isShow)
                    <div class="form-control bg-light">
                        {{ $clientType ?: '-' }}
                    </div>
                @else
                    <select
                        name="type_client"
                        id="type_client"
                        class="form-select"
                        required
                    >
                        <option value="">Sélectionner</option>

                        @foreach([
                            'Particulier',
                            'Gouvernement',
                            'Para-public',
                            'Privee'
                        ] as $type)
                            <option
                                value="{{ $type }}"
                                @selected($clientType === $type)
                            >
                                {{ $type === 'Privee' ? 'Privée' : $type }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>

            <div class="col-lg-4 col-md-6">
                <label class="form-label" for="payment_type">
                    Type de paiement
                    @unless($isShow)<span class="text-danger">*</span>@endunless
                </label>

                @if($isShow)
                    <div class="form-control bg-light">
                        {{ $paymentType ?: '-' }}
                    </div>
                @else
                    <select
                        name="payment_type"
                        id="payment_type"
                        class="form-select"
                        required
                    >
                        <option value="">Sélectionner</option>

                        @foreach([
                            'Cash',
                            'Bon de commande',
                            'Echeance'
                        ] as $payment)
                            <option
                                value="{{ $payment }}"
                                @selected($paymentType === $payment)
                            >
                                {{ $payment === 'Echeance' ? 'Échéance' : $payment }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>

            <div class="col-lg-4 col-md-6">
                <label class="form-label" for="invoice_type">
                    Type de proforma
                    @unless($isShow)<span class="text-danger">*</span>@endunless
                </label>

                @if($isShow)
                    <div class="form-control bg-light">
                        {{ $current?->invoice_type_label ?? '-' }}
                    </div>
                @else
                    <select
                        name="invoice_type"
                        id="invoice_type"
                        class="form-select"
                        required
                    >
                        <option
                            value="with_tax"
                            @selected($invoiceType === 'with_tax')
                        >
                            Proforma avec taxes
                        </option>

                        <option
                            value="without_tax"
                            @selected($invoiceType === 'without_tax')
                        >
                            Proforma sans taxes
                        </option>
                    </select>
                @endif
            </div>

            <div
                class="col-lg-4 col-md-6"
                id="showFreeServicesWrapper"
            >

                <label class="form-label">
                    Prestations offertes
                </label>

                <div class="form-check form-switch mt-2">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        role="switch"
                        name="show_free_services"
                        id="show_free_services"
                        value="1"
                        {{ old('show_free_services', true) ? 'checked' : '' }}
                    >

                    <label
                        class="form-check-label"
                        for="show_free_services"
                    >
                        Afficher la partie 2 dans le proforma
                    </label>

                </div>

                <small class="text-muted">
                    Pour un proforma sans taxes, vous pouvez masquer
                    les prestations offertes au client.
                </small>

            </div>

            <div class="col-lg-4 col-md-6">
                <label class="form-label" for="proforma_price">
                    Prix HT du véhicule
                    @unless($isShow)<span class="text-danger">*</span>@endunless
                </label>

                @if($isShow)
                    <div class="form-control bg-light fw-bold">
                        {{ number_format(
                            (float)($current?->proforma_price ?? 0),
                            2,
                            ',',
                            ' '
                        ) }} FDJ
                    </div>
                @else
                    <input
                        type="text"
                        name="proforma_price"
                        id="proforma_price"
                        value="{{ $price }}"
                        class="form-control"
                        placeholder="Exemple : 4 500 000,00"
                        inputmode="decimal"
                        required
                    >
                @endif
            </div>

           <!--div class="col-lg-4 col-md-6">
                <label class="form-label" for="discount_amount">
                    Montant de la remise
                </label>

                @ if($isShow)

                    <div class="form-control bg-light fw-bold">
                        { { number_format(
                            (float)($current?->proforma_discount_amount ?? 0),
                            2,
                            ',',
                            ' '
                        ) }} FDJ
                    </div>

                @ else

                    <input
                        type="text"
                        name="discount_amount"
                        id="discount_amount"
                        value="{ { old(
                            'discount_amount',
                            $discountAmount
                                ? number_format(
                                    (float)$discountAmount,
                                    2,
                                    ',',
                                    ' '
                                )
                                : ''
                        ) }}"
                        class="form-control @ error('discount_amount') is-invalid @ enderror"
                        placeholder="Exemple : 250 000"
                        inputmode="decimal"
                    >

                    @ error('discount_amount')
                        <div class="invalid-feedback">
                            { { $message }}
                        </div>
                    @ enderror

                @ endif
            </div-->

            <!--div class="col-lg-4 col-md-6">
                <label class="form-label">
                    Montant de la remise
                </label>

                <div
                    id="discountAmountPreview"
                    class="form-control bg-light"
                >
                    { { $isShow
                        ? number_format(
                            (float)$current->proforma_discount_amount,
                            2,
                            ',',
                            ' '
                        ) . ' FDJ'
                        : '0,00 FDJ'
                    }}
                </div>
            </div-->

           <div class="col-lg-4 col-md-6">
                <label class="form-label" for="valid_until">
                    Date de validité
                </label>

                @if($isShow)

                    <div class="form-control bg-light">
                        {{ $current?->valid_until
                            ? $current->valid_until->format('d/m/Y')
                            : '-'
                        }}
                    </div>

                @else

                    <input
                        type="date"
                        name="valid_until"
                        id="valid_until"
                        value="{{ $validUntil }}"
                        min="{{ now()->format('Y-m-d') }}"
                        max="{{ now()->addDays(7)->format('Y-m-d') }}"
                        class="form-control"
                    >

                    <small class="text-muted d-block mt-2">
                        <strong>Validité :</strong>
                        Ce proforma est valable pendant <strong>7 jours</strong>.
                        Après cette date, les prix, les conditions et la disponibilité
                        du véhicule ne sont plus garantis.
                    </small>

                @endif
            </div>

            @if($isShow)
                <div class="col-lg-4 col-md-6">
                    <label class="form-label">Statut</label>
                    <div class="form-control bg-light">
                        {{ $current?->status ?? '-' }}
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <label class="form-label">Créé par</label>
                    <div class="form-control bg-light">
                        {{ $current?->creator?->name ?? '-' }}
                    </div>
                </div>
            @endif

            <div class="col-12">
                <label class="form-label" for="notes">
                    Notes et conditions
                </label>

                @if($isShow)
                    <div
                        class="form-control bg-light"
                        style="min-height:100px; white-space:normal;"
                    >
                        {!! nl2br(e($notes ?: '-')) !!}
                    </div>
                @else
                    <textarea
                        name="notes"
                        id="notes"
                        rows="4"
                        class="form-control"
                        placeholder="Conditions ou observations"
                    >{{ $notes }}</textarea>
                @endif
            </div>
        </div>
    </div>
</div>

@unless($isShow)

<script>
document.addEventListener('DOMContentLoaded', function () {

    const customer = document.getElementById('customer_id');
    const clientType = document.getElementById('type_client');

    /*
    |--------------------------------------------------------------------------
    | Synchroniser automatiquement le type du client
    |--------------------------------------------------------------------------
    */
    function syncType() {

        if (!customer || !clientType) {
            return;
        }

        const option = customer.options[customer.selectedIndex];

        const type = option?.dataset?.type || '';

        if (type) {
            clientType.value = type;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Événement changement client
    |--------------------------------------------------------------------------
    */
    customer?.addEventListener('change', syncType);

    /*
    |--------------------------------------------------------------------------
    | Initialisation
    |--------------------------------------------------------------------------
    */
    syncType();

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const proformaType =
        document.getElementById('proforma_type');

    const wrapper =
        document.getElementById('showFreeServicesWrapper');

    const checkbox =
        document.getElementById('show_free_services');


    function updateFreeServicesOption() {

        if (!proformaType || !wrapper || !checkbox) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | AVEC TAXES
        |--------------------------------------------------------------------------
        |
        | Partie 2 obligatoire.
        |
        */

        if (proformaType.value === 'with_tax') {

            checkbox.checked = true;

            wrapper.style.display = 'none';

        }

        /*
        |--------------------------------------------------------------------------
        | SANS TAXES
        |--------------------------------------------------------------------------
        |
        | L'utilisateur choisit.
        |
        */

        else {

            wrapper.style.display = '';

        }

    }


    proformaType.addEventListener(
        'change',
        updateFreeServicesOption
    );

    updateFreeServicesOption();

});
</script>

@endunless
