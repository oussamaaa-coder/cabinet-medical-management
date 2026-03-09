<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mot de passe oublié – Cabinet Médical</title>

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
      <h2>Récupérez<br><em>votre accès</em></h2>
      <p>
        Entrez votre adresse e-mail et nous vous enverrons
        les instructions pour réinitialiser votre mot de passe.
      </p>
    </div>

    <div class="pill-list">

      <div class="pill">
        <div class="pill-dot"></div>
        Lien sécurisé envoyé par e-mail
      </div>

      <div class="pill">
        <div class="pill-dot"></div>
        Valable pendant 60 minutes
      </div>

      <div class="pill">
        <div class="pill-dot"></div>
        Vérifiez aussi vos spams
      </div>

    </div>

  </div>


  <!-- RIGHT PANEL -->
  <div class="card-right">

    <div class="form-head">
      <h1>Mot de passe oublié</h1>
      <p>Saisissez votre adresse e-mail pour recevoir le lien de réinitialisation</p>
    </div>

    {{-- Success message --}}
    @if (session('status'))
      <div class="alert-success">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
          <polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        {{ session('status') }}
      </div>
    @endif

    {{-- Error messages --}}
    @if ($errors->any())
      <div class="alert">
        {{ $errors->first('email') }}
      </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">

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

      </div>

      <button type="submit" class="btn-submit">

        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="22" y1="2" x2="11" y2="13"/>
          <polygon points="22 2 15 22 11 13 2 9 22 2"/>
        </svg>

        <span>Envoyer le lien</span>

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
