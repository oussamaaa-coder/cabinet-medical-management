<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion – Cabinet Médical</title>
</head>
<body>
    <h1>Connexion</h1>

    @if (session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    @if ($errors->any())
        <p style="color:red">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <label>Email
            <input type="email" name="email" value="{{ old('email') }}" required>
        </label>
        <br>
        <label>Mot de passe
            <input type="password" name="password" required>
        </label>
        <br>
        <label>
            <input type="checkbox" name="remember"> Se souvenir de moi
        </label>
        <br>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>