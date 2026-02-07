@extends('layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div>
                <h2 class="mb-1">Détails voiture</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('vehicles.index') }}">
                                <i class="ti ti-car"></i> Voitures
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Détails</li>
                    </ol>
                </nav>
            </div>

            <div>
                <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary">
                    ← Retour
                </a>
            </div>
        </div>

        <!-- Card -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    {{ $vehicle->brand }} {{ $vehicle->model }}
                </h4>
            </div>

            <div class="card-body">

                <div class="row">

                    <!-- VIN -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">VIN</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $vehicle->vin }}"
                               readonly>
                    </div>

                    <!-- Plate Number -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Immatriculation</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $vehicle->plate_number }}"
                               readonly>
                    </div>

                    <!-- Brand -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Marque</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $vehicle->brand }}"
                               readonly>
                    </div>

                    <!-- Model -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Modèle</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $vehicle->model }}"
                               readonly>
                    </div>

                    <!-- Year -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Année</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $vehicle->year }}"
                               readonly>
                    </div>

                    <!-- Mileage -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kilométrage</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $vehicle->mileage }} km"
                               readonly>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Statut</label>

                        @php
                            $badgeClass = match($vehicle->status) {
                                'draft'      => 'bg-secondary',
                                'inspected'  => 'bg-info',
                                'approved'   => 'bg-success',
                                'rejected'   => 'bg-danger',
                                'sold'       => 'bg-warning',
                                default      => 'bg-dark'
                            };
                        @endphp

                        <span class="badge {{ $badgeClass }} p-2">
                            {{ ucfirst($vehicle->status) }}
                        </span>
                    </div>

                </div>

                <!-- Actions buttons -->
                <div class="mt-4">
                    <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                       class="btn btn-warning">
                        <i class="ti ti-edit"></i> Modifier
                    </a>

                    <a href="{{ route('vehicles.index') }}"
                       class="btn btn-light ms-2">
                        Fermer
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
