@extends('layouts.guest')

@section('content')

<div class="account-content">
    <div class="container">

        <div class="account-box">
            <div class="account-wrapper">

                <h3 class="account-title text-warning">
                    Changer votre mot de passe
                </h3>

                <p class="account-subtitle">
                    Première connexion — Sécurité obligatoire
                </p>

                {{-- USER INFO --}}
                <div class="mb-3 text-start">
                    <label class="form-label fw-bold">Nom</label>
                    <input type="text"
                           class="form-control"
                           value="{{ auth()->user()->name }}"
                           readonly>
                </div>

                <div class="mb-3 text-start">
                    <label class="form-label fw-bold">Email</label>
                    <input type="text"
                           class="form-control"
                           value="{{ auth()->user()->email }}"
                           readonly>
                </div>

                {{-- FORM --}}
                <form method="POST" action="{{ route('force.password.save') }}">
                    @csrf

                    {{-- PASSWORD --}}
                    <div class="mb-3 text-start">
                        <label class="form-label">Nouveau mot de passe</label>

                        <input type="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               minlength="8"
                               pattern="(?=.*[A-Za-z])(?=.*\d).{8,}"
                               title="Minimum 8 caractères avec au moins 1 lettre et 1 chiffre"
                               required>

                        {{-- ERREUR LARAVEL --}}
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <small class="text-muted">
                            Minimum 8 caractères, au moins 1 lettre et 1 chiffre
                        </small>
                    </div>

                    {{-- CONFIRM PASSWORD --}}
                    <div class="mb-3 text-start">
                        <label class="form-label">Confirmer mot de passe</label>

                        <input type="password"
                               name="password_confirmation"
                               class="form-control"
                               minlength="8"
                               required>
                    </div>

                    <button class="btn btn-success w-100">
                        Enregistrer et entrer dans le système
                    </button>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection
