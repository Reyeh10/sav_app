<ul class="nav-menu">

    {{-- Menu visible seulement si NON connecté --}}
    @include('layout.partials.menu-auth')

    {{-- Menu visible seulement si connecté --}}
    @include('layout.partials.menu-user')

</ul>
