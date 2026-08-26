@php
    $vehicle = $proforma->vehicle;
    $customer = $proforma->customer;
    $creator = $proforma->creator;

    $hasTax = $proforma->has_tax;
    $vehicleHt = $proforma->vehicle_ht_amount;
    $stamp = $proforma->stamp_amount;
    $subtotal = $proforma->subtotal_ht;
    $discount = $proforma->proforma_discount_amount;
    $netHt = $proforma->net_ht;
    $vat = $proforma->vat_amount;
    $total = $proforma->total_amount;

    $roundedTotal = (int) round($total);

    if (class_exists(\NumberFormatter::class)) {
        $formatter = new \NumberFormatter('fr_FR', \NumberFormatter::SPELLOUT);
        $totalWords = $formatter->format($roundedTotal);
    } else {
        $totalWords = (string) $roundedTotal;
    }

    $totalWords = mb_strtoupper(
        trim(str_replace('-', ' ', $totalWords)),
        'UTF-8'
    );

    $logoPath = public_path('img/logo-stcd.jpg');
    $logo = null;

    if (file_exists($logoPath)) {
        $ext = pathinfo($logoPath, PATHINFO_EXTENSION);
        $logo = 'data:image/' . $ext . ';base64,' .
            base64_encode(file_get_contents($logoPath));
    }
@endphp

@if(empty($embedded))
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>{{ $proforma->proforma_number }}</title>
@endif

