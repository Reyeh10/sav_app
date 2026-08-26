@extends('layout.mainlayout')

@section('content')

<style>
    /*
    |--------------------------------------------------------------------------
    | AFFICHAGE NORMAL À L'ÉCRAN
    |--------------------------------------------------------------------------
    */

    .proforma-show-page {
        width: 100%;
        padding: 22px;
    }

    .proforma-show-inner {
        width: 100%;
        max-width: 1250px;
        margin: 0 auto;
    }

    .proforma-show-actions {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 9px;
        margin-bottom: 20px;
    }

    .proforma-document-frame {
        width: 100%;
        overflow: auto;
        background: #eef0f4;
        border-radius: 12px;
    }


    /*
    |--------------------------------------------------------------------------
    | SWEETALERT2 - POPUP STCD
    |--------------------------------------------------------------------------
    */

    .swal2-popup.stcd-swal-popup {
        width: 490px !important;
        max-width: calc(100% - 30px) !important;

        padding: 28px 30px 25px !important;

        border-radius: 20px !important;

        box-shadow:
            0 25px 65px rgba(15, 23, 42, 0.30) !important;
    }


    .stcd-swal-title {
        color: #1f2937 !important;

        font-size: 25px !important;
        font-weight: 700 !important;

        padding-top: 5px !important;
    }


    .stcd-swal-html {
        color: #667085 !important;

        font-size: 15px !important;
        line-height: 1.65 !important;

        margin-top: 10px !important;
    }


    .stcd-swal-confirm {
        min-width: 155px;

        padding: 11px 18px !important;

        border: none !important;
        border-radius: 9px !important;

        font-size: 14px !important;
        font-weight: 600 !important;

        box-shadow: none !important;
    }


    .stcd-swal-cancel {
        min-width: 115px;

        padding: 11px 18px !important;

        border: none !important;
        border-radius: 9px !important;

        font-size: 14px !important;
        font-weight: 600 !important;

        box-shadow: none !important;
    }


    .swal2-actions {
        gap: 8px !important;

        margin-top: 24px !important;
    }


    .swal2-icon {
        margin-top: 10px !important;
        margin-bottom: 15px !important;
    }


    /*
    |--------------------------------------------------------------------------
    | LOADER DU BOUTON
    |--------------------------------------------------------------------------
    */

    .stcd-button-loading {
        pointer-events: none;
        opacity: 0.75;
    }


    /*
    |--------------------------------------------------------------------------
    | IMPRESSION
    |--------------------------------------------------------------------------
    |
    | Principe :
    |
    | 1. Cacher absolument tout le site.
    | 2. Rendre visible uniquement le proforma.
    | 3. Positionner le proforma en haut à gauche de la feuille.
    |
    | Cette méthode ne dépend PAS des classes du thème Laravel.
    |--------------------------------------------------------------------------
    */

</style>


<div class="proforma-show-page">

    <div class="proforma-show-inner">


        {{-- ============================================================= --}}
        {{-- MESSAGES --}}
        {{-- ============================================================= --}}

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
        {{-- BOUTONS --}}
        {{-- ============================================================= --}}

        <div class="proforma-show-actions">


            {{-- RETOUR --}}

            <a
                href="{{ route('proformas.index') }}"
                class="btn btn-secondary"
            >
                <i class="ti ti-arrow-left me-1"></i>

                Retour
            </a>



            {{-- MODIFIER --}}

            @if(
                !in_array(
                    $proforma->status,
                    [
                        'Converti',
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
                    class="btn btn-warning"
                >

                    <i class="ti ti-edit me-1"></i>

                    Modifier

                </a>

            @endif



            {{-- TÉLÉCHARGER PDF --}}

            <a
                href="{{ route(
                    'proformas.download',
                    $proforma
                ) }}"
                class="btn btn-primary"
            >

                <i class="ti ti-download me-1"></i>

                Télécharger PDF

            </a>



            {{-- IMPRIMER --}}

            <button
                type="button"
                class="btn btn-info"
                onclick="printProforma()"
            >
                <i class="ti ti-printer me-1"></i>

                Imprimer
            </button>



            {{-- ========================================================= --}}
            {{-- TRANSFORMER EN VENTE --}}
            {{-- ========================================================= --}}

            @if($proforma->isConvertible())

                <form
                    id="convertProformaForm"
                    action="{{ route(
                        'proformas.convert',
                        $proforma
                    ) }}"
                    method="POST"
                    class="d-inline"
                >

                    @csrf

                    <button
                        type="button"
                        class="btn btn-success"
                        id="convertProformaButton"
                        onclick="confirmConvertProforma()"
                    >

                        <i
                            class="
                                ti
                                ti-shopping-cart-check
                                me-1
                            "
                        ></i>

                        Transformer en vente

                    </button>

                </form>


            @elseif(
                $proforma->status === 'Converti'
                && $proforma->sale
            )

                <a
                    href="{{ route(
                        'sales.invoice',
                        $proforma->sale
                    ) }}"
                    class="btn btn-success"
                >

                    <i class="ti ti-file-invoice me-1"></i>

                    Voir la facture

                </a>

            @endif



            {{-- ========================================================= --}}
            {{-- ANNULER --}}
            {{-- ========================================================= --}}

            @if(
                !in_array(
                    $proforma->status,
                    [
                        'Converti',
                        'Annulé'
                    ],
                    true
                )
            )

                <form
                    id="cancelProformaForm"
                    action="{{ route(
                        'proformas.cancel',
                        $proforma
                    ) }}"
                    method="POST"
                    class="d-inline"
                >

                    @csrf

                    <button
                        type="button"
                        class="btn btn-danger"
                        id="cancelProformaButton"
                        onclick="confirmCancelProforma()"
                    >

                        <i class="ti ti-ban me-1"></i>

                        Annuler le proforma

                    </button>

                </form>

            @endif

        </div>



        {{-- ============================================================= --}}
        {{-- DOCUMENT PROFORMA --}}
        {{-- ============================================================= --}}

        <div
            class="proforma-document-frame"
            id="printableProforma"
        >

            @include(
                'proformas.pdf',
                [
                    'proforma' => $proforma,
                    'embedded' => true,
                ]
            )

        </div>


    </div>

