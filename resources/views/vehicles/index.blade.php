@extends('layout.mainlayout')

@section('content')

@php
    $role = auth()->user()->role;
@endphp


{{-- ============================================================= --}}
{{-- ALERTES --}}
{{-- ============================================================= --}}

@if($errors->any())

    <div class="alert alert-danger">

        <strong>Erreur :</strong>

        <ul class="mb-0 mt-2">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif


@if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif


@if(session('error'))

    <div class="alert alert-danger">
        {{ session('error') }}
    </div>

@endif



{{-- ============================================================= --}}
{{-- HEADER --}}
{{-- ============================================================= --}}

<div class="card shadow-sm border-0 mb-4">

    <div class="card-body">

        <div
            class="
                d-flex
                justify-content-between
                align-items-center
                flex-wrap
                gap-3
            "
        >

            <div>

                <h3 class="fw-bold mb-1">
                    Gestion des voitures
                </h3>

                <p class="text-muted mb-0">
                    Liste des voitures enregistrées dans le système
                </p>

            </div>


            <div class="d-flex gap-2">

                @if(in_array($role, ['admin', 'logistique'], true))

                    <a
                        href="{{ route('vehicles.create') }}"
                        class="btn btn-primary shadow-sm"
                    >
                        <i class="ti ti-circle-plus me-1"></i>

                        Ajouter une voiture
                    </a>


                    <button
                        type="button"
                        class="btn btn-success shadow-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#importExcelModal"
                    >
                        <i class="ti ti-upload me-1"></i>

                        Importer Excel
                    </button>

                @endif

            </div>

        </div>

    </div>

</div>



{{-- ============================================================= --}}
{{-- TABLE --}}
{{-- ============================================================= --}}

