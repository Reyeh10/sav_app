@extends('layout.mainlayout')

@section('content')

<div class="page-wrapper">
<div class="content">

<h3>Modifier rôle utilisateur</h3>

<div class="card">
<div class="card-body">

<form method="POST" action="{{ route('users.update',$user->id) }}">
@csrf
@method('PUT')

<div class="mb-3">
<label>Nom</label>
<input class="form-control"
       value="{{ $user->name }}"
       disabled>
</div>

<div class="mb-3">
<label>Rôle</label>

<select name="role" class="form-control">

<option value="admin" {{ $user->role=='admin'?'selected':'' }}>
Admin
</option>

<option value="vendeur" {{ $user->role=='vendeur'?'selected':'' }}>
Vendeur
</option>

<option value="logistique" {{ $user->role=='logistique'?'selected':'' }}>
Logistique
</option>

<option value="mecanicien" {{ $user->role=='mecanicien'?'selected':'' }}>
Mécanicien
</option>

</select>

</div>

<button class="btn btn-primary">
Enregistrer
</button>

</form>

</div>
</div>

</div>
</div>

@endsection
