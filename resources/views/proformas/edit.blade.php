@extends('layout.mainlayout')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | DATE MAXIMALE DE VALIDITÉ
    |--------------------------------------------------------------------------
    |
    | Le proforma est valable au maximum 7 jours
    | après sa date de création.
    |
    */

    $creationDate = $proforma->proforma_date
        ?? $proforma->created_at
        ?? now();

    $maxValidUntil = \Carbon\Carbon::parse($creationDate)
        ->addDays(7)
        ->format('Y-m-d');

    /*
    |--------------------------------------------------------------------------
    | VALEUR ACTUELLE DE LA DATE
    |--------------------------------------------------------------------------
    */

    $currentValidUntil = old(
        'valid_until',
        $proforma->valid_until
            ? $proforma->valid_until->format('Y-m-d')
            : $maxValidUntil
    );

    /*
    |--------------------------------------------------------------------------
    | AFFICHAGE DE LA PARTIE 2
    |--------------------------------------------------------------------------
    |
    | La base utilise invoice_type :
    |
    | - with_tax
    | - without_tax
    |
    | La partie 2 n'est optionnelle que pour un proforma sans taxes.
    |
    */

    $isWithoutTax = $proforma->invoice_type === 'without_tax';

    $showFreeServicesChecked = old(
        'show_free_services',
        $proforma->show_free_services ?? true
    );
@endphp


<style>

    .proforma-edit-page {
        width: 100%;
        padding: 30px 22px 60px;
    }


    .proforma-edit-container {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
    }


    .proforma-edit-card {
        overflow: hidden;

        background: #ffffff;

        border: 1px solid #e5e7eb;
        border-radius: 16px;

        box-shadow:
            0 10px 30px rgba(15, 23, 42, 0.08);
    }


    .proforma-edit-header {
        padding: 22px 26px;

        color: #ffffff;

        background: linear-gradient(
            135deg,
            #ff6b00,
            #ff8a00
        );
    }


    .proforma-edit-header h4 {
        margin: 0 0 5px;

        font-size: 24px;
        font-weight: 800;
    }


    .proforma-edit-header p {
        margin: 0;

        opacity: 0.9;
    }


    .proforma-edit-body {
        padding: 28px;
    }


    .proforma-info-box {
        padding: 18px;

        margin-bottom: 25px;

        background: #f8fafc;

        border: 1px solid #e2e8f0;
        border-radius: 12px;
    }


    .proforma-info-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 15px;
    }


    .proforma-info-label {
        margin-bottom: 3px;

        font-size: 12px;
        font-weight: 700;

        color: #64748b;

        text-transform: uppercase;
    }


    .proforma-info-value {
        font-size: 15px;
        font-weight: 700;

        color: #0f172a;
    }


    .proforma-edit-field {
        margin-bottom: 22px;
    }


    .proforma-edit-field > label {
        display: block;

        margin-bottom: 7px;

        font-size: 14px;
        font-weight: 700;

        color: #111827;
    }


    .proforma-edit-field .form-control {
        min-height: 48px;

        font-size: 15px;

        border-radius: 9px;
    }


    .proforma-edit-help {
        display: block;

        margin-top: 7px;

        font-size: 12px;

        color: #64748b;
    }


    .validity-info {
        padding: 12px 14px;

        margin-top: 9px;

        color: #92400e;

        background: #fff7ed;

        border: 1px solid #fed7aa;
        border-radius: 9px;
    }


    /*
    |--------------------------------------------------------------------------
    | OPTION PARTIE 2
    |--------------------------------------------------------------------------
    */

    .free-services-box {
        padding: 18px;

        margin-bottom: 22px;

        background: #f0fdf4;

        border: 1px solid #bbf7d0;
        border-radius: 12px;
    }


    .free-services-box-title {
        display: flex;
        align-items: center;
        gap: 8px;

        margin-bottom: 10px;

        font-size: 14px;
        font-weight: 800;

        color: #166534;
    }


    .free-services-box .form-check {
        display: flex;
        align-items: center;
        gap: 10px;

        margin: 0;
        padding-left: 0;
    }


    .free-services-box .form-check-input {
        width: 44px;
        height: 24px;

        margin: 0;

        cursor: pointer;
    }


    .free-services-box .form-check-label {
        margin: 0;

        font-size: 14px;
        font-weight: 700;

        color: #111827;

        cursor: pointer;
    }


    .free-services-help {
        display: block;

        margin-top: 10px;

        font-size: 12px;
        line-height: 1.5;

        color: #64748b;
    }


    .free-services-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;

        margin-top: 10px;
        padding: 6px 10px;

        font-size: 12px;
        font-weight: 700;

        border-radius: 999px;
    }


    .free-services-status.is-visible {
        color: #166534;
        background: #dcfce7;
    }


    .free-services-status.is-hidden {
        color: #92400e;
        background: #ffedd5;
    }


    .proforma-edit-actions {
        display: flex;

        align-items: center;
        justify-content: flex-end;

        gap: 10px;

        padding-top: 10px;
    }


    .proforma-edit-actions .btn {
        min-width: 135px;

        padding: 11px 18px;

        font-weight: 700;

        border-radius: 9px;
    }


    @media (max-width: 767.98px) {

        .proforma-edit-page {
            padding: 18px 12px 40px;
        }


        .proforma-edit-body {
            padding: 20px;
        }


        .proforma-info-grid {
            grid-template-columns: 1fr;
        }


        .proforma-edit-actions {
            flex-direction: column-reverse;
        }


        .proforma-edit-actions .btn {
            width: 100%;
        }

    }

