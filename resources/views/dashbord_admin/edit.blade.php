<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MediCal — Modifier Utilisateur</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
  :root {
    --deep: #0a1628; --navy: #112240; --teal: #0d9488; --teal-light: #14b8a6;
    --cream: #f8f4ef; --warm: #fef9f4; --text: #1e293b; --muted: #64748b;
    --border: #e2e8f0; --white: #ffffff; --accent: #f59e0b; --danger: #ef4444;
    --success: #10b981; --purple: #7c3aed; --blue: #3b82f6;
  }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'DM Sans', sans-serif; background: var(--warm); color: var(--text); min-height: 100vh; }

  .sidebar { position: fixed; left: 0; top: 0; width: 260px; height: 100vh; background: var(--deep); display: flex; flex-direction: column; z-index: 100; padding: 0 0 24px; }
  .sidebar-logo { padding: 32px 28px 28px; border-bottom: 1px solid rgba(255,255,255,0.08); }
  .sidebar-logo .logo-text { font-family: 'Cormorant Garamond', serif; font-size: 28px; font-weight: 600; color: var(--white); }
  .sidebar-logo .logo-sub { font-size: 11px; color: var(--teal-light); letter-spacing: 0.12em; text-transform: uppercase; margin-top: 2px; }
  .sidebar-nav { flex: 1; padding: 24px 16px; display: flex; flex-direction: column; gap: 4px; }
  .nav-section-label { font-size: 10px; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.3); padding: 16px 12px 8px; font-weight: 500; }
  .nav-item { display: flex; align-items: center; gap: 12px; padding: 11px 14px; border-radius: 10px; cursor: pointer; transition: all 0.2s ease; color: rgba(255,255,255,0.55); font-size: 14px; font-weight: 400; border: none; background: none; width: 100%; text-align: left; text-decoration: none; }
  .nav-item:hover { background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.85); }
  .nav-item.active { background: rgba(13,148,136,0.2); color: var(--teal-light); }
  .nav-item .nav-icon { width: 18px; text-align: center; flex-shrink: 0; }
  .sidebar-user { padding: 20px 20px 0; border-top: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; gap: 12px; }
  .user-avatar-sm { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--teal), #0369a1); display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 600; color: white; flex-shrink: 0; }
  .user-info .user-name { font-size: 13px; font-weight: 500; color: white; }
  .user-info .user-role { font-size: 11px; color: rgba(255,255,255,0.4); margin-top: 1px; }

  .main { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; }
  .topbar { background: var(--white); border-bottom: 1px solid var(--border); padding: 0 36px; height: 68px; display: flex; align-items: center; position: sticky; top: 0; z-index: 50; }
  .topbar-left { display: flex; align-items: center; gap: 16px; }
  .topbar-title { font-family: 'Cormorant Garamond', serif; font-size: 22px; font-weight: 500; color: var(--deep); }
  .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--muted); }
  .breadcrumb a { color: var(--teal); text-decoration: none; }
  .breadcrumb a:hover { text-decoration: underline; }

  .content { padding: 32px 36px; flex: 1; display: flex; justify-content: center; }

  .form-card { background: var(--white); border-radius: 20px; border: 1px solid var(--border); width: 100%; max-width: 640px; animation: fadeIn 0.4s ease both; }
  .form-card-header { padding: 28px 32px 24px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 14px; }
  .form-card-icon { width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; }
  .form-card-title { font-family: 'Cormorant Garamond', serif; font-size: 22px; font-weight: 500; color: var(--deep); }
  .form-card-subtitle { font-size: 13px; color: var(--muted); margin-top: 2px; }
  .form-card-body { padding: 28px 32px; }
  .form-card-footer { padding: 20px 32px 28px; border-top: 1px solid var(--border); display: flex; gap: 12px; justify-content: flex-end; }

  .form-group { margin-bottom: 20px; }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
  .form-label { display: block; font-size: 12px; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 8px; }
  .form-input, .form-select { width: 100%; padding: 11px 14px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-family: 'DM Sans', sans-serif; color: var(--text); background: var(--warm); transition: all 0.15s; outline: none; }
  .form-input:focus, .form-select:focus { border-color: var(--teal); background: white; box-shadow: 0 0 0 3px rgba(13,148,136,0.1); }
  .form-input.error { border-color: var(--danger); }
  .form-error { font-size: 11px; color: var(--danger); margin-top: 6px; display: flex; align-items: center; gap: 4px; }
  .form-hint { font-size: 11px; color: var(--muted); margin-top: 6px; }

  .role-options { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
  .role-option { position: relative; cursor: pointer; }
  .role-option input { position: absolute; opacity: 0; width: 0; height: 0; }
  .role-option-card { padding: 14px 16px; border-radius: 12px; border: 2px solid var(--border); transition: all 0.2s; display: flex; align-items: center; gap: 10px; background: var(--warm); }
  .role-option input:checked + .role-option-card { border-color: var(--teal); background: rgba(13,148,136,0.05); box-shadow: 0 0 0 3px rgba(13,148,136,0.1); }
  .role-option-card:hover { border-color: var(--teal-light); }
  .role-option-icon { font-size: 20px; }
  .role-option-name { font-size: 13px; font-weight: 600; color: var(--deep); }
  .role-option-desc { font-size: 11px; color: var(--muted); }

  .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 500; cursor: pointer; border: none; transition: all 0.2s ease; font-family: 'DM Sans', sans-serif; text-decoration: none; }
  .btn-primary { background: var(--teal); color: white; }
  .btn-primary:hover { background: #0b7a72; transform: translateY(-1px); box-shadow: 0 4px 16px rgba(13,148,136,0.35); }
  .btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text); }
  .btn-outline:hover { background: var(--warm); }

  .user-edit-banner { display: flex; align-items: center; gap: 16px; padding: 20px; background: var(--warm); border-radius: 14px; margin-bottom: 24px; border: 1px solid var(--border); }
  .user-edit-avatar { width: 52px; height: 52px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; color: white; flex-shrink: 0; }
  .avatar-admin { background: linear-gradient(135deg, #7c3aed, #a855f7); }
  .avatar-doctor { background: linear-gradient(135deg, #0d9488, #0369a1); }
  .avatar-nurse { background: linear-gradient(135deg, #3b82f6, #6366f1); }
  .avatar-secretary { background: linear-gradient(135deg, #f59e0b, #ef4444); }
  .user-edit-name { font-weight: 600; color: var(--deep); font-size: 15px; }
  .user-edit-email { font-size: 12px; color: var(--muted); margin-top: 2px; }
  .user-edit-id { font-size: 11px; color: var(--teal); margin-top: 2px; font-weight: 500; }

  .alert-errors { background: rgba(239,68,68,0.06); border: 1px solid rgba(239,68,68,0.2); border-radius: 12px; padding: 16px 20px; margin-bottom: 24px; }
  .alert-errors-title { font-size: 13px; font-weight: 600; color: var(--danger); margin-bottom: 8px; display: flex; align-items: center; gap: 6px; }
  .alert-errors ul { list-style: none; padding: 0; }
  .alert-errors li { font-size: 12px; color: var(--danger); padding: 3px 0; padding-left: 16px; position: relative; }
  .alert-errors li::before { content: '•'; position: absolute; left: 4px; }

  @keyframes fadeIn { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
</style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-text">MediCal</div>
    <div class="logo-sub">Cabinet Médical</div>
  </div>
  <nav class="sidebar-nav">
    <span class="nav-section-label">Principal</span>
    <a class="nav-item" href="{{ route('dashboard') }}"><span class="nav-icon">🏠</span> Tableau de bord</a>
    <a class="nav-item" href="{{ route('appointments.index') }}"><span class="nav-icon">📅</span> Rendez-vous</a>
    <a class="nav-item" href="{{ route('patients.index') }}"><span class="nav-icon">👥</span> Patients</a>
    <a class="nav-item" href="{{ route('doctors.index') }}"><span class="nav-icon">🩺</span> Médecins</a>
    <span class="nav-section-label">Administration</span>
    <a class="nav-item active" href="{{ route('utilisateurs.index') }}"><span class="nav-icon">🔐</span> Gestion Utilisateurs</a>
    <span class="nav-section-label">Paramètres</span>
    <a class="nav-item" href="#"><span class="nav-icon">⚙️</span> Configuration</a>
  </nav>
  <div class="sidebar-user">
    <div class="user-avatar-sm">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
    <div class="user-info">
      <div class="user-name">{{ auth()->user()->name }}</div>
      <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
    </div>
  </div>
</aside>

<!-- MAIN -->
<main class="main">
  <header class="topbar">
    <div class="topbar-left">
      <div class="topbar-title">Modifier Utilisateur</div>
      <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a><span>›</span>
        <a href="{{ route('utilisateurs.index') }}">Utilisateurs</a><span>›</span>
        <span>{{ $utilisateur->name }}</span><span>›</span>
        <span>Modifier</span>
      </div>
    </div>
  </header>

  <div class="content">
    <div class="form-card">
      <div class="form-card-header">
        <div class="form-card-icon" style="background: rgba(245,158,11,0.1);">✏️</div>
        <div>
          <div class="form-card-title">Modifier l'utilisateur</div>
          <div class="form-card-subtitle">Mettez à jour les informations de cet utilisateur</div>
        </div>
      </div>

      <form method="POST" action="{{ route('utilisateurs.update', $utilisateur) }}">
        @csrf
        @method('PUT')
        <div class="form-card-body">

          <!-- User banner -->
          <div class="user-edit-banner">
            <div class="user-edit-avatar avatar-{{ $utilisateur->role }}">{{ strtoupper(substr($utilisateur->name, 0, 2)) }}</div>
            <div>
              <div class="user-edit-name">{{ $utilisateur->name }}</div>
              <div class="user-edit-email">{{ $utilisateur->email }}</div>
              <div class="user-edit-id">#U-{{ str_pad($utilisateur->id, 4, '0', STR_PAD_LEFT) }} · Créé le {{ $utilisateur->created_at ? $utilisateur->created_at->format('d/m/Y') : '—' }}</div>
            </div>
          </div>

          @if($errors->any())
          <div class="alert-errors">
            <div class="alert-errors-title">⚠️ Des erreurs ont été détectées</div>
            <ul>
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif

          <div class="form-group">
            <label class="form-label">Nom complet</label>
            <input type="text" name="name" class="form-input {{ $errors->has('name') ? 'error' : '' }}" value="{{ old('name', $utilisateur->name) }}" required>
            @error('name') <div class="form-error">⚠ {{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label class="form-label">Adresse email</label>
            <input type="email" name="email" class="form-input {{ $errors->has('email') ? 'error' : '' }}" value="{{ old('email', $utilisateur->email) }}" required>
            @error('email') <div class="form-error">⚠ {{ $message }}</div> @enderror
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Nouveau mot de passe</label>
              <input type="password" name="password" class="form-input {{ $errors->has('password') ? 'error' : '' }}" placeholder="Laisser vide pour ne pas changer">
              @error('password') <div class="form-error">⚠ {{ $message }}</div> @enderror
              <div class="form-hint">💡 Laisser vide pour conserver le mot de passe actuel</div>
            </div>
            <div class="form-group">
              <label class="form-label">Confirmation</label>
              <input type="password" name="password_confirmation" class="form-input" placeholder="Confirmer le mot de passe">
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Rôle</label>
            <div class="role-options">
              <label class="role-option">
                <input type="radio" name="role" value="admin" {{ old('role', $utilisateur->role) === 'admin' ? 'checked' : '' }}>
                <div class="role-option-card">
                  <span class="role-option-icon">🔐</span>
                  <div>
                    <div class="role-option-name">Administrateur</div>
                    <div class="role-option-desc">Accès complet</div>
                  </div>
                </div>
              </label>
              <label class="role-option">
                <input type="radio" name="role" value="doctor" {{ old('role', $utilisateur->role) === 'doctor' ? 'checked' : '' }}>
                <div class="role-option-card">
                  <span class="role-option-icon">🩺</span>
                  <div>
                    <div class="role-option-name">Médecin</div>
                    <div class="role-option-desc">Gestion patients</div>
                  </div>
                </div>
              </label>
              <label class="role-option">
                <input type="radio" name="role" value="nurse" {{ old('role', $utilisateur->role) === 'nurse' ? 'checked' : '' }}>
                <div class="role-option-card">
                  <span class="role-option-icon">💉</span>
                  <div>
                    <div class="role-option-name">Infirmier</div>
                    <div class="role-option-desc">Soins & suivi</div>
                  </div>
                </div>
              </label>
              <label class="role-option">
                <input type="radio" name="role" value="secretary" {{ old('role', $utilisateur->role) === 'secretary' ? 'checked' : '' }}>
                <div class="role-option-card">
                  <span class="role-option-icon">📋</span>
                  <div>
                    <div class="role-option-name">Secrétaire</div>
                    <div class="role-option-desc">Rendez-vous</div>
                  </div>
                </div>
              </label>
            </div>
            @error('role') <div class="form-error">⚠ {{ $message }}</div> @enderror
          </div>
        </div>

        <div class="form-card-footer">
          <a href="{{ route('utilisateurs.index') }}" class="btn btn-outline">← Retour</a>
          <button type="submit" class="btn btn-primary">💾 Enregistrer les modifications</button>
        </div>
      </form>
    </div>
  </div>
</main>

</body>
</html>