<div class="card">

    <div class="card-body">


        {{-- ========================================================= --}}
        {{-- RECHERCHE --}}
        {{-- ========================================================= --}}

        <form
            method="GET"
            action="{{ route('vehicles.index') }}"
            class="mb-3"
        >

            <div
                class="
                    d-flex
                    flex-wrap
                    gap-2
                    align-items-center
                "
            >

                {{-- VIN --}}

                <input
                    type="text"
                    name="vin"
                    class="form-control"
                    placeholder="VIN"
                    value="{{ request('vin') }}"
                    style="width: 180px;"
                >


                {{-- MARQUE --}}

                <input
                    type="text"
                    name="brand"
                    class="form-control"
                    placeholder="Marque"
                    value="{{ request('brand') }}"
                    style="width: 150px;"
                >


                {{-- MODÈLE --}}

                <input
                    type="text"
                    name="model"
                    class="form-control"
                    placeholder="Modèle"
                    value="{{ request('model') }}"
                    style="width: 150px;"
                >


                {{-- ANNÉE --}}

                <input
                    type="text"
                    name="model_year"
                    class="form-control"
                    placeholder="Année"
                    value="{{ request('model_year') }}"
                    style="width: 120px;"
                >


                {{-- STATUT --}}

                <select
                    name="status"
                    class="form-select"
                    style="width: 180px;"
                >

                    <option value="">
                        Tous les statuts
                    </option>

                    <option
                        value="Disponible"
                        @selected(request('status') === 'Disponible')
                    >
                        Disponible
                    </option>

                    <option
                        value="Vendu"
                        @selected(request('status') === 'Vendu')
                    >
                        Vendu
                    </option>

                    <option
                        value="En réparation"
                        @selected(request('status') === 'En réparation')
                    >
                        En réparation
                    </option>

                    <option
                        value="En attente"
                        @selected(request('status') === 'En attente')
                    >
                        En attente
                    </option>

                    <option
                        value="Pièces prélevées"
                        @selected(request('status') === 'Pièces prélevées')
                    >
                        Pièces prélevées
                    </option>

                </select>


                {{-- RECHERCHER --}}

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i class="ti ti-search"></i>
                </button>


                {{-- RÉINITIALISER --}}

                <a
                    href="{{ route('vehicles.index') }}"
                    class="btn btn-secondary"
                >
                    <i class="ti ti-refresh me-1"></i>

                    Réinitialiser
                </a>


                {{-- EXPORT --}}

                <a
                    href="{{ route(
                        'vehicles.exportVehicles',
                        request()->query()
                    ) }}"
                    class="btn btn-success"
                >
                    <i class="ti ti-download me-1"></i>

                    Exporter
                </a>

            </div>

        </form>



        {{-- ========================================================= --}}
        {{-- TABLE RESPONSIVE --}}
        {{-- ========================================================= --}}

        <div class="table-responsive">

            <table
                class="
                    table
                    table-striped
                    table-bordered
                    table-hover
                    align-middle
                    w-100
                    text-nowrap
                "
            >

                <thead class="table-light">

                    <tr>

                        <th>VIN</th>

                        <th>Marque</th>

                        <th>Modèle</th>

                        <th>Configuration</th>

                        <th>Engine Number</th>

                        <th>Cylindrée</th>

                        <th>Carburant / Énergie</th>

                        <th>Portes</th>

                        <th>Cylindres</th>

                        <th>Pneus</th>

                        <th>Transmission</th>

                        <th>Places</th>

                        <th>Couleur intérieure</th>

                        <th>Couleur extérieure</th>

                        <th>Model Year</th>

                        <th>Date d'arrivée</th>

                        <th>Kilométrage</th>

                        <th>Statut</th>

                        <th>Commentaire</th>

                        <th>Actions</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($vehicles as $vehicle)

                        <tr>


                            {{-- ========================================= --}}
                            {{-- VIN --}}
                            {{-- ========================================= --}}

                            <td>
                                {{ $vehicle->vin ?? '-' }}
                            </td>


                            {{-- ========================================= --}}
                            {{-- MARQUE --}}
                            {{-- ========================================= --}}

                            <td>
                                {{ $vehicle->brand ?? '-' }}
                            </td>


                            {{-- ========================================= --}}
                            {{-- MODÈLE --}}
                            {{-- ========================================= --}}

                            <td>
                                {{ $vehicle->model ?? '-' }}
                            </td>


                            {{-- ========================================= --}}
                            {{-- CONFIGURATION --}}
                            {{-- ========================================= --}}

                            <td>
                                {{ $vehicle->configuration ?? '-' }}
                            </td>


                            {{-- ========================================= --}}
                            {{-- ENGINE NUMBER --}}
                            {{-- ========================================= --}}

                            <td>
                                {{ $vehicle->engine_number ?? '-' }}
                            </td>


                            {{-- ========================================= --}}
                            {{-- CYLINDRÉE --}}
                            {{-- ========================================= --}}

                            <td>
                                {{ $vehicle->engine_capacity ?? '-' }}
                            </td>


                            {{-- ========================================= --}}
                            {{-- CARBURANT / ÉNERGIE --}}
                            {{-- ========================================= --}}

                            <td>
                                {{ $vehicle->fuel_type ?? '-' }}
                            </td>


                            {{-- ========================================= --}}
                            {{-- PORTES --}}
                            {{-- ========================================= --}}

                            <td class="text-center">
                                {{ $vehicle->doors ?? '-' }}
                            </td>


                            {{-- ========================================= --}}
                            {{-- CYLINDRES --}}
                            {{-- ========================================= --}}

                            <td class="text-center">
                                {{ $vehicle->cylinders ?? '-' }}
                            </td>


                            {{-- ========================================= --}}
                            {{-- TAILLE DES PNEUS --}}
                            {{-- ========================================= --}}

                            <td>
                                {{ $vehicle->tire_size ?? '-' }}
                            </td>


                            {{-- ========================================= --}}
                            {{-- TRANSMISSION --}}
                            {{-- ========================================= --}}

                            <td>
                                {{ $vehicle->transmission ?? '-' }}
                            </td>


                            {{-- ========================================= --}}
                            {{-- NOMBRE DE PLACES --}}
                            {{-- ========================================= --}}

                            <td class="text-center">
                                {{ $vehicle->seats ?? '-' }}
                            </td>


                            {{-- ========================================= --}}
                            {{-- COULEUR INTÉRIEURE --}}
                            {{-- ========================================= --}}

                            <td>
                                {{ $vehicle->color_interior ?? '-' }}
                            </td>


                            {{-- ========================================= --}}
                            {{-- COULEUR EXTÉRIEURE --}}
                            {{-- ========================================= --}}

                            <td>
                                {{ $vehicle->color_exterior ?? '-' }}
                            </td>


                            {{-- ========================================= --}}
                            {{-- ANNÉE --}}
                            {{-- ========================================= --}}

                            <td class="text-center">
                                {{ $vehicle->model_year ?? '-' }}
                            </td>


                            {{-- ========================================= --}}
                            {{-- DATE D'ARRIVÉE --}}
                            {{-- ========================================= --}}

                            <td>

                                {{ $vehicle->arrival_date
                                    ? \Carbon\Carbon::parse(
                                        $vehicle->arrival_date
                                    )->format('d/m/Y')
                                    : '-'
                                }}

                            </td>


                            {{-- ========================================= --}}
                            {{-- KILOMÉTRAGE --}}
                            {{-- ========================================= --}}

                            <td>

                                @if($vehicle->mileage !== null)

                                    {{ number_format(
                                        (float) $vehicle->mileage,
                                        0,
                                        ',',
                                        ' '
                                    ) }}

                                @else

                                    -

                                @endif

                            </td>


                            {{-- ========================================= --}}
                            {{-- STATUT --}}
                            {{-- ========================================= --}}

                            <td>

                                @switch($vehicle->status)

                                    @case('Disponible')

                                        <span class="badge bg-success">
                                            Disponible
                                        </span>

                                        @break


                                    @case('En réparation')

                                        <span class="badge bg-warning text-dark">
                                            En réparation
                                        </span>

                                        @break


                                    @case('En attente')

                                        <span class="badge bg-secondary">
                                            En attente
                                        </span>

                                        @break


                                    @case('Vendu')

                                        <span class="badge bg-danger">
                                            Vendu
                                        </span>

                                        @break


                                    @case('Payé')

                                        <span class="badge bg-primary">
                                            Payé
                                        </span>

                                        @break


                                    @case('Annulé')

                                        <span class="badge bg-dark">
                                            Annulé
                                        </span>

                                        @break


                                    @case('Pièces prélevées')

                                        <span class="badge bg-dark">
                                            Pièces prélevées
                                        </span>

                                        @break


                                    @default

                                        <span class="badge bg-light text-dark">
                                            {{ $vehicle->status ?? '-' }}
                                        </span>

                                @endswitch

                            </td>


                            {{-- ========================================= --}}
                            {{-- COMMENTAIRE --}}
                            {{-- ========================================= --}}

                            <td>

                                @if(!empty($vehicle->comment))

                                    {{ \Illuminate\Support\Str::limit(
                                        $vehicle->comment,
                                        20
                                    ) }}


                                    @if(
                                        mb_strlen(
                                            $vehicle->comment
                                        ) > 20
                                    )

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-link p-0 ms-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#commentModal{{ $vehicle->id }}"
                                        >
                                            Voir
                                        </button>

                                    @endif

                                @else

                                    -

                                @endif

                            </td>


                            {{-- ========================================= --}}
                            {{-- ACTIONS --}}
                            {{-- ========================================= --}}

                            <td>

                                <div
                                    class="
                                        d-flex
                                        align-items-center
                                        justify-content-center
                                        gap-1
                                    "
                                >


                                    {{-- VOIR --}}

                                    <a
                                        href="{{ route(
                                            'vehicles.show',
                                            $vehicle->id
                                        ) }}"
                                        class="btn btn-info btn-sm"
                                        title="Voir"
                                    >
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    {{-- MODIFIER --}}
                                    {{--
                                        Admin, logistique et mécanicien :
                                        bouton affiché selon leurs droits habituels.

                                        Vendeur :
                                        bouton affiché uniquement si le véhicule
                                        est encore "Disponible".
                                    --}}

                                    @if(
                                        in_array(
                                            $role,
                                            [
                                                'admin',
                                                'logistique',
                                                'mecanicien'
                                            ],
                                            true
                                        )
                                        ||
                                        (
                                            $role === 'vendeur'
                                            && $vehicle->status === 'Disponible'
                                        )
                                    )

                                        <a
                                            href="{{ route(
                                                'vehicles.edit',
                                                $vehicle->id
                                            ) }}"
                                            class="btn btn-warning btn-sm"
                                            title="Modifier"
                                        >
                                            <i class="ti ti-edit"></i>
                                        </a>

                                    @endif


                                    {{-- SUPPRIMER --}}

                                    @if($role === 'admin')

                                        <form
                                            id="delete-form-{{ $vehicle->id }}"
                                            action="{{ route(
                                                'vehicles.destroy',
                                                $vehicle->id
                                            ) }}"
                                            method="POST"
                                            class="m-0"
                                        >

                                            @csrf
                                            @method('DELETE')


                                            <button
                                                type="button"
                                                class="btn btn-danger btn-sm"
                                                title="Supprimer"
                                                onclick="confirmDelete(
                                                    {{ $vehicle->id }}
                                                )"
                                            >
                                                <i class="ti ti-trash"></i>
                                            </button>

                                        </form>

                                    @endif


                                </div>

                            </td>

                        </tr>



                        {{-- ============================================= --}}
                        {{-- IMAGE MODAL --}}
                        {{-- ============================================= --}}

                        @if($vehicle->image)

                            <div
                                class="modal fade"
                                id="img{{ $vehicle->id }}"
                                tabindex="-1"
                            >

                                <div
                                    class="
                                        modal-dialog
                                        modal-lg
                                        modal-dialog-centered
                                    "
                                >

                                    <div
                                        class="
                                            modal-content
                                            bg-transparent
                                            border-0
                                        "
                                    >

                                        <div class="modal-body text-center">

                                            <img
                                                src="{{ asset(
                                                    'storage/'
                                                    . $vehicle->image
                                                ) }}"
                                                class="
                                                    img-fluid
                                                    rounded
                                                    shadow
                                                "
                                                alt="Image du véhicule"
                                            >

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @endif



                        {{-- ============================================= --}}
                        {{-- COMMENTAIRE MODAL --}}
                        {{-- ============================================= --}}

                        @if(!empty($vehicle->comment))

                            <div
                                class="modal fade"
                                id="commentModal{{ $vehicle->id }}"
                                tabindex="-1"
                            >

                                <div class="modal-dialog">

                                    <div class="modal-content">

                                        <div class="modal-header">

                                            <h5 class="modal-title">
                                                Commentaire du mécanicien
                                            </h5>

                                            <button
                                                type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"
                                            ></button>

                                        </div>


                                        <div class="modal-body">

                                            {{ $vehicle->comment }}

                                        </div>


                                        <div class="modal-footer">

                                            <button
                                                type="button"
                                                class="btn btn-secondary"
                                                data-bs-dismiss="modal"
                                            >
                                                Fermer
                                            </button>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @endif


                    @empty


                        <tr>

                            <td
                                colspan="20"
                                class="
                                    text-center
                                    text-muted
                                    py-5
                                "
                            >

                                <i
                                    class="
                                        ti
                                        ti-car-off
                                        fs-2
                                        d-block
                                        mb-2
                                    "
                                ></i>

                                Aucun véhicule trouvé.

                            </td>

                        </tr>


                    @endforelse

                </tbody>

            </table>

        </div>



        {{-- ========================================================= --}}
        {{-- PAGINATION --}}
        {{-- ========================================================= --}}

        @if(
            $vehicles instanceof
            \Illuminate\Pagination\LengthAwarePaginator
        )

            <div
                class="
                    mt-3
                    d-flex
                    justify-content-center
                "
            >

                {{ $vehicles
                    ->withQueryString()
                    ->links('pagination::bootstrap-5')
                }}

            </div>

        @endif


    </div>