</style>


<div class="proforma-edit-page">

    <div class="proforma-edit-container">


        {{-- ============================================================= --}}
        {{-- MESSAGES --}}
        {{-- ============================================================= --}}

        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif


        @if(session('error'))

            <div class="alert alert-danger">
                {{ session('error') }}
            </div>

        @endif


        @if($errors->any())

            <div class="alert alert-danger">

                <strong>
                    Veuillez corriger les erreurs suivantes :
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif



        {{-- ============================================================= --}}
        {{-- CARTE --}}
        {{-- ============================================================= --}}

        <div class="proforma-edit-card">

            <div class="proforma-edit-header">

                <h4>
                    <i class="ti ti-edit me-2"></i>
                    Modifier le proforma
                </h4>

                <p>
                    {{ $proforma->proforma_number }}
                </p>

            </div>


            <div class="proforma-edit-body">


                {{-- ===================================================== --}}
                {{-- INFORMATIONS NON MODIFIABLES --}}
                {{-- ===================================================== --}}

                <div class="proforma-info-box">

                    <div class="proforma-info-grid">


                        {{-- CLIENT --}}

                        <div>

                            <div class="proforma-info-label">
                                Client
                            </div>

                            <div class="proforma-info-value">
                                {{ $proforma->customer->name ?? '-' }}
                            </div>

                        </div>


                        {{-- VÉHICULE --}}

                        <div>

                            <div class="proforma-info-label">
                                Véhicule
                            </div>

                            <div class="proforma-info-value">

                                {{ $proforma->vehicle->brand ?? '-' }}

                                {{ $proforma->vehicle->model ?? '' }}

                            </div>

                        </div>


                        {{-- VIN --}}

                        <div>

                            <div class="proforma-info-label">
                                VIN
                            </div>

                            <div class="proforma-info-value">
                                {{ $proforma->vehicle->vin ?? '-' }}
                            </div>

                        </div>


                        {{-- STATUT --}}

                        <div>

                            <div class="proforma-info-label">
                                Statut
                            </div>

                            <div class="proforma-info-value">
                                {{ $proforma->status }}
                            </div>

                        </div>


                        {{-- TYPE DE PROFORMA --}}

                        <div>

                            <div class="proforma-info-label">
                                Type de proforma
                            </div>

                            <div class="proforma-info-value">

                                @if($proforma->invoice_type === 'with_tax')
                                    Proforma avec taxes
                                @else
                                    Proforma sans taxes
                                @endif

                            </div>

                        </div>


                        {{-- PAIEMENT --}}

                        <div>

                            <div class="proforma-info-label">
                                Paiement
                            </div>

                            <div class="proforma-info-value">
                                {{ $proforma->payment_type ?? '-' }}
                            </div>

                        </div>


                    </div>

                </div>



                {{-- ===================================================== --}}
                {{-- FORMULAIRE --}}
                {{-- ===================================================== --}}

                <form
                    action="{{ route('proformas.update', $proforma) }}"
                    method="POST"
                >

                    @csrf
                    @method('PUT')



                    {{-- ================================================= --}}
                    {{-- PRIX --}}
                    {{-- ================================================= --}}

                    <div class="proforma-edit-field">

                        <label for="proforma_price">

                            Prix HT du véhicule

                            <span class="text-danger">
                                *
                            </span>

                        </label>


                        <input
                            type="text"
                            name="proforma_price"
                            id="proforma_price"

                            value="{{ old(
                                'proforma_price',
                                number_format(
                                    (float) $proforma->proforma_price,
                                    2,
                                    ',',
                                    ' '
                                )
                            ) }}"

                            class="form-control
                                @error('proforma_price')
                                    is-invalid
                                @enderror"

                            placeholder="Exemple : 4 500 000,00"

                            inputmode="decimal"

                            required
                        >


                        @error('proforma_price')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror


                        <small class="proforma-edit-help">

                            Montant HT proposé pour ce véhicule.

                        </small>

                    </div>



                    {{-- ================================================= --}}
                    {{-- DATE DE VALIDITÉ --}}
                    {{-- ================================================= --}}

                    <div class="proforma-edit-field">

                        <label for="valid_until">

                            Date de validité

                            <span class="text-danger">
                                *
                            </span>

                        </label>


                        <input
                            type="date"

                            name="valid_until"

                            id="valid_until"

                            value="{{ $currentValidUntil }}"

                            min="{{ now()->format('Y-m-d') }}"

                            max="{{ $maxValidUntil }}"

                            class="form-control
                                @error('valid_until')
                                    is-invalid
                                @enderror"

                            required
                        >


                        @error('valid_until')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror


                        <div class="validity-info">

                            <strong>
                                Validité maximale :
                            </strong>

                            {{ \Carbon\Carbon::parse(
                                $maxValidUntil
                            )->format('d/m/Y') }}

                            <br>

                            Ce proforma est valable pendant
                            <strong>7 jours maximum</strong>.

                        </div>

                    </div>



                    {{-- ================================================= --}}
                    {{-- PARTIE 2 - OPTIONNELLE UNIQUEMENT SANS TAXES --}}
                    {{-- ================================================= --}}

                    @if($isWithoutTax)

                        <div class="free-services-box">

                            <div class="free-services-box-title">

                                <i class="ti ti-gift"></i>

                                Prestations offertes au client

                            </div>


                            <div class="form-check form-switch">

                                <input
                                    class="form-check-input
                                        @error('show_free_services')
                                            is-invalid
                                        @enderror"
                                    type="checkbox"
                                    role="switch"
                                    name="show_free_services"
                                    id="show_free_services"
                                    value="1"
                                    {{ $showFreeServicesChecked ? 'checked' : '' }}
                                >


                                <label
                                    class="form-check-label"
                                    for="show_free_services"
                                >
                                    Afficher la partie 2 dans le proforma
                                </label>

                            </div>


                            @error('show_free_services')

                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>

                            @enderror


                            <small class="free-services-help">

                                Décochez cette option pour masquer complètement
                                la section « PARTIE 2 — PRESTATIONS OFFERTES AU CLIENT »
                                dans le proforma affiché, imprimé et téléchargé en PDF.

                            </small>


                            <div
                                id="freeServicesStatus"
                                class="free-services-status
                                    {{ $showFreeServicesChecked
                                        ? 'is-visible'
                                        : 'is-hidden'
                                    }}"
                            >

                                <i
                                    id="freeServicesStatusIcon"
                                    class="ti
                                        {{ $showFreeServicesChecked
                                            ? 'ti-eye'
                                            : 'ti-eye-off'
                                        }}"
                                ></i>

                                <span id="freeServicesStatusText">

                                    {{ $showFreeServicesChecked
                                        ? 'La partie 2 sera affichée'
                                        : 'La partie 2 sera masquée'
                                    }}

                                </span>

                            </div>

                        </div>

                    @else

                        {{--
                            Pour un proforma avec taxes,
                            le contrôleur force automatiquement
                            show_free_services à true.
                        --}}

                        <input
                            type="hidden"
                            name="show_free_services"
                            value="1"
                        >

                    @endif



                    {{-- ================================================= --}}
                    {{-- BOUTONS --}}
                    {{-- ================================================= --}}

                    <div class="proforma-edit-actions">

                        <a
                            href="{{ route(
                                'proformas.show',
                                $proforma
                            ) }}"
                            class="btn btn-secondary"
                        >
                            <i class="ti ti-arrow-left me-1"></i>

                            Annuler
                        </a>


                        <button
                            type="submit"
                            class="btn btn-success"
                        >

                            <i class="ti ti-device-floppy me-1"></i>

                            Enregistrer les modifications

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


