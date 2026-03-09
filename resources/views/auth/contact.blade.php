<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contactez-nous – Cabinet Médical</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('asset/css/style_login.css') }}">
<link rel="stylesheet" href="{{ asset('asset/css/style_contact.css') }}">
<link rel="icon" type="image/svg+xml" href="{{ asset('asset/img/logo.svg') }}">

</head>

<body>

<div class="card card--wide">

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
      <h2>Rejoignez<br><em>notre équipe</em></h2>
      <p>
        Vous êtes médecin ou professionnel de santé ?
        Contactez-nous pour intégrer le cabinet médical et accéder au système.
      </p>
    </div>

    <div class="contact-info-list">

      <div class="contact-info-item">
        <div class="contact-info-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <rect x="2" y="4" width="20" height="16" rx="3"/>
            <path d="m2 7 10 7 10-7"/>
          </svg>
        </div>
        <div class="contact-info-text">
          <span>E-mail</span>
          <small>contact@cabinetmedical.fr</small>
        </div>
      </div>

      <div class="contact-info-item">
        <div class="contact-info-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.65 3.38 2 2 0 0 1 3.62 1h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 8.91a16 16 0 0 0 6 6l.77-.77a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
          </svg>
        </div>
        <div class="contact-info-text">
          <span>Téléphone</span>
          <small>+212 5 22 00 00 00</small>
        </div>
      </div>

      <div class="contact-info-item">
        <div class="contact-info-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <circle cx="12" cy="10" r="3"/>
            <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 14 8 14s8-8.75 8-14a8 8 0 0 0-8-8z"/>
          </svg>
        </div>
        <div class="contact-info-text">
          <span>Adresse</span>
          <small>123 Rue de la Santé, Casablanca</small>
        </div>
      </div>

    </div>

  </div>


  <!-- RIGHT PANEL -->
  <div class="card-right">

    <div class="form-head">
      <h1>Contactez-nous</h1>
      <p>Remplissez le formulaire et nous vous répondrons rapidement</p>
    </div>

    {{-- Success message --}}
    @if (session('success'))
      <div class="alert-success">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
          <polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        Votre message a bien été envoyé. Nous vous contacterons dans les plus brefs délais.
      </div>
    @endif

    {{-- Error messages --}}
    @if ($errors->any())
      <div class="alert">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('contact.send') }}">

      @csrf

      <div class="fields">

        <div class="fields-row">

          <div class="field">
            <label for="prenom">Prénom</label>
            <div class="input-wrap">
              <input
                type="text"
                id="prenom"
                name="prenom"
                value="{{ old('prenom') }}"
                placeholder="Votre prénom"
                required>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
              </svg>
            </div>
          </div>

          <div class="field">
            <label for="nom">Nom</label>
            <div class="input-wrap">
              <input
                type="text"
                id="nom"
                name="nom"
                value="{{ old('nom') }}"
                placeholder="Votre nom"
                required>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
              </svg>
            </div>
          </div>

        </div>

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
          <label for="specialite">Spécialité médicale</label>
          <div class="input-wrap select-wrap">
            <select id="specialite" name="specialite" required>
              <option value="" disabled selected>Sélectionner votre spécialité</option>
              <option value="generaliste" {{ old('specialite') == 'generaliste' ? 'selected' : '' }}>Médecin généraliste</option>
              <option value="cardiologue" {{ old('specialite') == 'cardiologue' ? 'selected' : '' }}>Cardiologue</option>
              <option value="dermatologue" {{ old('specialite') == 'dermatologue' ? 'selected' : '' }}>Dermatologue</option>
              <option value="pediatre" {{ old('specialite') == 'pediatre' ? 'selected' : '' }}>Pédiatre</option>
              <option value="ophtalmologue" {{ old('specialite') == 'ophtalmologue' ? 'selected' : '' }}>Ophtalmologue</option>
              <option value="orthopediste" {{ old('specialite') == 'orthopediste' ? 'selected' : '' }}>Orthopédiste</option>
              <option value="neurologue" {{ old('specialite') == 'neurologue' ? 'selected' : '' }}>Neurologue</option>
              <option value="autre" {{ old('specialite') == 'autre' ? 'selected' : '' }}>Autre</option>
            </select>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M9 18l6-6-6-6"/>
            </svg>
          </div>
        </div>

        <div class="field">
          <label for="message">Message</label>
          <div class="textarea-wrap">
            <textarea
              id="message"
              name="message"
              placeholder="Présentez-vous et décrivez votre souhait de rejoindre notre cabinet..."
              required
              rows="4">{{ old('message') }}</textarea>
          </div>
        </div>

      </div>

      <button type="submit" class="btn-submit">

        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="22" y1="2" x2="11" y2="13"/>
          <polygon points="22 2 15 22 11 13 2 9 22 2"/>
        </svg>

        <span>Envoyer le message</span>

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