</div>



{{-- ============================================================= --}}
{{-- IMPORT EXCEL MODAL --}}
{{-- ============================================================= --}}

<div
    class="modal fade"
    id="importExcelModal"
    tabindex="-1"
>

    <div class="modal-dialog">

        <div class="modal-content">

            <form
                action="{{ route('vehicles.import') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                <div class="modal-header">

                    <h5 class="modal-title">
                        Importer fichier Excel
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>


                <div class="modal-body">

                    <label
                        for="vehicle-import-file"
                        class="form-label"
                    >
                        Fichier Excel
                    </label>


                    <input
                        type="file"
                        name="file"
                        id="vehicle-import-file"

                        class="
                            form-control
                            @error('file')
                                is-invalid
                            @enderror
                        "

                        accept="
                            .xlsx,
                            .xls,
                            .csv
                        "

                        required
                    >


                    @error('file')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Annuler
                    </button>


                    <button
                        type="submit"
                        class="btn btn-success"
                    >
                        <i class="ti ti-upload me-1"></i>

                        Importer
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



{{-- ============================================================= --}}
{{-- POPUP SUPPRESSION --}}
{{-- ============================================================= --}}

<script>

    function confirmDelete(vehicleId) {

        if (
            confirm(
                'Voulez-vous vraiment supprimer ce véhicule ?'
            )
        ) {

            const form =
                document.getElementById(
                    'delete-form-' + vehicleId
                );

            if (form) {
                form.submit();
            }

        }

    }

</script>

@endsection
