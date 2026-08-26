<div class="header-premium d-flex justify-content-between align-items-center">

    <!-- Logo / Titre -->
    <div>

        <h4 class="header-main-title mb-1">
            STCD Motors
            <span class="text-light opacity-75">| Djibouti</span>
        </h4>

        <small class="header-sub-title">
            Gestion SAV & Véhicules
        </small>

    </div>

    <!-- Utilisateur -->
    <div class="dropdown">

        <button
            class="user-btn"
            type="button"
            data-bs-toggle="dropdown"
        >

            <div class="text-start">

                <div class="user-name">
                    {{ auth()->user()->name }}
                </div>

                <div class="user-status">
                    <span class="status-dot"></span>
                    Connecté
                </div>

            </div>

            <i class="ti ti-chevron-down ms-2"></i>

        </button>

        <ul class="dropdown-menu dropdown-menu-end shadow">

            <li>

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="dropdown-item text-danger"
                    >
                        <i class="ti ti-logout me-2"></i>
                        Déconnexion
                    </button>

                </form>

            </li>

        </ul>

    </div>

</div>
