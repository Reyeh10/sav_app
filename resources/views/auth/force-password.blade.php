<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Changer mot de passe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            height: 100vh;
            background: linear-gradient(135deg, #ff7a00, #ff5500);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .card-box {
            width: 100%;
            max-width: 500px;
            background: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px);}
            to { opacity: 1; transform: translateY(0);}
        }

        .title {
            text-align: center;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
        }

        .btn-save {
            background: linear-gradient(135deg, #16c172, #0fb65f);
            border: none;
            font-weight: 600;
            padding: 12px;
            border-radius: 8px;
            transition: 0.3s;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(22,193,114,0.4);
        }
    </style>
</head>

<body>

<div class="card-box">

    <h3 class="title">🔐 Changer votre mot de passe</h3>
    <div class="subtitle">Première connexion — Sécurité obligatoire</div>

    <form method="POST" action="{{ route('force.password.save') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="text" class="form-control" value="{{ auth()->user()->email }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Nouveau mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-4">
            <label class="form-label">Confirmer mot de passe</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-save w-100">
            Enregistrer et entrer dans le système
        </button>

    </form>

</div>

</body>
</html>