<style>
    @page {
        margin: 8px;
        size: A4 portrait;
    }

    .proforma-document,
    .proforma-document \\\\* {
        box-sizing: border-box;
    }

    .proforma-document {
        width: 100%;
        max-width: 1120px;
        margin: {{ !empty($embedded) ? '10px auto' : '0 auto' }};
        padding: 10px;
        font-family: DejaVu Sans, Arial, sans-serif;
        font-size: 10px;
        line-height: 1.28;
        color: #000;
        background: #fff;
    }

    .proforma-document table {
        width: 100%;
        border-collapse: collapse;
    }

    .proforma-document th,
    .proforma-document td {
        padding: 4px;
        vertical-align: top;
        border: 1px solid #000;
    }

    .proforma-document th {
        font-size: 9px;
        line-height: 1.2;
        text-transform: uppercase;
        background: #d9d9d9;
    }

    .proforma-document .no-border td {
        border: none !important;
    }

    .proforma-document .text-center {
        text-align: center;
    }

    .proforma-document .text-end {
        text-align: right;
    }

    .proforma-document .fw-bold {
        font-weight: 700;
    }

    .proforma-document .mb-section {
        margin-bottom: 9px;
    }

    .proforma-document .company-title {
        margin: 0 0 3px;
        font-size: 23px;
        font-weight: 800;
        line-height: 1.05;
    }

    .proforma-document .main-title {
        margin: 0 0 5px;
        font-size: 28px;
        font-weight: 900;
        line-height: 1.05;
        color: #1f3c88;
    }

    .proforma-document .small-line {
        line-height: 1.2;
    }

    .proforma-document .info-box {
        min-height: 100px;
        padding: 7px;
        border: 1.5px solid #000;
    }

    .proforma-document .box-title {
        padding: 4px 5px;
        margin: -7px -7px 5px;
        font-weight: 700;
        background: #d9d9d9;
        border-bottom: 1.5px solid #000;
    }

    .proforma-document .section-title {
        padding: 5px 7px;
        margin-top: 8px;
        font-size: 9px;
        font-weight: 800;
        line-height: 1.2;
        text-transform: uppercase;
        background: #d9d9d9;
        border: 1px solid #000;
        border-bottom: none;
    }

    .proforma-document .section-title-free {
        color: #155724;
        background: #dff3e4;
        border-color: #6fa97c;
    }

    .proforma-document .paid-table {
        width: 100%;
        table-layout: fixed;
    }

    .proforma-document .paid-table th:nth-child(1),
    .proforma-document .paid-table td:nth-child(1) {
        width: 16%;
    }

    .proforma-document .paid-table th:nth-child(2),
    .proforma-document .paid-table td:nth-child(2) {
        width: 34%;
    }

    .proforma-document .paid-table th:nth-child(3),
    .proforma-document .paid-table td:nth-child(3) {
        width: 7%;
    }

    .proforma-document .paid-table th:nth-child(4),
    .proforma-document .paid-table td:nth-child(4) {
        width: 10%;
    }

   .proforma-document .paid-table th:nth-child(5),
    .proforma-document .paid-table td:nth-child(5) {
        width: 15%;
    }

    .proforma-document .paid-table th:nth-child(6),
    .proforma-document .paid-table td:nth-child(6) {
        width: 10%;
    }

    .proforma-document .paid-table th:nth-child(7),
    .proforma-document .paid-table td:nth-child(7) {
        width: 11%;
    }

    .proforma-document .vin-cell {
        white-space: normal;
        overflow-wrap: anywhere;
        word-break: break-word;
        line-height: 1.35;
        font-size: 10px;
    }

    .proforma-document .designation-cell {
        white-space: normal;
        overflow-wrap: break-word;
        word-break: normal;
        line-height: 1.25;
        padding: 6px 7px !important;
    }

    .proforma-document .vehicle-name {
        margin: 0 0 4px;
        font-size: 11px;
        line-height: 1.25;
        font-weight: 800;
        color: #111827;
    }

    .proforma-document .vehicle-subline {
        margin-bottom: 5px;
        font-size: 9px;
        line-height: 1.25;
        color: #374151;
    }

    .proforma-document .vehicle-specs {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .proforma-document .vehicle-specs td {
        width: 50%;
        padding: 2px 4px 2px 0 !important;
        border: none !important;
        font-size: 8.5px;
        line-height: 1.25;
        vertical-align: top;
        color: #111827;
    }

    .proforma-document .spec-label {
        font-weight: 700;
        color: #4b5563;
    }

    .proforma-document .spec-value {
        font-weight: 600;
    }


    .proforma-document .paid-table th,
    .proforma-document .paid-table td {
        overflow: hidden;
    }

    .proforma-document .summary {
        width: 50%;
        margin-top: 7px;
        margin-left: auto;
    }

    .proforma-document .summary td {
        padding: 3px 2px;
        border: none !important;
    }

    .proforma-document .summary td:last-child {
        text-align: right;
        white-space: nowrap;
    }

    .proforma-document .summary-total td {
        padding-top: 6px;
        font-size: 16px;
        font-weight: 900;
        border-top: 2px solid #000 !important;
    }

    .proforma-document .summary-total td:last-child {
        color: #1f3c88;
    }

    .proforma-document .amount-words,
    .proforma-document .delivery {
        padding: 5px 7px;
        border: 1.5px solid #000;
    }

    .proforma-document .amount-words {
        margin-top: 8px;
        font-weight: 700;
    }

    */\\\\**
*    |--------------------------------------------------------------------------*
*    | IMPRESSION / PDF SUR UNE SEULE PAGE*
*    |--------------------------------------------------------------------------*
*    \\\\*/
    @media print {
        html,
        body {
            margin: 0 !important;
            padding: 0 !important;
            background: #ffffff !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .proforma-document {
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
            padding: 6px !important;
            font-size: 9px !important;
            line-height: 1.18 !important;
        }

        .proforma-document th,
        .proforma-document td {
            padding: 3px !important;
        }

        .proforma-document .mb-section {
            margin-bottom: 6px !important;
        }

        .proforma-document .info-box {
            min-height: 88px !important;
        }

        .proforma-document .section-title {
            margin-top: 5px !important;
            padding: 4px 6px !important;
        }

        .proforma-document .summary {
            margin-top: 4px !important;
        }

        .proforma-document .summary td {
            padding: 2px !important;
        }

        .proforma-document .amount-words {
            margin-top: 5px !important;
        }

        .proforma-document table,
        .proforma-document tr,
        .proforma-document td,
        .proforma-document th,
        .proforma-document .section-title,
        .proforma-document .delivery,
        .proforma-document .amount-words {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
    }
</style>

@if(empty($embedded))
</head>
<body>
@endif

<div class="proforma-document">

    <table class="no-border mb-section">
        <tr>
            <td style="width:58%; padding:0; vertical-align:middle;">
                <table class="no-border">
                    <tr>
                        <td style="width:130px; padding:0 12px 0 0;">
                            @if($logo)
                                <img
                                    src="{{ $logo }}"
                                    alt="Logo STCD"
                                    style="width:115px; height:auto;"
                                >
                            @endif
                        </td>

                        <td style="padding:0;">
                            <h1 class="company-title">STCD MOTORS</h1>
                            <div class="small-line">1667 Guelleh-Batal, Djibouti-ville</div>
                            <div class="small-line">Téléphone : +253 77 22 93 33</div>
                            <div class="small-line">Fax : +253 21 35 30 09</div>
                            <div class="small-line">Email : spareparts@stcd.dj</div>
                        </td>
                    </tr>
                </table>
            </td>

            <td style="width:42%; padding:0; text-align:right;">
                <h1 class="main-title">PROFORMA</h1>
                <div><strong>N° Proforma :</strong> {{ $proforma->proforma_number }}</div>
                <div>
                    <strong>Date :</strong>
                    {{ $proforma->proforma_date?->format('d/m/Y') ?? '-' }}
                </div>
                <div>
                    <strong>Validité :</strong>
                    {{ $proforma->valid_until?->format('d/m/Y') ?? '-' }}
                </div>
            </td>
        </tr>
    </table>

    <table class="no-border mb-section">
        <tr>
            <td style="width:48%; padding:0;">
                <div class="info-box">
                    <div class="box-title">Proforma adressé à</div>
                    <div style="font-size:14px; font-weight:700; margin-bottom:4px;">
                        {{ $customer->name ?? '-' }}
                    </div>
                    <div><strong>Téléphone :</strong> {{ $customer->phone ?? '-' }}</div>
                    <div><strong>Email :</strong> {{ $customer->email ?? '-' }}</div>
                    <div><strong>Adresse :</strong> {{ $customer->address ?? '-' }}</div>
                </div>
            </td>

            <td style="width:4%; padding:0;"></td>

            <td style="width:48%; padding:0;">
                <div class="info-box">
                    <div class="box-title">Détails du proforma</div>

                    <table class="no-border">
                        <tr>
                            <td style="width:40%; padding:2px 0;"><strong>Proforma</strong></td>
                            <td style="padding:2px 0;">{{ $proforma->proforma_number }}</td>
                        </tr>
                        <tr>
                            <td style="padding:2px 0;"><strong>Date</strong></td>
                            <td style="padding:2px 0;">
                                {{ $proforma->proforma_date?->format('d/m/Y') ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:2px 0;"><strong>Validité</strong></td>
                            <td style="padding:2px 0;">
                                {{ $proforma->valid_until?->format('d/m/Y') ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:2px 0;"><strong>Statut</strong></td>
                            <td style="padding:2px 0;">{{ $proforma->status }}</td>
                        </tr>
                        <tr>
                            <td style="padding:2px 0;"><strong>Type</strong></td>
                            <td style="padding:2px 0;">{{ $proforma->invoice_type_label }}</td>
                        </tr>
                        <tr>
                            <td style="padding:2px 0;"><strong>Paiement</strong></td>
                            <td style="padding:2px 0;">{{ $proforma->payment_type }}</td>
                        </tr>
                        <tr>
                            <td style="padding:2px 0;"><strong>Créé par</strong></td>
                            <td style="padding:2px 0;">{{ $creator->name ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">
        Partie 1 — Éléments payants
    </div>

    <table class="paid-table">
        <thead>
            <tr>
                <th>Code / VIN</th>
                <th>Désignation</th>
                <th>Qté</th>
                <th>Année</th>
                <th>Prix unitaire HT</th>
                <th>Remise</th>
                <th>Montant</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="vin-cell">
                    {{ $vehicle->vin ?? '-' }}
                </td>

                <td class="designation-cell">

                    {{-- Nom principal --}}
                    <div class="vehicle-name">
                        {{ trim(($vehicle->brand ?? '') . ' ' . ($vehicle->model ?? '')) ?: '-' }}
                    </div>

                    {{-- Configuration + année --}}
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

                    {{-- Détails techniques organisés --}}
                    <table class="vehicle-specs">

                        <tr>
                            <td>
                                <span class="spec-label">Moteur :</span>
                                <span class="spec-value">
                                    {{ $vehicle->engine_number ?: ($vehicle->engine ?: '-') }}
                                </span>
                            </td>

                            <td>
                                <span class="spec-label">Cylindrée :</span>
                                <span class="spec-value">
                                    {{ $vehicle->engine_capacity ?: '-' }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span class="spec-label">Énergie :</span>
                                <span class="spec-value">
                                    {{ $vehicle->fuel_type ?: '-' }}
                                </span>
                            </td>

                            <td>
                                <span class="spec-label">Transmission :</span>
                                <span class="spec-value">
                                    {{ $vehicle->transmission ?: '-' }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span class="spec-label">Portes :</span>
                                <span class="spec-value">
                                    {{ $vehicle->doors ?: '-' }}
                                </span>
                            </td>

                            <td>
                                <span class="spec-label">Places :</span>
                                <span class="spec-value">
                                    {{ $vehicle->seats ?: '-' }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span class="spec-label">Cylindres :</span>
                                <span class="spec-value">
                                    {{ $vehicle->cylinders ?: '-' }}
                                </span>
                            </td>

                            <td>
                                <span class="spec-label">Pneus :</span>
                                <span class="spec-value">
                                    {{ $vehicle->tire_size ?: '-' }}
                                </span>
                            </td>
                        </tr>

                    </table>

                </td>
                <td class="text-center">1</td>
                <td class="text-center">{{ $vehicle->model_year ?? '-' }}</td>
                <td class="text-end">
                    {{ number_format($vehicleHt, 2, ',', ' ') }} FDJ
                </td>
               <td class="text-end">

                    @if($discount > 0)

                        <strong>
                            {{ number_format($discount, 2, ',', ' ') }}
                            FDJ
                        </strong>

                    @else

                        0,00 FDJ

                    @endif

                </td>
                <td class="text-end fw-bold">
                    {{ number_format($vehicleHt, 2, ',', ' ') }} FDJ
                </td>
            </tr>

            @if($hasTax)
                <tr>
                    <td class="text-center">TIMBRE</td>
                    <td><strong>Timbre</strong></td>
                    <td class="text-center">1</td>
                    <td class="text-center">-</td>
                    <td class="text-end">
                        {{ number_format($stamp, 2, ',', ' ') }} FDJ
                    </td>
                   <td class="text-end">
                        0,00 FDJ
                    </td>
                    <td class="text-end fw-bold">
                        {{ number_format($stamp, 2, ',', ' ') }} FDJ
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="summary">
        <table class="no-border">
            <tr>
                <td>{{ $hasTax ? 'Total HT :' : 'Prix du véhicule :' }}</td>
                <td>{{ number_format($subtotal, 2, ',', ' ') }} FDJ</td>
            </tr>

           @if($discount > 0)

                <tr style="color:#9a3412;">

                    <td>
                        Remise :
                    </td>

                    <td>
                        - {{ number_format($discount, 2, ',', ' ') }} FDJ
                    </td>

                </tr>

            @endif

            <tr>
                <td>
                    {{ $hasTax ? 'Total HT net :' : 'Montant après remise :' }}
                </td>
                <td><strong>{{ number_format($netHt, 2, ',', ' ') }} FDJ</strong></td>
            </tr>

            @if($hasTax)
                <tr>
                    <td>TVA (10 %) :</td>
                    <td>{{ number_format($vat, 2, ',', ' ') }} FDJ</td>
                </tr>
            @endif

            <tr class="summary-total">
                <td>{{ $hasTax ? 'TOTAL TTC :' : 'TOTAL À PAYER :' }}</td>
                <td>{{ number_format($total, 2, ',', ' ') }} FDJ</td>
            </tr>
        </table>
    </div>

    {{-- ============================================================= --}}
    {{-- PARTIE 2 — PRESTATIONS OFFERTES AU CLIENT --}}
    {{-- ============================================================= --}}
    **{{--**
**        Règle métier :**

**        - Proforma avec taxes :**
**          la partie 2 est toujours affichée.**

**        - Proforma sans taxes :**
**          la partie 2 est affichée uniquement si**
**          show_free_services = true.**

**        Ce choix est conservé à l'écran,**
**        à l'impression et dans le PDF téléchargé.**
**    --}}**

    @if(
        $hasTax
        || (bool) ($proforma->show_free_services ?? true)
    )

        <div class="section-title section-title-free">
            Partie 2 — Prestations offertes au client
        </div>

        <table class="free-table">

            <thead>

                <tr>

                    <th style="width:8%;">
                        Qté
                    </th>

                    <th>
                        Désignation
                    </th>

                    <th style="width:18%;">
                        Prix unitaire
                    </th>

                    <th style="width:18%;">
                        Montant
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($proforma->free_services as $service)

                    <tr>

                        <td class="text-center">
                            1
                        </td>

                        <td>
                            {{ $service }}
                        </td>

                        <td class="text-end">
                            0,00 FDJ
                        </td>

                        <td class="text-end fw-bold">
                            0,00 FDJ
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="4"
                            class="text-center"
                        >
                            Aucune prestation offerte.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>


        <div class="delivery">
            Délai de livraison : 5 jours ouvrables
        </div>

    @endif


    <div class="amount-words">
        Montant en lettres :
        {{ $totalWords }}
        {{ $roundedTotal > 1 ? 'FRANCS DJIBOUTI' : 'FRANC DJIBOUTI' }}
    </div>
</div>

@if(empty($embedded))
</body>
</html>
@endif
