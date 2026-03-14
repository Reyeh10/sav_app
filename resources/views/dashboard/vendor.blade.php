@extends('layout.mainlayout')

@section('content')

<style>
.dash-section-title{
    font-weight: 800;
    font-size: 20px;
    margin: 22px 0 14px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.kpi-card{
    border: 0;
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(0,0,0,.06);
    padding: 18px;
    height: 110px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    transition: .2s ease;
}

.kpi-card:hover{
    transform: translateY(-3px);
    box-shadow: 0 10px 22px rgba(0,0,0,.08);
}

.kpi-value{
    font-size: 28px;
    font-weight: 900;
    margin:0;
}

.kpi-label{
    color:#6c757d;
    margin:0;
    font-weight:600;
}

.chart-card{
    border: 0;
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(0,0,0,.06);
    padding: 18px;
}

.chart-wrap{
    position: relative;
    height: 280px;
    width: 100%;
}
</style>

<div class="container-fluid">

{{-- ================= SECTION 1 ================= --}}
<div class="dash-section-title">📊 Partie 1 — Indicateurs</div>

<div class="row g-3">

<div class="col-xl-3 col-md-6">
<div class="kpi-card bg-white">
<div>
<p class="kpi-value text-success">{{ $totalSold }}</p>
<p class="kpi-label">Voitures vendues</p>
</div>
<i class="ti ti-checks fs-1 text-success opacity-50"></i>
</div>
</div>

<div class="col-xl-3 col-md-6">
<div class="kpi-card bg-white">
<div>
<p class="kpi-value text-primary">{{ $stockVehicles }}</p>
<p class="kpi-label">Stock véhicules</p>
</div>
<i class="ti ti-car fs-1 text-primary opacity-50"></i>
</div>
</div>

<div class="col-xl-3 col-md-6">
<div class="kpi-card bg-white">
<div>
<p class="kpi-value text-warning">{{ $waitingVehicles }}</p>
<p class="kpi-label">Véhicules en attente</p>
</div>
<i class="ti ti-clock fs-1 text-warning opacity-50"></i>
</div>
</div>

<div class="col-xl-3 col-md-6">
<div class="kpi-card bg-white">
<div>
<p class="kpi-value text-info">{{ $totalClients }}</p>
<p class="kpi-label">Liste de clients</p>
</div>
<i class="ti ti-users fs-1 text-info opacity-50"></i>
</div>
</div>

</div>


{{-- ================= SECTION 2 ================= --}}
<div class="dash-section-title">📈 Partie 2 — Analyse</div>

<div class="row g-3">

<div class="col-lg-7">
<div class="chart-card bg-white">
<h6 class="fw-bold mb-3">Ventes par modèle</h6>
<div class="chart-wrap">
<canvas id="salesByModelChart"></canvas>
</div>
</div>
</div>

<div class="col-lg-5">
<div class="chart-card bg-white">
<h6 class="fw-bold mb-3">Répartition par marque</h6>
<div class="chart-wrap">
<canvas id="brandChart"></canvas>
</div>
</div>
</div>

</div>


{{-- ================= SECTION 3 ================= --}}
<div class="dash-section-title">🚗 Partie 3 — Flux des véhicules</div>

<div class="row g-3">

<div class="col-lg-6">
<div class="chart-card bg-white">
<h6 class="fw-bold mb-3">Arrivées par mois</h6>
<div class="chart-wrap">
<canvas id="arrivalChart"></canvas>
</div>
</div>
</div>

<div class="col-lg-6">
<div class="chart-card bg-white">
<h6 class="fw-bold mb-3">Ventes par mois</h6>
<div class="chart-wrap">
<canvas id="flowChart"></canvas>
</div>
</div>
</div>

</div>


{{-- ================= SECTION 4 ================= --}}
<!--div class="dash-section-title">💰 Partie 4 — Revenus</div>

<div class="row g-3">

<div class="col-xl-3 col-md-6">
<div class="kpi-card bg-white">
<div>
<p class="kpi-value text-success">{  number_format($totalRevenue,0,',',' ') }} $</p>
<p class="kpi-label">Revenus total</p>
</div>
<i class="ti ti-cash fs-1 text-success opacity-50"></i>
</div>
</div>

<div class="col-xl-3 col-md-6">
<div class="kpi-card bg-white">
<div>
<p class="kpi-value text-primary">{ { number_format($revenueThisMonth,0,',',' ') }} $</p>
<p class="kpi-label">Revenus ce mois</p>
</div>
<i class="ti ti-chart-line fs-1 text-primary opacity-50"></i>
</div>
</div>

<div class="col-xl-3 col-md-6">
<div class="kpi-card bg-white">
<div>
<p class="kpi-value text-warning">{ { number_format($averageSalePrice,0,',',' ') }} $</p>
<p class="kpi-label">Prix moyen</p>
</div>
<i class="ti ti-calculator fs-1 text-warning opacity-50"></i>
</div>
</div>

