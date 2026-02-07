<!DOCTYPE html>
<html lang="fr">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <title>SAV Application</title>

            {{-- ✅ Template CSS --}}
            @include('layout.partials.head')

            {{-- ✅ Custom Fix CSS (Always Last) --}}
            <link rel="stylesheet" href="{{ asset('admintemplate/assets/css/custom.css') }}">
        </head>

        <body>

            <div class="main-wrapper">

                {{-- ✅ HEADER + SIDEBAR seulement si connecté --}}
                @auth
                    @include('layout.partials.header')
                    @include('layout.partials.sidebar')
                @endauth

                {{-- ✅ CONTENU --}}
                <div class="content container-fluid px-2">
                    @yield('content')
                </div>

            </div>

            {{-- ✅ Footer --}}
            @include('layout.partials.footer')

            {{-- ✅ Scripts Template --}}
            @include('layout.partials.footer-scripts')

            {{-- ✅ Activation Select2 --}}
            <!--script>
                $(document).ready(function () {
                    $('.customer-select').select2({
                        placeholder: "-- Sélectionner un client --",
                        allowClear: true,
                        width: '100%'
                    });
                });

            </script-->
            <script>
                    $(document).ready(function () {

                        // ✅ Client Select2
                        $('.customer-select').select2({
                            placeholder: "-- Sélectionner un client --",
                            allowClear: true,
                            width: "100%"
                        });

                        // ✅ Vehicle Select2
                        $('.vehicle-select').select2({
                            placeholder: "-- Sélectionner une voiture --",
                            allowClear: true,
                            width: "100%"
                        });

                    });
            </script>
            


        </body>
</html>
