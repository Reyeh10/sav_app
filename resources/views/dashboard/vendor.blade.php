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
<div class="dash-section-title">
🚗 Partie 3 — Flux des véhicules
</div>

<div class="chart-card bg-white">

<div class="d-flex justify-content-between align-items-center mb-3">

<h6 class="fw-bold mb-0">
📈 Évolution mensuelle — Ventes & Arrivées
</h6>

<form method="GET">
<select name="year"
class="form-select form-select-sm"
style="width:120px"
onchange="this.form.submit()">

@for($y = date('Y'); $y >= 2023; $y--)
<option value="{{ $y }}"
{{ request('year', date('Y')) == $y ? 'selected' : '' }}>
{{ $y }}
</option>
@endfor

</select>
</form>

</div>

<div class="chart-wrap">
<canvas id="vehicleFlowChart"></canvas>
</div>

</div>


{{-- ================= SECTION 4 ================= --}}
<!--div class="dash-section-title">💰 Partie 4 — Revenus</div>

<div class="row g-3">

<div class="col-xl-3 col-md-6">
<div class="kpi-card bg-white">
<div>
<p class="kpi-value text-success">{ { number_format($totalRevenue,0,',',' ') }} $</p>
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
<!--div class="dash-section-title">💰 Partie 4 — Revenus</div>

<div class="row g-3">

<div class="col-xl-3 col-md-6">
<div class="kpi-card bg-white">
<div>
<p class="kpi-value text-success">
{ { number_format($totalRevenue, 2, ',', ' ') }} FDJ
</p>
<p class="kpi-label">Revenus total</p>
</div>
<i class="ti ti-cash fs-1 text-success opacity-50"></i>
</div>
</div>

<div class="col-xl-3 col-md-6">
<div class="kpi-card bg-white">
<div>
<p class="kpi-value text-primary">
{ { number_format($revenueThisMonth, 2, ',', ' ') }} FDJ
</p>
<p class="kpi-label">Revenus ce mois</p>
</div>
<i class="ti ti-chart-line fs-1 text-primary opacity-50"></i>
</div>
</div>

<div class="col-xl-3 col-md-6">
<div class="kpi-card bg-white">
<div>
<p class="kpi-value text-warning">
{ { number_format($averageSalePrice, 2, ',', ' ') }} FDJ
</p>
<p class="kpi-label">Prix moyen</p>
</div>
<i class="ti ti-calculator fs-1 text-warning opacity-50"></i>
</div>
</div>

<div class="col-xl-3 col-md-6">
<div class="kpi-card bg-white">
<div>
<p class="kpi-value text-danger">
{ { number_format($maxSalePrice, 2, ',', ' ') }} FDJ
</p>
<p class="kpi-label">Meilleure vente</p>
</div>
<i class="ti ti-trophy fs-1 text-danger opacity-50"></i>
</div>
</div>

</div-->

{{-- ================= SECTION 4 ================= --}}
<div class="dash-section-title">📦 Partie 4 — Stock par marque</div>

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


new Chart(document.getElementById('vehicleFlowChart'),{
type:'line',
data:{
labels:monthsFR,
datasets:[
{
label:'Ventes',
data:salesData,
borderColor:'#0d6efd',
backgroundColor:'rgba(13,110,253,0.15)',
fill:true,
tension:0.4
},
{
label:'Arrivées',
data:arrivalData,
borderColor:'#17a2b8',
backgroundColor:'rgba(23,162,184,0.15)',
fill:true,
tension:0.4
}
]
},
options:{
responsive:true,
maintainAspectRatio:false,
plugins:{
legend:{
position:'top'
}
},
scales:{
y:{
beginAtZero:true,
ticks:{precision:0}
}
}
}
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
