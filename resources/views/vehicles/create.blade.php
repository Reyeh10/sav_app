@extends('layout.mainlayout')

@section('content')

<div class="page-wrapper">
<div class="content">

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
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

{{-- ================= IMMATRICULATION ================= --}}
<div class="col-md-6 mb-3">
    <label class="form-label">Immatriculation</label>
    <input type="text"
           name="plate_number"
           value="{{ old('plate_number') }}"
           class="form-control"
           placeholder="Ex: AB-123-CD">
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
        <div class="invalid-feedback">
            {{ $message }}
        </div>
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
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

{{-- ================= ANNEE ================= --}}
<div class="col-md-4 mb-3">
    <label class="form-label">Année *</label>
    <input type="number"
           name="year"
           value="{{ old('year') }}"
           class="form-control @error('year') is-invalid @enderror"
           placeholder="2024">

    @error('year')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
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
    <label class="form-label">Date d’arrivée</label>
    <input type="date"
           name="arrival_date"
           value="{{ old('arrival_date') }}"
           class="form-control">
</div>

{{-- ================= KILOMETRAGE ================= --}}
<div class="col-md-6 mb-3">
    <label class="form-label">Kilométrage</label>
    <input type="number"
           name="mileage"
           value="{{ old('mileage') }}"
           class="form-control">
</div>

{{-- ================= COMMENT ================= --}}
<div class="col-md-12 mb-3">
    <label class="form-label">Commentaire</label>
    <textarea name="comment"
              class="form-control"
              rows="3">{{ old('comment') }}</textarea>
</div>

{{-- ================= IMAGE ================= --}}
<div class="col-md-6 mb-3">
    <label class="form-label">Image voiture</label>
    <input type="file" name="image" class="form-control">
</div>

</div>

<div class="d-flex justify-content-end mt-4 gap-2">
    <a href="{{ route('vehicles.index') }}" class="btn btn-light">
        Annuler
    </a>

    <button type="submit" class="btn btn-primary">
        Enregistrer
    </button>
</div>

</form>

</div>
</div>

</div>
</div>

@endsection
