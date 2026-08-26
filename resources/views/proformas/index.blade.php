@extends('layout.mainlayout')

@section('content')

<style>
    .proforma-page {
        width: 100%;
        padding: 28px 24px 50px;
    }

    .proforma-page-inner {
        width: 100%;
        max-width: 1500px;
        margin: 0 auto;
    }

    .proforma-list-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .proforma-list-title h4 {
        margin: 0 0 5px;
        font-size: 28px;
        font-weight: 800;
        color: #111827;
    }

    .proforma-list-title h6 {
        margin: 0;
        font-size: 15px;
        font-weight: 400;
        color: #64748b;
    }

    .proforma-new-button {
        min-height: 46px;
        padding: 11px 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        color: #ffffff !important;
        font-weight: 700;
        text-decoration: none;
        background: linear-gradient(135deg, #ff6b00, #ff8a00);
        border: none;
        border-radius: 9px;
        box-shadow: 0 6px 16px rgba(255, 107, 0, 0.22);
    }

    .proforma-new-button:hover {
        color: #ffffff !important;
        background: linear-gradient(135deg, #e86100, #f57900);
    }

    .proforma-list-card {
        width: 100%;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e7eaf0;
        border-radius: 14px;
        box-shadow: 0 8px 26px rgba(15, 23, 42, 0.08);
    }

    .proforma-list-card .card-body {
        padding: 24px;
    }

    .proforma-filter-grid {
        display: grid;
        grid-template-columns: minmax(280px, 1fr) 190px auto auto;
        gap: 10px;
        align-items: stretch;
        margin-bottom: 22px;
    }

    .proforma-filter-grid .form-control,
    .proforma-filter-grid .form-select,
    .proforma-filter-grid .btn {
        min-height: 46px;
    }

    .proforma-search-button,
    .proforma-reset-button {
        min-width: 135px;
        padding: 10px 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-weight: 700;
        border-radius: 8px;
    }

    .proforma-search-button {
        color: #ffffff;
        background: #ff6b00;
        border: 1px solid #ff6b00;
    }

    .proforma-reset-button {
        color: #ffffff;
        background: #35788b;
        border: 1px solid #35788b;
        text-decoration: none;
    }

    .proforma-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .proforma-table {
        width: 100%;
        min-width: 1250px;
        margin: 0;
        table-layout: fixed;
    }

    .proforma-table thead th {
        padding: 13px 10px;
        vertical-align: middle;
        white-space: nowrap;
        font-size: 13px;
        font-weight: 800;
        color: #111827;
        background: #e5e7eb;
    }

    .proforma-table tbody td {
        padding: 14px 10px;
        vertical-align: middle;
        font-size: 13px;
    }

    .proforma-table th:nth-child(1),
    .proforma-table td:nth-child(1) {
        width: 165px;
    }

    .proforma-table th:nth-child(2),
    .proforma-table td:nth-child(2) {
        width: 105px;
        text-align: center;
    }

    .proforma-table th:nth-child(3),
    .proforma-table td:nth-child(3) {
        width: 175px;
    }

    .proforma-table th:nth-child(4),
    .proforma-table td:nth-child(4) {
        width: 245px;
    }

    .proforma-table th:nth-child(5),
    .proforma-table td:nth-child(5) {
        width: 170px;
        text-align: right;
    }

    .proforma-table th:nth-child(6),
    .proforma-table td:nth-child(6) {
        width: 115px;
        text-align: center;
    }

    .proforma-table th:nth-child(7),
    .proforma-table td:nth-child(7) {
        width: 120px;
        text-align: center;
    }

    .proforma-table th:nth-child(8),
    .proforma-table td:nth-child(8) {
        width: 120px;
        text-align: center;
    }

    .proforma-action-group {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 7px;
    }

    .proforma-view-button {
        min-width: 82px;
        min-height: 36px;
        padding: 7px 13px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;

        color: #ffffff !important;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;

        background: linear-gradient(135deg, #ff6b00, #ff8a00) !important;
        border: none !important;
        border-radius: 8px;

        box-shadow: 0 4px 10px rgba(255, 107, 0, 0.20);

        transition:
            transform 0.15s ease,
            box-shadow 0.15s ease,
            background 0.15s ease;
    }

    .proforma-view-button:hover,
    .proforma-view-button:focus {
        color: #ffffff !important;
        background: linear-gradient(135deg, #e86100, #f57900) !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(255, 107, 0, 0.28);
    }

    /*
    |--------------------------------------------------------------------------
    | BOUTON MODIFIER
    |--------------------------------------------------------------------------
    */
    .proforma-edit-button {
        min-width: 100px;
        min-height: 36px;
        padding: 7px 13px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;

        color: #ffffff !important;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none !important;

        background: linear-gradient(135deg, #f59e0b, #fbbf24) !important;
        border: none !important;
        border-radius: 8px;

        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.22);

        transition:
            transform 0.15s ease,
            box-shadow 0.15s ease,
            background 0.15s ease;
    }

    .proforma-edit-button:hover,
    .proforma-edit-button:focus {
        color: #ffffff !important;
        background: linear-gradient(135deg, #d97706, #f59e0b) !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(245, 158, 11, 0.30);
    }

    .proforma-pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    @media (max-width: 991.98px) {
        .proforma-filter-grid {
            grid-template-columns: 1fr 180px;
        }

        .proforma-search-button,
        .proforma-reset-button {
            width: 100%;
        }
    }

    @media (max-width: 767.98px) {
        .proforma-page {
            padding: 18px 12px 35px;
        }

        .proforma-list-header {
            align-items: stretch;
            flex-direction: column;
        }

        .proforma-new-button {
            width: 100%;
        }

        .proforma-filter-grid {
            grid-template-columns: 1fr;
        }

        .proforma-list-card .card-body {
            padding: 16px;
        }
    }
</style>

<div class="proforma-page">
    <div class="proforma-page-inner">

        <div class="proforma-list-header">
            <div class="proforma-list-title">
                <h4>Liste des proformas</h4>
                <h6>Gestion des propositions commerciales</h6>
            </div>

            <a
                href="{{ route('proformas.create') }}"
                class="proforma-new-button"
            >
                <i class="ti ti-file-plus"></i>
                Nouveau proforma
            </a>
        </div>

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

        @if(session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif

        <div class="proforma-list-card">
            <div class="card-body">

                <form
                    method="GET"
                    action="{{ route('proformas.index') }}"
                    class="proforma-filter-grid"
                >
                    <input
                        type="text"
                        name="search"
                        value="{{ $search ?? request('search') }}"
                        class="form-control"
                        placeholder="N° proforma, client, VIN, marque ou modèle..."
                    >

                    <select
                        name="status"
                        class="form-select"
                    >
                        <option value="">Tous les statuts</option>

                        @foreach([
                            'Brouillon',
                            'Validé',
                            'Converti',
                            'Annulé',
                            'Expiré'
                        ] as $statusOption)
                            <option
                                value="{{ $statusOption }}"
                                @selected(($status ?? request('status')) === $statusOption)
                            >
                                {{ $statusOption }}
                            </option>
                        @endforeach
                    </select>

                    <button
                        type="submit"
                        class="btn proforma-search-button"
                    >
                        <i class="ti ti-search"></i>
                        Rechercher
                    </button>

                    <a
                        href="{{ route('proformas.index') }}"
                        class="btn proforma-reset-button"
                    >
                        <i class="ti ti-refresh"></i>
                        Réinitialiser
                    </a>
                </form>

                <div class="proforma-table-wrapper">
                    <table class="table table-bordered table-hover align-middle proforma-table">
                        <thead>
                            <tr>
                                <th>N° Proforma</th>
                                <th>Date</th>
                                <th>Client</th>
                                <th>Véhicule</th>
                                <th>Prix HT</th>
                                <th>Validité</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($proformas as $proforma)
                                <tr>
                                    <td>
                                        <strong>{{ $proforma->proforma_number }}</strong>
                                    </td>

                                    <td>
                                        {{ $proforma->proforma_date
                                            ? $proforma->proforma_date->format('d/m/Y')
                                            : '-'
                                        }}
                                    </td>

                                    <td>
                                        <strong>{{ $proforma->customer->name ?? '-' }}</strong>

                                        @if($proforma->customer?->phone)
                                            <br>
                                            <small class="text-muted">
                                                {{ $proforma->customer->phone }}
                                            </small>
                                        @endif
                                    </td>

                                    <td>
                                        <strong>
                                            {{ $proforma->vehicle->brand ?? '-' }}
                                            {{ $proforma->vehicle->model ?? '' }}
                                        </strong>

                                        <br>

                                        <small class="text-muted">
                                            VIN : {{ $proforma->vehicle->vin ?? '-' }}
                                        </small>
                                    </td>

                                    <td class="fw-bold">
                                        {{ number_format(
                                            (float) $proforma->proforma_price,
                                            2,
                                            ',',
                                            ' '
                                        ) }} FDJ
                                    </td>

                                    <td>
                                        {{ $proforma->valid_until
                                            ? $proforma->valid_until->format('d/m/Y')
                                            : '-'
                                        }}
                                    </td>

                                    <td>
                                        @switch($proforma->status)
                                            @case('Converti')
                                                <span class="badge bg-success">Converti</span>
                                                @break

                                            @case('Annulé')
                                                <span class="badge bg-danger">Annulé</span>
                                                @break

                                            @case('Expiré')
                                                <span class="badge bg-secondary">Expiré</span>
                                                @break

                                            @case('Brouillon')
                                                <span class="badge bg-warning text-dark">
                                                    Brouillon
                                                </span>
                                                @break

                                            @default
                                                <span class="badge bg-primary">
                                                    {{ $proforma->status }}
                                                </span>
                                        @endswitch
                                    </td>

                                  <td>

                                    <div class="proforma-action-group">

                                        {{-- ============================================================= --}}
                                        {{-- VOIR --}}
                                        {{-- ============================================================= --}}

                                        <a
                                            href="{{ route('proformas.show', $proforma) }}"
                                            class="proforma-view-button"
                                            title="Voir le proforma"
                                        >
                                            <i class="ti ti-eye"></i>
                                            Voir
                                        </a>


                                        {{-- ============================================================= --}}
                                        {{-- MODIFIER --}}
                                        {{-- ============================================================= --}}
                                        {{--
                                            Validé   → modification autorisée
                                            Converti → modification autorisée
                                            Annulé   → modification interdite
                                            Expiré   → modification interdite
                                        --}}

                                        @if(
                                            !in_array(
                                                $proforma->status,
                                                [
                                                    'Annulé',
                                                    'Expiré'
                                                ],
                                                true
                                            )
                                        )

                                            <a
                                                href="{{ route(
                                                    'proformas.edit',
                                                    $proforma
                                                ) }}"
                                                class="proforma-edit-button"
                                                title="Modifier le prix et la date"
                                            >

                                                <i class="ti ti-edit"></i>

                                                Modifier

                                            </a>

                                        @endif

                                    </div>

                                </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="8"
                                        class="text-center text-muted py-5"
                                    >
                                        <i class="ti ti-file-off fs-2 d-block mb-2"></i>
                                        Aucun proforma trouvé.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($proformas->hasPages())
                    <div class="proforma-pagination">
                        {{ $proformas->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

@endsection
