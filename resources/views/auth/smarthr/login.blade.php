<?php $page = 'login-3'; ?>

@extends('layout.mainlayout')

@section('content')

<div class="login-wrapper d-flex align-items-center justify-content-center">

    <div class="login-container">

        <div class="card login-card shadow-lg border-0">

            <div class="card-body p-4">

                <!-- ================= TITLE ================= -->
                <div class="text-center mb-4">
                    <h2 class="fw-bold mb-2 text-orange">
                        Connexion
                    </h2>

                    <p class="text-muted mb-0">
                        Accéder au système SAV — STCD Motors
                    </p>
                </div>

                <!-- ================= FORM ================= -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- EMAIL -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Adresse Email
                        </label>

                        <div class="input-group">
                            <input type="email"
                                   name="email"
                                   class="form-control login-input"
                                   placeholder="email@stcd.com"
                                   required>

                            <span class="input-group-text">
                                <i class="ti ti-mail"></i>
                            </span>
                        </div>
                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Mot de passe
                        </label>

                        <div class="pass-group position-relative">
                            <input type="password"
                                   name="password"
                                   class="pass-input form-control login-input"
                                   placeholder="********"
                                   required>

                            <span class="ti toggle-password ti-eye-off password-toggle"></span>
                        </div>
                    </div>

                    <!-- REMEMBER + FORGOT -->
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

                        <div class="form-check">
                            <input type="checkbox"
                                   name="remember"
                                   class="form-check-input"
                                   id="remember_me">

                            <label class="form-check-label" for="remember_me">
                                Se souvenir de moi
                            </label>
                        </div>

                        <a href="#" class="forgot-link">
                            Mot de passe oublié ?
                        </a>

                    </div>

                    <!-- SUBMIT -->
                    <button type="submit"
                            class="btn btn-login-green w-100 mb-3">
                        Se connecter
                    </button>

                    <!-- REGISTER -->
                    <div class="text-center">
                        <small class="text-muted">
                            Pas encore de compte ?
                            <a href="{{ route('register') }}"
                               class="register-link fw-semibold">
                                Créer un compte
                            </a>
                        </small>
                    </div>

                </form>

            </div>

            <!-- FOOTER -->
            <div class="text-center pb-3">
                <small class="text-muted">
                    © {{ date('Y') }} STCD Motors — SAV Application
                </small>
            </div>

        </div>

    </div>

</div>

@endsection
