@extends('layout.mainlayout')

@section('content')
<div class="row">

    <div class="col-md-3">
        <div class="card p-3 text-center">
            <h4>{{ $totalVehicles }}</h4>
            <p>Voitures</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 text-center">
            <h4>{{ $totalInspections }}</h4>
            <p>Inspections</p>
        </div>
    </div>

</div>
@endsection
