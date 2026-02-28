@extends('layout.mainlayout')

@section('content')

<!--div class="page-wrapper">
<div class="content"-->

<div class="page-header mb-4">
    <h3 class="page-title">Modifier Client</h3>
</div>

<div class="card">
<div class="card-body">

@if ($errors->any())
    <div class="alert alert-danger shadow-sm">
        <strong>Erreur :</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('customers.update', $customer->id) }}">
@csrf
@method('PUT')

<div class="mb-3">
<label>Nom</label>
<input type="text"
       name="name"
       class="form-control"
       value="{{ old('name', $customer->name) }}"
       required>
</div>

<div class="mb-3">
    <label>Type de client</label>
    <select name="type_client" class="form-select" required>
        <option value="Particulier" {{ $customer->type_client == 'Particulier' ? 'selected' : '' }}>Particulier</option>
        <option value="Gouvernement" {{ $customer->type_client == 'Gouvernement' ? 'selected' : '' }}>Gouvernement</option>
        <option value="Para-public" {{ $customer->type_client == 'Para-public' ? 'selected' : '' }}>Para-public</option>
        <option value="Privee" {{ $customer->type_client == 'Privee' ? 'selected' : '' }}>Privée</option>
    </select>
</div>

<div class="mb-3">
<label>Téléphone</label>
<input type="text"
       name="phone"
       class="form-control"
       value="{{ old('phone', $customer->phone) }}"
       required>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email"
       name="email"
       class="form-control"
       value="{{ old('email', $customer->email) }}">
</div>

<div class="mb-3">
<label>Adresse</label>
<textarea name="address"
          class="form-control">{{ old('address', $customer->address) }}</textarea>
</div>

<button class="btn btn-primary">
✅ Enregistrer
</button>

<a href="{{ route('customers.index') }}" class="btn btn-secondary">
Retour
</a>

</form>

</div>
</div>

<!--/div>
</div-->

@endsection
