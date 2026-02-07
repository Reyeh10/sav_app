@extends('layout.mainlayout')

@section('content')

<div class="page-wrapper">
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div>
                <h2 class="mb-1">Voiture</h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="ti ti-car"></i></a>
                    </li>
                    <li class="breadcrumb-item active">Liste des voitures</li>
                </ol>
            </div>

            <div class="d-flex align-items-center">

                <!-- Export -->
                <div class="dropdown me-2">
                    <a href="#" class="btn btn-white dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="ti ti-file-export me-1"></i> Export
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a href="#" class="dropdown-item">
                                <i class="ti ti-file-type-pdf me-1"></i> PDF
                            </a>
                        </li>
                        <li>
                            <a href="#" class="dropdown-item">
                                <i class="ti ti-file-type-xls me-1"></i> Excel
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Ajouter voiture -->
                <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
                    <i class="ti ti-circle-plus me-2"></i>
                    Ajouter une voiture
                </a>

            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Table Card -->
        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped table-bordered datatable w-100">

                        <!-- HEADER -->
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>VIN</th>
                                <th>Marque</th>
                                <th>Modèle</th>
                                <th>Année</th>
                                <th>Kilométrage</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <!-- BODY -->
                        <tbody>
                            @foreach($vehicles as $vehicle)
                                <tr>
                                    <td>{{ $vehicle->id }}</td>
                                    <td>{{ $vehicle->vin }}</td>
                                    <td>{{ $vehicle->brand }}</td>
                                    <td>{{ $vehicle->model }}</td>
                                    <td>{{ $vehicle->year }}</td>
                                    <td>{{ $vehicle->mileage }}</td>

                                    <!--td>
                                        <span class="badge bg-success">
                                            { { ucfirst($vehicle->status) }}
                                        </span>
                                    </td-->

                                    <td>
                                        @php
                                            $badgeClass = match($vehicle->status) {
                                                'draft'     => 'bg-secondary',
                                                'approved'  => 'bg-success',
                                                'rejected'  => 'bg-danger',
                                                'sold'      => 'bg-warning',
                                                default     => 'bg-dark',
                                            };
                                        @endphp

                                        <span class="badge {{ $badgeClass }}">
                                            {{ ucfirst($vehicle->status) }}
                                        </span>
                                    </td>


                                    <td>
                                        <div class="d-flex gap-2">

                                            <!-- Voir -->
                                            <a href="{{ route('vehicles.show', $vehicle->id) }}"
                                               class="btn btn-sm btn-info">
                                                <i class="ti ti-eye"></i>
                                            </a>

                                            <!-- Modifier -->
                                            <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                                               class="btn btn-sm btn-warning">
                                                <i class="ti ti-edit"></i>
                                            </a>

                                            <!-- Supprimer -->
                                            <form action="{{ route('vehicles.destroy', $vehicle->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Voulez-vous supprimer cette voiture ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
        <!-- /Table Card -->

    </div>
</div>

@endsection
