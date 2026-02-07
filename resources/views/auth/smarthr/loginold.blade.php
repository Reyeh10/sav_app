@extends('layouts.guest')

@section('content')
<div class="account-content">
    <div class="container">
        <div class="account-box">
            <div class="account-wrapper">
                <h3 class="account-title">Connexion</h3>
                <p class="account-subtitle">Accéder au système SAV</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label>Mot de passe</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <!-- Remember -->
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="remember">
                            Se souvenir de moi
                        </label>
                    </div>

                    <button class="btn btn-primary w-100" type="submit">
                        Se connecter
                    </button>

                    <div class="text-center mt-3">
                        Pas de compte ?
                        <a href="{{ route('register') }}">Créer un compte</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
