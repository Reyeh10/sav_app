@extends('layout.mainlayout')

@section('content')

<div class="page-wrapper">
<div class="content">

<!-- ================= HEADER ================= -->
<div class="card shadow-sm border-0 mb-4">
<div class="card-body">

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

<div>
<h3 class="fw-bold mb-1">Gestion des voitures</h3>
<p class="text-muted mb-0">
Liste des voitures enregistrées dans le système
</p>
</div>

<div class="d-flex gap-2">

@if(in_array(auth()->user()->role, ['admin','logistique']))

<a href="{{ route('vehicles.create') }}"
class="btn btn-orange shadow-sm">
<i class="ti ti-circle-plus me-2"></i>
Ajouter une voiture
</a>

<button class="btn btn-success shadow-sm"
data-bs-toggle="modal"
data-bs-target="#importExcelModal">
<i class="ti ti-upload me-2"></i>
Importer Excel
</button>

@endif

</div>
</div>
</div>
</div>

<!-- ================= TABLE ================= -->
<div class="card">
<div class="card-body">

<div class="table-responsive">
<table class="table table-striped table-bordered datatable w-100">

<thead class="table-light">
<tr>
<th>ID</th>
<th>Image</th>
<th>VIN</th>
<th>Marque</th>
<th>Modèle</th>
<th>Extérieur</th>
<th>Intérieur</th>
<th>Année</th>
<th>Date arrivée</th>
<th>Kilométrage</th>
<th>Statut</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

@foreach($vehicles as $vehicle)
<tr>

<td>{{ $vehicle->id }}</td>

<td>
@if($vehicle->image)
<img src="{{ asset('storage/'.$vehicle->image) }}"
style="width:35px;height:35px;object-fit:cover;border-radius:8px;cursor:pointer;"
data-bs-toggle="modal"
data-bs-target="#img{{ $vehicle->id }}">
@else
<span class="badge bg-light text-dark">No Image</span>
@endif
</td>

<td>{{ $vehicle->vin }}</td>
<td>{{ $vehicle->brand }}</td>
<td>{{ $vehicle->model }}</td>
<td>{{ $vehicle->color_exterior }}</td>
<td>{{ $vehicle->color_interior }}</td>
<td>{{ $vehicle->year }}</td>

<td>
{{ $vehicle->arrival_date
? \Carbon\Carbon::parse($vehicle->arrival_date)->format('Y-m-d')
: '-' }}
</td>

<td>{{ number_format($vehicle->mileage) }}</td>

<td>
@php
$badge = match($vehicle->status){
'draft'=>'secondary',
'approved'=>'success',
'rejected'=>'danger',
'sold'=>'warning',
default=>'dark'
};
@endphp

<span class="badge bg-{{ $badge }}">
{{ match($vehicle->status){
'draft'=>'Brouillon',
'approved'=>'Approuvé',
'rejected'=>'Rejeté',
'sold'=>'Vendu',
default=>$vehicle->status
} }}
</span>
</td>

<td class="d-flex gap-1">

<a href="{{ route('vehicles.show',$vehicle->id) }}"
class="btn btn-info btn-sm">
<i class="ti ti-eye"></i>
</a>

<a href="{{ route('vehicles.edit',$vehicle->id) }}"
class="btn btn-warning btn-sm">
<i class="ti ti-edit"></i>
</a>

@if(auth()->user()->role === 'admin')
<form action="{{ route('vehicles.destroy',$vehicle->id) }}"
method="POST">
@csrf
@method('DELETE')
<button class="btn btn-danger btn-sm">
<i class="ti ti-trash"></i>
</button>
</form>
@endif

</td>

</tr>

@if($vehicle->image)
<div class="modal fade" id="img{{ $vehicle->id }}">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content bg-transparent border-0">
<div class="modal-body text-center">
<img src="{{ asset('storage/'.$vehicle->image) }}"
class="img-fluid rounded shadow">
</div>
</div>
</div>
</div>
@endif

@endforeach

</tbody>
</table>
</div>

</div>
</div>

</div>
</div>

<!-- ================= IMPORT MODAL ================= -->
<div class="modal fade" id="importExcelModal">
<div class="modal-dialog">
<div class="modal-content">

<form action="{{ route('vehicles.import') }}"
method="POST"
enctype="multipart/form-data">
@csrf

<div class="modal-header">
<h5>Importer fichier Excel</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<input type="file"
name="file"
class="form-control"
required>
</div>

<div class="modal-footer">
<button class="btn btn-success">
Importer
</button>
</div>

</form>

</div>
</div>
</div>

@endsection
