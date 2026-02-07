
<!-- jQuery -->
<script src="{{ asset('admintemplate/assets/js/jquery-3.7.1.min.js') }}"></script>

<!-- Bootstrap Core JS -->
<script src="{{ asset('admintemplate/assets/js/bootstrap.bundle.min.js') }}"></script>

<!-- Feather Icon JS -->
<script src="{{ asset('admintemplate/assets/js/feather.min.js') }}"></script>

<!-- Slimscroll JS -->
<script src="{{ asset('admintemplate/assets/js/jquery.slimscroll.min.js') }}"></script>

<!-- Summernote JS -->
<script src="{{ asset('admintemplate/assets/plugins/summernote/summernote-lite.min.js') }}"></script>

<!-- Color Picker JS -->
<script src="{{ asset('admintemplate/assets/js/plyr-js.js') }}"></script>
<script src="{{ asset('admintemplate/assets/plugins/@simonwep/pickr/pickr.es5.min.js') }}"></script>

<!-- Datatable JS -->
<script src="{{ asset('admintemplate/assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admintemplate/assets/js/dataTables.bootstrap5.min.js') }}"></script>

<!-- Bootstrap Tagsinput JS -->
<script src="{{ asset('admintemplate/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>

<!-- Owl Carousel -->
<script src="{{ asset('admintemplate/assets/plugins/owlcarousel/owl.carousel.min.js') }}"></script>

<!-- Daterangepikcer JS -->
<script src="{{ asset('admintemplate/assets/js/moment.js') }}"></script>
<script src="{{ asset('admintemplate/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>

@if (Route::is(['ui-rangeslider']))
    <!-- Rangeslider JS -->
    <script src="{{ asset('admintemplate/assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('admintemplate/assets/plugins/ion-rangeslider/js/custom-rangeslider.js') }}"></script>
@endif

<!-- Fullcalendar JS -->
<script src="{{ asset('admintemplate/assets/plugins/fullcalendar/index.global.min.js') }}"></script>
<script src="{{ asset('admintemplate/assets/plugins/fullcalendar/calendar-data.js') }}"></script>

<!-- Datetimepicker JS -->
<script src="{{ asset('admintemplate/assets/js/bootstrap-datetimepicker.min.js') }}"></script>

<!-- Select2 JS -->
<script src="{{ asset('admintemplate/assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('admintemplate/assets/js/select2.min.js') }}"></script>
<!-- Theiastickysidebar JS -->
<script src="{{ asset('admintemplate/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.min.js') }}"></script>
<script src="{{ asset('admintemplate/assets/plugins/theia-sticky-sidebar/ResizeSensor.min.js') }}"></script>

<!-- Owl Carousel JS -->
<script src="{{ asset('admintemplate/assets/js/owl.carousel.min.js') }}"></script>

@if (Route::is(['ui-clipboard']))
    <!-- Clipboard JS -->
    <script src="{{ asset('admintemplate/assets/plugins/clipboard/clipboard.min.js') }}"></script>
@endif

@if (Route::is(['maps-vector']))

<script src="{{ asset('admintemplate/assets/plugins/jsvectormap/js/jsvectormap.min.js') }}"></script>
<!-- JSVector Maps MapsJS -->
<script src="{{ asset('admintemplate/assets/plugins/jsvectormap/maps/world-merc.js') }}"></script>
<script src="{{ asset('admintemplate/assets/js/us-merc-en.js') }}"></script>
<script src="{{ asset('admintemplate/assets/js/russia.js') }}"></script>
<script src="{{ asset('admintemplate/assets/js/spain.js') }}"></script>
<script src="{{ asset('admintemplate/assets/js/canada.js') }}"></script>
<script src="{{ asset('admintemplate/assets/js/jsvectormap.js') }}"></script>
<script src="{{ asset('admintemplate/assets/plugins/@simonwep/pickr/pickr.min.js') }}"></script>

@endif

@if (Route::is(['maps-leaflet']))

<script src="{{ asset('admintemplate/assets/plugins/leaflet/leaflet.js') }}"></script>
<script src="{{ asset('admintemplate/assets/js/leaflet.js') }}"></script>

@endif

@if (Route::is(['ui-drag-drop']))
    <!-- Dragula JS -->
    <script src="{{ asset('admintemplate/assets/plugins/dragula/js/dragula.min.js') }}"></script>
    <script src="{{ asset('admintemplate/assets/plugins/dragula/js/drag-drop.min.js') }}"></script>
    <script src="{{ asset('admintemplate/assets/plugins/dragula/js/draggable-cards.js') }}"></script>
