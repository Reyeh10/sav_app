<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion – STCD Motors</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ✅ Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            margin: 0;
            height: 100vh;
            background: url('{{ asset("images/GWM.jpg") }}') no-repeat center center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
            position: relative;
        }

        /* Overlay sombre */
        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(3px);
        }

        .logo-top {
            position: absolute;
            top: 25px;
            right: 40px;
            z-index: 10;
        }

        .logo-top img {
            height: 100px;
        }

        .login-card {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 420px;
            padding: 40px;
            border-radius: 20px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(15px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.4);
            color: #fff;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px);}
            to { opacity: 1; transform: translateY(0);}
        }

        .login-card h3 {
            font-weight: 600;
            text-align: center;
            margin-bottom: 10px;
        }

        .login-card p {
            text-align: center;
            font-size: 14px;
            margin-bottom: 30px;
            color: #ddd;
        }

        .form-control {
            border-radius: 10px;
            border: none;
            padding: 12px;
        }

        .btn-login {
            background: linear-gradient(135deg, #16c172, #0fb65f);
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 10px;
            transition: 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(22,193,114,0.5);
        }

        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #ccc;
        }

        /* ================== PASSWORD TOGGLE (PROPRE) ================== */
        .password-wrap{
            position: relative;
        }

        .password-wrap .form-control{
            padding-right: 52px;
        }

        .password-toggle{
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: none;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(6px);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            padding: 0;
        }

        .password-toggle:hover{
            background: rgba(255,255,255,0.20);
        }

        .password-toggle i,
        .password-toggle span{
            font-size: 18px;
            color: #fff;
            line-height: 1;
        }

        /* Fallback emoji caché par défaut */
        #toggleFallback{
            display: none;
        }
    </style>
</head>

<body>

<!-- Logo en haut à droite -->
<div class="logo-top">
    <img src="{{ asset('images/stcd.jpg') }}" alt="STCD Logo">
</div>

<div class="login-card">

    <h3>Connexion</h3>
    <p>Accéder au système SAV – STCD Motors</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Adresse Email" required>
        </div>

        <!-- ✅ Champ mot de passe + bouton œil -->
            <div class="mb-3 position-relative">
                <input type="password"
                    id="password"
                    name="password"
                    class="form-control pe-5"
                    placeholder="Mot de passe"
                    required>

                <button type="button"
                        id="togglePassword"
                        aria-label="Afficher/Masquer le mot de passe"
                        style="position:absolute;
                            right:12px;
                            top:50%;
                            transform:translateY(-50%);
                            background:transparent;
                            border:none;
                            cursor:pointer;">
                    <i class="bi bi-eye" id="toggleIcon"></i>
                </button>
            </div>

        <button type="submit" class="btn btn-login w-100">
            Se connecter
        </button>

    </form>

    <div class="footer-text">
        © 2026 STCD Motors — SAV Application
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const passwordInput = document.getElementById("password");
    const toggleBtn = document.getElementById("togglePassword");
    const icon = document.getElementById("toggleIcon");

    toggleBtn.addEventListener("click", function () {

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            passwordInput.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }

    });

});
</script>

</body>
</html>
