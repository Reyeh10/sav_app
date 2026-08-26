@extends('layout.mainlayout')

@section('content')

@php
    $role = auth()->user()->role;

    $status = $vehicle->status ?? 'En attente';

    $badgeClass = match ($status) {
        'Disponible'        => 'bg-success',
        'En réparation'     => 'bg-warning text-dark',
        'En attente'        => 'bg-info text-dark',
        'Vendu'             => 'bg-danger',
        'Payé'              => 'bg-primary',
        'Annulé'            => 'bg-dark',
        'Pièces prélevées'  => 'bg-secondary',

        'draft'             => 'bg-secondary',
        'approved'          => 'bg-success',
        'rejected'          => 'bg-danger',
        'sold'              => 'bg-warning text-dark',

        default             => 'bg-info text-dark',
    };
@endphp


{{-- ============================================================= --}}
{{-- BREADCRUMB / HEADER --}}
{{-- ============================================================= --}}

<div
    class="
        d-md-flex
        d-block
        align-items-center
        justify-content-between
        page-breadcrumb
        mb-4
    "
>

    <div>

        <h2 class="mb-1">
            Détails voiture
        </h2>

        <nav>

            <ol class="breadcrumb mb-0">

                <li class="breadcrumb-item">

                    <a href="{{ route('vehicles.index') }}">

                        <i class="ti ti-car me-1"></i>

                        Voitures

                    </a>

                </li>

                <li class="breadcrumb-item active">
                    Détails
                </li>

            </ol>

        </nav>

    </div>


    <div>

        <a
            href="{{ route('vehicles.index') }}"
            class="btn btn-outline-secondary"
        >
            <i class="ti ti-arrow-left me-1"></i>
            Retour
        </a>

    </div>

</div>



{{-- ============================================================= --}}
{{-- CARD PRINCIPALE --}}
{{-- ============================================================= --}}

