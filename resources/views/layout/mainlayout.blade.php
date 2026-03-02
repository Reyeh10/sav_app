<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- 🔥 Nouveau titre -->
    <title>STCD Motors | Djibouti</title>

    <!-- 🔥 Favicon logo -->
    <link rel="icon" type="image/jpg" href="{{ asset('images/STCD.jpg') }}">

    {{-- Template CSS --}}
    @include('layout.partials.head')

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('admintemplate/assets/css/custom.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- NO CACHE --}}
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>

/* =========================
   LAYOUT PROPRE & STABLE
========================= */

:root {
    --sidebar-width: 260px;
    --header-height: 80px;
}

/* RESET */
html, body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

/* SIDEBAR */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: var(--sidebar-width);
    height: 100vh;
    z-index: 1000;
}

/* HEADER (NE PAS METTRE left: var(--sidebar-width)) */
.header-premium {
    position: fixed;
    top: 0;
    left: 0;          /* 🔥 CHANGÉ */
    right: 0;
    height: var(--header-height);
    background: linear-gradient(135deg,#ff7a00,#ff5e00);
    display: flex;
    align-items: center;
    padding-left: calc(var(--sidebar-width) + 25px);
    padding-right: 25px;
    z-index: 999;
}

/* CONTENT */
.content {
    margin-left: var(--sidebar-width);
    margin-top: var(--header-height);
    padding: 20px;
}
/* TABLE FIX */
.table {
    background: white;
}

/* Remove ghost overlays */
.page-wrapper::before,
.page-wrapper::after,
.content::before,
.content::after {
    display: none !important;
}
     /* Dashboard */

     /* ===== SIDEBAR PREMIUM STYLE ===== */

            .sidebar-menu ul li a.sidebar-link {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 10px 16px;
                border-radius: 8px;
                color: #34495e;
                font-weight: 500;
                transition: all 0.25s ease;
            }

            .sidebar-menu ul li a.sidebar-link:hover {
                background: #f2f4f7;
                transform: translateX(4px);
            }

            /* Icon background circle */
            .sidebar-icon-wrap {
                width: 32px;
                height: 32px;
                background: #eef2f7;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 16px;
            }

            /* Active state */
            .sidebar-link.active {
                background: linear-gradient(90deg, #ff7a00, #ff5e00);
                color: white;
            }

            .sidebar-link.active .sidebar-icon-wrap {
                background: rgba(255,255,255,0.2);
            }

            .sidebar-link.active i {
                color: white;
            }

            /* Dashboard orange */
            .sidebar-link.dashboard-link {
                color: #ff7a00 !important;
                font-weight: 600;
            }

            .sidebar-link.dashboard-link i {
                color: #ff7a00 !important;
            }
            /* ===== FORCE ORANGE DASHBOARD ===== */

            .sidebar-menu ul li a.sidebar-link.dashboard-link {
                color: #ff7a00 !important;
                font-weight: 600;
            }

            .sidebar-menu ul li a.sidebar-link.dashboard-link .dashboard-icon {
                color: #ff7a00 !important;
            }

            .sidebar-menu ul li a.sidebar-link.dashboard-link .dashboard-text {
                color: #ff7a00 !important;
            }
</style>
</head>
<body>

<div class="main-wrapper">
    {{-- HEADER + SIDEBAR --}}
    @auth
        @include('layout.partials.header')
        @include('layout.partials.sidebar')
    @endauth
    {{-- CONTENT --}}
    <div class="content">
        @yield('content')
    </div>
</div>
{{-- AUTO LOGOUT FORM --}}
@auth
<form id="autoLogoutForm" method="POST" action="{{ route('logout') }}" style="display:none;">
    @csrf
</form>
@endauth
{{-- Footer --}}
@include('layout.partials.footer')
{{-- Scripts Template --}}
@include('layout.partials.footer-scripts')
{{-- ================= SELECT2 ================= --}}
<script>
$(document).ready(function () {
    // ===== CLIENT =====
    $('.customer-select').select2({
        placeholder: "-- Sélectionner un client --",
        allowClear: true,
        width: "100%"
    });
    // ===== VEHICLE =====
    $('.vehicle-select').select2({
        placeholder: "-- Sélectionner une voiture --",
        allowClear: true,
        width: "100%"
    });
    // ===== TYPE PAIEMENT =====
    $('.payment-select').select2({
        placeholder: "-- Sélectionner le type de paiement --",
        width: "100%"
    });
    // ===== TYPE CLIENT =====
    $('.typeclient-select').select2({
        placeholder: "-- Sélectionner le type --",
        width: "100%"
    });
    // IMPORTANT POUR MODAL
    $('.typeclient-select').select2({
        placeholder: "-- Sélectionner le type --",
        width: "100%",
        dropdownParent: $('#createCustomerModal')
    });
    $('#customerType').select2({
    width: "100%",
    dropdownParent: $('#createCustomerModal'),
    placeholder: "-- Type de client --",
    allowClear: true
});

});
</script>

{{-- ================= SESSION / SECURITY CONTROL================= --}}
@auth
<script>
let timeout;
let maxInactivity = 15 * 60 * 1000; // 5 minutes
function resetTimer() {
    clearTimeout(timeout);
    timeout = setTimeout(showTimeoutPopup, maxInactivity);
}
function showTimeoutPopup() {
    Swal.fire({
        icon: 'warning',
        title: 'Session expirée',
        text: 'Votre session a expiré pour inactivité.',
        confirmButtonText: 'Se reconnecter',
        allowOutsideClick: false
    }).then(() => {
        document.getElementById('autoLogoutForm').submit();
    });
}
/*
============================
USER ACTIVITY EVENTS
============================
*/
['load','mousemove','mousedown','click','scroll','keypress','touchstart']
.forEach(event => {
    window.addEventListener(event, resetTimer, true);
});
/*
============================
BACK / FORWARD CACHE FIX
============================
*/
window.addEventListener("pageshow", function (event) {
    if (event.persisted) {
        window.location.reload();
    }
});
</script>
@endauth
{{-- ================= SESSION EXPIRED FROM BACKEND ============== --}}
@if(session('session_expired'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'warning',
        title: 'Session expirée',
        text: 'Votre session a expiré. Veuillez vous reconnecter.',
        confirmButtonText: 'OK',
        allowOutsideClick: false
    });
});
</script>
@endif
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Forcer Select2 sur tous les selects ciblés
    if (typeof $.fn.select2 !== "undefined") {
        $('.typeclient-select').select2({
            width: "100%",
            dropdownParent: $('#createCustomerModal')
        });
        $('.payment-select').select2({
            width: "100%"
        });
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id)
{
    Swal.fire({
        title: 'Supprimer le véhicule ?',
        text: "Cette action est irréversible.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>

    <script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Supprimer ce client ?',
            text: "Cette action est irréversible !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler',
            reverseButtons: true,
            backdrop: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
    </script>

    <script>
        function confirmUserDelete(id) {
            Swal.fire({
                title: 'Supprimer cet utilisateur ?',
                html: '<b>Cette action est irréversible !</b>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="ti ti-trash"></i> Oui, supprimer',
                cancelButtonText: 'Annuler',
                reverseButtons: true,
                backdrop: true,
                allowOutsideClick: false,
                customClass: {
                    popup: 'rounded-4 shadow-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-user-' + id).submit();
                }
            });
        }
        </script>

        <script>
$(document).ready(function () {

    $('.datatable').DataTable().destroy();

    $('.datatable').DataTable({
        language: {
            lengthMenu: "Afficher _MENU_ lignes",
            info: "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
            infoEmpty: "Affichage de 0 à 0 sur 0 entrées",
            infoFiltered: "(filtré de _MAX_ entrées au total)",
            zeroRecords: "Aucun résultat trouvé",
            search: "Rechercher :",
            paginate: {
                first: "Premier",
                last: "Dernier",
                next: "Suivant",
                previous: "Précédent"
            }
        }
    });

});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('password');
    const btn   = document.getElementById('togglePassword');

    if (!input || !btn) return;

    btn.addEventListener('click', function () {
        input.type = input.type === 'password' ? 'text' : 'password';
    });

});
</script>
@stack('scripts')
</body>
</html>
