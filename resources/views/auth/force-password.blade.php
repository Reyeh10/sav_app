@extends('layout.mainlayout')

@section('content')

<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-md-5">

<div class="card shadow">
<div class="card-body">

<h4 class="mb-3 text-center">Créer votre nouveau mot de passe</h4>

<form method="POST" action="/force-password">
@csrf

<div class="mb-3">
<label>Nouveau mot de passe</label>
<input type="password" name="password" class="form-control" required>
</div>

<div class="mb-3">
<label>Confirmer mot de passe</label>
<input type="password" name="password_confirmation" class="form-control" required>
</div>

<button class="btn btn-primary w-100">
Valider
</button>

</form>

</div>
</div>

</div>
</div>
</div>

@endsection
