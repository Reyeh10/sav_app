@extends('layouts.guest')

@section('content')
<div class="account-content">
    <div class="container">
        <div class="account-box">
            <div class="account-wrapper">
                <h3 class="account-title">Créer un compte</h3>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="form-group">
                        <label>Nom</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

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

                    <!-- Confirm -->
                    <div class="form-group">
                        <label>Confirmer</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <button class="btn btn-success w-100" type="submit">
                        S’inscrire
                    </button>

                    <div class="text-center mt-3">
                        Déjà inscrit ?
                        <a href="{{ route('login') }}">Connexion</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