@endif

@if (Route::is(['ui-sweetalerts', 'ui-ribbon',]))
    <!-- Sweetalert 2 -->
    <script src="{{ asset('admintemplate/assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admintemplate/assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
@endif

@if (Route::is(['ui-stickynote', 'kanban-view', 'task-board', 'deals-grid', 'leads-grid', 'candidates-kanban']))
    <!-- Stickynote JS -->
    <script src="{{ asset('admintemplate/assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('admintemplate/assets/js/jquery.ui.touch-punch.min.js') }}"></script>
@endif

@if (Route::is(['plugin', 'ui-stickynote']))
<script src="{{ asset('admintemplate/assets/plugins/stickynote/sticky.js') }}"></script>
@endif

@if (Route::is([
        'chart-apex', 'index', 'employee-dashboard', 'deals-dashboard', 'leads-dashboard', 'file-manager', 'dashboard', 'companies', 'packages',
        'layout-horizontal', 'layout-detached', 'layout-modern', 'layout-horizontal-overlay', 'layout-two-column', 'layout-hovered', 'layout-box',
        'layout-horizontal-single', 'layout-horizontal-box', 'layout-horizontal-sidemenu', 'layout-vertical-transparent', 'layout-without-header',
        'layout-rtl', 'layout-dark', 'analytics','expenses-report','invoice-report','payment-report','project-report','task-report','user-report',
        'employee-report','payslip-report','attendance-report', 'leave-report', 'daily-report',
    ]))
    <!-- Chart JS -->
    <script src="{{ asset('admintemplate/assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admintemplate/assets/plugins/apexchart/chart-data.js') }}"></script>
@endif

@if (Route::is(['chart-c3']))
    <!-- Chart JS -->
    <script src="{{ asset('admintemplate/assets/plugins/c3-chart/d3.v5.min.js') }}"></script>
    <script src="{{ asset('admintemplate/assets/plugins/c3-chart/c3.min.js') }}"></script>
    <script src="{{ asset('admintemplate/assets/plugins/c3-chart/chart-data.js') }}"></script>
@endif

@if (Route::is(['chart-js', 'index', 'deals-dashboard', 'dashboard', 'companies', 'layout-horizontal', 'layout-detached', 'layout-modern',
'layout-horizontal-overlay', 'layout-two-column', 'layout-hovered', 'layout-box', 'layout-horizontal-single', 'layout-horizontal-box', 'layout-horizontal-sidemenu',
'layout-vertical-transparent', 'layout-without-header', 'layout-rtl', 'layout-dark', 'analytics'
]))
    <!-- Chart JS -->
    <script src="{{ asset('admintemplate/assets/plugins/chartjs/chart.min.js') }}"></script>
    <script src="{{ asset('admintemplate/assets/plugins/chartjs/chart-data.js') }}"></script>
@endif

@if (Route::is(['chart-morris']))
    <!-- Chart JS -->
    <script src="{{ asset('admintemplate/assets/plugins/morris/raphael-min.js') }}"></script>
    <script src="{{ asset('admintemplate/assets/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ asset('admintemplate/assets/plugins/morris/chart-data.js') }}"></script>
@endif

@if (Route::is(['chart-peity', 'deals-dashboard', 'leads-dashboard', 'dashboard', 'companies', 'subscription', 'tickets-grid','tickets', 'task-report']))
    <!-- Chart JS -->
    <script src="{{ asset('admintemplate/assets/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('admintemplate/assets/plugins/peity/chart-data.js') }}"></script>
@endif

@if (Route::is(['chart-flot']))
    <!-- Chart JS -->
    <script src="{{ asset('admintemplate/assets/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('admintemplate/assets/plugins/flot/jquery.flot.fillbetween.js') }}"></script>
    <script src="{{ asset('admintemplate/assets/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('admintemplate/assets/plugins/flot/chart-data.js') }}"></script>
@endif

<!-- Slimscroll JS -->
<script src="{{ asset('admintemplate/assets/js/jquery.slimscroll.min.js') }}"></script>

@if (Route::is(['ui-rating']))
    <!-- Rater JS -->
    <script src="{{ asset('admintemplate/assets/plugins/rater-js/index.js') }}"></script>

    <!-- Internal Ratings JS -->
    <script src="{{ asset('admintemplate/assets/js/ratings.js') }}"></script>
