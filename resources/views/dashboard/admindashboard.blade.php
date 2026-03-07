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
        height: 280px;   /* Taille contrôlée */
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
            <!--h6 class="card-title">Ventes par modèle</h6-->
            <h6 class="fw-bold mb-3">Ventes par modèle</h6>
            <!--canvas id="salesByModelChart" height="100"></canvas-->
            <div class="chart-wrap">
               <canvas id="salesByModelChart" height="100"></canvas>
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
<!--div class="dash-section-title">🚗 Partie 3 — Flux des véhicules</div>

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

</div-->


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const monthsFR = ["Jan","Fév","Mar","Avr","Mai","Juin","Juil","Août","Sep","Oct","Nov","Déc"];

const salesData   = @json($salesByMonth);
const arrivalData = @json($arrivalByMonth);
const salesFlow   = @json($salesFlow);

const brandLabels = @json($vehiclesByBrand->pluck('label'));
const brandValues = @json($vehiclesByBrand->pluck('total'));

// ===== Options propres =====
function cleanOptions(maxY = null){
    return {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'top' }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { precision: 0 },
                suggestedMax: maxY
            }
        }
    };
}

// ===== BAR =====
const salesChart = new Chart(document.getElementById('salesChart'), {
    type: 'bar',
    data: {
        labels: @json($salesModelLabels),
        datasets: [{
            label: 'Ventes',
            data: @json($salesModelData),
            backgroundColor: '#28a745'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// ===== DONUT =====
new Chart(document.getElementById('brandChart'), {
    type: 'doughnut',
    data: {
        labels: brandLabels,
        datasets: [{
            data: brandValues,
            backgroundColor: ['#007bff','#28a745','#ffc107','#dc3545','#6f42c1']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
            legend: { position: 'top' }
        }
    }
});

// ===== LINE ARRIVAL =====
new Chart(document.getElementById('arrivalChart'), {
    type: 'line',
    data: {
        labels: monthsFR,
        datasets: [{
            label: 'Arrivées',
            data: arrivalData,
            borderColor: '#17a2b8',
            backgroundColor: 'rgba(23,162,184,0.15)',
            fill: true,
            tension: 0.4,
            pointRadius: 4
        }]
    },
    options: cleanOptions(10)
});

// ===== LINE SALES =====
new Chart(document.getElementById('flowChart'), {
    type: 'line',
    data: {
        labels: monthsFR,
        datasets: [{
            label: 'Ventes',
            data: salesFlow,
            borderColor: '#dc3545',
            backgroundColor: 'rgba(220,53,69,0.15)',
            fill: true,
            tension: 0.4,
            pointRadius: 4
        }]
    },
    options: cleanOptions(10)
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const salesByModelCtx = document.getElementById('salesByModelChart');

    if (salesByModelCtx) {

        new Chart(salesByModelCtx, {
            type: 'bar',
            data: {
                labels: @json($salesModelLabels),
                datasets: [{
                    label: 'Ventes par modèle',
                    data: @json($salesModelData),
                    backgroundColor: '#0d6efd',
                    borderRadius: 6,
                    barThickness: 40
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

    }

});
</script>
<script>

/* ===============================
CORRECTION GRAPHIQUES DASHBOARD
(ancien code conservé)
================================ */

document.addEventListener("DOMContentLoaded", function(){

    const monthsFR = ["Jan","Fév","Mar","Avr","Mai","Juin","Juil","Août","Sep","Oct","Nov","Déc"];

    const salesByMonth  = @json($salesByMonth);
    const arrivalByMonth = @json($arrivalByMonth);

    /* ===============================
    GRAPH ARRIVALS
    =============================== */

    const arrivalCanvas = document.getElementById('arrivalChart');

    if(arrivalCanvas){

        new Chart(arrivalCanvas, {
            type: 'line',
            data: {
                labels: monthsFR,
                datasets: [{
                    label: 'Arrivées',
                    data: arrivalByMonth,
                    borderColor: '#17a2b8',
                    backgroundColor: 'rgba(23,162,184,0.15)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4
                }]
            },
            options:{
                responsive:true,
                maintainAspectRatio:false
            }
        });

    }

    /* ===============================
    GRAPH SALES PER MONTH
    =============================== */

    const salesCanvas = document.getElementById('flowChart');

    if(salesCanvas){

        new Chart(salesCanvas,{
            type:'line',
            data:{
                labels: monthsFR,
                datasets:[{
                    label:'Ventes',
                    data: salesByMonth,
                    borderColor:'#dc3545',
                    backgroundColor:'rgba(220,53,69,0.15)',
                    fill:true,
                    tension:0.4,
                    pointRadius:4
                }]
            },
            options:{
                responsive:true,
                maintainAspectRatio:false
            }
        });

    }

});
</script>
<style>
.chart-container{
    position: relative;
    height: 220px;
    width: 100%;
}

.chart-container canvas{
    max-height:220px;
}
</style>
@endsection
