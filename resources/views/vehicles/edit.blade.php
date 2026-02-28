@extends('layout.mainlayout')

@section('content')
@php
    $role = auth()->user()->role;
@endphp

<!--div class="page-wrapper">
<div class="content"-->

<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
    <div>
        <h2 class="mb-1">Modifier la voiture</h2>
    </div>
    <div>
        <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary">
            ⬅ Retour
        </a>
    </div>
</div>

<div class="card">
<div class="card-header">
    <h5 class="card-title">Informations du véhicule</h5>
</div>

<div class="card-body">

@if ($errors->any())
<div class="alert alert-danger">
<strong>⚠️ Erreur :</strong>
<ul class="mb-0 mt-2">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

@if($role === 'vendeur')
<div class="alert alert-danger">
Vous n’avez pas le droit de modifier ce véhicule.
</div>
@endif

<form action="{{ route('vehicles.update', $vehicle->id) }}"
      method="POST"
      enctype="multipart/form-data"
      @if($role === 'vendeur') style="pointer-events:none;opacity:0.6;" @endif>
@csrf
@method('PUT')

<div class="row">

{{-- ================= VIN ================= --}}
<div class="col-md-6 mb-3">
<label class="form-label">VIN *</label>
<input type="text"
name="vin"
value="{{ old('vin', $vehicle->vin) }}"
class="form-control @error('vin') is-invalid @enderror"
@if($role === 'mecanicien' || $role === 'vendeur') readonly @endif>
@error('vin')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>

{{-- ================= MARQUE ================= --}}
<div class="col-md-6 mb-3">
<label class="form-label">Marque *</label>
<input type="text"
name="brand"
value="{{ old('brand', $vehicle->brand) }}"
class="form-control"
@if($role === 'mecanicien' || $role === 'vendeur') readonly @endif>
</div>

{{-- ================= MODELE ================= --}}
<div class="col-md-6 mb-3">
<label class="form-label">Modèle *</label>
<input type="text"
name="model"
value="{{ old('model', $vehicle->model) }}"
class="form-control"
@if($role === 'mecanicien' || $role === 'vendeur') readonly @endif>
</div>

{{-- ================= MODEL YEAR ================= --}}
<div class="col-md-6 mb-3">
<label class="form-label">Model Year</label>
<input type="number"
name="model_year"
value="{{ old('model_year', $vehicle->model_year) }}"
class="form-control"
@if($role === 'mecanicien' || $role === 'vendeur') readonly @endif>
</div>

{{-- ================= ENGINE ================= --}}
<div class="col-md-6 mb-3">
<label class="form-label">Engine</label>
<select name="engine" class="form-control"
@if($role === 'mecanicien' || $role === 'vendeur') disabled @endif>
<option value="">-- Select --</option>
<option value="Essence" {{ old('engine', $vehicle->engine)=='Essence'?'selected':'' }}>Essence</option>
<option value="Diesel" {{ old('engine', $vehicle->engine)=='Diesel'?'selected':'' }}>Diesel</option>
<option value="HEV" {{ old('engine', $vehicle->engine)=='HEV'?'selected':'' }}>HEV</option>
<option value="PHEV" {{ old('engine', $vehicle->engine)=='PHEV'?'selected':'' }}>PHEV</option>
<option value="Electrique" {{ old('engine', $vehicle->engine)=='Electrique'?'selected':'' }}>Electrique</option>
</select>
</div>

{{-- ================= CONFIGURATION ================= --}}
<div class="col-md-6 mb-3">
<label class="form-label">Configuration</label>
<select name="configuration" class="form-control"
@if($role === 'mecanicien' || $role === 'vendeur') disabled @endif>
<option value="">-- Select --</option>
<option value="Basic" {{ old('configuration', $vehicle->configuration)=='Basic'?'selected':'' }}>Basic</option>
<option value="Medium Option" {{ old('configuration', $vehicle->configuration)=='Medium Option'?'selected':'' }}>Medium Option</option>
<option value="Full Option" {{ old('configuration', $vehicle->configuration)=='Full Option'?'selected':'' }}>Full Option</option>
</select>
</div>

