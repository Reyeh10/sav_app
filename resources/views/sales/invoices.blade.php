@extends('layout.mainlayout')

@section('content')

<style>
    .invoice-list-page {
        width: 100%;
        min-width: 0;
    }

    .invoice-list-card {
        width: 100%;
        min-width: 0;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    }

    .invoice-list-card .card-body {
        min-width: 0;
        padding: 28px;
    }

    .invoice-search-row {
        align-items: stretch;
    }

    .invoice-search-row .form-control,
    .invoice-search-row .btn {
        min-height: 46px;
    }

    .invoice-grid-scroll {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #fff;
    }

    .invoice-grid {
        min-width: 2010px;
    }

    .invoice-grid-row {
        display: grid;
        grid-template-columns:
            185px
            105px
            165px
            215px
            210px
            150px
            150px
            160px
            160px
            170px
            145px
            175px
            110px;
        align-items: stretch;
        width: 100%;
    }

    .invoice-grid-header {
        position: sticky;
        top: 0;
        z-index: 2;
        background: #eef2f7;
        border-bottom: 1px solid #d1d5db;
    }

    .invoice-grid-header > div {
        display: flex;
        align-items: center;
        min-width: 0;
        padding: 14px 12px;
        font-size: 12px;
        font-weight: 800;
        color: #1f2937;
        white-space: nowrap;
    }

    .invoice-grid-body .invoice-grid-row {
        border-bottom: 1px solid #eef2f7;
        background: #fff;
    }

    .invoice-grid-body .invoice-grid-row:last-child {
        border-bottom: none;
    }

    .invoice-grid-body .invoice-grid-row:hover {
        background: #f8fafc;
    }

    .invoice-grid-cell {
        display: flex;
        align-items: center;
        min-width: 0;
        padding: 14px 12px;
        font-size: 13px;
        color: #475569;
        white-space: nowrap;
    }

    .invoice-grid-cell.cell-right {
        justify-content: flex-end;
        text-align: right;
        font-variant-numeric: tabular-nums;
    }

    .invoice-grid-cell.cell-center {
        justify-content: center;
        text-align: center;
    }

    .invoice-grid-cell.cell-wrap {
        white-space: normal;
        overflow-wrap: anywhere;
    }

    .invoice-number {
        color: #334155;
        font-weight: 800;
    }

    .invoice-status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 118px;
        max-width: 160px;
        padding: 6px 10px;
        font-size: 11px;
        font-weight: 800;
        line-height: 1.2;
        text-align: center;
        white-space: normal;
        border: 1px solid transparent;
        border-radius: 999px;
    }

    .status-sold {
        color: #0c5460;
        background: #d1ecf1;
        border-color: #bee5eb;
    }

    .status-partial {
        color: #854d0e;
        background: #fef3c7;
        border-color: #fde68a;
    }

    .status-paid {
        color: #155724;
        background: #d4edda;
        border-color: #c3e6cb;
    }

    .status-cancelled {
        color: #721c24;
        background: #f8d7da;
        border-color: #f5c6cb;
    }

    .amount-paid {
        color: #15803d !important;
        font-weight: 800;
    }

    .amount-remaining {
        color: #b91c1c !important;
        font-weight: 800;
    }

    .amount-remaining-zero {
        color: #15803d !important;
        font-weight: 800;
    }

    .invoice-actions {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    .invoice-actions .btn {
        white-space: nowrap;
    }

    .invoice-empty {
        padding: 40px 20px;
        text-align: center;
        color: #64748b;
    }

    .invoice-pagination {
        margin-top: 20px;
    }

    @media (max-width: 1199.98px) {
        .invoice-list-card .card-body {
            padding: 22px;
        }
    }

    @media (max-width: 991.98px) {
        .invoice-list-card .card-body {
            padding: 18px;
        }

        .invoice-search-row {
            row-gap: 10px;
        }

        .invoice-search-row > div {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
    }

    @media (max-width: 767.98px) {
        .invoice-list-card {
            border-radius: 12px;
        }

        .invoice-list-card .card-body {
            padding: 14px;
        }

        .invoice-list-page h4 {
            font-size: 20px;
        }

        .invoice-list-page p {
            font-size: 13px;
        }

        .invoice-search-row .form-control,
        .invoice-search-row .btn {
            width: 100%;
        }

        .invoice-grid-scroll {
            overflow: visible;
            border: none;
            background: transparent;
        }

        .invoice-grid {
            min-width: 0;
        }

        .invoice-grid-header {
            display: none;
        }

        .invoice-grid-body {
            display: grid;
            gap: 14px;
        }

        .invoice-grid-body .invoice-grid-row {
            display: block;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
        }

        .invoice-grid-body .invoice-grid-row:hover {
            background: #fff;
        }

        .invoice-grid-cell {
            display: grid;
            grid-template-columns: minmax(125px, 42%) minmax(0, 58%);
            gap: 12px;
            width: 100%;
            padding: 10px 14px;
            text-align: right !important;
            white-space: normal;
            border-bottom: 1px solid #eef2f7;
        }

        .invoice-grid-cell::before {
            content: attr(data-label);
            font-size: 12px;
            font-weight: 800;
            color: #334155;
            text-align: left;
        }

        .invoice-grid-cell:last-child {
            border-bottom: none;
        }

        .invoice-grid-cell.cell-right,
        .invoice-grid-cell.cell-center {
            justify-content: initial;
        }

        .invoice-grid-cell[data-label="Numéro de facture"] {
            padding-top: 14px;
            background: #f8fafc;
        }

        .invoice-grid-cell[data-label="Actions"] {
            display: block;
            padding: 14px;
            background: #f8fafc;
        }

        .invoice-grid-cell[data-label="Actions"]::before {
            display: none;
        }

        .invoice-status-badge {
            justify-self: end;
            min-width: 0;
        }

        .invoice-actions .btn {
            width: 100%;
        }
    }

    @media (max-width: 420px) {
        .invoice-list-card .card-body {
            padding: 10px;
        }

        .invoice-grid-cell {
            grid-template-columns: 1fr;
            gap: 5px;
            text-align: left !important;
        }

        .invoice-grid-cell::before {
            margin-bottom: 2px;
        }

        .invoice-status-badge {
            justify-self: start;
        }
    }
</style>

<div class="invoice-list-page">
    <div class="card invoice-list-card">
        <div class="card-body">

            <div class="mb-4">
                <h4 class="mb-1 fw-bold">Liste des factures</h4>
                <p class="text-muted mb-0">
                    Consultez les factures, les montants encaissés et les soldes restant à payer.
                </p>
            </div>

            <form
                method="GET"
                action="{{ route('sales.invoices') }}"
                class="row g-2 mb-4 invoice-search-row"
            >
                <div class="col-lg-8 col-md-7">
                    <input
                        type="text"
                        name="search"
                        value="{{ $search ?? request('search') }}"
                        class="form-control"
                        placeholder="Rechercher par facture, VIN, client, marque ou modèle..."
                    >
                </div>

                <div class="col-lg-2 col-md-3 d-grid">
                    <button
                        type="submit"
                        class="btn btn-warning fw-semibold"
                    >
                        <i class="ti ti-search me-1"></i>
                        Rechercher
                    </button>
                </div>

                <div class="col-lg-2 col-md-2 d-grid">
                    <a
                        href="{{ route('sales.invoices') }}"
                        class="btn btn-secondary fw-semibold"
                    >
                        <i class="ti ti-refresh me-1"></i>
                        Réinitialiser
                    </a>
                </div>
            </form>

            <div class="invoice-grid-scroll">
                <div class="invoice-grid">

                    <div class="invoice-grid-row invoice-grid-header">
                        <div>Numéro de facture</div>
                        <div>Date</div>
                        <div>Client</div>
                        <div>VIN</div>
                        <div>Véhicule</div>
                        <div style="justify-content:flex-end;">Prix HT</div>
                        <div style="justify-content:flex-end;">Remise</div>
                        <div style="justify-content:flex-end;">Total TTC</div>
                        <div style="justify-content:flex-end;">Montant payé</div>
                        <div style="justify-content:flex-end;">Montant restant</div>
                        <div style="justify-content:center;">Type paiement</div>
                        <div style="justify-content:center;">Statut</div>
                        <div style="justify-content:center;">Actions</div>
                    </div>

                    <div class="invoice-grid-body">

                        @forelse($sales as $sale)

                            @php
                                $saleDate = $sale->sold_date ?? $sale->created_at;

                                $customerName = $sale->customer->name
                                    ?? $sale->customer->full_name
                                    ?? '-';

                                $vehicleBrand = $sale->vehicle->brand ?? '-';
                                $vehicleModel = $sale->vehicle->model ?? '';

                                $totalTtc = (float) ($sale->total_ttc ?? 0);

                                $paidAmount = max(
                                    0,
                                    (float) ($sale->paid_amount ?? 0)
                                );

                                $storedRemainingAmount = $sale->remaining_amount;
                                $invoiceStatus = $sale->invoice_status ?? 'Vendu';

                                if ($invoiceStatus === 'Payé') {
                                    $remainingAmount = 0;
                                } elseif (
                                    $storedRemainingAmount === null
                                    || (
                                        (float) $storedRemainingAmount <= 0
                                        && $paidAmount < $totalTtc
                                    )
                                ) {
                                    $remainingAmount = max(
                                        0,
                                        round($totalTtc - $paidAmount, 2)
                                    );
                                } else {
                                    $remainingAmount = max(
                                        0,
                                        (float) $storedRemainingAmount
                                    );
                                }

                                if ($invoiceStatus === 'Annulé') {
                                    $displayStatus = 'Annulé';
                                    $statusClass = 'status-cancelled';

                                } elseif (
                                    $invoiceStatus === 'Payé'
                                    || $remainingAmount <= 0
                                ) {
                                    $displayStatus = 'Payé';
                                    $statusClass = 'status-paid';

                                } elseif (
                                    $invoiceStatus === 'Partiellement payé'
                                    || $paidAmount > 0
                                ) {
                                    $displayStatus = 'Partiellement payé';
                                    $statusClass = 'status-partial';

                                } else {
                                    $displayStatus = 'Vendu';
                                    $statusClass = 'status-sold';
                                }
                            @endphp

                            <div class="invoice-grid-row">

                                <div class="invoice-grid-cell" data-label="Numéro de facture">
                                    <span class="invoice-number">
                                        {{ $sale->invoice_number ?? '-' }}
                                    </span>
                                </div>

                                <div class="invoice-grid-cell" data-label="Date">
                                    {{ $saleDate
                                        ? \Carbon\Carbon::parse($saleDate)->format('d/m/Y')
                                        : '-'
                                    }}
                                </div>

                                <div class="invoice-grid-cell cell-wrap" data-label="Client">
                                    {{ $customerName }}
                                </div>

                                <div class="invoice-grid-cell" data-label="VIN">
                                    {{ $sale->vehicle->vin ?? '-' }}
                                </div>

                                <div class="invoice-grid-cell cell-wrap" data-label="Véhicule">
                                    {{ $vehicleBrand }} {{ $vehicleModel }}
                                </div>

                                <div class="invoice-grid-cell cell-right" data-label="Prix HT">
                                    {{ number_format(
                                        (float) ($sale->vehicle_ht_amount ?? 0),
                                        2,
                                        ',',
                                        ' '
                                    ) }}
                                    FDJ
                                </div>

                                <div class="invoice-grid-cell cell-right" data-label="Remise">
                                    <div>
                                        {{ number_format(
                                            (float) ($sale->discount_rate ?? 0),
                                            2,
                                            ',',
                                            ' '
                                        ) }}
                                        %

                                        <br>

                                        <small class="text-muted">
                                            {{ number_format(
                                                (float) ($sale->invoice_discount_amount ?? 0),
                                                2,
                                                ',',
                                                ' '
                                            ) }}
                                            FDJ
                                        </small>
                                    </div>
                                </div>

                                <div class="invoice-grid-cell cell-right fw-bold" data-label="Total TTC">
                                    {{ number_format($totalTtc, 2, ',', ' ') }} FDJ
                                </div>

                                <div class="invoice-grid-cell cell-right amount-paid" data-label="Montant payé">
                                    {{ number_format($paidAmount, 2, ',', ' ') }} FDJ
                                </div>

                                <div
                                    class="invoice-grid-cell cell-right {{ $remainingAmount > 0 ? 'amount-remaining' : 'amount-remaining-zero' }}"
                                    data-label="Montant restant"
                                >
                                    {{ number_format($remainingAmount, 2, ',', ' ') }} FDJ
                                </div>

                                <div class="invoice-grid-cell cell-center" data-label="Type paiement">
                                    {{ $sale->payment_type ?? '-' }}
                                </div>

                                <div class="invoice-grid-cell cell-center" data-label="Statut">
                                    <span class="invoice-status-badge {{ $statusClass }}">
                                        {{ $displayStatus }}
                                    </span>
                                </div>

                                <div class="invoice-grid-cell cell-center" data-label="Actions">
                                    <div class="invoice-actions">
                                        <a
                                            href="{{ route('sales.invoice', $sale) }}"
                                            class="btn btn-sm btn-success"
                                            title="Voir la facture"
                                        >
                                            <i class="ti ti-eye me-1"></i>
                                            Voir
                                        </a>
                                    </div>
                                </div>

                            </div>

                        @empty

                            <div class="invoice-empty">
                                <i class="ti ti-file-off fs-2 d-block mb-2"></i>
                                Aucune facture trouvée.
                            </div>

                        @endforelse

                    </div>
                </div>
            </div>

            @if($sales->hasPages())
                <div class="invoice-pagination">
                    {{ $sales->appends(request()->query())->links() }}
                </div>
            @endif

        </div>
    </div>
</div>

@endsection