@endif

@if (Route::is(['ui-toasts']))
    <!-- Chart JS -->
    <script src="{{ asset('admintemplate/assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('admintemplate/assets/plugins/toastr/toastr.js') }}"></script>
@endif

@if (Route::is(['ui-counter']))
    <!-- Stickynote JS -->
    <script src="{{ asset('admintemplate/assets/plugins/countup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('admintemplate/assets/plugins/countup/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('admintemplate/assets/plugins/countup/jquery.missofis-countdown.js') }}"></script>
@endif

@if (Route::is(['ui-lightbox']))
    <!-- Alertify JS -->
    <script src="{{ asset('admintemplate/assets/plugins/lightbox/glightbox.min.js') }}"></script>
    <script src="{{ asset('admintemplate/assets/plugins/lightbox/lightbox.js') }}"></script>
@endif

@if (Route::is(['form-wizard']))
    <!-- Wizard JS -->
    <script src="{{ asset('admintemplate/assets/plugins/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
    <script src="{{ asset('admintemplate/assets/plugins/twitter-bootstrap-wizard/prettify.js') }}"></script>
    <script src="{{ asset('admintemplate/assets/plugins/twitter-bootstrap-wizard/form-wizard.js') }}"></script>
@endif

@if (Route::is(['form-mask']))
    <!-- Mask JS -->
    <script src="{{ asset('admintemplate/assets/js/jquery.maskedinput.min.js') }}"></script>
    <script src="{{ asset('admintemplate/assets/js/mask.js') }}"></script>
@endif

<!-- Sticky Sidebar JS -->
<script src="{{ asset('admintemplate/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
<script src="{{ asset('admintemplate/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>

@if (Route::is(['reset-password','reset-password-2','reset-password-3']))
<!-- Validation-->
<script src="{{ asset('admintemplate/assets/js/validation.js') }}"></script>
@endif

@if (Route::is(['email-verification','email-verification-2','email-verification-3','two-step-verification','two-step-verification-2','two-step-verification-3']))
<script src="{{ asset('admintemplate/assets/js/otp.js') }}"></script>
@endif



@if (Route::is(['form-fileupload']))
    <!-- Fileupload JS -->
    <script src="{{ asset('admintemplate/assets/plugins/fileupload/fileupload.min.js') }}"></script>
@endif

@if (Route::is(['employee-salary']))
<script src="{{ asset('admintemplate/assets/js/employee-salary.js') }}"></script>
@endif

<!-- Fancybox JS -->
<script src="{{ asset('admintemplate/assets/plugins/fancybox/jquery.fancybox.min.js') }}"></script>

<!-- Chart JS -->
<script src="{{ asset('admintemplate/assets/plugins/chartjs/chart.min.js') }}"></script>
<script src="{{ asset('admintemplate/assets/plugins/chartjs/chart-data.js') }}"></script>


@if (Route::is(['form-pickers']))
<script src="{{ asset('admintemplate/assets/plugins/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('admintemplate/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('admintemplate/assets/plugins/jquery-timepicker/jquery-timepicker.js') }}"></script>
<script src="{{ asset('admintemplate/assets/plugins/pickr/pickr.js') }}"></script>

<!-- Page JS -->
<script src="{{ asset('admintemplate/assets/js/forms-pickers.js') }}"></script>
@endif


@if (Route::is(['coming-soon']))
<script src="{{ asset('admintemplate/assets/js/coming-soon.js') }}"></script>
@endif

<script src="{{ asset('admintemplate/assets/js/email.js') }}"></script>
<script src="{{ asset('admintemplate/assets/js/kanban.js') }}"></script>
<script src="{{ asset('admintemplate/assets/js/invoice.js') }}"></script>
<script src="{{ asset('admintemplate/assets/js/projects.js') }}"></script>
<script src="{{ asset('admintemplate/assets/js/add-comments.js')}}"></script>
<script src="{{ asset('admintemplate/assets/js/file-manager.js') }}"></script>


<!-- Custom JS -->
<script src="{{ asset('admintemplate/assets/js/todo.js') }}"></script>
<script src="{{ asset('admintemplate/assets/js/theme-colorpicker.js') }}"></script>
<script src="{{ asset('admintemplate/assets/js/script.js') }}"></script>
