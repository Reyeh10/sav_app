<?php $page = 'register-3'; ?>

@extends('layout.mainlayout')

@section('content')

<div class="container-fluid">
    <div class="w-100 overflow-hidden position-relative flex-wrap d-block vh-100">

        <div class="row justify-content-center align-items-center vh-100 overflow-auto flex-wrap">
            <div class="col-md-4 mx-auto">

                <!-- ✅ Laravel Register Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="d-flex flex-column justify-content-center p-4">

                        <!-- ✅ Logo -->
                        <!--div class="mx-auto mb-3 text-center">
                            <img src="{ { asset('img/logo-stcd.jpg') }}"
                                 style="height:80px;"
                                 alt="Logo STCD">
                        </div-->

                        <!-- ✅ Title -->
                        <div class="text-center mb-3">
                            <h2 class="fw-bold mb-1">Créer un compte</h2>
                            <p class="text-muted mb-0">
                                Inscription au système SAV - STCD Motors
                            </p>
                        </div>

                        <!-- ✅ Name -->
                        <div class="mb-3">
                            <label class="form-label">Nom complet</label>
                            <div class="input-group">
                                <input type="text"
                                       name="name"
                                       class="form-control border-end-0"
                                       required>

                                <span class="input-group-text border-start-0">
                                    <i class="ti ti-user"></i>
                                </span>
                            </div>
                        </div>

                        <!-- ✅ Email -->
                        <div class="mb-3">
                            <label class="form-label">Adresse Email</label>
                            <div class="input-group">
                                <input type="email"
                                       name="email"
                                       class="form-control border-end-0"
                                       required>

                                <span class="input-group-text border-start-0">
                                    <i class="ti ti-mail"></i>
                                </span>
                            </div>
                        </div>

                        <!-- ✅ Password -->
                        <div class="mb-3">
                            <label class="form-label">Mot de passe</label>
                            <div class="pass-group">
                                <input type="password"
                                       name="password"
                                       class="form-control pass-input"
                                       required>

                                <span class="ti toggle-password ti-eye-off"></span>
                            </div>
                        </div>

                        <!-- ✅ Confirm Password -->
                        <div class="mb-3">
                            <label class="form-label">Confirmer mot de passe</label>
                            <div class="pass-group">
                                <input type="password"
                                       name="password_confirmation"
                                       class="form-control pass-input"
                                       required>

                                <span class="ti toggle-password ti-eye-off"></span>
                            </div>
                        </div>

                        <!-- ✅ Submit -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">
                                 S’inscrire
                            </button>
                        </div>

                        <!-- ✅ Login Link -->
                        <div class="text-center">
                            <small>
                                Déjà inscrit ?
                                <a href="{{ route('login') }}">Connexion</a>
                            </small>
                        </div>

                        <!-- ✅ Footer -->
                        <div class="mt-4 pb-2 text-center">
                            <p class="mb-0 text-gray-9">
                                © {{ date('Y') }} SAV Application - SmartHR Theme
                            </p>
                        </div>

                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

@endsection
