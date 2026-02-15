@extends('layout.mainlayout')

@section('content')
<div class="page-wrapper">
<div class="content">

<!-- Breadcrumb -->
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div>
        <h2 class="mb-1">Modifier une voiture</h2>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('vehicles.index') }}">
                        <i class="ti ti-car"></i> Voitures
                    </a>
                </li>
                <li class="breadcrumb-item active">Modifier</li>
            </ol>
        </nav>
    </div>

    <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary">
        ← Retour
    </a>
</div>

<!-- CARD -->
<div class="card shadow-sm">
<div class="card-header">
    <h5 class="card-title mb-0">Informations du véhicule</h5>
</div>

<div class="card-body">

<form action="{{ route('vehicles.update',$vehicle->id) }}"
      method="POST"
      enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="row g-3">

<!-- VIN -->
<div class="col-md-6">
    <label class="form-label">VIN *</label>
    <input type="text"
           name="vin"
           class="form-control"
           value="{{ old('vin',$vehicle->vin) }}"
           required>
</div>

<!-- Plate -->
<div class="col-md-6">
    <label class="form-label">Immatriculation</label>
    <input type="text"
           name="plate_number"
           class="form-control"
           value="{{ old('plate_number',$vehicle->plate_number) }}">
</div>

<!-- Brand -->
<div class="col-md-6">
    <label class="form-label">Marque *</label>
    <input type="text"
           name="brand"
           class="form-control"
           value="{{ old('brand',$vehicle->brand) }}"
           required>
</div>

<!-- Model -->
<div class="col-md-6">
    <label class="form-label">Modèle *</label>
    <input type="text"
           name="model"
           class="form-control"
           value="{{ old('model',$vehicle->model) }}"
           required>
</div>

<!-- Color Exterior -->
<div class="col-md-6">
    <label class="form-label">Couleur extérieure</label>
    <input type="text"
           name="color_exterior"
           class="form-control"
           value="{{ old('color_exterior',$vehicle->color_exterior) }}">
</div>

<!-- Color Interior -->
<div class="col-md-6">
    <label class="form-label">Couleur intérieure</label>
    <input type="text"
           name="color_interior"
           class="form-control"
           value="{{ old('color_interior',$vehicle->color_interior) }}">
</div>

<!-- Arrival Date -->
<div class="col-md-6">
    <label class="form-label">Date arrivée</label>
    <input type="date"
           name="arrival_date"
           class="form-control"
           value="{{ old('arrival_date',
                $vehicle->arrival_date
                    ? \Carbon\Carbon::parse($vehicle->arrival_date)->format('Y-m-d')
                    : ''
           ) }}">
</div>

<!-- Year -->
<div class="col-md-3">
    <label class="form-label">Année *</label>
    <input type="number"
           name="year"
           class="form-control"
           value="{{ old('year',$vehicle->year) }}"
           required>
</div>

<!-- Mileage -->
<div class="col-md-3">
    <label class="form-label">Kilométrage *</label>
    <input type="number"
           name="mileage"
           class="form-control"
           value="{{ old('mileage',$vehicle->mileage) }}"
           required>
</div>

<!-- STATUS (Admin + Mecanicien) -->
@if(in_array(auth()->user()->role,['admin','mecanicien']))
<div class="col-md-6">
    <label class="form-label">Statut</label>
    <select name="status" class="form-select">
        <option value="draft" {{ $vehicle->status=='draft'?'selected':'' }}>En cours d'inspection</option>
        <!--option value="inspected" { { $vehicle->status=='inspected'?'selected':'' }}>Inspected</option-->
        <option value="approved" {{ $vehicle->status=='approved'?'selected':'' }}>Approuvé</option>
        <option value="rejected" {{ $vehicle->status=='rejected'?'selected':'' }}>Rejeté</option>
        <option value="sold" {{ $vehicle->status=='sold'?'selected':'' }}>Sold</option>
    </select>
</div>
@endif


<!-- COMMENTAIRE (MECANICIEN SEULEMENT) -->
@if(auth()->user()->role === 'mecanicien')
<div class="col-md-12">
    <label class="form-label fw-bold">
        Commentaire du mécanicien
    </label>

    <textarea name="comment"
              class="form-control"
              rows="4"
              placeholder="Ajouter un commentaire technique...">{{ old('comment', $vehicle->comment) }}</textarea>
</div>
@endif


<!-- IMAGE -->
@if(auth()->user()->role === 'mecanicien')

<div class="col-md-6">
    <label class="form-label">Image voiture</label>
    <input type="file" name="image" class="form-control">
</div>

@else

<div class="col-md-6">
    <label class="form-label">Image voiture</label><br>

    @if($vehicle->image)
        <img src="{{ asset('storage/'.$vehicle->image) }}"
             style="width:120px;border-radius:8px">
    @else
        <span class="badge bg-light text-dark">No Image</span>
    @endif
</div>

@endif


<!-- BUTTONS -->
<div class="col-md-12 text-end mt-4">
    <a href="{{ route('vehicles.index') }}" class="btn btn-light">
        Annuler
    </a>

    <button type="submit" class="btn btn-primary">
        Enregistrer les modifications
    </button>
</div>

</div> {{-- row --}}
</form>

</div>
</div>

</div>
</div>
@endsection