</div>



{{-- ============================================================= --}}
{{-- SWEETALERT2 --}}
{{-- ============================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>

/*
|--------------------------------------------------------------------------
| TRANSFORMER LE PROFORMA EN VENTE
|--------------------------------------------------------------------------
*/

function confirmConvertProforma()
{
    const form = document.getElementById(
        'convertProformaForm'
    );

    const button = document.getElementById(
        'convertProformaButton'
    );


    if (!form) {

        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: 'Le formulaire de conversion est introuvable.',
            confirmButtonColor: '#dc3545'
        });

        return;
    }


    Swal.fire({

        title: 'Transformer en vente ?',

        html: `
            <div>
                Ce proforma sera transformé en
                <strong>vente définitive</strong>.
            </div>

            <div style="
                margin-top: 10px;
                color: #98a2b3;
                font-size: 13px;
            ">
                Une facture pourra ensuite être générée
                à partir de cette vente.
            </div>
        `,

        icon: 'question',

        showCancelButton: true,

        confirmButtonText:
            '<i class="ti ti-shopping-cart-check me-1"></i> Oui, transformer',

        cancelButtonText:
            '<i class="ti ti-x me-1"></i> Annuler',

        confirmButtonColor: '#28a745',

        cancelButtonColor: '#6c757d',

        reverseButtons: true,

        focusCancel: true,

        allowOutsideClick: false,

        allowEscapeKey: true,

        backdrop: 'rgba(15, 23, 42, 0.58)',

        customClass: {

            popup:
                'stcd-swal-popup',

            title:
                'stcd-swal-title',

            htmlContainer:
                'stcd-swal-html',

            confirmButton:
                'stcd-swal-confirm',

            cancelButton:
                'stcd-swal-cancel'
        }

    }).then((result) => {

        if (result.isConfirmed) {

            /*
            |--------------------------------------------------------------------------
            | ÉVITER LE DOUBLE CLIC
            |--------------------------------------------------------------------------
            */

            if (button) {

                button.disabled = true;

                button.classList.add(
                    'stcd-button-loading'
                );

                button.innerHTML = `
                    <span
                        class="
                            spinner-border
                            spinner-border-sm
                            me-1
                        "
                        role="status"
                        aria-hidden="true"
                    ></span>

                    Transformation...
                `;
            }


            /*
            |--------------------------------------------------------------------------
            | ENVOYER LE FORMULAIRE
            |--------------------------------------------------------------------------
            */

            form.submit();
        }

    });
}



/*
|--------------------------------------------------------------------------
| ANNULER LE PROFORMA
|--------------------------------------------------------------------------
*/

function confirmCancelProforma()
{
    const form = document.getElementById(
        'cancelProformaForm'
    );

    const button = document.getElementById(
        'cancelProformaButton'
    );


    if (!form) {

        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: 'Le formulaire d’annulation est introuvable.',
            confirmButtonColor: '#dc3545'
        });

        return;
    }


    Swal.fire({

        title: 'Annuler ce proforma ?',

        html: `
            <div>
                Vous êtes sur le point d'annuler
                ce proforma.
            </div>

            <div style="
                margin-top: 10px;
                color: #dc3545;
                font-size: 13px;
                font-weight: 600;
            ">
                Le statut du proforma deviendra
                « Annulé ».
            </div>
        `,

        icon: 'warning',

        showCancelButton: true,

        confirmButtonText:
            '<i class="ti ti-ban me-1"></i> Oui, annuler',

        cancelButtonText:
            '<i class="ti ti-arrow-left me-1"></i> Retour',

        confirmButtonColor: '#dc3545',

        cancelButtonColor: '#6c757d',

        reverseButtons: true,

        focusCancel: true,

        allowOutsideClick: false,

        allowEscapeKey: true,

        backdrop: 'rgba(15, 23, 42, 0.58)',

        customClass: {

            popup:
                'stcd-swal-popup',

            title:
                'stcd-swal-title',

            htmlContainer:
                'stcd-swal-html',

            confirmButton:
                'stcd-swal-confirm',

            cancelButton:
                'stcd-swal-cancel'
        }

    }).then((result) => {

        if (result.isConfirmed) {

            /*
            |--------------------------------------------------------------------------
            | ÉVITER LE DOUBLE CLIC
            |--------------------------------------------------------------------------
            */

            if (button) {

                button.disabled = true;

                button.classList.add(
                    'stcd-button-loading'
                );

                button.innerHTML = `
                    <span
                        class="
                            spinner-border
                            spinner-border-sm
                            me-1
                        "
                        role="status"
                        aria-hidden="true"
                    ></span>

                    Annulation...
                `;
            }


            /*
            |--------------------------------------------------------------------------
            | ENVOYER LE FORMULAIRE
            |--------------------------------------------------------------------------
            */

            form.submit();
        }

    });
}



