@extends('layout.mainlayout')

@section('content')

<div class="container-fluid py-4">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold">Tableau de bord Logistique</h3>
        <p class="text-muted">Gestion du stock véhicules</p>
    </div>

    <span class="badge bg-dark fs-6">
        {{ now()->format('d M Y') }}
    </span>
</div>


<!-- KPI CARDS -->

<div class="row g-3 mb-4">

<div class="col-md-3">
<div class="card shadow border-0">
<div class="card-body">
<h6>Total véhicules</h6>
<h2 class="fw-bold text-primary">{{ $totalVehicles }}</h2>
</div>
</div>
</div>


<div class="col-md-3">
<div class="card shadow border-0">
<div class="card-body">
<h6>Importés aujourd'hui</h6>
<h2 class="fw-bold text-success">{{ $vehiclesToday }}</h2>
</div>
</div>
</div>


<!--div class="col-md-2">
<div class="card shadow border-0">
<div class="card-body">
<h6>Disponible</h6>
<h3 class="fw-bold text-success">{ { $vehiclesDisponibles }}</h3>
</div>
</div>
</div>


<div class="col-md-2">
<div class="card shadow border-0">
<div class="card-body">
<h6>En attente</h6>
<h3 class="fw-bold text-warning">{ { $vehiclesEnAttente }}</h3>
</div>
</div>
</div>


<div class="col-md-2">
<div class="card shadow border-0">
<div class="card-body">
<h6>En réparation</h6>
<h3 class="fw-bold text-danger">{ { $vehiclesEnReparation }}</h3>
</div>
</div>
</div-->

</div>


<!-- GRAPH -->

<div class="row">

<div class="col-lg-6">
<div class="card shadow border-0">
<div class="card-body">

<h5 class="fw-bold mb-3">Répartition par marque</h5>

<canvas id="brandChart"></canvas>

</div>
</div>
</div>

</div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const brandLabels = @json($vehiclesByBrand->keys());
const brandData = @json($vehiclesByBrand->values());

new Chart(document.getElementById('brandChart'), {

type: 'bar',

data: {
labels: brandLabels,
datasets: [{
data: brandData,
backgroundColor: '#ff7a18'
}]
},

options: {
responsive: true,
plugins: {
legend: { display: false }
}
}

});

</script>

@endsection
