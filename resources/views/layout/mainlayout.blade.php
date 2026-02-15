<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SAV Application</title>

    {{-- Template CSS --}}
    @include('layout.partials.head')

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('admintemplate/assets/css/custom.css') }}">

    {{-- NO CACHE --}}
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

<div class="main-wrapper">

    {{-- HEADER + SIDEBAR --}}
    @auth
        @include('layout.partials.header')
        @include('layout.partials.sidebar')
    @endauth

    {{-- CONTENT --}}
    <div class="content container-fluid px-2">
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

    $('.customer-select').select2({
        placeholder: "-- Sélectionner un client --",
        allowClear: true,
        width: "100%"
    });

    $('.vehicle-select').select2({
        placeholder: "-- Sélectionner une voiture --",
        allowClear: true,
        width: "100%"
    });

});
</script>

{{-- ================= SESSION / SECURITY CONTROL ================= --}}
@auth
<script>

let timeout;
let maxInactivity = 5 * 60 * 1000; // 5 minutes

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

{{-- ================= SESSION EXPIRED FROM BACKEND ================= --}}
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

</body>
</html>
