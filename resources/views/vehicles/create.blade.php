@extends('layout.mainlayout')

@section('content')

@php
    $role = auth()->user()->role;
@endphp

<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">

    <div>
        <h2 class="mb-1">
            Ajouter une voiture
        </h2>
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


<div class="card shadow-sm border-0">

    <div class="card-header">
        <h5 class="card-title mb-0">
            Informations du véhicule
        </h5>
    </div>


    <div class="card-body">

        {{-- ============================================================= --}}
        {{-- ERREURS GLOBALES --}}
        {{-- ============================================================= --}}

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


        {{-- ============================================================= --}}
        {{-- FORMULAIRE --}}
        {{-- ============================================================= --}}

        <form
            action="{{ route('vehicles.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


            <div class="row">


                {{-- ===================================================== --}}
                {{-- VIN --}}
                {{-- ===================================================== --}}

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
                        value="{{ old('vin') }}"
                        class="form-control @error('vin') is-invalid @enderror"
                        placeholder="Ex : LGWEEUA58SL614280"
                        required
                    >

                    @error('vin')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ===================================================== --}}
                {{-- MARQUE --}}
                {{-- ===================================================== --}}

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
                        value="{{ old('brand') }}"
                        class="form-control @error('brand') is-invalid @enderror"
                        placeholder="Ex : GWM / Haval / Toyota"
                        required
                    >

                    @error('brand')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ===================================================== --}}
                {{-- MODÈLE --}}
                {{-- ===================================================== --}}

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
                        value="{{ old('model') }}"
                        class="form-control @error('model') is-invalid @enderror"
                        placeholder="Ex : Jolion Pro HEV"
                        required
                    >

                    @error('model')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ===================================================== --}}
                {{-- MODEL YEAR --}}
                {{-- ===================================================== --}}

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
                        value="{{ old('model_year') }}"
                        class="form-control @error('model_year') is-invalid @enderror"
                        placeholder="Ex : 2026"
                        min="1900"
                        max="2100"
                    >

                    @error('model_year')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ===================================================== --}}
                {{-- CONFIGURATION --}}
                {{-- ===================================================== --}}

                @if(in_array($role, ['admin', 'logistique'], true))

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
                            value="{{ old('configuration') }}"
                            class="form-control @error('configuration') is-invalid @enderror"
                            placeholder="Ex : Semi-Full option"
                        >

                        @error('configuration')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                @endif


                {{-- ===================================================== --}}
                {{-- ENGINE NUMBER --}}
                {{-- ===================================================== --}}

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
                        value="{{ old('engine_number') }}"
                        class="form-control @error('engine_number') is-invalid @enderror"
                        placeholder="Ex : 4G15K"
                    >

                    @error('engine_number')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ===================================================== --}}
                {{-- CYLINDRÉE --}}
                {{-- ===================================================== --}}

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
                        value="{{ old('engine_capacity') }}"
                        class="form-control @error('engine_capacity') is-invalid @enderror"
                        placeholder="Ex : 1.5L"
                    >

                    @error('engine_capacity')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ===================================================== --}}
                {{-- CARBURANT / ÉNERGIE --}}
                {{-- ===================================================== --}}

                <div class="col-md-6 mb-3">

                    <label
                        for="fuel_type"
                        class="form-label"
                    >
                        Carburant / Énergie
                    </label>

                    <select
                        name="fuel_type"
                        id="fuel_type"
                        class="form-select @error('fuel_type') is-invalid @enderror"
                    >

                        <option value="">
                            -- Sélectionner --
                        </option>

                        <option
                            value="Essence"
                            @selected(old('fuel_type') === 'Essence')
                        >
                            Essence
                        </option>

                        <option
                            value="Gasoline"
                            @selected(old('fuel_type') === 'Gasoline')
                        >
                            Gasoline
                        </option>

                        <option
                            value="Diesel"
                            @selected(old('fuel_type') === 'Diesel')
                        >
                            Diesel
                        </option>

                        <option
                            value="HEV"
                            @selected(old('fuel_type') === 'HEV')
                        >
                            HEV
                        </option>

                        <option
                            value="PHEV"
                            @selected(old('fuel_type') === 'PHEV')
                        >
                            PHEV
                        </option>

                        <option
                            value="Électrique"
                            @selected(old('fuel_type') === 'Électrique')
                        >
                            Électrique
                        </option>

                    </select>

                    @error('fuel_type')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ===================================================== --}}
                {{-- NOMBRE DE PORTES --}}
                {{-- ===================================================== --}}

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
                        value="{{ old('doors') }}"
                        class="form-control @error('doors') is-invalid @enderror"
                        placeholder="Ex : 5"
                        min="1"
                        max="20"
                    >

                    @error('doors')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ===================================================== --}}
                {{-- CYLINDRES --}}
                {{-- ===================================================== --}}

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
                        value="{{ old('cylinders') }}"
                        class="form-control @error('cylinders') is-invalid @enderror"
                        placeholder="Ex : 4"
                        min="1"
                        max="20"
                    >

                    @error('cylinders')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ===================================================== --}}
                {{-- NOMBRE DE PLACES --}}
                {{-- ===================================================== --}}

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
                        value="{{ old('seats') }}"
                        class="form-control @error('seats') is-invalid @enderror"
                        placeholder="Ex : 5"
                        min="1"
                        max="100"
                    >

                    @error('seats')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ===================================================== --}}
                {{-- TAILLE DES PNEUS --}}
                {{-- ===================================================== --}}

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
                        value="{{ old('tire_size') }}"
                        class="form-control @error('tire_size') is-invalid @enderror"
                        placeholder="Ex : 225/55R18"
                    >

                    @error('tire_size')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ===================================================== --}}
                {{-- TRANSMISSION --}}
                {{-- ===================================================== --}}

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
                        value="{{ old('transmission') }}"
                        class="form-control @error('transmission') is-invalid @enderror"
                        placeholder="Ex : 7 Vitesses automatique (A/T)"
                    >

                    @error('transmission')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ===================================================== --}}
                {{-- COULEUR EXTÉRIEURE --}}
                {{-- ===================================================== --}}

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
                        value="{{ old('color_exterior') }}"
                        class="form-control @error('color_exterior') is-invalid @enderror"
                        placeholder="Ex : Blue"
                    >

                    @error('color_exterior')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ===================================================== --}}
                {{-- COULEUR INTÉRIEURE --}}
                {{-- ===================================================== --}}

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
                        value="{{ old('color_interior') }}"
                        class="form-control @error('color_interior') is-invalid @enderror"
                        placeholder="Ex : Black"
                    >

                    @error('color_interior')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ===================================================== --}}
                {{-- DATE D'ARRIVÉE --}}
                {{-- ===================================================== --}}

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
                        value="{{ old('arrival_date') }}"
                        class="form-control @error('arrival_date') is-invalid @enderror"
                        required
                    >

                    @error('arrival_date')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ===================================================== --}}
                {{-- KILOMÉTRAGE --}}
                {{-- ===================================================== --}}

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
                        value="{{ old('mileage', 0) }}"
                        class="form-control @error('mileage') is-invalid @enderror"
                        min="0"
                    >

                    @error('mileage')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ===================================================== --}}
                {{-- STATUT --}}
                {{-- ===================================================== --}}

                @if($role === 'admin')

                    <div class="col-md-6 mb-3">

                        <label
                            for="status"
                            class="form-label"
                        >
                            Statut
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="status"
                            id="status"
                            class="form-select @error('status') is-invalid @enderror"
                        >

                            <option
                                value="Disponible"
                                @selected(old('status') === 'Disponible')
                            >
                                Disponible
                            </option>

                            <option
                                value="En réparation"
                                @selected(old('status') === 'En réparation')
                            >
                                En réparation
                            </option>

                            <option
                                value="En attente"
                                @selected(old('status', 'En attente') === 'En attente')
                            >
                                En attente
                            </option>

                            <option
                                value="Vendu"
                                @selected(old('status') === 'Vendu')
                            >
                                Vendu
                            </option>

                            <option
                                value="Pièces prélevées"
                                @selected(old('status') === 'Pièces prélevées')
                            >
                                Pièces prélevées
                            </option>

                        </select>

                        @error('status')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                @endif


                {{-- ===================================================== --}}
                {{-- COMMENTAIRE --}}
                {{-- ===================================================== --}}

                @if(
                    $role === 'admin'
                    || $role === 'mecanicien'
                )

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
                            class="form-control @error('comment') is-invalid @enderror"
                            rows="3"
                            placeholder="Commentaire ou observation..."
                        >{{ old('comment') }}</textarea>

                        @error('comment')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                @endif


                {{-- ===================================================== --}}
                {{-- IMAGE --}}
                {{-- ===================================================== --}}

                @if($role === 'admin')

                    <div class="col-md-6 mb-3">

                        <label
                            for="image"
                            class="form-label"
                        >
                            Image voiture
                        </label>

                        <input
                            type="file"
                            name="image"
                            id="image"
                            class="form-control @error('image') is-invalid @enderror"
                            accept="image/*"
                        >

                        @error('image')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                @endif

            </div>


            {{-- ========================================================= --}}
            {{-- BOUTONS --}}
            {{-- ========================================================= --}}

            <div class="d-flex justify-content-end mt-4 gap-2">

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
                    Enregistrer
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
