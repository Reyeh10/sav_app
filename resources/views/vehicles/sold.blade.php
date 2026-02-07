@extends('layout.mainlayout')

@section('content')

<div class="page-wrapper">
<div class="content">

<div class="card">
<div class="card-body">

<h4 class="mb-3">Liste des voitures vendues</h4>

<div class="table-responsive">
<table class="table table-striped">

<thead>
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

<tbody>

@foreach($vehicles as $vehicle)
<tr>
    <td>{{ $vehicle->id }}</td>
    <td>{{ $vehicle->vin }}</td>
    <td>{{ $vehicle->brand }}</td>
    <td>{{ $vehicle->model }}</td>
    <td>{{ $vehicle->year }}</td>
    <td>{{ number_format($vehicle->mileage) }}</td>

    <td>
        <span class="badge bg-warning">
            {{ ucfirst($vehicle->status) }}
        </span>
    </td>

    <td>
        <a href="{{ route('vehicles.edit',$vehicle->id) }}"
           class="btn btn-sm btn-primary">
           Modifier
        </a>
    </td>

</tr>
@endforeach

</tbody>

</table>
</div>

</div>
</div>

</div>
</div>

@endsection
