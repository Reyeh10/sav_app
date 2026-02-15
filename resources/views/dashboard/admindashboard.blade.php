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

<!-- ================= CARTES ================= -->
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
                <p class="mb-1 text-muted">Voitures Non Vendues</p>
                <h2 class="fw-bold">{{ $notSoldVehicles }}</h2>
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

<!-- ================= CHARTS ================= -->
<div class="row mt-4 g-3">

<div class="col-xl-6">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="fw-semibold mb-3">Véhicules par Marque et Modèle</h5>
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

// ===== VEHICULES PAR MARQUE (2 BARRES COTE A COTE) =====

const labels = {!! json_encode($vehiclesByBrand->pluck('brand')) !!};

const brandData = {!! json_encode($vehiclesByBrand->pluck('total')) !!};
const modelData = {!! json_encode($vehiclesByModel->pluck('total')) !!};

new Chart(document.getElementById('brandChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Total par Marque',
                data: brandData,
                backgroundColor: '#4e73df',
                borderRadius: 6
            },
            {
                label: 'Total par Modèle',
                data: modelData,
                backgroundColor: '#9b59b6',
                borderRadius: 6
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            x: {
                stacked: false
            },
            y: {
                beginAtZero: true
            }
        }
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
            borderColor: '#f6c23e',
            tension: 0.4
        }]
    }
});

</script>


@endsection
