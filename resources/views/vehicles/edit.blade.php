@extends('layout.mainlayout')

@section('content')

@php
    $role = auth()->user()->role;

    $isAdmin = $role === 'admin';
    $isLogistique = $role === 'logistique';
    $isMecanicien = $role === 'mecanicien';
    $isVendeur = $role === 'vendeur';

    // Informations générales du véhicule :
    // admin, logistique et vendeur peuvent les modifier.
    $canEditVehicleInfo = in_array(
        $role,
        ['admin', 'logistique', 'vendeur'],
        true
    );

    // Statut technique :
    // seulement admin et mécanicien.
    $canEditTechnicalStatus = in_array(
        $role,
        ['admin', 'mecanicien'],
        true
    );

    // Commentaire et image :
    // le contrôleur autorise admin, mécanicien et vendeur.
    $canEditCommentAndImage = in_array(
        $role,
        ['admin', 'mecanicien', 'vendeur'],
        true
    );
@endphp


{{-- ============================================================= --}}
{{-- HEADER --}}
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
            Modifier la voiture
        </h2>

        <p class="text-muted mb-0">
            {{ $vehicle->brand ?? '' }}
            {{ $vehicle->model ?? '' }}

            @if(!empty($vehicle->vin))
                — VIN : {{ $vehicle->vin }}
            @endif
        </p>

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
{{-- CARD --}}
{{-- ============================================================= --}}
<div class="card shadow-sm border-0">

    <div class="card-header">

        <h5 class="card-title mb-0">
            Informations du véhicule
        </h5>

    </div>


    <div class="card-body">


        {{-- ========================================================= --}}
        {{-- ERREURS --}}
        {{-- ========================================================= --}}
        @if($errors->any())

            <div class="alert alert-danger">

                <strong>
                    Erreur :
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


        {{-- ========================================================= --}}
        {{-- VENDEUR --}}
        {{-- ========================================================= --}}
        @if($isVendeur)

            <div class="alert alert-info">

                <i class="ti ti-info-circle me-1"></i>

                Vous pouvez modifier les informations de ce véhicule
                tant qu’il est disponible.
                Le statut du véhicule reste verrouillé.

            </div>

        @endif


        {{-- ========================================================= --}}
        {{-- FORMULAIRE --}}
        {{-- ========================================================= --}}
        <form
            action="{{ route('vehicles.update', $vehicle->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')


            <div class="row">


                {{-- ================================================= --}}
                {{-- VIN --}}
                {{-- ================================================= --}}
                <div class="col-md-6 mb-3">

                    <label
                        for="vin"
                        class="form-label"
                    >
                        VIN
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="vin"
                        id="vin"

                        value="{{ old(
                            'vin',
                            $vehicle->vin
                        ) }}"

                        class="
                            form-control
                            @error('vin')
                                is-invalid
                            @enderror
                        "

                        placeholder="Ex : LGWEEUA58SL614280"

                        @if(!$canEditVehicleInfo)
                            readonly
                        @endif
                    >

                    @error('vin')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- MARQUE --}}
                {{-- ================================================= --}}
                <div class="col-md-6 mb-3">

                    <label
                        for="brand"
                        class="form-label"
                    >
                        Marque
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="brand"
                        id="brand"

                        value="{{ old(
                            'brand',
                            $vehicle->brand
                        ) }}"

                        class="
                            form-control
                            @error('brand')
                                is-invalid
                            @enderror
                        "

                        placeholder="Ex : GWM / Haval / Toyota"

                        @if(!$canEditVehicleInfo)
                            readonly
                        @endif
                    >

                    @error('brand')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- MODÈLE --}}
                {{-- ================================================= --}}
                <div class="col-md-6 mb-3">

                    <label
                        for="model"
                        class="form-label"
                    >
                        Modèle
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="model"
                        id="model"

                        value="{{ old(
                            'model',
                            $vehicle->model
                        ) }}"

                        class="
                            form-control
                            @error('model')
                                is-invalid
                            @enderror
                        "

                        placeholder="Ex : Jolion Pro HEV"

                        @if(!$canEditVehicleInfo)
                            readonly
                        @endif
                    >

                    @error('model')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- MODEL YEAR --}}
                {{-- ================================================= --}}
                <div class="col-md-6 mb-3">

                    <label
                        for="model_year"
                        class="form-label"
                    >
                        Model Year
                    </label>

                    <input
                        type="number"
                        name="model_year"
                        id="model_year"

                        value="{{ old(
                            'model_year',
                            $vehicle->model_year
                        ) }}"

                        class="
                            form-control
                            @error('model_year')
                                is-invalid
                            @enderror
                        "

                        min="1900"
                        max="2100"

                        placeholder="Ex : 2026"

                        @if(!$canEditVehicleInfo)
                            readonly
                        @endif
                    >

                    @error('model_year')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- CONFIGURATION --}}
                {{-- ================================================= --}}
                <div class="col-md-6 mb-3">

                    <label
                        for="configuration"
                        class="form-label"
                    >
                        Configuration
                    </label>

                    <input
                        type="text"
                        name="configuration"
                        id="configuration"

                        value="{{ old(
                            'configuration',
                            $vehicle->configuration
                        ) }}"

                        class="
                            form-control
                            @error('configuration')
                                is-invalid
                            @enderror
                        "

                        placeholder="
                            Ex : Semi-Full option
                        "

                        @if(!$canEditVehicleInfo)
                            readonly
                        @endif
                    >

                    @error('configuration')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- ENGINE NUMBER --}}
                {{-- ================================================= --}}
                <div class="col-md-6 mb-3">

                    <label
                        for="engine_number"
                        class="form-label"
                    >
                        Engine Number
                    </label>

                    <input
                        type="text"
                        name="engine_number"
                        id="engine_number"

                        value="{{ old(
                            'engine_number',
                            $vehicle->engine_number
                        ) }}"

                        class="
                            form-control
                            @error('engine_number')
                                is-invalid
                            @enderror
                        "

                        placeholder="Ex : 4G15K"

                        @if(!$canEditVehicleInfo)
                            readonly
                        @endif
                    >

                    @error('engine_number')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- CYLINDRÉE --}}
                {{-- ================================================= --}}
                <div class="col-md-6 mb-3">

                    <label
                        for="engine_capacity"
                        class="form-label"
                    >
                        Cylindrée
                    </label>

                    <input
                        type="text"
                        name="engine_capacity"
                        id="engine_capacity"

                        value="{{ old(
                            'engine_capacity',
                            $vehicle->engine_capacity
                        ) }}"

                        class="
                            form-control
                            @error('engine_capacity')
                                is-invalid
                            @enderror
                        "

                        placeholder="Ex : 1.5L"

                        @if(!$canEditVehicleInfo)
                            readonly
                        @endif
                    >

                    @error('engine_capacity')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- CARBURANT / ÉNERGIE --}}
                {{-- ================================================= --}}
                <div class="col-md-6 mb-3">

                    <label
                        for="fuel_type"
                        class="form-label"
                    >
                        Carburant / Énergie
                    </label>

                    @if($canEditVehicleInfo)

                        <select
                            name="fuel_type"
                            id="fuel_type"

                            class="
                                form-select
                                @error('fuel_type')
                                    is-invalid
                                @enderror
                            "
                        >

                            <option value="">
                                -- Sélectionner --
                            </option>

                            <option
                                value="Essence"
                                @selected(
                                    old(
                                        'fuel_type',
                                        $vehicle->fuel_type
                                    ) === 'Essence'
                                )
                            >
                                Essence
                            </option>

                            <option
                                value="Gasoline"
                                @selected(
                                    old(
                                        'fuel_type',
                                        $vehicle->fuel_type
                                    ) === 'Gasoline'
                                )
                            >
                                Gasoline
                            </option>

                            <option
                                value="Diesel"
                                @selected(
                                    old(
                                        'fuel_type',
                                        $vehicle->fuel_type
                                    ) === 'Diesel'
                                )
                            >
                                Diesel
                            </option>

                            <option
                                value="HEV"
                                @selected(
                                    old(
                                        'fuel_type',
                                        $vehicle->fuel_type
                                    ) === 'HEV'
                                )
                            >
                                HEV
                            </option>

                            <option
                                value="PHEV"
                                @selected(
                                    old(
                                        'fuel_type',
                                        $vehicle->fuel_type
                                    ) === 'PHEV'
                                )
                            >
                                PHEV
                            </option>

                            <option
                                value="Électrique"
                                @selected(
                                    old(
                                        'fuel_type',
                                        $vehicle->fuel_type
                                    ) === 'Électrique'
                                )
                            >
                                Électrique
                            </option>

                        </select>

                    @else

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $vehicle->fuel_type ?? '-' }}"
                            readonly
                        >

                    @endif


                    @error('fuel_type')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- NOMBRE DE PORTES --}}
                {{-- ================================================= --}}
                <div class="col-md-4 mb-3">

                    <label
                        for="doors"
                        class="form-label"
                    >
                        Nombre de portes
                    </label>

                    <input
                        type="number"
                        name="doors"
                        id="doors"

                        value="{{ old(
                            'doors',
                            $vehicle->doors
                        ) }}"

                        class="
                            form-control
                            @error('doors')
                                is-invalid
                            @enderror
                        "

                        placeholder="Ex : 5"

                        min="1"
                        max="20"

                        @if(!$canEditVehicleInfo)
                            readonly
                        @endif
                    >

                    @error('doors')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- CYLINDRES --}}
                {{-- ================================================= --}}
                <div class="col-md-4 mb-3">

                    <label
                        for="cylinders"
                        class="form-label"
                    >
                        Nombre de cylindres
                    </label>

                    <input
                        type="number"
                        name="cylinders"
                        id="cylinders"

                        value="{{ old(
                            'cylinders',
                            $vehicle->cylinders
                        ) }}"

                        class="
                            form-control
                            @error('cylinders')
                                is-invalid
                            @enderror
                        "

                        placeholder="Ex : 4"

                        min="1"
                        max="20"

                        @if(!$canEditVehicleInfo)
                            readonly
                        @endif
                    >

                    @error('cylinders')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- NOMBRE DE PLACES --}}
                {{-- ================================================= --}}
                <div class="col-md-4 mb-3">

                    <label
                        for="seats"
                        class="form-label"
                    >
                        Nombre de places
                    </label>

                    <input
                        type="number"
                        name="seats"
                        id="seats"

                        value="{{ old(
                            'seats',
                            $vehicle->seats
                        ) }}"

                        class="
                            form-control
                            @error('seats')
                                is-invalid
                            @enderror
                        "

                        placeholder="Ex : 5"

                        min="1"
                        max="100"

                        @if(!$canEditVehicleInfo)
                            readonly
                        @endif
                    >

                    @error('seats')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- TAILLE DES PNEUS --}}
                {{-- ================================================= --}}
                <div class="col-md-6 mb-3">

                    <label
                        for="tire_size"
                        class="form-label"
                    >
                        Taille des pneus
                    </label>

                    <input
                        type="text"
                        name="tire_size"
                        id="tire_size"

                        value="{{ old(
                            'tire_size',
                            $vehicle->tire_size
                        ) }}"

                        class="
                            form-control
                            @error('tire_size')
                                is-invalid
                            @enderror
                        "

                        placeholder="Ex : 225/55R18"

                        @if(!$canEditVehicleInfo)
                            readonly
                        @endif
                    >

                    @error('tire_size')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- TRANSMISSION --}}
                {{-- ================================================= --}}
                <div class="col-md-6 mb-3">

                    <label
                        for="transmission"
                        class="form-label"
                    >
                        Transmission
                    </label>

                    <input
                        type="text"
                        name="transmission"
                        id="transmission"

                        value="{{ old(
                            'transmission',
                            $vehicle->transmission
                        ) }}"

                        class="
                            form-control
                            @error('transmission')
                                is-invalid
                            @enderror
                        "

                        placeholder="
                            Ex : 7 Vitesses automatique (A/T)
                        "

                        @if(!$canEditVehicleInfo)
                            readonly
                        @endif
                    >

                    @error('transmission')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- COULEUR EXTÉRIEURE --}}
                {{-- ================================================= --}}
                <div class="col-md-6 mb-3">

                    <label
                        for="color_exterior"
                        class="form-label"
                    >
                        Couleur extérieure
                    </label>

                    <input
                        type="text"
                        name="color_exterior"
                        id="color_exterior"

                        value="{{ old(
                            'color_exterior',
                            $vehicle->color_exterior
                        ) }}"

                        class="
                            form-control
                            @error('color_exterior')
                                is-invalid
                            @enderror
                        "

                        placeholder="Ex : Blue"

                        @if(!$canEditVehicleInfo)
                            readonly
                        @endif
                    >

                    @error('color_exterior')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- COULEUR INTÉRIEURE --}}
                {{-- ================================================= --}}
                <div class="col-md-6 mb-3">

                    <label
                        for="color_interior"
                        class="form-label"
                    >
                        Couleur intérieure
                    </label>

                    <input
                        type="text"
                        name="color_interior"
                        id="color_interior"

                        value="{{ old(
                            'color_interior',
                            $vehicle->color_interior
                        ) }}"

                        class="
                            form-control
                            @error('color_interior')
                                is-invalid
                            @enderror
                        "

                        placeholder="Ex : Black"

                        @if(!$canEditVehicleInfo)
                            readonly
                        @endif
                    >

                    @error('color_interior')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- DATE D’ARRIVÉE --}}
                {{-- ================================================= --}}
                <div class="col-md-6 mb-3">

                    <label
                        for="arrival_date"
                        class="form-label"
                    >
                        Date d’arrivée
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="date"
                        name="arrival_date"
                        id="arrival_date"

                        value="{{ old(
                            'arrival_date',
                            $vehicle->arrival_date
                                ? \Carbon\Carbon::parse(
                                    $vehicle->arrival_date
                                )->format('Y-m-d')
                                : ''
                        ) }}"

                        class="
                            form-control
                            @error('arrival_date')
                                is-invalid
                            @enderror
                        "

                        @if(!$canEditVehicleInfo)
                            readonly
                        @endif
                    >

                    @error('arrival_date')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- KILOMÉTRAGE --}}
                {{-- ================================================= --}}
                <div class="col-md-6 mb-3">

                    <label
                        for="mileage"
                        class="form-label"
                    >
                        Kilométrage
                    </label>

                    <input
                        type="number"
                        name="mileage"
                        id="mileage"

                        value="{{ old(
                            'mileage',
                            $vehicle->mileage
                        ) }}"

                        class="
                            form-control
                            @error('mileage')
                                is-invalid
                            @enderror
                        "

                        min="0"

                        @if(!$canEditVehicleInfo)
                            readonly
                        @endif
                    >

                    @error('mileage')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

                {{-- ================================================= --}}
                {{-- STATUT DU VÉHICULE --}}
                {{-- ================================================= --}}

                @if($isAdmin)

                    <div class="col-md-6 mb-3">

                        <label for="status" class="form-label">
                            Statut du véhicule
                        </label>

                        <select
                            name="status"
                            id="status"
                            class="form-select @error('status') is-invalid @enderror"
                        >

                            <option
                                value="Disponible"
                                @selected(old('status', $vehicle->status) === 'Disponible')
                            >
                                Disponible
                            </option>

                            <option
                                value="En réparation"
                                @selected(old('status', $vehicle->status) === 'En réparation')
                            >
                                En réparation
                            </option>

                            <option
                                value="En attente"
                                @selected(old('status', $vehicle->status) === 'En attente')
                            >
                                En attente
                            </option>

                            <option
                                value="Pièces prélevées"
                                @selected(old('status', $vehicle->status) === 'Pièces prélevées')
                            >
                                Pièces prélevées
                            </option>

                            <option
                                value="Vendu"
                                @selected(old('status', $vehicle->status) === 'Vendu')
                            >
                                Vendu
                            </option>

                            <option
                                value="Payé"
                                @selected(old('status', $vehicle->status) === 'Payé')
                            >
                                Payé
                            </option>

                        </select>

                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        @if($vehicle->status === 'Vendu')
                            <small class="text-muted d-block mt-2">
                                Ce véhicule est actuellement vendu.
                                Il restera « Vendu » tant que vous ne choisissez
                                pas volontairement un autre statut.
                            </small>
                        @elseif($vehicle->status === 'Payé')
                            <small class="text-muted d-block mt-2">
                                Ce véhicule est actuellement payé.
                            </small>
                        @endif

                    </div>


                @elseif($isMecanicien)

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Statut du véhicule
                        </label>

                        @if(in_array($vehicle->status, ['Vendu', 'Payé'], true))

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $vehicle->status }}"
                                readonly
                            >

                            <small class="text-muted d-block mt-2">
                                Le mécanicien ne peut pas modifier
                                le statut d’un véhicule vendu ou payé.
                            </small>

                        @else

                            <select
                                name="status"
                                id="status"
                                class="form-select @error('status') is-invalid @enderror"
                            >

                                <option
                                    value="Disponible"
                                    @selected(old('status', $vehicle->status) === 'Disponible')
                                >
                                    Disponible
                                </option>

                                <option
                                    value="En réparation"
                                    @selected(old('status', $vehicle->status) === 'En réparation')
                                >
                                    En réparation
                                </option>

                                <option
                                    value="En attente"
                                    @selected(old('status', $vehicle->status) === 'En attente')
                                >
                                    En attente
                                </option>

                                <option
                                    value="Pièces prélevées"
                                    @selected(old('status', $vehicle->status) === 'Pièces prélevées')
                                >
                                    Pièces prélevées
                                </option>

                            </select>

                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        @endif

                    </div>


                @elseif($isLogistique)

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Statut du véhicule
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $vehicle->status ?? '-' }}"
                            readonly
                        >

                    </div>


                @else

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Statut du véhicule
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $vehicle->status ?? '-' }}"
                            readonly
                        >

                    </div>

                @endif



                {{-- ================================================= --}}
                {{-- COMMENTAIRE MÉCANICIEN --}}
                {{-- ================================================= --}}
                @if($canEditCommentAndImage)

                    <div class="col-md-12 mb-3">

                        <label
                            for="comment"
                            class="form-label"
                        >
                            Commentaire
                        </label>

                        <textarea
                            name="comment"
                            id="comment"

                            class="
                                form-control
                                @error('comment')
                                    is-invalid
                                @enderror
                            "

                            rows="3"

                            placeholder="
                                Commentaire ou observation...
                            "
                        >{{ old(
                            'comment',
                            $vehicle->comment
                        ) }}</textarea>

                        @error('comment')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                @elseif(!empty($vehicle->comment))

                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            Commentaire
                        </label>

                        <textarea
                            class="form-control"
                            rows="3"
                            readonly
                        >{{ $vehicle->comment }}</textarea>

                    </div>

                @endif


                {{-- ================================================= --}}
                {{-- IMAGE --}}
                {{-- ================================================= --}}
                <div class="col-md-6 mb-3">

                    <label
                        for="image"
                        class="form-label"
                    >
                        Image voiture
                    </label>


                    @if($canEditCommentAndImage)

                        <input
                            type="file"
                            name="image"
                            id="image"

                            class="
                                form-control
                                @error('image')
                                    is-invalid
                                @enderror
                            "

                            accept="image/*"
                        >

                        @error('image')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    @endif


                    @if($vehicle->image)

                        <div class="mt-3">

                            <img
                                src="{{ asset(
                                    'storage/'
                                    . $vehicle->image
                                ) }}"
                                alt="Image du véhicule"

                                style="
                                    width: 150px;
                                    max-height: 120px;
                                    object-fit: cover;
                                    border-radius: 10px;
                                "
                            >

                        </div>

                    @else

                        <div class="text-muted mt-2">
                            Aucune image
                        </div>

                    @endif

                </div>


            </div>


            {{-- ========================================================= --}}
            {{-- BOUTONS --}}
            {{-- ========================================================= --}}
            <div
                class="
                    d-flex
                    justify-content-end
                    mt-4
                    gap-2
                "
            >

                <a
                    href="{{ route('vehicles.index') }}"
                    class="btn btn-light"
                >
                    Annuler
                </a>


                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i class="ti ti-device-floppy me-1"></i>

                    Mettre à jour
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
