@extends('layout.mainlayout')

@section('content')

<div class="card">

    <div class="card-body">

        {{-- ============================================================
             TITRE
        ============================================================ --}}

        <h4 class="mb-4">
            Liste des voitures vendues
        </h4>


        {{-- ============================================================
             RECHERCHE
        ============================================================ --}}

        <form
            method="GET"
            action="{{ route('vehicles.sold') }}"
            class="mb-4"
        >

            <div class="row g-2 align-items-center">

                <div class="col-md-8">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Rechercher par VIN, marque, modèle..."
                    >

                </div>


                <div class="col-auto">

                    <button
                        type="submit"
                        class="btn btn-warning"
                    >
                        <i class="ti ti-search me-1"></i>
                        Rechercher
                    </button>

                </div>


                @if(request('search'))

                    <div class="col-auto">

                        <a
                            href="{{ route('vehicles.sold') }}"
                            class="btn btn-secondary"
                        >
                            <i class="ti ti-refresh me-1"></i>
                            Réinitialiser
                        </a>

                    </div>

                @endif

            </div>

        </form>


        {{-- ============================================================
             MESSAGE SUCCÈS
        ============================================================ --}}

        @if(session('success'))

            <div
                class="alert alert-success alert-dismissible fade show"
                role="alert"
            >

                <i class="ti ti-circle-check me-2"></i>

                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Fermer"
                ></button>

            </div>

        @endif


        {{-- ============================================================
             MESSAGE ERREUR
        ============================================================ --}}

        @if(session('error'))

            <div
                class="alert alert-danger alert-dismissible fade show"
                role="alert"
            >

                <i class="ti ti-alert-circle me-2"></i>

                {{ session('error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Fermer"
                ></button>

            </div>

        @endif


        {{-- ============================================================
             ERREURS DE VALIDATION
        ============================================================ --}}

        @if($errors->any())

            <div class="alert alert-danger">

                <strong>
                    Erreur :
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- ============================================================
             TABLEAU
        ============================================================ --}}

        <div class="table-responsive">

            <table
                class="table table-hover align-middle text-center"
            >

                <thead class="table-light">

                    <tr>

                        <th>
                            Numéro VIN
                        </th>

                        <th>
                            Marque
                        </th>

                        <th>
                            Modèle
                        </th>

                        <th>
                            Model year
                        </th>

                        <th>
                            Prix de vente
                        </th>

                        <th>
                            Date de vente
                        </th>

                        <th>
                            Client
                        </th>

                        <th>
                            Statut
                        </th>

                        <th style="min-width: 180px;">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($vehicles as $vehicle)

                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | DERNIÈRE VENTE
                            |--------------------------------------------------------------------------
                            |
                            | Vehicle::sale() doit utiliser latestOfMany().
                            |
                            */

                            $latestSale = $vehicle->sale;

                        @endphp


                        <tr>


                            {{-- =================================================
                                 VIN
                            ================================================= --}}

                            <td class="fw-semibold">

                                {{ $vehicle->vin ?? '-' }}

                            </td>


                            {{-- =================================================
                                 MARQUE
                            ================================================= --}}

                            <td>

                                {{ $vehicle->brand ?? '-' }}

                            </td>


                            {{-- =================================================
                                 MODÈLE
                            ================================================= --}}

                            <td>

                                {{ $vehicle->model ?? '-' }}

                            </td>


                            {{-- =================================================
                                 ANNÉE
                            ================================================= --}}

                            <td>

                                {{ $vehicle->model_year ?? '-' }}

                            </td>


                            {{-- =================================================
                                 PRIX DE LA DERNIÈRE VENTE
                            ================================================= --}}

                            <td class="fw-bold">

                                @if(
                                    $latestSale
                                    && $latestSale->sold_price !== null
                                )

                                    {{ number_format(
                                        (float) $latestSale->sold_price,
                                        2,
                                        ',',
                                        ' '
                                    ) }}
                                    FDJ

                                @else

                                    <span class="text-muted">
                                        Non défini
                                    </span>

                                @endif

                            </td>


                            {{-- =================================================
                                 DATE DE LA DERNIÈRE VENTE
                            ================================================= --}}

                            <td>

                                @if(
                                    $latestSale
                                    && $latestSale->sold_date
                                )

                                    @if(
                                        $latestSale
                                            ->sold_date
                                            ->isToday()
                                    )

                                        <span
                                            class="badge rounded-pill bg-danger mb-1"
                                        >
                                            Nouveau
                                        </span>

                                        <br>

                                    @endif


                                    {{ $latestSale
                                        ->sold_date
                                        ->format('d-m-Y')
                                    }}

                                @elseif($vehicle->sold_at)

                                    {{ \Carbon\Carbon::parse(
                                        $vehicle->sold_at
                                    )->format('d-m-Y') }}

                                @else

                                    <span class="text-muted">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- =================================================
                                 CLIENT DE LA DERNIÈRE VENTE
                            ================================================= --}}

                            <td>

                                @if(
                                    $latestSale
                                    && $latestSale->customer
                                )

                                    {{ $latestSale->customer->name }}

                                @else

                                    <span class="text-muted">
                                        N/A
                                    </span>

                                @endif

                            </td>


                            {{-- =================================================
                                 STATUT
                            ================================================= --}}

                            <td>

                                @if($vehicle->status === 'Vendu')

                                    <span class="badge bg-success">
                                        Vendu
                                    </span>

                                @elseif($vehicle->status === 'Payé')

                                    <span class="badge bg-primary">
                                        Payé
                                    </span>

                                @else

                                    <span class="badge bg-secondary">

                                        {{ $vehicle->status ?? '-' }}

                                    </span>

                                @endif

                            </td>


                            {{-- =================================================
                                 ACTIONS
                            ================================================= --}}

                            <td>

                                <div
                                    class="d-flex flex-wrap justify-content-center gap-1"
                                >


                                    {{-- =========================================
                                         ADMIN
                                    ========================================= --}}

                                    @auth

                                        @if(
                                            auth()->user()->role === 'admin'
                                        )

                                            <a
                                                href="{{ route(
                                                    'vehicles.edit',
                                                    $vehicle->id
                                                ) }}"
                                                class="btn btn-sm btn-primary"
                                                title="Modifier le véhicule"
                                            >

                                                <i class="ti ti-edit me-1"></i>

                                                Modifier

                                            </a>

                                        @endif

                                    @endauth


                                    {{-- =========================================
                                         VENDEUR
                                    ========================================= --}}

                                    @auth

                                        @if(
                                            auth()->user()->role === 'vendeur'
                                        )

                                            <a
                                                href="{{ route(
                                                    'vehicles.editPrice',
                                                    $vehicle->id
                                                ) }}"
                                                class="btn btn-sm btn-warning"
                                                title="Modifier le prix"
                                            >

                                                <i class="ti ti-edit me-1"></i>

                                                Éditer

                                            </a>

                                        @endif

                                    @endauth


                                    {{-- =========================================
                                         MÉCANICIEN / LOGISTIQUE
                                    ========================================= --}}

                                    @auth

                                        @if(
                                            in_array(
                                                auth()->user()->role,
                                                [
                                                    'mecanicien',
                                                    'logistique'
                                                ],
                                                true
                                            )
                                        )

                                            <a
                                                href="{{ route(
                                                    'vehicles.show',
                                                    $vehicle->id
                                                ) }}"
                                                class="btn btn-sm btn-info"
                                            >

                                                <i class="ti ti-eye me-1"></i>

                                                Voir

                                            </a>

                                        @endif

                                    @endauth


                                    {{-- =========================================
                                         VOIR FACTURE
                                    ========================================= --}}

                                    @auth

                                        @if(
                                            in_array(
                                                auth()->user()->role,
                                                [
                                                    'admin',
                                                    'vendeur'
                                                ],
                                                true
                                            )
                                            && $latestSale
                                        )

                                            <a
                                                href="{{ route(
                                                    'sales.invoice',
                                                    $latestSale
                                                ) }}"
                                                class="btn btn-sm btn-success"
                                                title="Voir la facture"
                                            >

                                                <i class="ti ti-file-invoice me-1"></i>

                                                Facture

                                            </a>

                                        @endif

                                    @endauth


                                </div>

                            </td>

                        </tr>


                    @empty


                        <tr>

                            <td
                                colspan="9"
                                class="text-center text-muted py-5"
                            >

                                <i
                                    class="ti ti-car-off d-block mb-2"
                                    style="font-size: 30px;"
                                ></i>

                                Aucune voiture vendue trouvée.

                            </td>

                        </tr>


                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- ============================================================
             PAGINATION
        ============================================================ --}}

        @if(
            $vehicles instanceof
            \Illuminate\Pagination\LengthAwarePaginator
        )

            <div
                class="mt-4 d-flex justify-content-center"
            >

                {{ $vehicles
                    ->withQueryString()
                    ->links('pagination::bootstrap-5')
                }}

            </div>

        @endif

    </div>

</div>

@endsection
