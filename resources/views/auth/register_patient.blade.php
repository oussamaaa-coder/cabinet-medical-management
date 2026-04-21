<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Créer un compte Patient — Cabinet Médical</title>
<meta name="description" content="Inscrivez-vous pour accéder à votre espace patient: rendez-vous, ordonnances et dossier médical.">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="icon" type="image/svg+xml" href="{{ asset('asset/img/logo.svg') }}">

<style>
:root {
    --accent:      #2d8f6f;
    --accent-2:    #1a6e53;
    --accent-l:    #e4f4ed;
    --accent-glow: rgba(45,143,111,.15);
    --bg:          #eef4f1;
    --card:        #ffffff;
    --text:        #152820;
    --sub:         #4d7a68;
    --muted:       #7fa394;
    --border:      #d4e8df;
    --err:         #c0593a;
    --ease:        cubic-bezier(.4,0,.2,1);
}

*, *::before, *::after { box-sizing: border-box; margin:0; padding:0; }

body {
    font-family:'Outfit',sans-serif;
    background: var(--bg);
    min-height: 100vh;
    display: flex;
    align-items: stretch;
}

/* ── Left panel ── */
.left-panel {
    width: 40%;
    background: linear-gradient(145deg, var(--accent) 0%, var(--accent-2) 100%);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 48px 44px;
    position: relative;
    overflow: hidden;
}

.left-panel::before {
    content:''; position:absolute;
    top:-80px; right:-80px;
    width:280px; height:280px;
    border-radius:50%;
    background: rgba(255,255,255,.07);
}

.left-panel::after {
    content:''; position:absolute;
    bottom:40px; left:-60px;
    width:200px; height:200px;
    border-radius:50%;
    background: rgba(255,255,255,.05);
}

.logo {
    display:flex; align-items:center; gap:14px;
    animation: fadeDown 500ms var(--ease) both;
}

.logo-icon {
    width:48px; height:48px; border-radius:14px;
    background: rgba(255,255,255,.18);
    display:flex; align-items:center; justify-content:center;
}

