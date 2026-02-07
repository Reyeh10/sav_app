<div class="dropdown ms-auto">

    <a href="#" class="d-flex align-items-center dropdown-toggle"
       data-bs-toggle="dropdown">

        <span class="avatar avatar-sm online">
            <img src="{{ asset('admintemplate/assets/img/profiles/avatar-12.jpg') }}">
        </span>
    </a>

    <div class="dropdown-menu dropdown-menu-end shadow">

        <a class="dropdown-item" href="#">
            <i class="ti ti-user-circle"></i> Mon Profil
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item">
                <i class="ti ti-power"></i> Déconnexion
            </button>
        </form>

    </div>
</div>