<div class="col-xl-3 col-md-6">
<div class="kpi-card bg-white">
<div>
<p class="kpi-value text-danger">{ { number_format($maxSalePrice,0,',',' ') }} $</p>
<p class="kpi-label">Meilleure vente</p>
</div>
<i class="ti ti-trophy fs-1 text-danger opacity-50"></i>
</div>
</div>

</div-->


{{-- ================= SECTION 4 ================= --}}
<div class="dash-section-title">🏆 Partie 4 — Top voitures vendues</div>

<div class="row">
<div class="col-lg-12">

<div class="chart-card bg-white">

<h6 class="fw-bold mb-4">Top 5 véhicules vendus</h6>

<table class="table table-hover align-middle">

<thead class="table-dark">
<tr>
<th style="width:80px">#</th>
<th>Modèle</th>
<th style="width:150px">Total ventes</th>
<th style="width:300px">Popularité</th>
</tr>
</thead>

<tbody>

@foreach($topVehicles as $index => $v)

@php
$model = $v->vehicle->model ?? 'Inconnu';
$total = $v->total;
$max = $topVehicles->max('total');
$percent = ($max > 0) ? ($total / $max) * 100 : 0;
@endphp

<tr>

<td>

@if($index == 0)
<span class="badge bg-warning text-dark">🥇 1</span>
@elseif($index == 1)
<span class="badge bg-secondary">🥈 2</span>
@elseif($index == 2)
<span class="badge bg-dark">🥉 3</span>
@else
<span class="badge bg-light text-dark">{{ $index+1 }}</span>
@endif

</td>

<td>
<i class="ti ti-car text-primary me-2"></i>
<strong>{{ $model }}</strong>
</td>

<td>

<span class="badge bg-success fs-6">
{{ $total }} ventes
</span>

</td>

<td>

<div class="progress" style="height:10px">

<div class="progress-bar bg-success"
role="progressbar"
style="width: {{ $percent }}%">
</div>

</div>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>
</div>
</div>


{{-- ================= SECTION 5 ================= --}}
<div class="dash-section-title">📦 Partie 5 — Stock par marque</div>

<div class="row">
<div class="col-lg-12">

<div class="chart-card bg-white">

<h6 class="fw-bold mb-3">Stock par marque</h6>

<div class="chart-wrap">
<canvas id="stockBrandChart"></canvas>
</div>

</div>

</div>
</div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const monthsFR = ["Jan","Fév","Mar","Avr","Mai","Juin","Juil","Août","Sep","Oct","Nov","Déc"];

const salesData   = @json($salesByMonth);
const arrivalData = @json($arrivalByMonth);
const salesFlow   = @json($salesFlow);

const brandLabels = @json($vehiclesByBrand->pluck('label'));
const brandValues = @json($vehiclesByBrand->pluck('total'));

const stockBrandLabels = @json($stockByBrand->pluck('brand'));
const stockBrandValues = @json($stockByBrand->pluck('total'));


new Chart(document.getElementById('salesByModelChart'),{
type:'bar',
data:{
labels:@json($salesModelLabels),
datasets:[{
label:'Ventes',
data:@json($salesModelData),
backgroundColor:'#0d6efd'
}]
},
options:{responsive:true,maintainAspectRatio:false}
});


new Chart(document.getElementById('brandChart'),{
type:'doughnut',
data:{
labels:brandLabels,
datasets:[{
data:brandValues,
backgroundColor:['#007bff','#28a745','#ffc107','#dc3545','#6f42c1']
}]
},
options:{responsive:true,maintainAspectRatio:false,cutout:'65%'}
});


new Chart(document.getElementById('arrivalChart'),{
type:'line',
data:{
labels:monthsFR,
datasets:[{
label:'Arrivées',
data:arrivalData,
borderColor:'#17a2b8',
backgroundColor:'rgba(23,162,184,0.15)',
fill:true,
tension:0.4
}]
},
options:{responsive:true,maintainAspectRatio:false}
});


new Chart(document.getElementById('flowChart'),{
type:'line',
data:{
labels:monthsFR,
datasets:[{
label:'Ventes',
data:salesFlow,
borderColor:'#dc3545',
backgroundColor:'rgba(220,53,69,0.15)',
fill:true,
tension:0.4
}]
},
options:{responsive:true,maintainAspectRatio:false}
});


new Chart(document.getElementById('stockBrandChart'),{
type:'bar',
data:{
labels:stockBrandLabels,
datasets:[{
label:'Stock',
data:stockBrandValues,
backgroundColor:'#6f42c1'
}]
},
options:{responsive:true,maintainAspectRatio:false}
});

</script>

@endsection
