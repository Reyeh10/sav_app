<!-- ================= PREMIUM CLEAN HEADER ================= -->
<div class="header header-premium">

    <div class="container-fluid">

        <div class="d-flex align-items-center justify-content-between">

            <!-- ===== LEFT : PAGE TITLE ===== -->
            <div class="header-left-block">

                <h4 class="header-main-title mb-0">
                    STCD Motors | Djibouti
                </h4>

                <span class="header-sub-title">
                    Gestion SAV & Véhicules
                </span>

            </div>


            <!-- ===== RIGHT : USER INFO ===== -->
            <div class="header-user-box d-flex align-items-center">

                <!-- ROLE -->
                <!--span class="header-role">
                    { { ucfirst(auth()->user()->role ?? 'User') }}
                </span-->

                <!-- AVATAR -->
                <img src="{{ asset('admintemplate/assets/img/profiles/avatar-02.jpg') }}"
                     class="header-avatar">

                <!-- USER INFO -->
                <div class="header-user-text">
                    <div class="header-username">
                        {{ auth()->user()->name ?? 'Utilisateur' }}
                    </div>

                    <small class="header-user-status">
                        Connecté
                    </small>
                </div>

                <!-- DROPDOWN -->
                <div class="dropdown ms-2">

                    <a href="#" data-bs-toggle="dropdown" class="header-dropdown-arrow">
                        ▼
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">

                        <li>
                            <a class="dropdown-item" href="#">
                                Profil
                            </a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <a class="dropdown-item text-danger"
                               href="#"
                               onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                                Déconnexion
                            </a>
                        </li>

                    </ul>

                </div>

                <!-- LOGOUT FORM -->
                <form id="logout-form"
                      action="{{ route('logout') }}"
                      method="POST"
                      class="d-none">
                    @csrf
                </form>

            </div>

        </div>

    </div>

</div>
