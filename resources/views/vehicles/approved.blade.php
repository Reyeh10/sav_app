@extends('layout.mainlayout')

@section('content')

        <div class="page-wrapper">
        <div class="content">

        <h2 class="mb-2">Voitures disponibles à vendre</h2>
        <p class="text-muted">Liste des véhicules prêts pour la vente</p>

        <div class="card">
        <div class="card-body">

        <div class="table-responsive">

        <table class="table table-striped table-bordered">

        <thead class="table-light">
        <tr>
        <th>VIN</th>
        <th>Marque</th>
        <th>Modèle</th>
        <th>Extérieur</th>
        <th>Intérieur</th>
        <th>Année</th>
        <th>Date arrivée</th>
        <th>Kilométrage</th>
        <th>Status</th>
        </tr>
        </thead>

        <tbody>

        @forelse($vehicles as $vehicle)

        <tr>
        <td>{{ $vehicle->vin }}</td>
        <td>{{ $vehicle->brand }}</td>
        <td>{{ $vehicle->model }}</td>
        <td>{{ $vehicle->color_exterior ?? '-' }}</td>
        <td>{{ $vehicle->color_interior ?? '-' }}</td>
        <td>{{ $vehicle->year }}</td>
        <td>{{ $vehicle->arrival_date ?? '-' }}</td>
        <td>{{ number_format($vehicle->mileage) }}</td>

        <td>

        @php
        $badgeClass = match($vehicle->status) {
        'draft' => 'bg-secondary',
        'inspected' => 'bg-info',
        'approved' => 'bg-success',
        'rejected' => 'bg-danger',
        'sold' => 'bg-warning',
        default => 'bg-dark'
        };
        @endphp

        <span class="badge {{ $badgeClass }}">
        {{ ucfirst($vehicle->status) }}
        </span>

        </td>

        </tr>

        @empty

        <tr>
        <td colspan="9" class="text-center text-muted">
        Aucune voiture disponible
        </td>
        </tr>

        @endforelse

        </tbody>

        </table>

        </div>
        </div>
        </div>

        </div>
        </div>

@endsection
