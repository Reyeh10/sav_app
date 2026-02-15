@extends('layout.mainlayout')

@section('content')

<div class="page-wrapper">
<div class="content">

<h3>Ajouter un utilisateur</h3>

<div class="card shadow-sm">
<div class="card-body">

<form method="POST" action="{{ route('users.store') }}">
@csrf

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
<label>Nom</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label>Mot de passe temporaire</label>
<input type="text" name="temp_password" class="form-control" required>
</div>

<div class="mb-3">
<label>Rôle</label>
<select name="role" class="form-control">
<option value="vendeur">Vendeur</option>
<option value="logistique">Logistique</option>
<option value="mecanicien">Mécanicien</option>
<option value="admin">Admin</option>
</select>
</div>

<button class="btn btn-primary">
Créer utilisateur
</button>

</form>

</div>
</div>

</div>
</div>

@endsection
