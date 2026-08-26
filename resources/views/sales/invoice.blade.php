<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">

    <title>
        Facture {{ $invoiceNumber ?? $sale->invoice_number }}
    </title>

    <style>
        @page {
            margin: 14px;
            size: A4 portrait;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            margin: 0;
            padding: 0;
            background: #f5f6f8;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11px;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 6px;
            vertical-align: top;
            border: 1px solid #000;
        }

        th {
            font-size: 10px;
            text-transform: uppercase;
            background: #d9d9d9;
        }

        .invoice-container {
            width: 100%;
            max-width: 1120px;
            margin: 20px auto;
            padding: 22px;
            background: #fff;
        }

        .no-border td {
            border: none !important;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .fw-bold {
            font-weight: 700;
        }

        .text-primary {
            color: #1f3c88;
        }

        .small-line {
            margin: 0;
            line-height: 1.35;
        }

        .mb-section {
            margin-bottom: 19px;
        }

        .actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 26px;
        }

        .button {
            display: inline-block;
            padding: 10px 18px;
            font-family: inherit;
            font-size: 12px;
            font-weight: 700;
            line-height: 1.2;
            color: #fff;
            text-decoration: none;
            background: #302b8f;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .button-secondary {
            background: #333;
        }

        .button-success {
            background: #28a745;
        }

        .button-danger {
            background: #c63f4b;
        }

        .button-disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }

        .alert {
            padding: 12px 15px;
            margin-bottom: 18px;
            font-weight: 700;
            border-radius: 4px;
        }

        .alert-success {
            color: #155724;
            background: #d4edda;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
        }

        .company-title {
            margin: 0 0 6px;
            font-size: 27px;
            font-weight: 800;
            line-height: 1.1;
        }

        .invoice-main-title {
            margin: 0 0 10px;
            font-size: 35px;
            font-weight: 900;
            color: #1f3c88;
            letter-spacing: 1px;
        }

        .invoice-box {
            min-height: 132px;
            padding: 11px;
            border: 2px solid #000;
        }

        .invoice-title {
            padding: 7px;
            margin: -11px -11px 9px;
            font-weight: 700;
            background: #d9d9d9;
            border-bottom: 2px solid #000;
        }

        .invoice-status {
            display: inline-block;
            min-width: 62px;
            padding: 4px 9px;
            font-weight: 700;
            text-align: center;
            border: 1px solid #000;
            border-radius: 4px;
        }

        .invoice-status-sold {
            color: #0c5460;
            background: #d1ecf1;
        }

        .invoice-status-paid {
            color: #155724;
            background: #d4edda;
        }

        .invoice-status-cancelled {
            color: #721c24;
            background: #f8d7da;
        }

        .invoice-status-partial {
            color: #854d0e;
            background: #fef3c7;
        }

        .summary-payment-paid td {
            padding-top: 9px;
            font-weight: 800;
            color: #166534;
            border-top: 1px dashed #94a3b8 !important;
        }

        .summary-payment-remaining td {
            padding-top: 7px;
            font-weight: 900;
            color: #b91c1c;
        }

        .summary-payment-remaining.is-paid td {
            color: #166534;
        }

        .section-title {
            padding: 8px 10px;
            margin-top: 17px;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            background: #d9d9d9;
            border: 1px solid #000;
            border-bottom: none;
        }

        .section-title-free {
            color: #155724;
            background: #dff3e4;
            border-color: #6fa97c;
        }

        .paid-table {
            table-layout: fixed;
        }

        .vin-cell {
            white-space: normal !important;
            overflow-wrap: anywhere !important;
            word-break: break-all !important;
            font-size: 8.5px;
            line-height: 1.2;
            text-align: left;
        }

        .designation-cell {
            white-space: normal;
            overflow-wrap: break-word;
            word-break: normal;
            line-height: 1.2;
            padding: 5px 6px !important;
        }

        .vehicle-name {
            margin: 0 0 3px;
            font-size: 10.5px;
            line-height: 1.2;
            font-weight: 800;
            color: #111827;
        }

        .vehicle-subline {
            margin-bottom: 3px;
            font-size: 8.5px;
            line-height: 1.2;
            color: #374151;
        }

        .vehicle-specs-compact {
            margin: 0;
            font-size: 8px;
            line-height: 1.28;
            color: #111827;
        }

        .vehicle-specs-compact .spec-line {
            margin: 0 0 1px;
        }

        .vehicle-specs-compact .spec-label {
            font-weight: 700;
            color: #4b5563;
        }

        .vehicle-specs-compact .spec-separator {
            padding: 0 3px;
            color: #94a3b8;
        }

        .designation-cell {
            white-space: normal;
            overflow-wrap: break-word;
            word-break: normal;
            line-height: 1.25;
            padding: 6px 7px !important;
        }

        .vehicle-name {
            margin: 0 0 4px;
            font-size: 11px;
            line-height: 1.25;
            font-weight: 800;
            color: #111827;
        }

        .vehicle-subline {
            margin-bottom: 5px;
            font-size: 9px;
            line-height: 1.25;
            color: #374151;
        }

        .vehicle-specs {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .vehicle-specs td {
            width: 50%;
            padding: 2px 4px 2px 0 !important;
            border: none !important;
            font-size: 8.5px;
            line-height: 1.25;
            vertical-align: top;
            color: #111827;
        }

        .spec-label {
            font-weight: 700;
            color: #4b5563;
        }

        .spec-value {
            font-weight: 600;
        }

        .paid-table th:nth-child(1),
        .paid-table td:nth-child(1) {
            width: 14%;
        }

        .paid-table th:nth-child(2),
        .paid-table td:nth-child(2) {
            width: 34%;
        }

        .paid-table th:nth-child(3),
        .paid-table td:nth-child(3) {
            width: 6%;
        }

        .paid-table th:nth-child(4),
        .paid-table td:nth-child(4) {
            width: 8%;
        }

        .paid-table th:nth-child(5),
        .paid-table td:nth-child(5) {
            width: 15%;
        }

        .paid-table th:nth-child(6),
        .paid-table td:nth-child(6) {
            width: 10%;
        }

        .paid-table th:nth-child(7),
        .paid-table td:nth-child(7) {
            width: 13%;
        }

        .discount-cell {
            text-align: right;
            line-height: 1.35;
        }

        .free-table {
            table-layout: fixed;
        }

        .free-table th:nth-child(1),
        .free-table td:nth-child(1) {
            width: 8%;
        }

        .free-table th:nth-child(2),
        .free-table td:nth-child(2) {
            width: 56%;
        }

        .free-table th:nth-child(3),
        .free-table td:nth-child(3) {
            width: 18%;
        }

        .free-table th:nth-child(4),
        .free-table td:nth-child(4) {
            width: 18%;
        }

        .summary-wrapper {
            width: 50%;
            margin-top: 16px;
            margin-left: auto;
        }

        .summary-table {
            table-layout: fixed;
        }

        .summary-table td {
            padding: 6px 4px;
            border: none !important;
        }

        .summary-table td:first-child {
            width: 52%;
            font-weight: 700;
        }

        .summary-table td:last-child {
            width: 48%;
            text-align: right;
            white-space: nowrap;
            font-variant-numeric: tabular-nums;
        }

        .summary-discount td {
            color: #9a3412;
        }

        .summary-net td {
            padding-top: 7px;
            font-weight: 800;
        }

        .summary-total td {
            padding-top: 10px;
            font-size: 21px;
            font-weight: 900;
            border-top: 3px solid #000 !important;
        }

        .summary-total td:last-child {
            color: #1f3c88;
        }

        .delivery-note {
            padding: 8px 10px;
            font-weight: 700;
            border: 1px solid #000;
            border-top: none;
        }

        .amount-in-words {
            padding: 10px;
            margin-top: 17px;
            font-weight: 700;
            border: 2px solid #000;
        }

        .custom-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(15, 23, 42, 0.68);
        }

        .custom-modal-overlay.is-visible {
            display: flex;
        }

        .custom-modal {
            width: 100%;
            max-width: 500px;
            padding: 30px;
            text-align: center;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.25);
        }

        .custom-modal-title {
            margin: 0 0 12px;
            font-size: 24px;
        }

        .custom-modal-message {
            margin: 0 0 18px;
            line-height: 1.6;
            color: #475569;
        }

        .custom-modal-actions {
            display: flex;
            justify-content: center;
            gap: 12px;
        }

        .modal-button {
            padding: 11px 17px;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .modal-secondary {
            background: #e2e8f0;
        }

        .modal-danger {
            color: #fff;
            background: #dc2626;
        }

        .modal-success {
            color: #fff;
            background: #16a34a;
        }


        .payment-modal-summary {
            padding: 14px;
            margin: 0 0 18px;
            text-align: left;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
        }

        .payment-modal-row {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 8px;
        }

        .payment-modal-row:last-child {
            margin-bottom: 0;
        }

        .payment-form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .payment-form-label {
            display: block;
            margin-bottom: 6px;
            font-weight: 700;
        }

        .payment-form-control {
            width: 100%;
            padding: 11px 12px;
            font-family: inherit;
            font-size: 14px;
            color: #111827;
            background: #fff;
            border: 1px solid #94a3b8;
            border-radius: 8px;
        }

        .payment-form-control:focus {
            border-color: #302b8f;
            outline: none;
            box-shadow: 0 0 0 3px rgba(48, 43, 143, 0.12);
        }

        .payment-preview {
            padding: 12px;
            margin-bottom: 18px;
            text-align: left;
            background: #eff6ff;
            border: 1px solid #93c5fd;
            border-radius: 8px;
        }

        .payment-error {
            margin-top: 6px;
            font-size: 12px;
            font-weight: 700;
            color: #b91c1c;
        }

/*
        |--------------------------------------------------------------------------
        | MODE PDF DOMPDF
        |--------------------------------------------------------------------------
        | Ces règles ne s'appliquent que lorsque $isPdf = true.
        | Elles ne modifient pas l'affichage normal de la facture à l'écran.
        */

        body.pdf-mode {
            font-size: 8.2px;
            line-height: 1.08;
            background: #fff;
        }

        body.pdf-mode .invoice-container {
            width: 100%;
            max-width: none;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        body.pdf-mode .actions,
        body.pdf-mode .alert,
        body.pdf-mode .custom-modal-overlay {
            display: none !important;
        }

        body.pdf-mode .company-title {
            margin: 0 0 2px;
            font-size: 18px;
            line-height: 1;
        }

        body.pdf-mode .invoice-main-title {
            margin: 0 0 3px;
            font-size: 23px;
            line-height: 1;
            letter-spacing: .5px;
        }

        body.pdf-mode .small-line {
            line-height: 1.08;
        }

        body.pdf-mode .mb-section {
            margin-bottom: 6px;
        }

        body.pdf-mode .invoice-box {
            min-height: 76px;
            padding: 5px;
            border-width: 1px;
        }

        body.pdf-mode .invoice-title {
            padding: 4px 5px;
            margin: -5px -5px 4px;
            font-size: 8px;
            border-bottom-width: 1px;
        }

        body.pdf-mode .invoice-status {
            min-width: 48px;
            padding: 2px 5px;
            font-size: 7px;
            color: #000;
            background: #fff;
            border: 1px solid #000;
        }

        body.pdf-mode .section-title {
            padding: 4px 6px;
            margin-top: 5px;
            font-size: 8.5px;
        }

        body.pdf-mode table th,
        body.pdf-mode table td {
            padding: 2px 3px;
        }

        body.pdf-mode th {
            font-size: 7px;
        }

        body.pdf-mode .paid-table,
        body.pdf-mode .free-table,
        body.pdf-mode .summary-table {
            table-layout: fixed;
        }

        body.pdf-mode .vin-cell {
            font-size: 6.5px;
            line-height: 1.05;
            word-break: break-all;
        }

        body.pdf-mode .designation-cell {
            padding: 3px !important;
            line-height: 1.05;
        }

        body.pdf-mode .vehicle-name {
            margin-bottom: 1px;
            font-size: 8px;
            line-height: 1.05;
        }

        body.pdf-mode .vehicle-subline {
            margin-bottom: 1px;
            font-size: 6.5px;
            line-height: 1.05;
        }

        body.pdf-mode .vehicle-specs-compact {
            font-size: 6.2px;
            line-height: 1.08;
        }

        body.pdf-mode .vehicle-specs-compact .spec-line {
            margin-bottom: 0;
        }

        body.pdf-mode .discount-cell {
            font-size: 7px;
            line-height: 1.08;
        }

        body.pdf-mode .summary-wrapper {
            width: 50%;
            margin-top: 3px;
            margin-left: auto;
        }

        body.pdf-mode .summary-table td {
            padding: 1px 2px;
            line-height: 1.05;
        }

        body.pdf-mode .summary-net td,
        body.pdf-mode .summary-payment-paid td,
        body.pdf-mode .summary-payment-remaining td {
            padding-top: 2px;
        }

        body.pdf-mode .summary-total td {
            padding-top: 3px;
            font-size: 12px;
            line-height: 1.05;
            border-top: 2px solid #000 !important;
        }

        body.pdf-mode .free-table th,
        body.pdf-mode .free-table td {
            padding: 1px 2px;
            font-size: 7px;
            line-height: 1.05;
        }

        body.pdf-mode .delivery-note {
            padding: 2px 4px;
            font-size: 7px;
        }

        body.pdf-mode .amount-in-words {
            padding: 3px 5px;
            margin-top: 4px;
            font-size: 7px;
            line-height: 1.05;
            border-width: 1px;
        }

        body.pdf-mode table,
        body.pdf-mode tr,
        body.pdf-mode td,
        body.pdf-mode th,
        body.pdf-mode .section-title,
        body.pdf-mode .delivery-note,
        body.pdf-mode .amount-in-words,
        body.pdf-mode .summary-wrapper {
            page-break-inside: avoid;
            break-inside: avoid;
        }

                body.pdf-mode .invoice-logo {
            width: 105px !important;
            height: auto !important;
        }

@media print {

            @page {
                size: A4 portrait;
                margin: 5mm;
            }

            html,
            body {
                width: 100%;
                margin: 0 !important;
                padding: 0 !important;
                background: #fff !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body {
                font-size: 8.8px !important;
                line-height: 1.16 !important;
            }

            .invoice-container {
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
                background: #fff !important;
            }

            .actions,
            .alert,
            .custom-modal-overlay {
                display: none !important;
            }

            .company-title {
                margin-bottom: 2px !important;
                font-size: 19px !important;
                line-height: 1 !important;
            }

            .invoice-main-title {
                margin-bottom: 3px !important;
                font-size: 24px !important;
                line-height: 1 !important;
            }

            .small-line {
                line-height: 1.1 !important;
            }

            .mb-section {
                margin-bottom: 7px !important;
            }

            .invoice-box {
                min-height: 82px !important;
                padding: 5px !important;
                border-width: 1px !important;
            }

            .invoice-title {
                padding: 4px 5px !important;
                margin: -6px -6px 5px !important;
                border-bottom-width: 1px !important;
            }

            .invoice-status {
                min-width: 50px !important;
                padding: 2px 5px !important;
                color: #000 !important;
                background: #fff !important;
                border: 1px solid #000 !important;
            }

            .section-title {
                padding: 4px 6px !important;
                margin-top: 6px !important;
                font-size: 9px !important;
            }

            table th,
            table td {
                padding: 3px !important;
            }

            th {
                font-size: 8px !important;
            }

            .vin-cell {
                font-size: 7.5px !important;
                line-height: 1.1 !important;
                word-break: break-all !important;
            }

            .designation-cell {
                padding: 4px !important;
            }

            .vehicle-name {
                margin-bottom: 2px !important;
                font-size: 9px !important;
                line-height: 1.1 !important;
            }

            .vehicle-subline {
                margin-bottom: 2px !important;
                font-size: 7.5px !important;
                line-height: 1.1 !important;
            }

            .vehicle-specs-compact {
                font-size: 7px !important;
                line-height: 1.2 !important;
            }

            .vehicle-specs-compact .spec-line {
                margin-bottom: 0 !important;
            }

            .summary-wrapper {
                width: 50% !important;
                margin-top: 4px !important;
            }

            .summary-table td {
                padding: 2px 2px !important;
                line-height: 1.1 !important;
            }

            .summary-total td {
                padding-top: 4px !important;
                font-size: 14px !important;
                border-top: 2px solid #000 !important;
            }

            .summary-payment-paid td,
            .summary-payment-remaining td,
            .summary-net td {
                padding-top: 3px !important;
            }

            .free-table th,
            .free-table td {
                padding: 2px 3px !important;
                line-height: 1.1 !important;
            }

            .delivery-note {
                padding: 3px 5px !important;
            }

            .amount-in-words {
                padding: 4px 6px !important;
                margin-top: 6px !important;
                border-width: 1px !important;
                line-height: 1.15 !important;
            }

            table,
            tr,
            td,
            th,
            .section-title,
            .delivery-note,
            .amount-in-words,
            .summary-wrapper {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
        }
    </style>
</head>

<body class="{{ isset($isPdf) && $isPdf ? 'pdf-mode' : '' }}">

@php
    $invoiceNumber = $invoiceNumber ?? $sale->invoice_number;
    $saleDate = $sale->sold_date ?? $sale->created_at;

    $vehicle = $sale->vehicle;
    $customer = $sale->customer;
    $seller = $sale->seller;


    /**
*    |--------------------------------------------------------------------------
*    | CALCULS
*    |--------------------------------------------------------------------------
*    |
*    | Facture avec taxes :
*    | véhicule - remise + timbre + TVA
*    |
*    | Facture sans taxes :
*    | véhicule - remise
*    |
 */

    $vehicleHt = $sale->vehicle_ht_amount;
    $stampAmount = $sale->stamp_amount;
    $subtotalHt = $sale->subtotal_ht;
    // Remise commerciale : uniquement en montant (aucun pourcentage affiché)
    $discountAmount = $sale->invoice_discount_amount;
    $netHt = $sale->net_ht;
    $tvaRate = \App\Models\Sale::VAT_RATE;
    $tva = $sale->vat_amount;
    $total = (float) $sale->total_ttc;
    /**
*    |--------------------------------------------------------------------------
*    | PAIEMENT
*    |--------------------------------------------------------------------------
*    |
*    | paid_amount : montant total déjà versé par le client.
*    | remaining_amount : montant qu'il reste encore à payer.
*    |
*    | Compatibilité avec les anciennes ventes :
*    | si une ancienne facture non payée possède encore 0 dans
*    | remaining_amount, le reste est recalculé à partir du total.
*    |
 */

    $paidAmount = max(
        0,
        (float) ($sale->paid_amount ?? 0)
    );

    // Remises accordées au moment des paiements.
    // Ce montant réduit le solde à payer sans être comptabilisé comme paiement reçu.
    $paymentDiscountAmount = max(
        0,
        (float) ($sale->payment_discount_amount ?? 0)
    );

    $storedRemainingAmount = $sale->remaining_amount;

    if ($storedRemainingAmount === null) {
        $remainingAmount = max(
            0,
            round($total - $paidAmount - $paymentDiscountAmount, 2)
        );
    } else {
        $remainingAmount = max(
            0,
            (float) $storedRemainingAmount
        );
    }

    $currentInvoiceStatus = $sale->invoice_status ?? 'Vendu';

    if (
        $currentInvoiceStatus !== 'Payé'
        && $currentInvoiceStatus !== 'Annulé'
        && $paidAmount <= 0
        && $paymentDiscountAmount <= 0
        && $remainingAmount <= 0
        && $total > 0
    ) {
        $remainingAmount = $total;
    }

    if ($paidAmount > $total) {
        $paidAmount = $total;
    }

    if ($remainingAmount > $total) {
        $remainingAmount = max(
            0,
            round($total - $paidAmount - $paymentDiscountAmount, 2)
        );
    }


    /**
*    |--------------------------------------------------------------------------
*    | MONTANT RESTANT EN LETTRES
*    |--------------------------------------------------------------------------
 */

$roundedRemainingAmount = (int) round($remainingAmount);

if (class_exists(\NumberFormatter::class)) {

    $formatter = new \NumberFormatter(
        'fr_FR',
        \NumberFormatter::SPELLOUT
    );

    $remainingAmountInWords = $formatter->format(
        $roundedRemainingAmount
    );

} else {

    $remainingAmountInWords = (string) $roundedRemainingAmount;

}

$remainingAmountInWords = str_replace(
    ['-', '  '],
    [' ', ' '],
    $remainingAmountInWords
);

$remainingAmountInWords = mb_strtoupper(
    trim($remainingAmountInWords),
    'UTF-8'
);

$currencyLabel = $roundedRemainingAmount > 1
    ? 'FRANCS DJIBOUTI'
    : 'FRANC DJIBOUTI';

    $invoiceStatus = $currentInvoiceStatus;
    $paymentType = $sale->payment_type ?? 'Non précisé';

    $hasTax = $sale->invoice_type !== 'without_tax';

    $invoiceTypeLabel = $hasTax
        ? 'Facture avec taxes'
        : 'Facture sans taxes';

    $freeServices = $hasTax
        ? [
            'Frais d’assurance automobile — 1 an',
            'Plaque d’immatriculation',
            'Carte grise',
            'Vignette',
            'Antirouille',
            'Tapis au sol',
        ]
        : [
            'Frais d’assurance automobile — 1 an',
        ];
@endphp

<div class="invoice-container">

    @if(!isset($isPdf) || !$isPdf)

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

        <div class="actions">

            <a
                href="{{ route('vehicles.sold') }}"
                class="button button-secondary"
            >
                Retour aux véhicules vendus
            </a>

            <a
                href="{{ route('sales.invoice.download', $sale) }}"
                class="button"
            >
                Télécharger PDF
            </a>

            <button
                type="button"
                class="button"
                onclick="window.print()"
            >
                🖨 Imprimer
            </button>

            @if(
                in_array(
                    $invoiceStatus,
                    ['Vendu', 'Partiellement payé'],
                    true
                )
                && $remainingAmount > 0
            )
                <button
                    type="button"
                    class="button button-success"
                    onclick="openModal('payInvoiceModal')"
                >
                    Enregistrer un paiement
                </button>
            @elseif($invoiceStatus === 'Payé' || $remainingAmount <= 0)
                <span class="button button-disabled">
                    Facture payée
                </span>
            @endif

            @if(auth()->check() && auth()->user()->role === 'admin')
                @if($invoiceStatus !== 'Annulé')
                    <button
                        type="button"
                        class="button button-danger"
                        onclick="openModal('cancelInvoiceModal')"
                    >
                        Annuler la facture
                    </button>
                @else
                    <span class="button button-disabled">
                        Facture annulée
                    </span>
                @endif
            @endif

        </div>
    @endif

    {{-- EN-TÊTE --}}
    <table class="no-border mb-section">
        <tr>
            <td style="width:58%; padding:0; vertical-align:middle;">

                <table class="no-border">
                    <tr>
                        <td style="width:170px; padding:0 20px 0 0; text-align:center;">

                            @php
                                $logoPath = public_path('img/logo-stcd.jpg');
                                $logo = null;

                                if (file_exists($logoPath)) {
                                    $extension = pathinfo($logoPath, PATHINFO_EXTENSION);

                                    $logo = 'data:image/' . $extension . ';base64,' .
                                        base64_encode(file_get_contents($logoPath));
                                }
                            @endphp

                            @if($logo)
                                <img
                                    src="{{ $logo }}"
                                    alt="Logo STCD"
                                    class="invoice-logo"
                                    style="display:block; width:150px; height:auto;"
                                >
                            @endif
                        </td>

                        <td style="padding:0; vertical-align:middle;">
                            <h1 class="company-title">STCD MOTORS</h1>
                            <div class="small-line">1667 Guelleh-Batal, Djibouti-ville</div>
                            <div class="small-line">Téléphone : +253 77 22 93 33</div>
                            <div class="small-line">Fax : +253 21 35 30 09</div>
                            <div class="small-line">Email : spareparts@stcd.dj</div>
                        </td>
                    </tr>
                </table>
            </td>

            <td style="width:42%; padding:0; text-align:right; vertical-align:middle;">
                <h1 class="invoice-main-title">FACTURE</h1>

                <div class="small-line">
                    <strong>N° Facture :</strong>
                    {{ $invoiceNumber }}
                </div>

                <div class="small-line">
                    <strong>Date :</strong>
                    {{ $saleDate
                        ? \Carbon\Carbon::parse($saleDate)->format('d/m/Y')
                        : '-'
                    }}
                </div>
            </td>
        </tr>
    </table>

    {{-- CLIENT ET DÉTAILS --}}
    <table class="no-border mb-section">
        <tr>
            <td style="width:48%; padding:0;">

                <div class="invoice-box">
                    <div class="invoice-title">Facturé à</div>

                    <div style="margin-bottom:9px; font-size:18px; font-weight:700;">
                        {{ $customer->name
                            ?? $customer->full_name
                            ?? 'Client non défini'
                        }}
                    </div>

                    <div class="small-line">
                        <strong>Téléphone :</strong>
                        {{ $customer->phone ?? '-' }}
                    </div>

                    <div class="small-line">
                        <strong>Email :</strong>
                        {{ $customer->email ?? '-' }}
                    </div>

                    <div class="small-line">
                        <strong>Adresse :</strong>
                        {{ $customer->address ?? '-' }}
                    </div>
                </div>
            </td>

            <td style="width:4%; padding:0;"></td>

            <td style="width:48%; padding:0;">
                <div class="invoice-box">
                    <div class="invoice-title">Détails de la facture</div>

                    <table class="no-border">
                        <tr>
                            <td style="width:40%; padding:2px 0;">
                                <strong>Facture</strong>
                            </td>
                            <td style="padding:2px 0;">
                                {{ $invoiceNumber }}
                            </td>
                        </tr>

                        <tr>
                            <td style="padding:2px 0;">
                                <strong>Date</strong>
                            </td>
                            <td style="padding:2px 0;">
                                {{ $saleDate
                                    ? \Carbon\Carbon::parse($saleDate)->format('d/m/Y')
                                    : '-'
                                }}
                            </td>
                        </tr>

                        <tr>
                            <td style="padding:2px 0;">
                                <strong>Statut</strong>
                            </td>
                            <td style="padding:2px 0;">
                                @if($invoiceStatus === 'Payé')
                                    <span class="invoice-status invoice-status-paid">
                                        Payé
                                    </span>
                                @elseif($invoiceStatus === 'Partiellement payé')
                                    <span class="invoice-status invoice-status-partial">
                                        Partiellement payé
                                    </span>
                                @elseif($invoiceStatus === 'Annulé')
                                    <span class="invoice-status invoice-status-cancelled">
                                        Annulé
                                    </span>
                                @else
                                    <span class="invoice-status invoice-status-sold">
                                        Vendu
                                    </span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td style="padding:2px 0;">
                                <strong>Type</strong>
                            </td>
                            <td style="padding:2px 0;">
                                {{ $invoiceTypeLabel }}
                            </td>
                        </tr>

                        <tr>
                            <td style="padding:2px 0;">
                                <strong>Paiement</strong>
                            </td>
                            <td style="padding:2px 0;">
                                {{ ucfirst($paymentType) }}
                            </td>
                        </tr>

                        <tr>
                            <td style="padding:2px 0;">
                                <strong>Vendu par</strong>
                            </td>
                            <td style="padding:2px 0;">
                                {{ $seller->name ?? '-' }}
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    {{-- PARTIE PAYANTE --}}
    <div class="section-title">
        Partie 1 — Éléments payants
    </div>

    <table class="paid-table">
        <thead>
            <tr>
                <th>Code / VIN</th>
                <th>Désignation</th>
                <th class="text-center">Qté</th>
                <th class="text-center">Année</th>
                <th class="text-end">Prix unitaire HT</th>
                <th class="text-end">Remise</th>
                <th class="text-end">Montant</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="vin-cell">
                    {{ $vehicle->vin ?? '-' }}
                </td>

                <td class="designation-cell">

                    <div class="vehicle-name">
                        {{ trim(($vehicle->brand ?? '') . ' ' . ($vehicle->model ?? '')) ?: '-' }}
                    </div>

                    <div class="vehicle-subline">
                        @if(!empty($vehicle->configuration))
                            {{ $vehicle->configuration }}
                        @endif

                        @if(!empty($vehicle->configuration) && !empty($vehicle->model_year))
                            &nbsp;|&nbsp;
                        @endif

                        @if(!empty($vehicle->model_year))
                            MY {{ $vehicle->model_year }}
                        @endif
                    </div>

                    <div class="vehicle-specs-compact">

                        <div class="spec-line">
                            <span class="spec-label">Moteur :</span>
                            {{ $vehicle->engine_number ?: ($vehicle->engine ?: '-') }}
                            <span class="spec-separator">•</span>
                            <span class="spec-label">Cylindrée :</span>
                            {{ $vehicle->engine_capacity ?: '-' }}
                        </div>

                        <div class="spec-line">
                            <span class="spec-label">Énergie :</span>
                            {{ $vehicle->fuel_type ?: '-' }}
                            <span class="spec-separator">•</span>
                            <span class="spec-label">Transmission :</span>
                            {{ $vehicle->transmission ?: '-' }}
                        </div>

                        <div class="spec-line">
                            <span class="spec-label">Portes :</span>
                            {{ $vehicle->doors ?: '-' }}
                            <span class="spec-separator">•</span>
                            <span class="spec-label">Places :</span>
                            {{ $vehicle->seats ?: '-' }}
                            <span class="spec-separator">•</span>
                            <span class="spec-label">Cylindres :</span>
                            {{ $vehicle->cylinders ?: '-' }}
                        </div>

                        <div class="spec-line">
                            <span class="spec-label">Pneus :</span>
                            {{ $vehicle->tire_size ?: '-' }}
                        </div>

                    </div>

                </td>

                <td class="text-center">1</td>

                <td class="text-center">
                    {{ $vehicle->model_year ?? '-' }}
                </td>

                <td class="text-end">
                    {{ number_format($vehicleHt, 2, ',', ' ') }} FDJ
                </td>

                <td class="discount-cell">
                    <strong>
                        {{ number_format(
                            $discountAmount + $paymentDiscountAmount,
                            2,
                            ',',
                            ' '
                        ) }} FDJ
                    </strong>
                </td>

                <td class="text-end fw-bold">
                    {{ number_format($vehicleHt, 2, ',', ' ') }} FDJ
                </td>
            </tr>

            @if($hasTax)
                <tr>
                    <td class="text-center">TIMBRE</td>

                    <td>
                        <strong>Timbre</strong>
                    </td>

                    <td class="text-center">1</td>

                    <td class="text-center">-</td>

                    <td class="text-end">
                        {{ number_format($stampAmount, 2, ',', ' ') }} FDJ
                    </td>

                    <td class="discount-cell">
                        <strong>0,00 FDJ</strong>
                    </td>

                    <td class="text-end fw-bold">
                        {{ number_format($stampAmount, 2, ',', ' ') }} FDJ
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="summary-wrapper">
        <table class="summary-table no-border">

            <tr>
                <td>
                    {{ $hasTax ? 'Total HT :' : 'Prix du véhicule :' }}
                </td>

                <td>
                    {{ number_format($subtotalHt, 2, ',', ' ') }} FDJ
                </td>
            </tr>

            @if($discountAmount > 0)
                <tr class="summary-discount">
                    <td>
                        Remise commerciale :
                    </td>

                    <td>
                        - {{ number_format($discountAmount, 2, ',', ' ') }} FDJ
                    </td>
                </tr>
            @endif

            <tr class="summary-net">
                <td>
                    {{ $hasTax ? 'Total HT net :' : 'Montant après remise :' }}
                </td>

                <td>
                    {{ number_format($netHt, 2, ',', ' ') }} FDJ
                </td>
            </tr>

            @if($hasTax)
                <tr>
                    <td>
                        TVA ({{ number_format($tvaRate, 0) }} %) :
                    </td>

                    <td>
                        {{ number_format($tva, 2, ',', ' ') }} FDJ
                    </td>
                </tr>
            @endif

            <tr class="summary-total">
                <td>
                    {{ $hasTax ? 'TOTAL TTC :' : 'TOTAL À PAYER :' }}
                </td>

                <td class="text-end text-primary">
                    {{ number_format($total, 2, ',', ' ') }} FDJ
                </td>
            </tr>

            @if($paymentDiscountAmount > 0)
                <tr class="summary-discount">
                    <td>REMISE DE RÈGLEMENT :</td>
                    <td>
                        - {{ number_format($paymentDiscountAmount, 2, ',', ' ') }} FDJ
                    </td>
                </tr>
            @endif

            <tr class="summary-payment-paid">
                <td>
                    MONTANT PAYÉ :
                </td>

                <td class="text-end">
                    {{ number_format($paidAmount, 2, ',', ' ') }} FDJ
                </td>
            </tr>

            <tr class="summary-payment-remaining {{ $remainingAmount <= 0 ? 'is-paid' : '' }}">
                <td>
                    MONTANT RESTANT :
                </td>

                <td class="text-end">
                    {{ number_format($remainingAmount, 2, ',', ' ') }} FDJ
                </td>
            </tr>
        </table>
    </div>

    {{-- PARTIE NON PAYANTE --}}
    <div class="section-title section-title-free">
        Partie 2 — Prestations offertes au client
    </div>

    <table class="free-table">
        <thead>
            <tr>
                <th class="text-center">Qté</th>
                <th>Désignation</th>
                <th class="text-end">Prix unitaire</th>
                <th class="text-end">Montant</th>
            </tr>
        </thead>

        <tbody>
            @foreach($freeServices as $service)
                <tr>
                    <td class="text-center">1</td>

                    <td>{{ $service }}</td>

                    <td class="text-end">
                        0,00 FDJ
                    </td>

                    <td class="text-end fw-bold">
                        0,00 FDJ
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if($hasTax)
        <div class="delivery-note">
            Délai de livraison : 5 jours ouvrables
        </div>
    @endif

    <div class="amount-in-words">
            <strong>Montant restant en lettres :</strong>

            {{ $remainingAmountInWords }}
            {{ $currencyLabel }}
        </div>
    </div>

@if(!isset($isPdf) || !$isPdf)

    @if(
        in_array(
            $invoiceStatus,
            ['Vendu', 'Partiellement payé'],
            true
        )
        && $remainingAmount > 0
    )
        <div
            id="payInvoiceModal"
            class="custom-modal-overlay"
            aria-hidden="true"
        >
            <div class="custom-modal">
                <h2 class="custom-modal-title">
                    Enregistrer un paiement
                </h2>

                <p class="custom-modal-message">
                    Facture <strong>{{ $invoiceNumber }}</strong>
                </p>

                <div class="payment-modal-summary">
                    <div class="payment-modal-row">
                        <span>Total de la facture :</span>
                        <strong>
                            {{ number_format($total, 2, ',', ' ') }} FDJ
                        </strong>
                    </div>

                    <div class="payment-modal-row">
                        <span>Déjà payé :</span>
                        <strong style="color:#166534;">
                            {{ number_format($paidAmount, 2, ',', ' ') }} FDJ
                        </strong>
                    </div>

                    @if($paymentDiscountAmount > 0)
                        <div class="payment-modal-row">
                            <span>Remises déjà accordées :</span>
                            <strong style="color:#9a3412;">
                                {{ number_format($paymentDiscountAmount, 2, ',', ' ') }} FDJ
                            </strong>
                        </div>
                    @endif

                    <div class="payment-modal-row">
                        <span>Montant restant :</span>
                        <strong style="color:#b91c1c;">
                            {{ number_format($remainingAmount, 2, ',', ' ') }} FDJ
                        </strong>
                    </div>
                </div>

                <form
                    action="{{ route('sales.invoice.pay', $sale) }}"
                    method="POST"
                    id="invoicePaymentForm"
                >
                    @csrf

                    <div class="payment-form-group">
                        <label
                            for="paymentDiscount"
                            class="payment-form-label"
                        >
                            Remise accordée
                        </label>

                        <input
                            type="number"
                            name="discount_amount"
                            id="paymentDiscount"
                            class="payment-form-control"
                            value="{{ old('discount_amount', 0) }}"
                            min="0"
                            max="{{ $remainingAmount }}"
                            step="0.01"
                            placeholder="Exemple : 100000"
                        >

                        <small style="
                            display:block;
                            margin-top:6px;
                            color:#64748b;
                        ">
                            Facultatif — montant de la remise en FDJ.
                        </small>

                        @error('discount_amount')
                            <div class="payment-error">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="payment-form-group">
                        <label
                            for="paymentAmount"
                            class="payment-form-label"
                        >
                            Montant versé par le client
                        </label>

                        <input
                            type="number"
                            name="amount"
                            id="paymentAmount"
                            class="payment-form-control"
                            value="{{ old('amount') }}"
                            min="0"
                            max="{{ $remainingAmount }}"
                            step="0.01"
                            placeholder="Exemple : 2000000"
                            autofocus
                        >

                        @error('amount')
                            <div class="payment-error">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                  <div class="payment-preview">

                        <div class="payment-modal-row">
                            <span>Remise accordée :</span>

                            <strong id="discountPreview">
                                0,00 FDJ
                            </strong>
                        </div>

                        <div class="payment-modal-row">
                            <span>Paiement du client :</span>

                            <strong id="paymentPreview">
                                0,00 FDJ
                            </strong>
                        </div>

                        <div
                            class="payment-modal-row"
                            style="
                                padding-top:10px;
                                margin-top:10px;
                                border-top:1px solid #cbd5e1;
                            "
                        >
                            <span>
                                <strong>Reste après opération :</strong>
                            </span>

                            <strong
                                id="remainingAfterPayment"
                                style="color:#b45309;"
                            >
                                {{ number_format(
                                    $remainingAmount,
                                    2,
                                    ',',
                                    ' '
                                ) }} FDJ
                            </strong>
                        </div>

                        <div
                            id="paymentAmountError"
                            class="payment-error"
                            style="display:none;"
                        ></div>

                    </div>

                    <div class="custom-modal-actions">
                        <button
                            type="button"
                            class="modal-button modal-secondary"
                            onclick="closeModal('payInvoiceModal')"
                        >
                            Annuler
                        </button>

                        <button
                            type="submit"
                            class="modal-button modal-success"
                            id="submitPaymentButton"
                        >
                            Enregistrer le paiement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if(
        auth()->check()
        && auth()->user()->role === 'admin'
        && $invoiceStatus !== 'Annulé'
    )
        <div
            id="cancelInvoiceModal"
            class="custom-modal-overlay"
            aria-hidden="true"
        >
            <div class="custom-modal">
                <h2 class="custom-modal-title">
                    Annuler cette facture ?
                </h2>

                <p class="custom-modal-message">
                    Cette action annulera la facture
                    <strong>{{ $invoiceNumber }}</strong>
                    et remettra le véhicule dans le stock.
                </p>

                <div class="custom-modal-actions">
                    <button
                        type="button"
                        class="modal-button modal-secondary"
                        onclick="closeModal('cancelInvoiceModal')"
                    >
                        Non, revenir
                    </button>

                    <form
                        action="{{ route('sales.invoice.cancel', $sale) }}"
                        method="POST"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="modal-button modal-danger"
                        >
                            Oui, annuler
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <script>
        function openModal(id) {
            const modal = document.getElementById(id);

            if (!modal) {
                return;
            }

            modal.classList.add('is-visible');
            modal.setAttribute('aria-hidden', 'false');
        }

        function closeModal(id) {
            const modal = document.getElementById(id);

            if (!modal) {
                return;
            }

            modal.classList.remove('is-visible');
            modal.setAttribute('aria-hidden', 'true');
        }

        document.addEventListener('click', function (event) {
            if (
                event.target.classList.contains('custom-modal-overlay')
            ) {
                closeModal(event.target.id);
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key !== 'Escape') {
                return;
            }

            document
                .querySelectorAll('.custom-modal-overlay.is-visible')
                .forEach(function (modal) {
                    closeModal(modal.id);
                });
        });


        document.addEventListener('DOMContentLoaded', function () {
            const paymentAmount =
                document.getElementById('paymentAmount');

            const paymentDiscount =
                document.getElementById('paymentDiscount');

            const remainingAfterPayment =
                document.getElementById('remainingAfterPayment');

            const discountPreview =
                document.getElementById('discountPreview');

            const paymentPreview =
                document.getElementById('paymentPreview');

            const paymentAmountError =
                document.getElementById('paymentAmountError');

            const invoicePaymentForm =
                document.getElementById('invoicePaymentForm');

            const submitPaymentButton =
                document.getElementById('submitPaymentButton');

            const remainingBeforePayment =
                Number(@json((float) $remainingAmount));

            function formatFdj(value) {
                return new Intl.NumberFormat('fr-FR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(value) + ' FDJ';
            }

            function parseAmount(value) {
                const number = Number.parseFloat(value || '0');

                return Number.isFinite(number)
                    ? number
                    : 0;
            }

            function showPaymentError(message) {
                if (!paymentAmountError) {
                    return;
                }

                paymentAmountError.textContent = message;
                paymentAmountError.style.display = 'block';
            }

            function clearPaymentError() {
                if (!paymentAmountError) {
                    return;
                }

                paymentAmountError.textContent = '';
                paymentAmountError.style.display = 'none';
            }

            function updatePaymentPreview() {
                if (!remainingAfterPayment) {
                    return true;
                }

                const amount = parseAmount(
                    paymentAmount?.value
                );

                const discount = parseAmount(
                    paymentDiscount?.value
                );

                clearPaymentError();

                if (amount < 0) {
                    showPaymentError(
                        'Le montant du paiement ne peut pas être négatif.'
                    );

                    return false;
                }

                if (discount < 0) {
                    showPaymentError(
                        'Le montant de la remise ne peut pas être négatif.'
                    );

                    return false;
                }

                if (discount > remainingBeforePayment) {
                    remainingAfterPayment.textContent =
                        'Remise supérieure au reste à payer';

                    remainingAfterPayment.style.color =
                        '#b91c1c';

                    showPaymentError(
                        'La remise ne peut pas dépasser ' +
                        formatFdj(remainingBeforePayment) +
                        '.'
                    );

                    return false;
                }

                const operationTotal = amount + discount;

                if (operationTotal > remainingBeforePayment) {
                    remainingAfterPayment.textContent =
                        'Montant supérieur au reste à payer';

                    remainingAfterPayment.style.color =
                        '#b91c1c';

                    showPaymentError(
                        'Le paiement + la remise ne peuvent pas dépasser ' +
                        formatFdj(remainingBeforePayment) +
                        '.'
                    );

                    return false;
                }

                const remaining = Math.max(
                    0,
                    remainingBeforePayment
                        - amount
                        - discount
                );

                if (discountPreview) {
                    discountPreview.textContent =
                        formatFdj(discount);
                }

                if (paymentPreview) {
                    paymentPreview.textContent =
                        formatFdj(amount);
                }

                remainingAfterPayment.textContent =
                    formatFdj(remaining);

                remainingAfterPayment.style.color =
                    remaining === 0
                        ? '#166534'
                        : '#b45309';

                return operationTotal > 0;
            }

            paymentAmount?.addEventListener(
                'input',
                updatePaymentPreview
            );

            paymentDiscount?.addEventListener(
                'input',
                updatePaymentPreview
            );

            invoicePaymentForm?.addEventListener(
                'submit',
                function (event) {
                    const amount = parseAmount(
                        paymentAmount?.value
                    );

                    const discount = parseAmount(
                        paymentDiscount?.value
                    );

                    const operationTotal =
                        amount + discount;

                    const valid =
                        amount >= 0
                        && discount >= 0
                        && operationTotal > 0
                        && operationTotal <= remainingBeforePayment
                        && updatePaymentPreview();

                    if (!valid) {
                        event.preventDefault();

                        if (
                            amount <= 0
                            && discount <= 0
                        ) {
                            showPaymentError(
                                'Veuillez saisir un paiement ou une remise.'
                            );
                        } else if (
                            operationTotal >
                            remainingBeforePayment
                        ) {
                            showPaymentError(
                                'Le paiement + la remise ne peuvent pas dépasser ' +
                                formatFdj(remainingBeforePayment) +
                                '.'
                            );
                        } else {
                            showPaymentError(
                                'Les montants saisis sont invalides.'
                            );
                        }

                        return;
                    }

                    if (submitPaymentButton) {
                        submitPaymentButton.disabled = true;
                        submitPaymentButton.textContent =
                            'Enregistrement...';
                    }
                }
            );

            updatePaymentPreview();

            @if(
                $errors->has('amount')
                || $errors->has('discount_amount')
                || $errors->has('payment_method')
            )
                openModal('payInvoiceModal');
            @endif
        });
    </script>
@endif

</body>
</html>
