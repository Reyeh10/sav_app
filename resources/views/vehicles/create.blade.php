@extends('layout.mainlayout')

@section('content')

<div class="page-wrapper">
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
            <div class="my-auto">
                <h2 class="mb-1">Ajouter une voiture</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('vehicles.index') }}">
                                <i class="ti ti-car"></i> Voitures
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Ajouter</li>
                    </ol>
                </nav>
            </div>

            <div>
                <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary">
                    ⬅ Retour
                </a>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Informations du véhicule</h5>
            </div>

            <div class="card-body">

                <!-- Form -->
                <form action="{{ route('vehicles.store') }}"
                      method="POST"
                      enctype="multipart/form-data">
                      @csrf

                    <div class="row">

                        <!-- VIN -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">VIN *</label>
                            <input type="text" name="vin"
                                   class="form-control"
                                   placeholder="Ex: 1HGCM82633A123456"
                                   required>
                        </div>

                        <!-- Plate Number -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Immatriculation</label>
                            <input type="text" name="plate_number"
                                   class="form-control"
                                   placeholder="Ex: AB-123-CD">
                        </div>

                        <!-- Brand -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Marque *</label>
                            <input type="text" name="brand"
                                   class="form-control"
                                   placeholder="Ex: Toyota"
                                   required>
                        </div>

                        <!-- Model -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Modèle *</label>
                            <input type="text" name="model"
                                   class="form-control"
                                   placeholder="Ex: Corolla"
                                   required>
                        </div>
                        <!-- Couleur exterieur -->
                        <div class="form-group mb-3">
                            <label class="form-label">Couleur extérieure</label>
                            <input type="text"
                                name="color_exterior"
                                class="form-control"
                                placeholder="Ex : Rouge"
                                value="{{ old('color_exterior') }}">
                        </div>

                        <!-- Couleur interieur -->
                        <div class="form-group mb-3">
                            <label class="form-label">Couleur intérieure</label>
                            <input type="text"
                                name="color_interior"
                                class="form-control"
                                placeholder="Ex : Noir"
                                value="{{ old('color_interior') }}">
                        </div>

                        <!-- Year -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Année *</label>
                            <input type="number" name="year"
                                   class="form-control"
                                   placeholder="2022"
                                   required>
                        </div>
                         <!-- Date d'arrivee -->
                         <div class="form-group mb-3">
                            <label class="form-label">Date d’arrivée</label>
                            <input type="date"
                                name="arrival_date"
                                class="form-control"
                                value="{{ old('arrival_date') }}">
                        </div>

                        <!-- Mileage -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Kilométrage *</label>
                            <input type="number" name="mileage"
                                   class="form-control"
                                   placeholder="45000"
                                   required>
                        </div>

                        <!-- Status -->
                        <!--@ if(auth()->user()->isAdmin() || auth()->user()->isMecanicien())-->
                        @if(!auth()->user()->isLogistique())
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Statut</label>
                                <select name="status" class="form-select">
                                    <option value="draft" selected>Brouillon</option>
                                    <option value="inspected">Inspectée</option>
                                    <option value="approved">Approuvée</option>
                                    <option value="rejected">Rejetée</option>
                                    <option value="sold">Vendue</option>
                                </select>
                            </div>
                        @endif
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-end mt-4 gap-2">

                        <a href="{{ route('vehicles.index') }}"
                           class="btn btn-light">
                            Annuler
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i>
                            Enregistrer
                        </button>

                    </div>

                    <div class="col-md-6">
                         <!-- image -->
                    <label>Image voiture</label>
                        <input type="file" name="image" class="form-control">
                    </div>


                </form>
                <!-- /Form -->

            </div>
        </div>
        <!-- /Card -->

    </div>
</div>

@endsection