/*
|--------------------------------------------------------------------------
| IMPRESSION DU PROFORMA
|--------------------------------------------------------------------------
*/

function printProforma()
{
    const printable = document.getElementById(
        'printableProforma'
    );


    if (!printable) {

        Swal.fire({
            icon: 'error',

            title: 'Impression impossible',

            text: 'Le proforma est introuvable.',

            confirmButtonText: 'OK',

            confirmButtonColor: '#dc3545',

            customClass: {
                popup: 'stcd-swal-popup',
                title: 'stcd-swal-title'
            }
        });

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | OUVRIR UNE FENÊTRE DÉDIÉE À L'IMPRESSION
    |--------------------------------------------------------------------------
    */

    const printWindow = window.open(
        '',
        '_blank',
        'width=1000,height=900'
    );


    if (!printWindow) {

        Swal.fire({

            icon: 'warning',

            title: 'Fenêtre bloquée',

            html: `
                Votre navigateur bloque la fenêtre
                nécessaire à l'impression.
                <br><br>
                Veuillez autoriser les fenêtres popup
                pour ce site.
            `,

            confirmButtonText: 'Compris',

            confirmButtonColor: '#0d6efd',

            customClass: {
                popup: 'stcd-swal-popup',
                title: 'stcd-swal-title',
                htmlContainer: 'stcd-swal-html'
            }
        });

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | RÉCUPÉRER LES STYLES DU DOCUMENT
    |--------------------------------------------------------------------------
    */

    const styles = Array
        .from(
            document.querySelectorAll(
                'style, link[rel="stylesheet"]'
            )
        )
        .map(function(element) {

            return element.outerHTML;

        })
        .join('\n');


    /*
    |--------------------------------------------------------------------------
    | CONSTRUIRE UNE PAGE QUI CONTIENT UNIQUEMENT LE PROFORMA
    |--------------------------------------------------------------------------
    */

    printWindow.document.open();


    printWindow.document.write(`
        <!DOCTYPE html>

        <html lang="fr">

        <head>

            <meta charset="UTF-8">

            <title>
                Proforma
            </title>

            ${styles}

            <style>

                @page {
                    size: A4 portrait;
                    margin: 6mm;
                }


                html,
                body {

                    width: 100%;

                    margin: 0;
                    padding: 0;

                    background: #ffffff;

                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }


                body {
                    overflow: visible;
                }


                .proforma-document-frame {

                    width: 100% !important;

                    margin: 0 !important;
                    padding: 0 !important;

                    overflow: visible !important;

                    background: #ffffff !important;

                    border: none !important;
                    border-radius: 0 !important;

                    box-shadow: none !important;
                }


                .proforma-document {

                    width: 100% !important;

                    max-width: none !important;

                    margin: 0 !important;

                    background: #ffffff !important;
                }


                /*
                |--------------------------------------------------------------------------
                | UNE SEULE PAGE
                |--------------------------------------------------------------------------
                */

                .proforma-document table,
                .proforma-document tr,
                .proforma-document td,
                .proforma-document th {

                    page-break-inside: avoid !important;
                    break-inside: avoid !important;
                }


                .proforma-document .section-title,
                .proforma-document .delivery,
                .proforma-document .amount-words {

                    page-break-inside: avoid !important;
                    break-inside: avoid !important;
                }


                /*
                |--------------------------------------------------------------------------
                | SUPPRIMER TOUT ÉLÉMENT INUTILE
                |--------------------------------------------------------------------------
                */

                .proforma-show-actions,
                .header,
                .sidebar,
                .footer,
                .navbar {

                    display: none !important;
                }

            </style>

        </head>


        <body>

            ${printable.outerHTML}

        </body>

        </html>
    `);


    printWindow.document.close();


    /*
    |--------------------------------------------------------------------------
    | ATTENDRE LE CHARGEMENT
    |--------------------------------------------------------------------------
    */

    printWindow.focus();


    setTimeout(function() {

        printWindow.print();

        printWindow.close();

    }, 500);
}

</script>

@endsection
