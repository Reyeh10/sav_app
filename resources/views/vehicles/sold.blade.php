@extends('layout.mainlayout')

@section('content')

<!--div class="page-wrapper">
    <div class="content"-->

        <div class="card">
            <div class="card-body">

                <h4 class="mb-4">Liste des voitures vendues</h4>
                <!-- ================= SEARCH ================= -->
                <form method="GET" action="{{ route('vehicles.sold') }}" class="mb-3">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-4">
                            <input type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control"
                                placeholder="Rechercher par VIN, marque, modèle...">
                        </div>

                        <div class="col-auto">
                            <button type="submit" class="btn btn-warning">
                                🔍 Rechercher
                            </button>
                        </div>

                        @if(request('search'))
                        <div class="col-auto">
                            <a href="{{ route('vehicles.sold') }}" class="btn btn-secondary">
                                Réinitialiser
                            </a>
                        </div>
                        @endif
                    </div>
                </form>
                {{-- ================= ALERTS ================= --}}
                @if(session('success'))
                <script>
                Swal.fire({
                    title: 'Succès',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#28a745',
                    background: '#f8f9fa'
                });
                </script>
                @endif


                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- ================= TABLE ================= --}}
                <div class="table-responsive">
                   <table class="table table-hover align-middle text-center">

                        <thead class="table-light">
                            <tr>
                                <!--th>ID</th-->
                                <th>Numéro VIN</th>
                                <th>Marque</th>
                                <th>Modèle</th>
                                <th>Model year</th>
                                <th>Prix de vente</th>
                                 <th>Date de vente</th>
                                <th>Statut</th>
                                <th width="180">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                        @forelse($vehicles as $vehicle)

                            <tr>
                                <!--td>{ { $vehicle->id }}</td-->
                                <td>{{ $vehicle->vin }}</td>
                                <td>{{ $vehicle->brand ?? 'UNKNOWN' }}</td>
                                <td>{{ $vehicle->model }}</td>
                                <td>{{ $vehicle->year }}</td>

                                {{-- ================= PRIX ================= --}}
                                <td>
                                    @if($vehicle->sale && $vehicle->sale->sold_price)
                                        {{ number_format($vehicle->sale->sold_price, 3, ',', ' ') }} FDJ
                                    @else
                                        Non défini
                                    @endif
                                </td>
                                {{-- DATE DE VENTE --}}
                                <td>
                                    @php
                                        $soldDate = optional($vehicle->sale)->sold_date;
                                    @endphp

                                    @if($soldDate)
                                        @if(\Carbon\Carbon::parse($soldDate)->isToday())
                                            <span class="badge rounded-pill px-3 py-1"
                                                style="background: linear-gradient(45deg, #ff4d4d, #ff0000); font-size: 11px;">
                                                ✨ Nouveau
                                            </span>
                                        @endif

                                        {{ \Carbon\Carbon::parse($soldDate)->format('d-m-Y') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                {{-- ================= STATUT ================= --}}
                                <td>
                                    <span class="badge bg-success">
                                        Vendu
                                    </span>
                                </td>

                                {{-- ================= ACTIONS ================= --}}
                                <td>

                                    {{-- ADMIN : modification complète --}}
                                    @auth
                                        @if(auth()->user()->role === 'admin')
                                            <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                                               class="btn btn-sm btn-primary">
                                                Modifier
                                            </a>
                                        @endif
                                    @endauth

                                    {{-- VENDEUR : uniquement modifier prix --}}
                                    @auth
                                        @if(auth()->user()->role === 'vendeur')
                                            <a href="{{ route('vehicles.editPrice', $vehicle->id) }}"
                                               class="btn btn-sm btn-warning">
                                                Editer
                                            </a>
                                        @endif
                                    @endauth

                                {{-- MECANICIEN : voir seulement --}}
                                @auth
                                @if(auth()->user()->role === 'mecanicien')
                                    <a href="{{ route('vehicles.show', $vehicle->id) }}"
                                    class="btn btn-sm btn-info">
                                        Voir
                                    </a>
                                @endif
                                @endauth
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    Aucune voiture vendue trouvée
                                </td>
                            </tr>

                        @endforelse

                        </tbody>

                    </table>
                     {{--  Pagination --}}
                    @if(method_exists($vehicles, 'links'))
                        <div class="mt-3 d-flex justify-content-center">
                            {{ $vehicles->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>

            </div>
        </div>

    <!--/div>
</div-->

@endsection
