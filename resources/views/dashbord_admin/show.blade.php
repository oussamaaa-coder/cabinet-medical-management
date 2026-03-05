<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MediCal — Détails Utilisateur</title>
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
  .topbar { background: var(--white); border-bottom: 1px solid var(--border); padding: 0 36px; height: 68px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
  .topbar-left { display: flex; align-items: center; gap: 16px; }
  .topbar-title { font-family: 'Cormorant Garamond', serif; font-size: 22px; font-weight: 500; color: var(--deep); }
  .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--muted); }
  .breadcrumb a { color: var(--teal); text-decoration: none; }
  .breadcrumb a:hover { text-decoration: underline; }

  .topbar-actions { display: flex; align-items: center; gap: 10px; }

  .content { padding: 32px 36px; flex: 1; display: flex; justify-content: center; }

  .btn { display: inline-flex; align-items: center; gap: 8px; padding: 9px 18px; border-radius: 10px; font-size: 13px; font-weight: 500; cursor: pointer; border: none; transition: all 0.2s ease; font-family: 'DM Sans', sans-serif; text-decoration: none; }
  .btn-primary { background: var(--teal); color: white; }
  .btn-primary:hover { background: #0b7a72; transform: translateY(-1px); box-shadow: 0 4px 16px rgba(13,148,136,0.35); }
  .btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text); }
  .btn-outline:hover { background: var(--warm); }

  .profile-card { background: var(--white); border-radius: 20px; border: 1px solid var(--border); width: 100%; max-width: 580px; overflow: hidden; animation: fadeIn 0.4s ease both; }

  .profile-hero {
    background: linear-gradient(135deg, var(--deep), #1e3a5f);
    padding: 40px 32px 32px;
    text-align: center;
    position: relative;
    overflow: hidden;
  }

  .profile-hero::before {
    content: '';
    position: absolute;
    top: -50%; left: -50%;
    width: 200%; height: 200%;
    background: radial-gradient(ellipse at center, rgba(13,148,136,0.15) 0%, transparent 60%);
    pointer-events: none;
  }

  .profile-avatar {
    width: 80px; height: 80px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 28px; font-weight: 700; color: white;
    margin: 0 auto 16px;
    border: 3px solid rgba(255,255,255,0.2);
    position: relative;
    z-index: 1;
  }
  .avatar-admin { background: linear-gradient(135deg, #7c3aed, #a855f7); }
  .avatar-doctor { background: linear-gradient(135deg, #0d9488, #0369a1); }
  .avatar-nurse { background: linear-gradient(135deg, #3b82f6, #6366f1); }
  .avatar-secretary { background: linear-gradient(135deg, #f59e0b, #ef4444); }

  .profile-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 26px; font-weight: 600; color: white;
    margin-bottom: 4px; position: relative; z-index: 1;
  }

  .profile-email {
    font-size: 13px; color: rgba(255,255,255,0.6);
    position: relative; z-index: 1;
  }

  .role-badge {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 12px; font-weight: 600; padding: 6px 16px;
    border-radius: 20px; margin-top: 12px;
    position: relative; z-index: 1;
  }
  .role-admin { background: rgba(124,58,237,0.2); color: #c4b5fd; border: 1px solid rgba(124,58,237,0.3); }
  .role-doctor { background: rgba(13,148,136,0.2); color: var(--teal-light); border: 1px solid rgba(13,148,136,0.3); }
  .role-nurse { background: rgba(59,130,246,0.2); color: #93c5fd; border: 1px solid rgba(59,130,246,0.3); }
  .role-secretary { background: rgba(245,158,11,0.2); color: #fcd34d; border: 1px solid rgba(245,158,11,0.3); }

  .profile-details { padding: 28px 32px; }

  .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

  .detail-item {
    padding: 16px;
    background: var(--warm);
    border-radius: 12px;
    border: 1px solid var(--border);
  }

  .detail-label {
    font-size: 10px; font-weight: 600;
    color: var(--muted); text-transform: uppercase;
    letter-spacing: 0.1em; margin-bottom: 6px;
    display: flex; align-items: center; gap: 6px;
  }

  .detail-value {
    font-size: 14px; font-weight: 500; color: var(--deep);
  }

  .profile-actions {
    padding: 20px 32px 28px;
    border-top: 1px solid var(--border);
    display: flex;
    gap: 12px;
    justify-content: space-between;
  }

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
      <div class="topbar-title">Profil Utilisateur</div>
      <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a><span>›</span>
        <a href="{{ route('utilisateurs.index') }}">Utilisateurs</a><span>›</span>
        <span>{{ $utilisateur->name }}</span>
      </div>
    </div>
    <div class="topbar-actions">
      <a href="{{ route('utilisateurs.edit', $utilisateur) }}" class="btn btn-primary">✏️ Modifier</a>
    </div>
  </header>

  <div class="content">
    <div class="profile-card">
      <!-- Hero -->
      <div class="profile-hero">
        <div class="profile-avatar avatar-{{ $utilisateur->role }}">
          {{ strtoupper(substr($utilisateur->name, 0, 2)) }}
        </div>
        <div class="profile-name">{{ $utilisateur->name }}</div>
        <div class="profile-email">{{ $utilisateur->email }}</div>
        <span class="role-badge role-{{ $utilisateur->role }}">
          @switch($utilisateur->role)
            @case('admin') 🔐 Administrateur @break
            @case('doctor') 🩺 Médecin @break
            @case('nurse') 💉 Infirmier @break
            @case('secretary') 📋 Secrétaire @break
          @endswitch
        </span>
      </div>

      <!-- Details -->
      <div class="profile-details">
        <div class="detail-grid">
          <div class="detail-item">
            <div class="detail-label">🆔 Identifiant</div>
            <div class="detail-value">#U-{{ str_pad($utilisateur->id, 4, '0', STR_PAD_LEFT) }}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">🔑 Rôle système</div>
            <div class="detail-value">{{ ucfirst($utilisateur->role) }}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">📅 Date de création</div>
            <div class="detail-value">{{ $utilisateur->created_at ? $utilisateur->created_at->format('d/m/Y à H:i') : '—' }}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">🔄 Dernière mise à jour</div>
            <div class="detail-value">{{ $utilisateur->updated_at ? $utilisateur->updated_at->format('d/m/Y à H:i') : '—' }}</div>
          </div>
          <div class="detail-item" style="grid-column: 1 / -1;">
            <div class="detail-label">📧 Email vérifié</div>
            <div class="detail-value">
              @if($utilisateur->email_verified_at)
                ✅ Vérifié le {{ $utilisateur->email_verified_at->format('d/m/Y') }}
              @else
                ⏳ Non vérifié
              @endif
            </div>
          </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="profile-actions">
        <a href="{{ route('utilisateurs.index') }}" class="btn btn-outline">← Retour à la liste</a>
        <a href="{{ route('utilisateurs.edit', $utilisateur) }}" class="btn btn-primary">✏️ Modifier cet utilisateur</a>
      </div>
    </div>
  </div>
</main>

</body>
</html>