{{-- ================= ENGINE NUMBER ================= --}}
<div class="col-md-6 mb-3">
<label class="form-label">Engine Number</label>
<input type="text"
name="engine_number"
value="{{ old('engine_number', $vehicle->engine_number) }}"
class="form-control"
@if($role === 'mecanicien' || $role === 'vendeur') readonly @endif>
</div>

{{-- ================= COULEURS ================= --}}
<div class="col-md-6 mb-3">
<label class="form-label">Couleur extérieure</label>
<input type="text"
name="color_exterior"
value="{{ old('color_exterior', $vehicle->color_exterior) }}"
class="form-control"
@if($role === 'mecanicien' || $role === 'vendeur') readonly @endif>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Couleur intérieure</label>
<input type="text"
name="color_interior"
value="{{ old('color_interior', $vehicle->color_interior) }}"
class="form-control"
@if($role === 'mecanicien' || $role === 'vendeur') readonly @endif>
</div>

{{-- ================= DATE ================= --}}
<div class="col-md-6 mb-3">
<label class="form-label">Date d’arrivée *</label>
<input type="date"
name="arrival_date"
value="{{ old('arrival_date', $vehicle->arrival_date) }}"
class="form-control"
@if($role === 'mecanicien' || $role === 'vendeur') readonly @endif>
</div>

{{-- ================= KILOMETRAGE ================= --}}
<div class="col-md-6 mb-3">
<label class="form-label">Kilométrage</label>
<input type="number"
name="mileage"
value="{{ old('mileage', $vehicle->mileage) }}"
class="form-control"
@if($role === 'mecanicien' || $role === 'vendeur') readonly @endif>
</div>

{{-- ================= COMMENT ================= --}}
<div class="col-md-12 mb-3">
<label class="form-label">Commentaire</label>
<textarea name="comment"
class="form-control"
rows="3"
@if($role === 'logistique' || $role === 'vendeur') readonly @endif>{{ old('comment', $vehicle->comment) }}</textarea>
</div>

{{-- ================= STATUS ================= --}}
@if($role === 'admin' || $role === 'mecanicien')
<div class="col-md-6">
<label>Statut du véhicule</label>
<select name="status" class="form-control">
<option value="Disponible" {{ $vehicle->status == 'Disponible' ? 'selected' : '' }}>Disponible</option>
<option value="En réparation" {{ $vehicle->status == 'En réparation' ? 'selected' : '' }}>En réparation</option>
<option value="En attente" {{ $vehicle->status == 'En attente' ? 'selected' : '' }}>En attente</option>
<option value="Vendu" {{ $vehicle->status == 'Vendu' ? 'selected' : '' }}>Vendu</option>
</select>
</div>
@elseif($role === 'logistique')
<div class="col-md-6">
<label>Statut du véhicule</label>
<input type="text" value="{{ $vehicle->status }}" class="form-control" readonly>
</div>
@endif

{{-- ================= IMAGE ================= --}}
<div class="col-md-6 mb-3">
<label class="form-label">Image voiture</label>

@if($role === 'admin' || $role === 'mecanicien')
<input type="file" name="image" class="form-control">
@endif

@if($vehicle->image)
<div class="mt-2">
<img src="{{ asset('storage/'.$vehicle->image) }}" width="120">
</div>
@endif
</div>

</div>

<div class="d-flex justify-content-end mt-4 gap-2">
<a href="{{ route('vehicles.index') }}" class="btn btn-light">
Annuler
</a>

@if($role !== 'vendeur')
<button type="submit" class="btn btn-primary">
Mettre à jour
</button>
@endif
</div>

</form>

</div>
</div>
<!--/div>
</div-->

@endsection
