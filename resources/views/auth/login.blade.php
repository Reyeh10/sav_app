@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="account-content">

    <div class="login-wrapper">
        <div class="loginbox">

            <div class="login-auth">
                <h3>Sign In</h3>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="input-block">
                        <label>Email</label>
                        <input type="email" name="email" required>
                    </div>

                    <div class="input-block">
                        <label>Password</label>
                        <input type="password" name="password" required>
                    </div>

                    <button class="btn btn-primary w-100">
                        Login
                    </button>
                </form>

            </div>

        </div>
    </div>
</div>
@endsection
