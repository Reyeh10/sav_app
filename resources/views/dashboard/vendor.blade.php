@extends('layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div>
                <h2>Tableau de bord Vendeur</h2>
                <p>Vue rapide des statistiques</p>
            </div>
        </div>

        <div class="row g-4">

            {{-- TOTAL VOITURES --}}
            <div class="col-xl-4 col-md-6">
                <div class="card stat-soft stat-blue border-0">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="stat-title text-primary mb-1">Total Voitures</h6>
                            <h2 class="stat-number mb-1">{{ $totalVehicles }}</h2>
                            <p class="stat-sub">Toutes les voitures enregistrées</p>
                        </div>
                        <div class="stat-icon bg-primary">
                            <i class="ti ti-car text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- VOITURES VENDUES --}}
            <div class="col-xl-4 col-md-6">
                <div class="card stat-soft stat-yellow border-0">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="stat-title text-warning mb-1">Voitures Vendues</h6>
                            <h2 class="stat-number mb-1">{{ $soldVehicles }}</h2>
                            <p class="stat-sub">Performance commerciale</p>
                        </div>
                        <div class="stat-icon bg-warning">
                            <i class="ti ti-cash text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- VOITURES APPROUVÉES --}}
            <div class="col-xl-4 col-md-6">
                <div class="card stat-soft stat-green border-0">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="stat-title text-success mb-1">Voitures Approuvées</h6>
                            <h2 class="stat-number mb-1">{{ $approvedVehicles }}</h2>
                            <p class="stat-sub">Disponibles à la vente</p>
                        </div>
                        <div class="stat-icon bg-success">
                            <i class="ti ti-circle-check text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- VOITURES NON VENDUES --}}
            <div class="col-xl-4 col-md-6">
                <div class="card stat-soft stat-gray border-0">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="stat-title text-dark mb-1">Voitures Non Vendues</h6>
                            <h2 class="stat-number mb-1">{{ $notSoldVehicles }}</h2>
                            <p class="stat-sub">Encore disponibles / en traitement</p>
                        </div>
                        <div class="stat-icon bg-dark">
                            <i class="ti ti-clock text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TOTAL CLIENTS --}}
            <div class="col-xl-4 col-md-6">
                <div class="card stat-soft stat-purple border-0">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="stat-title text-purple mb-1">Total Clients</h6>
                            <h2 class="stat-number mb-1">{{ $totalClients }}</h2>
                            <p class="stat-sub">Clients enregistrés</p>
                        </div>
                        <div class="stat-icon bg-purple">
                            <i class="ti ti-users text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TOTAL EMPLOYÉS --}}
            <!--div class="col-xl-4 col-md-6">
                <div class="card stat-soft stat-orange border-0">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="stat-title text-orange mb-1">Total Employés</h6>
                            <h2 class="stat-number mb-1">{ { $totalEmployees }}</h2>
                            <p class="stat-sub">Utilisateurs internes</p>
                        </div>
                        <div class="stat-icon bg-orange">
                            <i class="ti ti-briefcase text-white"></i>
                        </div>
                    </div>
                </div>
            </div-->

        </div>

    </div>
</div>
@endsection