{{-- ===================================================================== --}}
{{-- JAVASCRIPT : APERÇU DE L'ÉTAT DE LA PARTIE 2 --}}
{{-- ===================================================================== --}}

@if($isWithoutTax)

<script>

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const checkbox =
                document.getElementById(
                    'show_free_services'
                );

            const status =
                document.getElementById(
                    'freeServicesStatus'
                );

            const statusText =
                document.getElementById(
                    'freeServicesStatusText'
                );

            const statusIcon =
                document.getElementById(
                    'freeServicesStatusIcon'
                );


            if (
                !checkbox
                || !status
                || !statusText
                || !statusIcon
            ) {
                return;
            }


            function refreshFreeServicesStatus() {

                if (checkbox.checked) {

                    status.classList.remove(
                        'is-hidden'
                    );

                    status.classList.add(
                        'is-visible'
                    );

                    statusText.textContent =
                        'La partie 2 sera affichée';

                    statusIcon.className =
                        'ti ti-eye';

                } else {

                    status.classList.remove(
                        'is-visible'
                    );

                    status.classList.add(
                        'is-hidden'
                    );

                    statusText.textContent =
                        'La partie 2 sera masquée';

                    statusIcon.className =
                        'ti ti-eye-off';

                }

            }


            checkbox.addEventListener(
                'change',
                refreshFreeServicesStatus
            );


            refreshFreeServicesStatus();

        }
    );

</script>

@endif

@endsection
