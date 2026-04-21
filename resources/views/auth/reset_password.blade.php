<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Réinitialiser le mot de passe – Cabinet Médical</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('asset/css/style_login.css') }}">
<link rel="stylesheet" href="{{ asset('asset/css/style_forgot_password.css') }}">
<link rel="icon" type="image/svg+xml" href="{{ asset('asset/img/logo.svg') }}">
</head>

<body>

<div class="card card--narrow">

  <!-- LEFT PANEL -->
  <div class="card-left">

    <div class="grid-deco"></div>

    <div class="logo">
      <div class="logo-mark">
        <img src="{{ asset('asset/img/logo.svg') }}" alt="Logo" style="width:100%;height:100%">
      </div>
      <div class="logo-text">
        Cabinet Médical
        <small>Système de gestion</small>
      </div>
    </div>

    <div class="hero">
      <h2>Nouveau<br><em>mot de passe</em></h2>
      <p>
        Choisissez un mot de passe sécurisé d'au moins 8 caractères
        pour protéger votre compte.
      </p>
    </div>

    <div class="pill-list">
      <div class="pill"><div class="pill-dot"></div> Au moins 8 caractères</div>
      <div class="pill"><div class="pill-dot"></div> Utilisez lettres et chiffres</div>
      <div class="pill"><div class="pill-dot"></div> Lien valable 60 minutes</div>
    </div>

  </div>

  <!-- RIGHT PANEL -->
  <div class="card-right">

    <div class="form-head">
      <h1>Réinitialiser</h1>
      <p>Saisissez votre nouveau mot de passe ci-dessous</p>
    </div>

    @if ($errors->any())
      <div class="alert">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
      @csrf

      {{-- Token caché transmis depuis le lien e-mail --}}
      <input type="hidden" name="token" value="{{ $token }}">

      <div class="fields">

        <div class="field">
          <label for="email">Adresse e-mail</label>
          <div class="input-wrap">
            <input
              type="email"
              id="email"
              name="email"
              value="{{ old('email', $email ?? '') }}"
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
          <label for="password">Nouveau mot de passe</label>
          <div class="input-wrap">
            <input
              type="password"
              id="password"
              name="password"
              placeholder="Minimum 8 caractères"
              required
              autocomplete="new-password">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <rect x="3" y="11" width="18" height="11" rx="2"/>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
          </div>
        </div>

        <div class="field">
          <label for="password_confirmation">Confirmer le mot de passe</label>
          <div class="input-wrap">
            <input
              type="password"
              id="password_confirmation"
              name="password_confirmation"
              placeholder="Répétez le mot de passe"
              required
              autocomplete="new-password">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <rect x="3" y="11" width="18" height="11" rx="2"/>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
          </div>
        </div>

      </div>

      <button type="submit" class="btn-submit">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
        <span>Réinitialiser le mot de passe</span>
      </button>

    </form>

    <div class="form-footer">
      <a href="{{ route('login') }}" class="back-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M19 12H5M5 12l7 7M5 12l7-7"/>
        </svg>
        Retour à la connexion
      </a>
    </div>

  </div>

</div>

</body>
</html>
