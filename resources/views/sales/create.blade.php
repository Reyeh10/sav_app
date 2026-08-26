@extends('layout.mainlayout')

@section('content')

<style>
    /*
    |--------------------------------------------------------------------------
    | PAGE
    |--------------------------------------------------------------------------
    */

    .sale-page {
        width: 100%;
        padding: 10px 20px 35px;
    }

    .sale-content {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
    }

    /*
    |--------------------------------------------------------------------------
    | CARTE DU FORMULAIRE
    |--------------------------------------------------------------------------
    */

    .sale-form-card {
        width: 100%;
        margin-top: 0;
        overflow: hidden;

        background: #ffffff;
        border: 1px solid #e6e9ef;
        border-radius: 16px;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.08);
    }

    .sale-form-card-header {
        padding: 12px 22px;
        color: #ffffff;
        background: linear-gradient(135deg, #26328c, #3b49ad);
    }

    .sale-form-card-header h5 {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: #ffffff;
    }

    .sale-form-card-header p {
        margin: 3px 0 0;
        font-size: 12px;
        color: rgba(255, 255, 255, 0.88);
    }

    .sale-form-card-body {
        padding: 22px;
    }

    /*
    |--------------------------------------------------------------------------
    | CHAMPS
    |--------------------------------------------------------------------------
    */

    .sale-form-card .form-group {
        margin-bottom: 20px;
    }

    .sale-form-card .form-label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 700;
        color: #1f2937;
    }

    .sale-form-card .form-control,
    .sale-form-card .form-select {
        width: 100%;
        min-height: 50px;
        padding: 10px 14px;

        font-size: 15px;
        color: #1f2937;
        background-color: #ffffff;

        border: 1px solid #d5d9e2;
        border-radius: 10px;

        transition:
            border-color 0.15s ease,
            box-shadow 0.15s ease;
    }

    .sale-form-card .form-control:focus,
    .sale-form-card .form-select:focus {
        border-color: #ff7a00;
        outline: none;
        box-shadow: 0 0 0 3px rgba(255, 122, 0, 0.14);
    }

    .sale-form-card .form-control[readonly] {
        color: #374151;
        background: #f8fafc;
        cursor: not-allowed;
    }

    .field-help {
        display: block;
        margin-top: 7px;
        font-size: 13px;
        line-height: 1.5;
        color: #6b7280;
    }

    .required-mark {
        color: #dc2626;
    }

    /*
    |--------------------------------------------------------------------------
    | CLIENT ET BOUTON AJOUTER
    |--------------------------------------------------------------------------
    */

    .customer-selection-wrapper {
        width: 100%;
    }

    .customer-selection-wrapper .customer-select {
        width: 100%;
        min-width: 0;
    }

   .customer-button-wrapper {
        display: flex;
        justify-content: flex-end;
        align-items: center;

        width: 100%;

        margin-top: 8px;
        margin-bottom: 6px;
    }

    .customer-add-button {
        width: auto;
        min-width: 190px;
        height: 46px;
        padding: 0 18px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;

        color: #ffffff !important;
        font-size: 14px;
        font-weight: 700;
        line-height: 1;
        white-space: nowrap;

        background: linear-gradient(135deg, #00b85a, #009f4e) !important;
        border: none !important;
        border-radius: 9px;
        box-shadow: 0 5px 14px rgba(0, 184, 90, 0.22);

        cursor: pointer;
        transition:
            transform 0.15s ease,
            box-shadow 0.15s ease,
            background 0.15s ease;
    }

    .customer-add-button:hover,
    .customer-add-button:focus {
        color: #ffffff !important;
        background: linear-gradient(135deg, #009f4e, #008744) !important;
        box-shadow: 0 7px 18px rgba(0, 159, 78, 0.28);
        transform: translateY(-1px);
    }

    .customer-add-button:active {
        transform: translateY(0);
    }

    /*
    |--------------------------------------------------------------------------
    | REMISE
    |--------------------------------------------------------------------------
    */

    .discount-box {
        padding: 20px;
        margin-bottom: 20px;
        background: #fff8f1;
        border: 1px solid #fed7aa;
        border-radius: 13px;
    }

    .discount-box-title {
        margin: 0 0 15px;
        font-size: 15px;
        font-weight: 800;
        color: #9a3412;
    }

    /*
    |--------------------------------------------------------------------------
    | INFORMATIONS DU PAIEMENT
    |--------------------------------------------------------------------------
    */

    .payment-box {
        padding: 22px;
        margin-top: 6px;
        margin-bottom: 22px;
        background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
        border: 1px solid #bfdbfe;
        border-radius: 14px;
        box-shadow: 0 5px 16px rgba(37, 99, 235, 0.07);
    }

    .payment-box-title {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0 0 18px;
        font-size: 16px;
        font-weight: 800;
        color: #1e3a8a;
    }

    .payment-summary {
        padding: 16px;
        margin-bottom: 18px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 11px;
    }

    .payment-summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        padding: 6px 0;
        font-size: 14px;
        color: #334155;
    }

    .payment-summary-row + .payment-summary-row {
        border-top: 1px dashed #bfdbfe;
    }

    .payment-summary-row strong {
        text-align: right;
        color: #0f172a;
        font-variant-numeric: tabular-nums;
    }

    .payment-summary-row.total-row strong {
        color: #1d4ed8;
        font-size: 16px;
    }

    .payment-summary-row.remaining-row strong {
        color: #b45309;
        font-size: 16px;
    }

    .payment-summary-row.remaining-row.is-paid strong {
        color: #15803d;
    }

    .payment-summary-row.remaining-row.is-overpaid strong {
        color: #dc2626;
    }

    .payment-input-wrapper {
        position: relative;
    }

    .payment-input-wrapper .form-control {
        padding-right: 72px;
    }

    .payment-currency {
        position: absolute;
        top: 50%;
        right: 14px;
        transform: translateY(-50%);
        font-size: 13px;
        font-weight: 800;
        color: #64748b;
        pointer-events: none;
    }

    .payment-warning {
        display: none;
        padding: 10px 12px;
        margin-top: 10px;
        color: #991b1b;
        font-size: 13px;
        font-weight: 700;
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 8px;
    }

    .payment-warning.is-visible {
        display: block;
    }

    /*
    |--------------------------------------------------------------------------
    | BOUTON DE CONFIRMATION
    |--------------------------------------------------------------------------
    */

    .sale-submit-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 28px;
    }

    .sale-submit-button {
        min-width: 240px;
        padding: 14px 25px;

        font-size: 15px;
        font-weight: 700;
        color: #ffffff;

        background: linear-gradient(135deg, #ff6b00, #ff8a00);
        border: none;
        border-radius: 10px;
        box-shadow: 0 8px 20px rgba(255, 107, 0, 0.25);

        transition:
            transform 0.15s ease,
            box-shadow 0.15s ease,
            background 0.15s ease;
    }

    .sale-submit-button:hover {
        color: #ffffff;
        background: linear-gradient(135deg, #e86100, #f57900);
        box-shadow: 0 10px 24px rgba(255, 107, 0, 0.32);
        transform: translateY(-1px);
    }

   /*
    |--------------------------------------------------------------------------
    | MODALE CLIENT
    |--------------------------------------------------------------------------
    */

    .customer-modal .modal-content {
        overflow: hidden;
        border: none;
        border-radius: 16px;
        box-shadow: 0 20px 55px rgba(15, 23, 42, 0.20);
    }

    .customer-modal .modal-header {
        color: #ffffff !important;
        background: linear-gradient(
            135deg,
            #26328c,
            #3b49ad
        ) !important;

        border-bottom: none;
    }

    .customer-modal .modal-header .modal-title,
    .customer-modal .modal-header h5,
    .customer-modal .modal-header i {
        color: #ffffff !important;
    }

    .customer-modal .modal-title {
        margin: 0;
        font-size: 19px;
        font-weight: 700;
    }

    .customer-modal .btn-close {
        opacity: 1;
        filter: brightness(0) invert(1);
    }

    .customer-modal .modal-body {
        padding: 24px;
    }

   .customer-modal .modal-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;

        padding: 16px 24px 22px;

        border-top: 1px solid #eef0f4;
    }

    /*
    |--------------------------------------------------------------------------
    | RESPONSIVE
    |--------------------------------------------------------------------------
    */

    @media (max-width: 767.98px) {
        .sale-page {
            padding: 8px 10px 26px;
        }

        .sale-content {
            max-width: 100%;
        }

        .sale-form-card-body {
            padding: 18px 14px;
        }

        .customer-button-wrapper {
            justify-content: stretch;
        }

        .customer-add-button,
        .sale-submit-button {
            width: 100%;
            min-width: 0;
        }
    }
</style>

<div class="sale-page">
    <div class="sale-content">

        <div class="sale-form-card">
            <div class="sale-form-card-header">
                <h5>
                    <i class="ti ti-file-invoice me-2"></i>
                    Informations de la vente
                </h5>
                <p>Sélectionnez le véhicule, le client et les conditions de vente.</p>
            </div>

            <div class="sale-form-card-body">

                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <strong>Veuillez corriger les erreurs suivantes :</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('sales.store') }}" id="saleForm">
                    @csrf

                    <div class="form-group">
                        <label for="vehicle_id" class="form-label">
                            Voiture approuvée <span class="required-mark">*</span>
                        </label>

                        <select
                            name="vehicle_id"
                            id="vehicle_id"
                            class="form-select vehicle-select @error('vehicle_id') is-invalid @enderror"
                            required
                        >
                            <option value="">-- Sélectionner une voiture --</option>

                            @foreach($vehiclesForSale as $v)
                                <option
                                    value="{{ $v->id }}"
                                    {{ (string) old('vehicle_id', isset($vehicle) ? $vehicle->id : '') === (string) $v->id ? 'selected' : '' }}
                                >
                                    {{ $v->brand }} {{ $v->model }}
                                    ({{ $v->plate_number ?? $v->vin }})
                                </option>
                            @endforeach
                        </select>

                        @error('vehicle_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="saleTypeClient" class="form-label">
                            Type de client <span class="required-mark">*</span>
                        </label>

                        <select
                            name="type_client"
                            id="saleTypeClient"
                            class="form-select @error('type_client') is-invalid @enderror"
                            required
                        >
                            <option value="">-- Sélectionner le type --</option>
                            <option value="Particulier" {{ old('type_client') === 'Particulier' ? 'selected' : '' }}>Particulier</option>
                            <option value="Gouvernement" {{ old('type_client') === 'Gouvernement' ? 'selected' : '' }}>Gouvernement</option>
                            <option value="Para-public" {{ old('type_client') === 'Para-public' ? 'selected' : '' }}>Para-public</option>
                            <option value="Privee" {{ old('type_client') === 'Privee' ? 'selected' : '' }}>Privée</option>
                        </select>

                        @error('type_client')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="customerSelect" class="form-label">
                            Client <span class="required-mark">*</span>
                        </label>

                       <div class="customer-selection-wrapper">

                            <select
                                name="customer_id"
                                id="customerSelect"
                                class="form-select customer-select @error('customer_id') is-invalid @enderror"
                                required
                            >
                                <option value="">
                                    -- Sélectionner un client --
                                </option>

                                @foreach($customers as $customer)
                                    <option
                                        value="{{ $customer->id }}"
                                        data-type="{{ $customer->type_client }}"
                                        {{ (string) old('customer_id') === (string) $customer->id ? 'selected' : '' }}
                                    >
                                        {{ $customer->name }}
                                        ({{ $customer->phone ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>

                            <div class="customer-button-wrapper">

                                <button
                                    type="button"
                                    class="btn customer-add-button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#createCustomerModal"
                                >
                                    <i class="ti ti-user-plus me-1"></i>
                                    Ajouter un client
                                </button>

                            </div>

                        </div>

                        @error('customer_id')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror

                        <!--small class="field-help">
                            Si le client n’existe pas, utilisez le bouton Ajouter un client.
                        </small-->
                    </div>

                    <div class="form-group">
                        <label for="soldPrice" class="form-label">
                            Prix de vente HT <span class="required-mark">*</span>
                        </label>

                        <input
                            type="text"
                            name="sold_price"
                            id="soldPrice"
                            class="form-control @error('sold_price') is-invalid @enderror"
                            inputmode="decimal"
                            placeholder="Exemple : 9 800 000,99"
                            value="{{ old('sold_price') }}"
                            required
                        >

                        @error('sold_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <small class="field-help">
                            Vous pouvez saisir le montant avec une virgule ou un point.
                        </small>
                    </div>

                    <div class="discount-box">
                        <h6 class="discount-box-title">
                            <i class="ti ti-discount-2 me-1"></i>
                            Remise commerciale
                        </h6>

                        <div class="form-group mb-0">
                            <label for="discountAmount" class="form-label">
                                Montant de la remise
                            </label>

                            <div class="payment-input-wrapper">
                                <input
                                    type="text"
                                    name="discount_amount"
                                    id="discountAmount"
                                    class="form-control @error('discount_amount') is-invalid @enderror"
                                    inputmode="decimal"
                                    placeholder="Exemple : 150 000,00"
                                    value="{{ old('discount_amount', 0) }}"
                                >

                                <span class="payment-currency">
                                    FDJ
                                </span>
                            </div>

                            @error('discount_amount')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                            <small class="field-help">
                                Saisissez directement le montant de la remise en FDJ.
                                La remise s’applique uniquement au prix HT du véhicule.
                                Le timbre n’est pas remisé.
                            </small>
                        </div>
                    </div>

                    <div class="form-group">

                        <label
                            for="invoiceType"
                            class="form-label"
                        >
                            Type de facture
                            <span class="required-mark">*</span>
                        </label>

                        <select
                            name="invoice_type"
                            id="invoiceType"
                            class="form-select @error('invoice_type') is-invalid @enderror"
                            required
                        >
                            <option value="">
                                -- Sélectionner le type de facture --
                            </option>

                            <option
                                value="with_tax"
                                {{ old('invoice_type', 'with_tax') === 'with_tax' ? 'selected' : '' }}
                            >
                                Facture avec taxes
                            </option>

                            <option
                                value="without_tax"
                                {{ old('invoice_type') === 'without_tax' ? 'selected' : '' }}
                            >
                                Facture sans taxes
                            </option>
                        </select>

                        @error('invoice_type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <small
                            id="invoiceTypeHelp"
                            class="field-help"
                        >
                            Avec taxes : timbre et TVA. Sans taxes : aucun timbre et aucune TVA.
                        </small>

                    </div>

                    <div class="form-group">
                        <label for="payment_type" class="form-label">
                            Type de paiement <span class="required-mark">*</span>
                        </label>

                        <select
                            name="payment_type"
                            id="payment_type"
                            class="form-select payment-select @error('payment_type') is-invalid @enderror"
                            required
                        >
                            <option value="">-- Sélectionner le type de paiement --</option>
                            <option value="Cash" {{ old('payment_type') === 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="Bon de commande" {{ old('payment_type') === 'Bon de commande' ? 'selected' : '' }}>Bon de commande</option>
                            <option value="Echeance" {{ old('payment_type') === 'Echeance' ? 'selected' : '' }}>Échéance</option>
                        </select>

                        @error('payment_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="payment-box">
                        <h6 class="payment-box-title">
                            <i class="ti ti-cash me-1"></i>
                            Informations du paiement
                        </h6>

                        <input
                            type="hidden"
                            name="total_ttc"
                            id="totalTtc"
                            value="{{ old('total_ttc', 0) }}"
                        >

                        <div class="payment-summary">
                            <div class="payment-summary-row">
                                <span>Prix de vente HT</span>
                                <strong id="paymentVehicleHt">0,00 FDJ</strong>
                            </div>

                            <div class="payment-summary-row">
                                <span>Remise</span>
                                <strong id="paymentDiscountAmount">0,00 FDJ</strong>
                            </div>

                            <div class="payment-summary-row" id="paymentStampRow">
                                <span>Timbre</span>
                                <strong id="paymentStampAmount">0,00 FDJ</strong>
                            </div>

                            <div class="payment-summary-row" id="paymentVatRow">
                                <span>TVA ({{ number_format(\App\Models\Sale::VAT_RATE, 0) }} %)</span>
                                <strong id="paymentVatAmount">0,00 FDJ</strong>
                            </div>

                            <div class="payment-summary-row total-row">
                                <span>Total de la facture</span>
                                <strong id="paymentInvoiceTotal">0,00 FDJ</strong>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="initialPaymentAmount" class="form-label">
                                        Montant versé par le client
                                    </label>

                                    <div class="payment-input-wrapper">
                                        <input
                                            type="text"
                                            name="initial_payment_amount"
                                            id="initialPaymentAmount"
                                            class="form-control @error('initial_payment_amount') is-invalid @enderror"
                                            inputmode="decimal"
                                            placeholder="Exemple : 20 000 000"
                                            value="{{ old('initial_payment_amount', 0) }}"
                                        >
                                        <span class="payment-currency">FDJ</span>
                                    </div>

                                    @error('initial_payment_amount')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <small class="field-help">
                                        Laissez 0 si le client ne verse rien au moment de la vente.
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="initialPaymentMethod" class="form-label">
                                        Mode de règlement du versement
                                    </label>

                                    <select
                                        name="initial_payment_method"
                                        id="initialPaymentMethod"
                                        class="form-select @error('initial_payment_method') is-invalid @enderror"
                                    >
                                        <option value="cash" {{ old('initial_payment_method', 'cash') === 'cash' ? 'selected' : '' }}>
                                            Espèces
                                        </option>

                                        <option value="bank_transfer" {{ old('initial_payment_method') === 'bank_transfer' ? 'selected' : '' }}>
                                            Virement bancaire
                                        </option>

                                        <option value="cheque" {{ old('initial_payment_method') === 'cheque' ? 'selected' : '' }}>
                                            Chèque
                                        </option>

                                        <option value="mobile_money" {{ old('initial_payment_method') === 'mobile_money' ? 'selected' : '' }}>
                                            Mobile Money
                                        </option>

                                        <option value="other" {{ old('initial_payment_method') === 'other' ? 'selected' : '' }}>
                                            Autre
                                        </option>
                                    </select>

                                    @error('initial_payment_method')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <small class="field-help">
                                        Ce champ décrit le mode utilisé pour ce premier versement.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div
                            class="payment-summary-row remaining-row"
                            id="paymentRemainingRow"
                        >
                            <span>Montant restant</span>
                            <strong id="paymentRemainingAmount">0,00 FDJ</strong>
                        </div>

                        <div
                            id="paymentWarning"
                            class="payment-warning"
                        >
                            Le montant versé ne peut pas dépasser le total de la facture.
                        </div>
                    </div>

                    <div class="sale-submit-wrapper">
                        <button type="submit" class="btn sale-submit-button" id="submitSaleButton">
                            <i class="ti ti-check me-2"></i>
                            Confirmer la vente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div
    class="modal fade customer-modal"
    id="createCustomerModal"
    tabindex="-1"
    aria-labelledby="createCustomerModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCustomerModalLabel">
                    <i class="ti ti-user-plus me-2"></i>
                    Créer un client
                </h5>

                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"
                    aria-label="Fermer"
                ></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="customerName" class="form-label fw-bold">
                        Nom <span class="required-mark">*</span>
                    </label>
                    <input type="text" id="customerName" class="form-control" placeholder="Nom du client">
                </div>

                <div class="mb-3">
                    <label for="customerType" class="form-label fw-bold">
                        Type de client <span class="required-mark">*</span>
                    </label>
                    <select id="customerType" class="form-select typeclient-select">
                        <option value="">-- Sélectionner le type --</option>
                        <option value="Particulier">Particulier</option>
                        <option value="Gouvernement">Gouvernement</option>
                        <option value="Para-public">Para-public</option>
                        <option value="Privee">Privée</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="customerPhone" class="form-label fw-bold">Téléphone</label>
                    <input type="text" id="customerPhone" class="form-control" placeholder="+25377123456">
                </div>

                <div class="mb-3">
                    <label for="customerEmail" class="form-label fw-bold">Email</label>
                    <input type="email" id="customerEmail" class="form-control" placeholder="exemple@gmail.com">
                </div>

                <div>
                    <label for="customerAddress" class="form-label fw-bold">Adresse</label>
                    <input type="text" id="customerAddress" class="form-control" placeholder="Adresse du client">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>

                <button
                    type="button"
                    class="btn btn-primary"
                    id="saveCustomerButton"
                    onclick="createCustomer(event)"
                >
                    <i class="ti ti-device-floppy me-1"></i>
                    Enregistrer
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function parseNumericValue(value) {
        if (value === null || value === undefined || value === '') {
            return 0;
        }

        const normalized = String(value)
            .replace(/\u00A0/g, '')
            .replace(/\s/g, '')
            .replace(',', '.');

        const parsed = Number.parseFloat(normalized);

        return Number.isFinite(parsed) ? parsed : 0;
    }

    function formatFdj(value) {
        return new Intl.NumberFormat('fr-FR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(value) + ' FDJ';
    }

    function updateSaleFinancials() {
        const soldPriceInput = document.getElementById('soldPrice');
        const discountAmountInput = document.getElementById('discountAmount');
        const invoiceTypeInput = document.getElementById('invoiceType');
        const initialPaymentInput = document.getElementById('initialPaymentAmount');

        const totalTtcInput = document.getElementById('totalTtc');

        const paymentVehicleHt = document.getElementById('paymentVehicleHt');
        const paymentDiscountAmount = document.getElementById('paymentDiscountAmount');
        const paymentStampAmount = document.getElementById('paymentStampAmount');
        const paymentVatAmount = document.getElementById('paymentVatAmount');
        const paymentInvoiceTotal = document.getElementById('paymentInvoiceTotal');
        const paymentRemainingAmount = document.getElementById('paymentRemainingAmount');

        const paymentStampRow = document.getElementById('paymentStampRow');
        const paymentVatRow = document.getElementById('paymentVatRow');
        const paymentRemainingRow = document.getElementById('paymentRemainingRow');
        const paymentWarning = document.getElementById('paymentWarning');

        if (!soldPriceInput || !discountAmountInput || !invoiceTypeInput) {
            return;
        }

        const VAT_RATE = Number(@json((float) \App\Models\Sale::VAT_RATE));
        const STAMP_AMOUNT = 1000;

        const soldPrice = Math.max(
            0,
            parseNumericValue(soldPriceInput.value)
        );

        const discountAmount = Math.max(
            0,
            parseNumericValue(discountAmountInput.value)
        );

        const isDiscountTooHigh =
            discountAmount > soldPrice && soldPrice > 0;

        /*
        |--------------------------------------------------------------------------
        | REMISE EN MONTANT
        |--------------------------------------------------------------------------
        |
        | La remise est déduite uniquement du prix HT du véhicule.
        | Le timbre n'est jamais remisé.
        |
        */

        const validDiscountAmount = Math.min(
            discountAmount,
            soldPrice
        );

        const vehicleNetHt = Math.max(
            0,
            soldPrice - validDiscountAmount
        );

        const hasTax = invoiceTypeInput.value === 'with_tax';

        const stampAmount = hasTax ? STAMP_AMOUNT : 0;

        const subtotalForVat =
            vehicleNetHt + stampAmount;

        const vatAmount = hasTax
            ? subtotalForVat * VAT_RATE / 100
            : 0;

        const totalTtc = hasTax
            ? subtotalForVat + vatAmount
            : vehicleNetHt;

        const initialPayment = Math.max(
            0,
            parseNumericValue(initialPaymentInput?.value)
        );

        const isOverpaid =
            initialPayment > totalTtc && totalTtc >= 0;

        const remainingAmount = Math.max(
            0,
            totalTtc - initialPayment
        );

        if (totalTtcInput) {
            totalTtcInput.value =
                totalTtc.toFixed(2);
        }

        if (paymentVehicleHt) {
            paymentVehicleHt.textContent =
                formatFdj(soldPrice);
        }

        if (paymentDiscountAmount) {
            paymentDiscountAmount.textContent =
                formatFdj(discountAmount);
        }

        if (paymentStampAmount) {
            paymentStampAmount.textContent =
                formatFdj(stampAmount);
        }

        if (paymentVatAmount) {
            paymentVatAmount.textContent =
                formatFdj(vatAmount);
        }

        if (paymentInvoiceTotal) {
            paymentInvoiceTotal.textContent =
                formatFdj(totalTtc);
        }

        if (paymentRemainingAmount) {
            if (isDiscountTooHigh) {
                paymentRemainingAmount.textContent =
                    'Remise supérieure au prix HT';
            } else if (isOverpaid) {
                paymentRemainingAmount.textContent =
                    'Montant versé trop élevé';
            } else {
                paymentRemainingAmount.textContent =
                    formatFdj(remainingAmount);
            }
        }

        if (paymentStampRow) {
            paymentStampRow.style.display =
                hasTax ? 'flex' : 'none';
        }

        if (paymentVatRow) {
            paymentVatRow.style.display =
                hasTax ? 'flex' : 'none';
        }

        if (paymentWarning) {
            const hasFinancialError =
                isOverpaid || isDiscountTooHigh;

            paymentWarning.classList.toggle(
                'is-visible',
                hasFinancialError
            );

            if (isDiscountTooHigh) {
                paymentWarning.textContent =
                    'Le montant de la remise ne peut pas dépasser le prix HT du véhicule.';
            } else if (isOverpaid) {
                paymentWarning.textContent =
                    'Le montant versé par le client ne peut pas dépasser le total de la facture.';
            }
        }

        if (paymentRemainingRow) {
            paymentRemainingRow.classList.toggle(
                'is-paid',
                !isOverpaid
                    && !isDiscountTooHigh
                    && totalTtc > 0
                    && remainingAmount === 0
            );

            paymentRemainingRow.classList.toggle(
                'is-overpaid',
                isOverpaid || isDiscountTooHigh
            );
        }

        return {
            soldPrice,
            discountAmount,
            vehicleNetHt,
            stampAmount,
            vatAmount,
            totalTtc,
            initialPayment,
            remainingAmount,
            isOverpaid,
            isDiscountTooHigh
        };
    }

    function updateDiscountPreview() {
        updateSaleFinancials();
    }

    function syncCustomerType() {
        const customerSelect = document.getElementById('customerSelect');
        const saleTypeClient = document.getElementById('saleTypeClient');

        if (!customerSelect || !saleTypeClient) {
            return;
        }

        const selectedOption = customerSelect.options[customerSelect.selectedIndex];
        const selectedType = selectedOption?.dataset?.type || '';

        if (selectedType !== '') {
            saleTypeClient.value = selectedType;
        }
    }

    async function createCustomer(event) {
        if (event) {
            event.preventDefault();
        }

        const name = (document.getElementById('customerName')?.value || '').trim();
        const type = (document.getElementById('customerType')?.value || '').trim();
        const phoneRaw = (document.getElementById('customerPhone')?.value || '').trim();
        const emailRaw = (document.getElementById('customerEmail')?.value || '').trim();
        const address = (document.getElementById('customerAddress')?.value || '').trim();

        const email = emailRaw !== '' ? emailRaw.toLowerCase() : null;

        let phone = phoneRaw.replace(/[\s\-()]/g, '');

        if (phone.startsWith('00')) {
            phone = '+' + phone.substring(2);
        }

        if (phone === '') {
            phone = null;
        }

        if (!name) {
            Swal.fire({
                icon: 'error',
                title: 'Nom obligatoire',
                text: 'Veuillez saisir le nom du client.'
            });
            return;
        }

        if (!type) {
            Swal.fire({
                icon: 'error',
                title: 'Type obligatoire',
                text: 'Veuillez sélectionner le type de client.'
            });
            return;
        }

        if (phone !== null) {
            const phonePattern = /^\+[1-9]\d{1,14}$/;

            if (!phonePattern.test(phone)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Téléphone invalide',
                    text: 'Utilisez le format international, par exemple : +25377123456.'
                });
                return;
            }
        }

        if (email !== null) {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailPattern.test(email)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Email invalide',
                    text: 'Veuillez saisir une adresse email valide.'
                });
                return;
            }
        }

        const saveButton = document.getElementById('saveCustomerButton');

        if (saveButton) {
            saveButton.disabled = true;
            saveButton.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Enregistrement...';
        }

        try {
            const response = await fetch("{{ route('customers.quickStore') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    name: name,
                    type_client: type,
                    phone: phone,
                    email: email,
                    address: address || null
                })
            });

            const contentType = response.headers.get('content-type') || '';
            const data = contentType.includes('application/json') ? await response.json() : null;

            if (response.status === 419) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Session expirée',
                    text: 'Actualisez la page puis réessayez.'
                });
                return;
            }

            if (response.status === 422) {
                const errors = data?.errors || {};
                const firstError = Object.values(errors).flat().find(Boolean);

                Swal.fire({
                    icon: 'error',
                    title: 'Erreur de validation',
                    text: firstError || 'Les informations saisies sont invalides.'
                });
                return;
            }

            if (!response.ok || !data?.success) {
                throw new Error(data?.message || 'Création du client impossible.');
            }

            const customer = data.customer;
            const customerSelect = document.getElementById('customerSelect');

            if (customerSelect) {
                const option = new Option(
                    customer.name + (customer.phone ? ' (' + customer.phone + ')' : ''),
                    customer.id,
                    true,
                    true
                );

                option.dataset.type = customer.type_client || '';
                customerSelect.add(option);
                customerSelect.value = customer.id;
            }

            const saleTypeClient = document.getElementById('saleTypeClient');

            if (saleTypeClient) {
                saleTypeClient.value = customer.type_client || '';
            }

            Swal.fire({
                icon: 'success',
                title: 'Client créé avec succès',
                timer: 1300,
                showConfirmButton: false
            });

            const modalElement = document.getElementById('createCustomerModal');

            if (modalElement) {
                const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                modalInstance.hide();
            }

            document.getElementById('customerName').value = '';
            document.getElementById('customerType').value = '';
            document.getElementById('customerPhone').value = '';
            document.getElementById('customerEmail').value = '';
            document.getElementById('customerAddress').value = '';

        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: error.message || 'Impossible de contacter le serveur.'
            });
        } finally {
            if (saveButton) {
                saveButton.disabled = false;
                saveButton.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Enregistrer';
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const soldPriceInput = document.getElementById('soldPrice');
        const discountAmountInput = document.getElementById('discountAmount');
        const invoiceTypeInput = document.getElementById('invoiceType');
        const initialPaymentInput = document.getElementById('initialPaymentAmount');
        const customerSelect = document.getElementById('customerSelect');
        const saleForm = document.getElementById('saleForm');
        const submitSaleButton = document.getElementById('submitSaleButton');

        soldPriceInput?.addEventListener('input', updateSaleFinancials);
        discountAmountInput?.addEventListener('input', updateSaleFinancials);
        invoiceTypeInput?.addEventListener('change', updateSaleFinancials);
        initialPaymentInput?.addEventListener('input', updateSaleFinancials);
        customerSelect?.addEventListener('change', syncCustomerType);

        saleForm?.addEventListener('submit', function (event) {
            const financials = updateSaleFinancials();

            if (financials?.isDiscountTooHigh) {
                event.preventDefault();

                Swal.fire({
                    icon: 'error',
                    title: 'Remise invalide',
                    text: 'Le montant de la remise ne peut pas dépasser le prix HT du véhicule.'
                });

                discountAmountInput?.focus();
                return;
            }

            if (financials?.isOverpaid) {
                event.preventDefault();

                Swal.fire({
                    icon: 'error',
                    title: 'Montant versé invalide',
                    text: 'Le montant versé par le client ne peut pas dépasser le total de la facture.'
                });

                initialPaymentInput?.focus();
                return;
            }

            if (financials && financials.initialPayment > 0 && financials.totalTtc <= 0) {
                event.preventDefault();

                Swal.fire({
                    icon: 'error',
                    title: 'Total de facture invalide',
                    text: 'Veuillez saisir un prix de vente valide avant d’enregistrer un paiement.'
                });

                soldPriceInput?.focus();
                return;
            }

            if (submitSaleButton) {
                submitSaleButton.disabled = true;
                submitSaleButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Enregistrement...';
            }
        });

        updateSaleFinancials();
        syncCustomerType();
    });
</script>

@endsection
