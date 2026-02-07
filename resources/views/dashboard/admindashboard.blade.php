@extends('layout.mainlayout')

@section('content')

<div class="page-wrapper">
<div class="content">

<!-- ================= HEADER ================= -->
<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-4">
    <div>
        <h2 class="fw-bold">Tableau de bord Administrateur</h2>
        <p class="text-muted mb-0">Vue globale Véhicules & Clients</p>
    </div>
</div>

<!-- ================= CARTES PRINCIPALES ================= -->
<div class="row g-3">

<div class="col-xl-3 col-md-6">
    <div class="card bg-blue-img border-0 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <p class="mb-1 text-muted">Total Véhicules</p>
                <h2 class="fw-bold">{{ $totalVehicles }}</h2>
            </div>
            <i class="ti ti-car fs-1 opacity-75"></i>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6">
    <div class="card bg-green-img border-0 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <p class="mb-1 text-muted">Véhicules Actifs</p>
                <h2 class="fw-bold">{{ $activeVehicles }}</h2>
            </div>
            <i class="ti ti-check fs-1 opacity-75"></i>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6">
    <div class="card bg-purple-img border-0 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <p class="mb-1 text-muted">Total Clients</p>
                <h2 class="fw-bold">{{ $totalClients }}</h2>
            </div>
            <i class="ti ti-users fs-1 opacity-75"></i>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6">
    <div class="card bg-yellow-img border-0 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <p class="mb-1 text-muted">Nouveaux Clients (30j)</p>
                <h2 class="fw-bold">{{ $newClients }}</h2>
            </div>
            <i class="ti ti-user-plus fs-1 opacity-75"></i>
        </div>
    </div>
</div>

</div>

<!-- ================= STATUS KPI PRO ================= -->
<div class="row mt-4 g-3">

<!-- SOLD -->
<div class="col-xl-4">
    <div class="card border-0 shadow-sm bg-warning-subtle">
        <div class="card-body d-flex justify-content-between align-items-center">

            <div>
                <h6 class="text-warning fw-semibold mb-1">Véhicules Vendus</h6>
                <h2 class="fw-bold text-dark">{{ $soldVehicles }}</h2>
                <small class="text-muted">Performance commerciale</small>
            </div>

            <div class="bg-warning rounded-circle p-3">
                <i class="ti ti-cash text-white fs-2"></i>
            </div>

        </div>
    </div>
</div>

<!-- APPROVED -->
<div class="col-xl-4">
    <div class="card border-0 shadow-sm bg-success-subtle">
        <div class="card-body d-flex justify-content-between align-items-center">

            <div>
                <h6 class="text-success fw-semibold mb-1">Véhicules Approuvés</h6>
                <h2 class="fw-bold text-dark">{{ $approvedVehicles }}</h2>
                <small class="text-muted">Disponibles à la vente</small>
            </div>

            <div class="bg-success rounded-circle p-3">
                <i class="ti ti-circle-check text-white fs-2"></i>
            </div>

        </div>
    </div>
</div>

<!-- REJECTED -->
<div class="col-xl-4">
    <div class="card border-0 shadow-sm bg-danger-subtle">
        <div class="card-body d-flex justify-content-between align-items-center">

            <div>
                <h6 class="text-danger fw-semibold mb-1">Véhicules Rejetés</h6>
                <h2 class="fw-bold text-dark">{{ $rejectedVehicles }}</h2>
                <small class="text-muted">Inspection échouée</small>
            </div>

            <div class="bg-danger rounded-circle p-3">
                <i class="ti ti-alert-triangle text-white fs-2"></i>
            </div>

        </div>
    </div>
</div>

</div>

<!-- ================= CHARTS ================= -->
<div class="row mt-4 g-3">

<div class="col-xl-6">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="fw-semibold mb-3">Véhicules par Marque</h5>
            <canvas id="brandChart"></canvas>
        </div>
    </div>
</div>

<div class="col-xl-6">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="fw-semibold mb-3">Véhicules Vendus par Mois</h5>
            <canvas id="soldChart"></canvas>
        </div>
    </div>
</div>

</div>

</div>
</div>

<!-- ================= CHART JS ================= -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

// ===== VEHICULES PAR MARQUE =====
const brandLabels = {!! json_encode($vehiclesByBrand->pluck('brand')) !!};
const brandData = {!! json_encode($vehiclesByBrand->pluck('total')) !!};

new Chart(document.getElementById('brandChart'), {
    type: 'bar',
    data: {
        labels: brandLabels,
        datasets: [{
            label: 'Nombre de Véhicules',
            data: brandData,
            borderRadius: 6
        }]
    }
});

// ===== VENDUS PAR MOIS =====
const months = [
'Janvier','Février','Mars','Avril','Mai','Juin',
'Juillet','Août','Septembre','Octobre','Novembre','Décembre'
];

const soldMonthData = new Array(12).fill(0);

@foreach($soldByMonth as $item)
soldMonthData[{{ $item->month - 1 }}] = {{ $item->total }};
@endforeach

new Chart(document.getElementById('soldChart'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Véhicules Vendus',
            data: soldMonthData,
            tension: 0.4
        }]
    }
});

</script>

@endsection
