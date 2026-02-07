<!-- Apple Touch Icon -->
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('admintemplate/assets/img/apple-touch-icon.png') }}">

<!-- Favicon -->
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('admintemplate/assets/img/favicon.png') }}">

@if (!Route::is(['login', 'layout-horizontal', 'layout-detached', 'layout-modern', 'layout-horizontal-overlay', 'layout-two-column',
'layout-hovered', 'layout-box', 'layout-horizontal-single', 'layout-horizontal-box', 'layout-horizontal-sidemenu', 'layout-vertical-transparent',
'layout-without-header','login','login-2','login-3','register','register-2','register-3','forgot-password','forgot-password-2','forgot-password-3',
'reset-password','reset-password-2','reset-password-3','email-verification','email-verification-2','email-verification-3','lock-screen','error-404',
'error-500','coming-soon','under-maintenance','under-construction','success','success-2','success-3','two-step-verification','two-step-verification-2','two-step-verification-3',
'layout-without-header', 'layout-rtl', 'layout-dark'
]))
<!-- Theme Script js -->
<script src="{{ asset('admintemplate/assets/js/theme-script.js') }}"></script>
@endif

@if (!Route::is(['layout-rtl']))
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/css/bootstrap.min.css') }}">
@endif

@if (Route::is(['layout-rtl']))
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/css/bootstrap.rtl.min.css') }}">
@endif

<!-- Fancybox CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/fancybox/jquery.fancybox.min.css') }}">

<!-- Feather CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/icons/feather/feather.css') }}">

<!-- Tabler Icon CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/icons/bootstrap/bootstrap-icons.min.css') }}">

<!-- Tabler Icon CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/tabler-icons/tabler-icons.css') }}">

@if (Route::is(['icon-remix']))
<!-- Remix Icon CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/remix/fonts/remixicon.css') }}">
@endif

<!-- Select2 CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/select2/css/select2.min.css') }}">

@if (Route::is(['maps-leaflet']))
<!-- Leaflet Maps CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/leaflet/leaflet.css') }}">
@endif

@if (Route::is(['maps-vector']))
<!-- Jsvector Maps -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/jsvectormap/css/jsvectormap.min.css') }}">
@endif

@if (Route::is(['ui-scrollbar']))
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/scrollbar/scroll.min.css') }}">
@endif

@if (Route::is(['search-result', 'gallery']))
    <!-- Fancybox CSS -->
    <link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/fancybox/jquery.fancybox.min.css') }}">
@endif

@if (Route::is(['ui-stickynote']))
    <!-- Sticky CSS -->
    <link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/stickynote/sticky.css') }}">
@endif

<!-- Fontawesome CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/fontawesome/css/all.min.css') }}">

 <!-- Color Picker Css -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/flatpickr/flatpickr.min.css') }}">
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/@simonwep/pickr/themes/nano.min.css') }}">

<!-- Daterangepikcer CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/daterangepicker/daterangepicker.css') }}">

<!-- Owl carousel CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/css/owl.carousel.min.css') }}">

<!-- Datatable CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/css/dataTables.bootstrap5.min.css') }}">

<!-- Player CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/css/plyr.css') }}">

<!-- Owl Carousel -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/owlcarousel/owl.carousel.min.css') }}">

<!-- Summernote CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/summernote/summernote-lite.min.css') }}">

<!-- Datetimepicker CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/css/bootstrap-datetimepicker.min.css') }}">

<!-- Select2 CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/select2/css/select2.min.css') }}">

<!-- Dragula CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/dragula/css/dragula.min.css') }}">

<!-- ChartC3 CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/c3-chart/c3.min.css') }}">

<!-- Bootstrap Tagsinput CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">

<!-- Rangeslider CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/ion-rangeslider/css/ion.rangeSlider.min.css') }}">

@if (Route::is(['icon-ionic', 'plugin']))
<!-- Ionic CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/icons/ionic/ionicons.css') }}">
@endif

<!-- Morris CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/morris/morris.css') }}">

<!-- Material CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/material/materialdesignicons.css') }}">

<!-- Pe7 CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/icons/pe7/pe-icon-7.css') }}">

@if (Route::is(['icon-simpleline', 'plugin']))
<!-- Material CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/simpleline/simple-line-icons.css') }}">
@endif

@if (Route::is(['icon-themify']))
<!-- Pe7 CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/icons/themify/themify.css') }}">
@endif

<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/jquery-timepicker/jquery-timepicker.css') }}" />
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/pickr/pickr-themes.css') }}" />


<!-- Pe7 CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/icons/typicons/typicons.css') }}">

<!-- Pe7 CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/icons/flags/flags.css') }}">

<!-- Pe7 CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/plugins/icons/weather/weathericons.css') }}">

<!-- Main CSS -->
<link rel="stylesheet" href="{{ asset('admintemplate/assets/css/style.css') }}">
