<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion – Cabinet Médical</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/css/style_login.css') }}">
</head>
<body>

<div class="page-wrapper">

    <!-- ── Left decorative panel ── -->
    <div class="panel-left">
        <div class="brand">
            <div class="brand-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary)">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
                    <path d="M12 8v8M8 12h8"/>
                </svg>
            </div>
            <div class="brand-name">
                Cabinet Médical
                <span>Espace Patient</span>
            </div>
        </div>

        <div class="panel-hero">
            <h2>Votre santé,<br><em>notre priorité</em></h2>
            <p>Accédez à votre espace personnel pour gérer vos rendez-vous, ordonnances et suivis médicaux.</p>
        </div>

        <div class="features">
            <div class="feature-item">
                <div class="feature-dot"></div>
                Prise de rendez-vous en ligne
            </div>
            <div class="feature-item">
                <div class="feature-dot"></div>
                Ordonnances & résultats d'analyses
            </div>
            <div class="feature-item">
                <div class="feature-dot"></div>
                Messagerie sécurisée avec votre médecin
            </div>
            <div class="feature-item">
                <div class="feature-dot"></div>
                Dossier médical centralisé
            </div>
        </div>
    </div>

    <!-- ── Right form panel ── -->
    <div class="panel-right">

        <div class="form-header">
            <h1>Connexion</h1>
            <p>Bienvenue, veuillez vous identifier</p>
        </div>

        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="field">
                <label for="email">Adresse e-mail</label>
                <div class="input-wrap">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="prenom@exemple.fr"
                        required
                        autocomplete="email"
                    >
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="4" width="20" height="16" rx="3"/>
                        <path d="m2 7 10 7 10-7"/>
                    </svg>
                </div>
            </div>

            <div class="field">
                <label for="password">Mot de passe</label>
                <div class="input-wrap">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    >
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                </div>
            </div>

            <div class="row-remember">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember">
                    Se souvenir de moi
                </label>
                <a href="#" class="forgot-link">Mot de passe oublié ?</a>
            </div>

            <button type="submit" class="btn-submit">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                Se connecter
            </button>
        </form>

        <div class="form-footer">
            Pas encore de compte ? <a href="#">Contactez votre cabinet</a>
        </div>

    </div>
</div>

</body>
</html>
