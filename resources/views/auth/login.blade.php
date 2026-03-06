<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Connexion – Cabinet Médical</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('asset/css/style_login.css') }}">
<link rel="icon" type="image/svg+xml" href="{{ asset('asset/img/logo.svg') }}">

</head>

<body>

<div class="card">

<!-- LEFT PANEL -->
<div class="card-left">

<div class="grid-deco"></div>

<div class="logo">
<div class="logo-mark">
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
<path d="M12 8v8M8 12h8"/>
</svg>
</div>

<div class="logo-text">
Cabinet Médical
<small>Système de gestion</small>
</div>
</div>

<div class="hero">
<h2>Gestion du cabinet,<br><em>simple et efficace</em></h2>
<p>
Accédez au système interne pour gérer les patients,
les rendez-vous et l'organisation du cabinet médical.
</p>
</div>

<div class="pill-list">

<div class="pill">
<div class="pill-dot"></div>
Gestion des patients
</div>

<div class="pill">
<div class="pill-dot"></div>
Gestion des rendez-vous
</div>

<div class="pill">
<div class="pill-dot"></div>
Suivi des consultations
</div>

<div class="pill">
<div class="pill-dot"></div>
Organisation du cabinet médical
</div>

</div>

</div>


<!-- RIGHT PANEL -->
<div class="card-right">

<div class="form-head">
<h1>Connexion</h1>
<p>Bienvenue, veuillez vous identifier</p>
</div>

@if (session('error'))
<div class="alert">
{{ session('error') }}
</div>
@endif

@if ($errors->any())
<div class="alert">
{{ $errors->first() }}
</div>
@endif

<form method="POST" action="{{ route('login.post') }}">

@csrf

<div class="fields">

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
autocomplete="email">

<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
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
autocomplete="current-password">

<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
<rect x="3" y="11" width="18" height="11" rx="2"/>
<path d="M7 11V7a5 5 0 0 1 10 0v4"/>
</svg>

</div>
</div>

</div>


<div class="row-opts">

<label class="check-label">
<input type="checkbox" name="remember">
Se souvenir de moi
</label>

<a href="#" class="forgot">
Mot de passe oublié ?
</a>

</div>


<button type="submit" class="btn">

<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
<path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
<polyline points="10 17 15 12 10 7"/>
<line x1="15" y1="12" x2="3" y2="12"/>
</svg>

<span>Se connecter</span>

</button>

</form>

<div class="form-footer">
Vous êtes un nouveau docteur ?
<a href="#">Contactez nous</a>
</div>

</div>

</div>

</body>
</html>