.logo-icon svg { width:22px; height:22px; fill:none; stroke:#fff; stroke-width:2; stroke-linecap:round; stroke-linejoin:round; }
.logo-text { font-family:'Cormorant Garamond',serif; font-size:22px; font-weight:600; color:#fff; }
.logo-sub  { font-size:11px; color:rgba(255,255,255,.65); letter-spacing:.5px; text-transform:uppercase; margin-top:2px; }

.hero {
    position:relative; z-index:1;
    animation: fadeUp 500ms var(--ease) 80ms both;
}

.hero h2 {
    font-family:'Cormorant Garamond',serif;
    font-size:2.4rem; font-weight:600; line-height:1.2;
    color:#fff; margin-bottom:14px;
}

.hero h2 em { font-style:italic; color:rgba(255,255,255,.8); }

.hero p {
    font-size:14px; color:rgba(255,255,255,.75); line-height:1.7;
}

.features {
    display:flex; flex-direction:column; gap:10px;
    position:relative; z-index:1;
    animation: fadeUp 500ms var(--ease) 160ms both;
}

.feat {
    display:flex; align-items:center; gap:12px;
    background: rgba(255,255,255,.1);
    padding: 12px 16px; border-radius:12px;
    font-size:13.5px; color:#fff;
    backdrop-filter:blur(4px);
}

.feat-dot {
    width:8px; height:8px; border-radius:50%;
    background:#fff; flex-shrink:0; opacity:.8;
}

/* ── Right panel ── */
.right-panel {
    flex:1;
    display:flex; align-items:center; justify-content:center;
    padding: 40px 32px;
    overflow-y:auto;
}

.form-card {
    width:100%; max-width:480px;
    animation: fadeUp 420ms var(--ease) both;
}

.form-head { margin-bottom:28px; }
.form-head h1 { font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:600; color:var(--text); line-height:1.15; }
.form-head p  { font-size:14px; color:var(--muted); margin-top:5px; }

.field-grid   { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px; }
.field        { display:flex; flex-direction:column; gap:6px; }
.field.full   { grid-column:span 2; }

label { font-size:11.5px; font-weight:600; color:var(--sub); letter-spacing:.4px; text-transform:uppercase; }

input, select {
    width:100%; padding:11px 14px;
    background:var(--bg); color:var(--text);
    border:1.5px solid var(--border);
    border-radius:10px;
    font-family:'Outfit',sans-serif; font-size:14px;
    outline:none;
    transition: border-color 200ms var(--ease), box-shadow 200ms var(--ease);
}

input:focus, select:focus {
    border-color:var(--accent);
    box-shadow:0 0 0 3px var(--accent-glow);
}

select {
    appearance:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%237fa394' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat:no-repeat;
    background-position:right 14px center;
    padding-right:38px;
}

.btn-submit {
    width:100%; padding:13px;
    background:linear-gradient(135deg, var(--accent), var(--accent-2));
    color:#fff; border:none; border-radius:12px;
    font-family:'Outfit',sans-serif; font-size:15px; font-weight:600;
    cursor:pointer; display:flex; align-items:center; justify-content:center; gap:10px;
    box-shadow:0 4px 16px rgba(45,143,111,.35);
    transition: all 220ms var(--ease);
    margin-top:22px;
}

.btn-submit:hover { transform:translateY(-2px); box-shadow:0 6px 24px rgba(45,143,111,.45); filter:brightness(1.05); }
.btn-submit:active { transform:translateY(0); }
.btn-submit svg { width:17px; height:17px; fill:none; stroke:#fff; stroke-width:2; stroke-linecap:round; stroke-linejoin:round; }

.form-footer {
    text-align:center; margin-top:18px;
    font-size:13.5px; color:var(--muted);
}

.form-footer a { color:var(--accent); font-weight:600; text-decoration:none; }
.form-footer a:hover { text-decoration:underline; }

.alert-err {
    background:rgba(192,89,58,.08); color:var(--err);
    border:1px solid rgba(192,89,58,.2);
    padding:11px 16px; border-radius:10px;
    font-size:13px; margin-bottom:18px;
    display:flex; gap:8px; align-items:flex-start;
}

.alert-err ul { padding-left:18px; }
.alert-err svg { width:16px; height:16px; fill:none; stroke:currentColor; stroke-width:2; flex-shrink:0; margin-top:2px; }

.divider { display:flex; align-items:center; gap:12px; margin:20px 0; }
.divider::before, .divider::after { content:''; flex:1; height:1px; background:var(--border); }
.divider span { font-size:12px; color:var(--muted); white-space:nowrap; }

@keyframes fadeUp   { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }
@keyframes fadeDown { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }

@media (max-width:800px) {
    body { flex-direction:column; }
    .left-panel { width:100%; padding:32px 24px; }
    .hero h2 { font-size:1.8rem; }
    .features { display:none; }
    .field-grid { grid-template-columns:1fr; }
    .field.full { grid-column:span 1; }
}
</style>
</head>
<body>

{{-- Left panel --}}
<div class="left-panel">
    <div class="logo">
        <div class="logo-icon">
            <svg viewBox="0 0 24 24"><rect x="7" y="2" width="4" height="14" rx="1.5" fill="white"/><rect x="2" y="7" width="14" height="4" rx="1.5" fill="white"/></svg>
        </div>
        <div>
            <div class="logo-text">MediCal</div>
            <div class="logo-sub">Espace Patient</div>
        </div>
    </div>

    <div class="hero">
        <h2>Votre santé,<br><em>à portée de main</em></h2>
        <p>Créez votre espace patient pour accéder à votre dossier médical, prendre des rendez-vous et consulter vos ordonnances à tout moment.</p>
    </div>

    <div class="features">
        <div class="feat"><div class="feat-dot"></div> Prise de rendez-vous en ligne</div>
        <div class="feat"><div class="feat-dot"></div> Consultation des ordonnances</div>
        <div class="feat"><div class="feat-dot"></div> Accès à votre dossier médical</div>
        <div class="feat"><div class="feat-dot"></div> Suivi de vos consultations</div>
    </div>
</div>

{{-- Right panel --}}
<div class="right-panel">
<div class="form-card">

    <div class="form-head">
        <h1>Créer mon compte</h1>
        <p>Inscrivez-vous en quelques secondes.</p>
    </div>

    {{-- Errors --}}
    @if($errors->any())
    <div class="alert-err">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('register.patient.post') }}">
        @csrf

        <div class="field-grid">

            <div class="field full">
                <label for="name">Nom complet</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    placeholder="Prénom Nom" required autocomplete="name">
            </div>

            <div class="field full">
                <label for="email">Adresse e-mail</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    placeholder="vous@exemple.fr" required autocomplete="email">
            </div>

            <div class="field">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password"
                    placeholder="Min. 8 caractères" required autocomplete="new-password">
            </div>

            <div class="field">
                <label for="password_confirmation">Confirmer</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    placeholder="Répétez le mot de passe" required autocomplete="new-password">
            </div>

            <div class="field">
                <label for="phone">Téléphone (facultatif)</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                    placeholder="+212 6XX XXX XXX" autocomplete="tel">
            </div>

            <div class="field">
                <label for="birth_date">Date de naissance</label>
                <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
            </div>

            <div class="field full">
                <label for="gender">Genre</label>
                <select id="gender" name="gender">
                    <option value="">— Sélectionnez —</option>
                    <option value="Masculin" {{ old('gender') === 'Masculin' ? 'selected' : '' }}>Masculin</option>
                    <option value="Féminin"  {{ old('gender') === 'Féminin'  ? 'selected' : '' }}>Féminin</option>
                </select>
            </div>

        </div>

        <button type="submit" class="btn-submit">
            <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
            Créer mon compte patient
        </button>
    </form>

    <div class="divider"><span>Déjà inscrit ?</span></div>

    <div class="form-footer">
        <a href="{{ route('login') }}">Connectez-vous à votre espace</a>
    </div>

</div>
</div>

</body>
</html>
