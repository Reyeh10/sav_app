<div class="header-premium d-flex justify-content-between w-100 align-items-center">

    <!-- LEFT -->
    <div>
        <h5 class="header-main-title mb-0">STCD Motors | Djibouti</h5>
        <small class="header-sub-title">Gestion SAV & Véhicules</small>
    </div>

    <!-- RIGHT USER -->
    <div class="dropdown">

        <button class="user-btn"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">

            <div class="d-flex flex-column text-start">
                <span class="user-name">
                    {{ auth()->user()->name }}
                </span>
                <span class="user-status">
                    ● Connecté
                </span>
            </div>

            <!--span class="badge bg-light text-dark">
                { { auth()->user()->role }}
            </span-->

            <i class="ti ti-chevron-down"></i>
        </button>

        <!-- DROPDOWN MENU -->
        <ul class="dropdown-menu dropdown-menu-end user-dropdown shadow">

            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="dropdown-item text-danger fw-semibold">
                        <i class="ti ti-logout me-2"></i>
                        Déconnexion
                    </button>
                </form>
            </li>

        </ul>

    </div>

</div>
