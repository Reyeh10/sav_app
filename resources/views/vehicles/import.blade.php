@extends('layout.mainlayout')

@section('content')

<div class="page-wrapper">
<div class="content">

<h3>Importer véhicules Excel</h3>

<form action="{{ route('vehicles.import') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="mb-3">
<input type="file" name="file" class="form-control" required>
</div>

<button class="btn btn-success">
Importer
</button>

</form>

</div>
</div>

@endsection
