@extends('layout.mainlayout')

@section('content')

<div class="container-fluid py-4">

    <!-- ================= HEADER ================= -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Tableau de bord Logistique</h3>
            <p class="text-muted mb-0">Gestion des véhicules et stock</p>
        </div>
        <span class="badge bg-light text-dark fs-6 px-3 py-2 shadow-sm">
            {{ now()->format('d M Y') }}
        </span>
    </div>

    <!-- ================= TOTAL CARD ================= -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-lg rounded-4 bg-gradient text-white"
                 style="background: linear-gradient(135deg, #ff7a18, #ffb347);">
                <div class="card-body p-4">
                    <h6 class="text-uppercase opacity-75">Total Véhicules</h6>
                    <h2 class="fw-bold display-5">{{ $totalVehicles }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= GRAPHIQUES ================= -->
    <div class="row g-4">

        <!-- Graphique Marque -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Répartition par Marque</h6>
                    <canvas id="brandChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Graphique Date -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Évolution par Date d’arrivée</h6>
                    <canvas id="dateChart" height="200"></canvas>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- ================= CHART JS ================= -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const brandLabels = @json($vehiclesByBrand->keys());
const brandData = @json($vehiclesByBrand->values());

const dateLabels = @json($vehiclesByDate->keys());
const dateData = @json($vehiclesByDate->values());

/* ================= MARQUE ================= */
new Chart(document.getElementById('brandChart'), {
    type: 'bar',
    data: {
        labels: brandLabels,
        datasets: [{
            data: brandData,
            backgroundColor: [
                '#ff7a18',
                '#ffb347',
                '#198754',
                '#0d6efd',
                '#6f42c1'
            ],
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: "#f1f1f1" }
            },
            x: {
                grid: { display: false }
            }
        }
    }
});

/* ================= DATE ================= */
new Chart(document.getElementById('dateChart'), {
    type: 'line',
    data: {
        labels: dateLabels,
        datasets: [{
            data: dateData,
            borderColor: '#198754',
            backgroundColor: 'rgba(25, 135, 84, 0.15)',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#198754',
            pointRadius: 5
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: "#f1f1f1" }
            },
            x: {
                grid: { display: false }
            }
        }
    }
});

</script>

@endsection
