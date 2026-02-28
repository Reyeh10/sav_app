@extends('layout.mainlayout')

@section('content')

<!--div class="page-wrapper">
<div class="content"-->

<h2 class="mb-2">Voitures disponibles à vendre</h2>
<p class="text-muted">Liste des véhicules prêts pour la vente</p>
<!-- ================= SEARCH ================= -->
<form method="GET" action="{{ route('vehicles.approved') }}" class="mb-3">
    <div class="row g-2 align-items-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="ti ti-search"></i>
                </span>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control"
                       placeholder="Rechercher par VIN, marque, modèle...">
            </div>
        </div>

        <div class="col-12 col-md-auto">
            <button type="submit" class="btn btn-orange w-100">
                Rechercher
            </button>
        </div>

        @if(request('search'))
        <div class="col-12 col-md-auto">
            <a href="{{ route('vehicles.approved') }}" class="btn btn-light w-100">
                Effacer
            </a>
        </div>
        @endif
    </div>
</form>
<!-- ================= TABLE ================= -->
<div class="card">
<div class="card-body">
<div class="table-responsive">
<table class="table table-striped table-bordered align-middle">
<thead class="table-light">

<tr>
<th>Image</th>
<th>VIN</th>
<th>Brand</th>
<th>Model</th>
<th>Color exterior</th>
<th>Color interior</th>
<th>Model year</th>
<th>Engine</th>
<th>Configuration</th>
<th>Engine Number</th>
<th>Arrival date</th>
<th>Sale price</th>
<th>Status</th>
<th>Comment</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

@forelse($vehicles as $vehicle)

<tr>

<!-- IMAGE -->
<td>
@if($vehicle->image)
    <img src="{{ asset('storage/'.$vehicle->image) }}"
         width="60"
         height="60"
         style="object-fit:cover;border-radius:8px;">
@else
    <span class="badge bg-light text-dark">No Image</span>
@endif
</td>

<td>{{ $vehicle->vin }}</td>
<td>{{ $vehicle->brand }}</td>
<td>{{ $vehicle->model }}</td>
<td>{{ $vehicle->color_exterior ?? '-' }}</td>
<td>{{ $vehicle->color_interior ?? '-' }}</td>
<td>{{ $vehicle->year }}</td>
<td>{{ $vehicle->engine ?? '-' }}</td>
<td>{{ $vehicle->configuration ?? '-' }}</td>
<td>{{ $vehicle->engine_number ?? '-' }}</td>
<td>{{ $vehicle->arrival_date ?? '-' }}</td>

<td>
@if($vehicle->sale_price)
    {{ number_format($vehicle->sale_price, 2, ',', ' ') }} $
@else
    -
@endif
</td>

<!-- STATUS -->
<td>
@if($vehicle->status == 'Disponible')
    <span class="badge bg-success">Disponible</span>
@elseif($vehicle->status == 'En réparation')
    <span class="badge bg-warning text-dark">En réparation</span>
@elseif($vehicle->status == 'En attente')
    <span class="badge bg-secondary">En attente</span>
@elseif($vehicle->status == 'Vendu')
    <span class="badge bg-danger">Vendu</span>
@else
    <span class="badge bg-dark">{{ $vehicle->status }}</span>
@endif
</td>

<td>{{ $vehicle->comment ?? '-' }}</td>

<!-- ACTIONS -->
<td>
@if(auth()->user()->role == 'vendeur' && $vehicle->status == 'Disponible')
        <a href="{{ route('sales.create.withVehicle', $vehicle->id) }}"
            class="btn btn-sm btn-warning">
            Vendre
        </a>
@endif
</td>

</tr>

@empty

<tr>
<td colspan="15" class="text-center text-muted">
Aucune voiture disponible
</td>
</tr>

@endforelse

</tbody>
</table>
<!-- ================= Pagination ================= -->
@if(method_exists($vehicles, 'links'))
    <div class="mt-3 d-flex justify-content-center">
        {{ $vehicles->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
@endif

</div>
</div>
</div>



<!--/div>
</div-->

@endsection
