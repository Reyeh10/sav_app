@extends('layout.mainlayout')
@section('content')

@php
    $role = auth()->user()->role;
@endphp

<!--div class="page-wrapper">
<div class="content"-->

<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
    <div>
        <h2 class="mb-1">Ajouter une voiture</h2>
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

    {{-- ✅ ERREURS GLOBALES --}}
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

<form action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="row">

{{-- ================= VIN ================= --}}
<div class="col-md-6 mb-3">
    <label class="form-label">VIN *</label>
    <input type="text"
           name="vin"
           value="{{ old('vin') }}"
           class="form-control @error('vin') is-invalid @enderror"
           placeholder="Ex: 1HGCM82633A123456">
    @error('vin')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- ================= MARQUE ================= --}}
<div class="col-md-6 mb-3">
    <label class="form-label">Marque *</label>
    <input type="text"
           name="brand"
           value="{{ old('brand') }}"
           class="form-control @error('brand') is-invalid @enderror"
           placeholder="Ex: Toyota">
    @error('brand')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- ================= MODELE ================= --}}
<div class="col-md-6 mb-3">
    <label class="form-label">Modèle *</label>
    <input type="text"
           name="model"
           value="{{ old('model') }}"
           class="form-control @error('model') is-invalid @enderror"
           placeholder="Ex: Corolla">
    @error('model')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- ================= MODEL YEAR ================= --}}
<div class="col-md-6 mb-3">
    <label class="form-label">Model Year</label>
    <input type="number"
           name="model_year"
           value="{{ old('model_year') }}"
           class="form-control @error('model_year') is-invalid @enderror"
           placeholder="Ex: 2024">
    @error('model_year')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- ================= ENGINE ================= --}}
<div class="col-md-6 mb-3">
    <label class="form-label">Engine</label>
    <select name="engine" class="form-control">
        <option value="">-- Select --</option>
        <option value="Essence" {{ old('engine')=='Essence'?'selected':'' }}>Essence</option>
        <option value="Diesel" {{ old('engine')=='Diesel'?'selected':'' }}>Diesel</option>
        <option value="HEV" {{ old('engine')=='HEV'?'selected':'' }}>HEV</option>
        <option value="PHEV" {{ old('engine')=='PHEV'?'selected':'' }}>PHEV</option>
        <option value="Electrique" {{ old('engine')=='Electrique'?'selected':'' }}>Electrique</option>
    </select>
</div>

{{-- ================= CONFIGURATION ================= --}}
<div class="col-md-6 mb-3">
    <label class="form-label">Configuration</label>
    <select name="configuration" class="form-control">
        <option value="">-- Select --</option>
        <option value="Basic" {{ old('configuration')=='Basic'?'selected':'' }}>Basic</option>
        <option value="Medium Option" {{ old('configuration')=='Medium Option'?'selected':'' }}>Medium Option</option>
        <option value="Full Option" {{ old('configuration')=='Full Option'?'selected':'' }}>Full Option</option>
    </select>
</div>

{{-- ================= ENGINE NUMBER ================= --}}
<div class="col-md-6 mb-3">
    <label class="form-label">Engine Number</label>
    <input type="text"
           name="engine_number"
           value="{{ old('engine_number') }}"
           class="form-control">
</div>

{{-- ================= COULEURS ================= --}}
<div class="col-md-6 mb-3">
    <label class="form-label">Couleur extérieure</label>
    <input type="text"
           name="color_exterior"
           value="{{ old('color_exterior') }}"
           class="form-control">
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Couleur intérieure</label>
    <input type="text"
           name="color_interior"
           value="{{ old('color_interior') }}"
           class="form-control">
</div>

{{-- ================= DATE ================= --}}
<div class="col-md-6 mb-3">
    <label class="form-label">Date d’arrivée *</label>
    <input type="date"
           name="arrival_date"
           value="{{ old('arrival_date') }}"
           class="form-control @error('arrival_date') is-invalid @enderror">
    @error('arrival_date')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- ================= KILOMETRAGE ================= --}}
<div class="col-md-6 mb-3">
    <label class="form-label">Kilométrage</label>
    <input type="number"
           name="mileage"
           value="{{ old('mileage',0) }}"
           class="form-control">
</div>

{{-- ================= COMMENT ================= --}}
<div class="col-md-12 mb-3">
    <label class="form-label">Commentaire</label>
    <textarea name="comment"
              class="form-control"
              rows="3">{{ old('comment') }}</textarea>
</div>
{{-- ================= STATUS ================= --}}
<!--div class="col-md-6 mb-3">
    <label class="form-label">Statut *</label>
    <select name="status"
            class="form-control @ error('status') is-invalid @ enderror">
        <option value="Disponible" { { old('status')=='Disponible'?'selected':'' }}>Disponible</option>
        <option value="En réparation" { { old('status')=='En réparation'?'selected':'' }}>En réparation</option>
        <option value="En attente" { { old('status')=='En attente'?'selected':'' }}>En attente</option>
        <option value="Vendu" { { old('status')=='Vendu'?'selected':'' }}>Vendu</option>
    </select>

    @ error('status')
        <div class="invalid-feedback">{ { $message }}</div>
    @ enderror
</div-->

@if($role === 'admin')
<div class="col-md-6 mb-3">
<label class="form-label">Statut *</label>
<select name="status" class="form-control">
    <option value="Disponible">Disponible</option>
    <option value="En réparation">En réparation</option>
    <option value="En attente">En attente</option>
    <option value="Vendu">Vendu</option>
</select>
</div>
@endif
{{-- ================= IMAGE ================= --}}
<!--div class="col-md-6 mb-3">
    <label class="form-label">Image voiture</label>
    <input type="file" name="image" class="form-control">
</div-->
@if($role === 'admin')
<div class="col-md-6 mb-3">
<label class="form-label">Image voiture</label>
<input type="file" name="image" class="form-control">
</div>
@endif

</div>

<div class="d-flex justify-content-end mt-4 gap-2">
    <a href="{{ route('customers.index') }}" class="btn btn-light">
        Annuler
    </a>

    <button type="submit" class="btn btn-primary">
        Enregistrer
    </button>
</div>

</form>

</div>
</div>

<!--/div>
</div-->

@endsection