<div class="card shadow-sm border-0">

    <div
        class="
            card-header
            d-flex
            align-items-center
            justify-content-between
            flex-wrap
            gap-2
        "
    >

        <div>

            <h4 class="card-title mb-1">

                {{ $vehicle->brand ?? '-' }}

                {{ $vehicle->model ?? '' }}

            </h4>


            @if(!empty($vehicle->vin))

                <small class="text-muted">

                    VIN :
                    {{ $vehicle->vin }}

                </small>

            @endif

        </div>


        <div>

            <span
                class="
                    badge
                    {{ $badgeClass }}
                    px-3
                    py-2
                "
            >
                {{ $status }}
            </span>

        </div>

    </div>


    <div class="card-body">


        {{-- ========================================================= --}}
        {{-- INFORMATIONS GÉNÉRALES --}}
        {{-- ========================================================= --}}

        <h5 class="fw-bold mb-3">

            <i class="ti ti-info-circle me-1"></i>

            Informations générales

        </h5>


        <div class="row">


            {{-- VIN --}}

            <div class="col-md-6 mb-3">

                <label class="form-label fw-semibold">
                    VIN
                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $vehicle->vin ?? '-' }}"
                    readonly
                >

            </div>


            {{-- MARQUE --}}

            <div class="col-md-6 mb-3">

                <label class="form-label fw-semibold">
                    Marque
                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $vehicle->brand ?? '-' }}"
                    readonly
                >

            </div>


            {{-- MODÈLE --}}

            <div class="col-md-6 mb-3">

                <label class="form-label fw-semibold">
                    Modèle
                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $vehicle->model ?? '-' }}"
                    readonly
                >

            </div>


            {{-- MODEL YEAR --}}

            <div class="col-md-6 mb-3">

                <label class="form-label fw-semibold">
                    Model Year
                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $vehicle->model_year ?? '-' }}"
                    readonly
                >

            </div>


            {{-- CONFIGURATION --}}

            <div class="col-md-6 mb-3">

                <label class="form-label fw-semibold">
                    Configuration
                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $vehicle->configuration ?? '-' }}"
                    readonly
                >

            </div>


            {{-- ENGINE NUMBER --}}

            <div class="col-md-6 mb-3">

                <label class="form-label fw-semibold">
                    Engine Number
                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $vehicle->engine_number ?? '-' }}"
                    readonly
                >

            </div>

        </div>



        <hr class="my-4">



        {{-- ========================================================= --}}
        {{-- CARACTÉRISTIQUES TECHNIQUES --}}
        {{-- ========================================================= --}}

        <h5 class="fw-bold mb-3">

            <i class="ti ti-settings me-1"></i>

            Caractéristiques techniques

        </h5>


        <div class="row">


            {{-- CYLINDRÉE --}}

            <div class="col-md-4 mb-3">

                <label class="form-label fw-semibold">
                    Cylindrée
                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $vehicle->engine_capacity ?? '-' }}"
                    readonly
                >

            </div>


            {{-- CARBURANT / ÉNERGIE --}}

            <div class="col-md-4 mb-3">

                <label class="form-label fw-semibold">
                    Carburant / Énergie
                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $vehicle->fuel_type ?? '-' }}"
                    readonly
                >

            </div>


            {{-- PORTES --}}

            <div class="col-md-4 mb-3">

                <label class="form-label fw-semibold">
                    Nombre de portes
                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $vehicle->doors ?? '-' }}"
                    readonly
                >

            </div>


            {{-- CYLINDRES --}}

            <div class="col-md-4 mb-3">

                <label class="form-label fw-semibold">
                    Nombre de cylindres
                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $vehicle->cylinders ?? '-' }}"
                    readonly
                >

            </div>


            {{-- TAILLE DES PNEUS --}}

            <div class="col-md-4 mb-3">

                <label class="form-label fw-semibold">
                    Taille des pneus
                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $vehicle->tire_size ?? '-' }}"
                    readonly
                >

            </div>


            {{-- TRANSMISSION --}}

            <div class="col-md-4 mb-3">

                <label class="form-label fw-semibold">
                    Transmission
                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $vehicle->transmission ?? '-' }}"
                    readonly
                >

            </div>


            {{-- PLACES --}}

            <div class="col-md-4 mb-3">

                <label class="form-label fw-semibold">
                    Nombre de places
                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $vehicle->seats ?? '-' }}"
                    readonly
                >

            </div>

        </div>



        <hr class="my-4">



        {{-- ========================================================= --}}
        {{-- COULEURS --}}
        {{-- ========================================================= --}}

        <h5 class="fw-bold mb-3">

            <i class="ti ti-palette me-1"></i>

            Couleurs

        </h5>


        <div class="row">


            {{-- COULEUR EXTÉRIEURE --}}

            <div class="col-md-6 mb-3">

                <label class="form-label fw-semibold">
                    Couleur extérieure
                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $vehicle->color_exterior ?? '-' }}"
                    readonly
                >

            </div>


            {{-- COULEUR INTÉRIEURE --}}

            <div class="col-md-6 mb-3">

                <label class="form-label fw-semibold">
                    Couleur intérieure
                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $vehicle->color_interior ?? '-' }}"
                    readonly
                >

            </div>

        </div>



        <hr class="my-4">



        {{-- ========================================================= --}}
        {{-- STOCK / ARRIVÉE --}}
        {{-- ========================================================= --}}

        <h5 class="fw-bold mb-3">

            <i class="ti ti-calendar me-1"></i>

            Informations de stock

        </h5>


        <div class="row">


            {{-- DATE D'ARRIVÉE --}}

            <div class="col-md-6 mb-3">

                <label class="form-label fw-semibold">
                    Date d’arrivée
                </label>

                <input
                    type="text"
                    class="form-control"

                    value="{{ $vehicle->arrival_date
                        ? \Carbon\Carbon::parse(
                            $vehicle->arrival_date
                        )->format('d/m/Y')
                        : '-'
                    }}"

                    readonly
                >

            </div>


            {{-- KILOMÉTRAGE --}}

            <div class="col-md-6 mb-3">

                <label class="form-label fw-semibold">
                    Kilométrage
                </label>

                <input
                    type="text"
                    class="form-control"

                    value="{{ $vehicle->mileage !== null
                        ? number_format(
                            (float) $vehicle->mileage,
                            0,
                            ',',
                            ' '
                        ) . ' km'
                        : '-'
                    }}"

                    readonly
                >

            </div>


            {{-- STATUT --}}

            <div class="col-md-6 mb-3">

                <label class="form-label fw-semibold d-block">
                    Statut
                </label>

                <div
                    class="
                        form-control
                        d-flex
                        align-items-center
                    "
                >

                    <span
                        class="
                            badge
                            {{ $badgeClass }}
                            px-3
                            py-2
                        "
                    >

                        {{ $status }}

                    </span>

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- COMMENTAIRE --}}
        {{-- ========================================================= --}}

        @if(!empty($vehicle->comment))

            <hr class="my-4">


            <h5 class="fw-bold mb-3">

                <i class="ti ti-message me-1"></i>

                Commentaire

            </h5>


            <div class="mb-3">

                <textarea
                    class="form-control"
                    rows="4"
                    readonly
                >{{ $vehicle->comment }}</textarea>

            </div>

        @endif



        {{-- ========================================================= --}}
        {{-- IMAGE --}}
        {{-- ========================================================= --}}

        @if(!empty($vehicle->image))

            <hr class="my-4">


            <h5 class="fw-bold mb-3">

                <i class="ti ti-photo me-1"></i>

                Image du véhicule

            </h5>


            <div class="mb-3">

                <img
                    src="{{ asset(
                        'storage/'
                        . $vehicle->image
                    ) }}"

                    alt="
                        {{ $vehicle->brand ?? '' }}
                        {{ $vehicle->model ?? '' }}
                    "

                    class="
                        img-fluid
                        rounded
                        shadow-sm
                    "

                    style="
                        max-width: 320px;
                        max-height: 230px;
                        object-fit: cover;
                    "
                >

            </div>

        @endif



        {{-- ========================================================= --}}
        {{-- DESCRIPTION PROFORMA --}}
        {{-- ========================================================= --}}

        <hr class="my-4">


        <h5 class="fw-bold mb-3">

            <i class="ti ti-file-description me-1"></i>

            Description commerciale

        </h5>


        @php

            $specifications = [];


            if (!empty($vehicle->configuration)) {
                $specifications[] =
                    $vehicle->configuration;
            }


            if (!empty($vehicle->engine_number)) {
                $specifications[] =
                    $vehicle->engine_number;
            }


            if (!empty($vehicle->engine_capacity)) {
                $specifications[] =
                    $vehicle->engine_capacity;
            }


            if (!empty($vehicle->fuel_type)) {
                $specifications[] =
                    $vehicle->fuel_type;
            }


            if (!empty($vehicle->doors)) {
                $specifications[] =
                    $vehicle->doors . ' Portes';
            }


            if (!empty($vehicle->model_year)) {
                $specifications[] =
                    'MY ' . $vehicle->model_year;
            }


            if (!empty($vehicle->cylinders)) {
                $specifications[] =
                    $vehicle->cylinders . ' Cylindres';
            }


            if (!empty($vehicle->tire_size)) {
                $specifications[] =
                    'Taille de pneu : '
                    . $vehicle->tire_size;
            }


            if (!empty($vehicle->transmission)) {
                $specifications[] =
                    $vehicle->transmission;
            }


            if (!empty($vehicle->seats)) {
                $specifications[] =
                    $vehicle->seats . ' Places';
            }

        @endphp


        <div
            class="
                alert
                alert-light
                border
                mb-0
            "
        >

            <strong>

                {{ $vehicle->brand ?? '-' }}

                {{ $vehicle->model ?? '' }}

            </strong>


            @if(count($specifications) > 0)

                <div class="mt-2">

                    {{ implode(
                        ', ',
                        $specifications
                    ) }}

                </div>

            @endif


            @if(!empty($vehicle->color_exterior))

                <div class="mt-1">

                    <strong>
                        Couleur extérieure :
                    </strong>

                    {{ $vehicle->color_exterior }}

                </div>

            @endif


            @if(!empty($vehicle->color_interior))

                <div class="mt-1">

                    <strong>
                        Couleur intérieure :
                    </strong>

                    {{ $vehicle->color_interior }}

                </div>

            @endif

        </div>



        {{-- ========================================================= --}}
        {{-- ACTIONS --}}
        {{-- ========================================================= --}}

        <div
            class="
                mt-4
                d-flex
                flex-wrap
                gap-2
            "
        >


            {{-- MODIFIER --}}

            @if(
                in_array(
                    $role,
                    [
                        'admin',
                        'logistique',
                        'mecanicien'
                    ],
                    true
                )
            )

                <a
                    href="{{ route(
                        'vehicles.edit',
                        $vehicle->id
                    ) }}"
                    class="btn btn-warning"
                >

                    <i class="ti ti-edit me-1"></i>

                    Modifier

                </a>

            @endif


            {{-- FERMER --}}

            <a
                href="{{ route('vehicles.index') }}"
                class="btn btn-light"
            >

                <i class="ti ti-x me-1"></i>

                Fermer

            </a>


        </div>


    </div>

</div>

@endsection
