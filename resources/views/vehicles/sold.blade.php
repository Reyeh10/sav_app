@extends('layout.mainlayout')

@section('content')

<div class="page-wrapper">
    <div class="content">

        <div class="card">
            <div class="card-body">

                <h4 class="mb-4">Liste des voitures vendues</h4>

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
                    <table class="table table-striped table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <!--th>ID</th-->
                                <th>Numéro VIN</th>
                                <th>Marque</th>
                                <th>Modèle</th>
                                <th>Année</th>
                                <th>Prix de vente</th>
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


                                {{-- ================= STATUT ================= --}}
                                <td>
                                    <span class="badge bg-success">
                                        Sold
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
                </div>

            </div>
        </div>

    </div>
</div>

@endsection
