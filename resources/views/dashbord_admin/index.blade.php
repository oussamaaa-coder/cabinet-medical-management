<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MediCal — Gestion des Utilisateurs</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
  :root {
    --deep: #0a1628;
    --navy: #112240;
    --teal: #0d9488;
    --teal-light: #14b8a6;
    --cream: #f8f4ef;
    --warm: #fef9f4;
    --text: #1e293b;
    --muted: #64748b;
    --border: #e2e8f0;
    --white: #ffffff;
    --accent: #f59e0b;
    --danger: #ef4444;
    --success: #10b981;
    --purple: #7c3aed;
    --blue: #3b82f6;
    --rose: #f43f5e;
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--warm);
    color: var(--text);
    min-height: 100vh;
    overflow-x: hidden;
  }

  /* ── SIDEBAR ── */
  .sidebar {
    position: fixed;
    left: 0; top: 0;
    width: 260px;
    height: 100vh;
    background: var(--deep);
    display: flex;
    flex-direction: column;
    z-index: 100;
    padding: 0 0 24px;
  }

  .sidebar-logo {
    padding: 32px 28px 28px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
  }

  .sidebar-logo .logo-text {
    font-family: 'Cormorant Garamond', serif;
    font-size: 28px;
    font-weight: 600;
    color: var(--white);
    letter-spacing: 0.02em;
  }

  .sidebar-logo .logo-sub {
    font-size: 11px;
    color: var(--teal-light);
    letter-spacing: 0.12em;
    text-transform: uppercase;
    margin-top: 2px;
  }

  .sidebar-nav {
    flex: 1;
    padding: 24px 16px;
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .nav-section-label {
    font-size: 10px;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.3);
    padding: 16px 12px 8px;
    font-weight: 500;
  }

  .nav-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 14px;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
    color: rgba(255,255,255,0.55);
    font-size: 14px;
    font-weight: 400;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    text-decoration: none;
  }

  .nav-item:hover {
    background: rgba(255,255,255,0.06);
    color: rgba(255,255,255,0.85);
  }

  .nav-item.active {
    background: rgba(13,148,136,0.2);
    color: var(--teal-light);
  }

  .nav-item .nav-icon {
    width: 18px;
    text-align: center;
    flex-shrink: 0;
  }

  .nav-badge {
    margin-left: auto;
    background: var(--teal);
    color: white;
    font-size: 10px;
    font-weight: 600;
    padding: 2px 7px;
    border-radius: 20px;
  }

  .sidebar-user {
    padding: 20px 20px 0;
    border-top: 1px solid rgba(255,255,255,0.08);
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .user-avatar-sm {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--teal), #0369a1);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 600;
    color: white;
    flex-shrink: 0;
  }

  .user-info .user-name { font-size: 13px; font-weight: 500; color: white; }
  .user-info .user-role { font-size: 11px; color: rgba(255,255,255,0.4); margin-top: 1px; }

  /* ── MAIN ── */
  .main {
    margin-left: 260px;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }

  /* ── TOPBAR ── */
  .topbar {
    background: var(--white);
    border-bottom: 1px solid var(--border);
    padding: 0 36px;
    height: 68px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    z-index: 50;
  }

  .topbar-left {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .topbar-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 22px;
    font-weight: 500;
    color: var(--deep);
  }

  .breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: var(--muted);
  }

  .breadcrumb a { color: var(--teal); text-decoration: none; }
  .breadcrumb a:hover { text-decoration: underline; }

  .topbar-actions {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .search-input-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--warm);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 8px 14px;
    width: 280px;
    transition: border-color 0.2s;
  }

  .search-input-wrapper:focus-within {
    border-color: var(--teal);
    background: white;
    box-shadow: 0 0 0 3px rgba(13,148,136,0.1);
  }

  .search-input-wrapper input {
    border: none;
    background: none;
    outline: none;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    color: var(--text);
    width: 100%;
  }

  .btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 18px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    border: none;
    transition: all 0.2s ease;
    font-family: 'DM Sans', sans-serif;
    text-decoration: none;
  }

  .btn-primary {
    background: var(--teal);
    color: white;
  }

  .btn-primary:hover {
    background: #0b7a72;
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(13,148,136,0.35);
  }

  .btn-outline {
    background: transparent;
    border: 1px solid var(--border);
    color: var(--text);
  }

  .btn-outline:hover { background: var(--warm); }

  .btn-danger {
    background: var(--danger);
    color: white;
  }

  .btn-danger:hover {
    background: #dc2626;
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(239,68,68,0.35);
  }

  .btn-sm {
    padding: 6px 12px;
    font-size: 12px;
  }

  /* ── CONTENT ── */
  .content {
    padding: 32px 36px;
    flex: 1;
  }

  /* ── STATS ── */
  .stats-row {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 16px;
    margin-bottom: 28px;
  }

  .stat-card {
    background: var(--white);
    border-radius: 16px;
    padding: 22px;
    border: 1px solid var(--border);
    position: relative;
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
    cursor: default;
  }

  .stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
  }

  .stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    border-radius: 16px 16px 0 0;
  }

  .stat-card.teal::before { background: var(--teal); }
  .stat-card.purple::before { background: var(--purple); }
  .stat-card.blue::before { background: var(--blue); }
  .stat-card.amber::before { background: var(--accent); }
  .stat-card.rose::before { background: var(--rose); }

  .stat-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    margin-bottom: 14px;
  }

  .stat-card.teal .stat-icon { background: rgba(13,148,136,0.1); }
  .stat-card.purple .stat-icon { background: rgba(124,58,237,0.1); }
  .stat-card.blue .stat-icon { background: rgba(59,130,246,0.1); }
  .stat-card.amber .stat-icon { background: rgba(245,158,11,0.1); }
  .stat-card.rose .stat-icon { background: rgba(244,63,94,0.1); }

  .stat-value {
    font-family: 'Cormorant Garamond', serif;
    font-size: 32px;
    font-weight: 600;
    color: var(--deep);
    line-height: 1;
    margin-bottom: 4px;
  }

  .stat-label {
    font-size: 11px;
    color: var(--muted);
    font-weight: 400;
    text-transform: uppercase;
    letter-spacing: 0.08em;
  }

  /* ── CARD ── */
  .card {
    background: var(--white);
    border-radius: 16px;
    border: 1px solid var(--border);
    overflow: hidden;
  }

  .card-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
  }

  .card-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 18px;
    font-weight: 500;
    color: var(--deep);
  }

  .card-actions {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  /* ── FILTER TABS ── */
  .filter-tabs {
    display: flex;
    gap: 4px;
    background: var(--warm);
    padding: 4px;
    border-radius: 10px;
    border: 1px solid var(--border);
  }

  .filter-tab {
    padding: 6px 14px;
    border-radius: 7px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    border: none;
    background: none;
    color: var(--muted);
    transition: all 0.15s;
    font-family: 'DM Sans', sans-serif;
    text-decoration: none;
  }

  .filter-tab.active,
  .filter-tab:hover {
    background: white;
    color: var(--deep);
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
  }

  /* ── TABLE ── */
  .table-container { overflow-x: auto; }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  thead th {
    padding: 12px 16px;
    text-align: left;
    font-size: 11px;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    border-bottom: 2px solid var(--border);
  }

  tbody tr {
    border-bottom: 1px solid var(--border);
    transition: background 0.15s;
  }

  tbody tr:last-child { border-bottom: none; }
  tbody tr:hover { background: var(--warm); }

  tbody td {
    padding: 14px 16px;
    font-size: 13px;
    vertical-align: middle;
  }

  .user-cell {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .user-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 600;
    color: white;
    flex-shrink: 0;
  }

  .user-name-text { font-weight: 500; color: var(--deep); }
  .user-email-text { font-size: 11px; color: var(--muted); margin-top: 1px; }

  /* ── ROLE BADGES ── */
  .role-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    font-weight: 600;
    padding: 5px 12px;
    border-radius: 20px;
    text-transform: capitalize;
  }

  .role-admin { background: rgba(124,58,237,0.1); color: var(--purple); border: 1px solid rgba(124,58,237,0.2); }
  .role-doctor { background: rgba(13,148,136,0.1); color: var(--teal); border: 1px solid rgba(13,148,136,0.2); }
  .role-nurse { background: rgba(59,130,246,0.1); color: var(--blue); border: 1px solid rgba(59,130,246,0.2); }
  .role-secretary { background: rgba(245,158,11,0.1); color: var(--accent); border: 1px solid rgba(245,158,11,0.2); }

  /* ── ACTION BUTTONS ── */
  .action-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: 1px solid var(--border);
    background: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    color: var(--muted);
    transition: all 0.15s;
    margin-right: 4px;
  }

  .action-btn:hover { background: var(--teal); color: white; border-color: var(--teal); }
  .action-btn.danger:hover { background: var(--danger); color: white; border-color: var(--danger); }

  /* ── PAGINATION ── */
  .pagination-wrapper {
    padding: 16px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top: 1px solid var(--border);
  }

  .pagination-info {
    font-size: 12px;
    color: var(--muted);
  }

  .pagination-links {
    display: flex;
    gap: 4px;
  }

  .pagination-links a,
  .pagination-links span {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 500;
    text-decoration: none;
    border: 1px solid var(--border);
    color: var(--text);
    transition: all 0.15s;
  }

  .pagination-links a:hover {
    background: var(--teal);
    color: white;
    border-color: var(--teal);
  }

  .pagination-links span.current {
    background: var(--teal);
    color: white;
    border-color: var(--teal);
  }

  .pagination-links span.disabled {
    color: var(--border);
    cursor: default;
  }

  /* ── MODAL ── */
  .modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(10,22,40,0.6);
    z-index: 200;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.25s;
    backdrop-filter: blur(4px);
  }

  .modal-overlay.open {
    opacity: 1;
    pointer-events: all;
  }

  .modal {
    background: var(--white);
    border-radius: 20px;
    width: 440px;
    max-width: 90vw;
    transform: translateY(20px) scale(0.97);
    transition: transform 0.25s ease;
    box-shadow: 0 24px 64px rgba(0,0,0,0.2);
  }

  .modal-overlay.open .modal {
    transform: translateY(0) scale(1);
  }

  .modal-header {
    padding: 28px 28px 20px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .modal-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 20px;
    font-weight: 500;
    color: var(--deep);
  }

  .modal-close {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: 1px solid var(--border);
    background: none;
    cursor: pointer;
    font-size: 18px;
    color: var(--muted);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
  }

  .modal-close:hover { background: var(--danger); color: white; border-color: var(--danger); }

  .modal-body { padding: 24px 28px; }

  .modal-body p {
    font-size: 14px;
    color: var(--muted);
    line-height: 1.6;
  }

  .modal-body .user-delete-name {
    font-weight: 600;
    color: var(--deep);
  }

  .modal-footer {
    padding: 20px 28px 28px;
    display: flex;
    gap: 12px;
    justify-content: flex-end;
  }

  /* ── TOAST ── */
  .toast {
    position: fixed;
    bottom: 28px;
    right: 28px;
    background: var(--deep);
    color: white;
    padding: 14px 20px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 500;
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    transform: translateY(100px);
    opacity: 0;
    transition: all .3s ease;
    z-index: 999;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .toast.success { border-left: 4px solid var(--teal); }
  .toast.error { border-left: 4px solid var(--danger); }
  .toast.show { transform: translateY(0); opacity: 1; }

  /* ── EMPTY STATE ── */
  .empty-state {
    text-align: center;
    padding: 60px 20px;
  }

  .empty-state .empty-icon {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.6;
  }

  .empty-state .empty-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 20px;
    color: var(--deep);
    margin-bottom: 8px;
  }

  .empty-state .empty-text {
    font-size: 13px;
    color: var(--muted);
  }

  /* ── ANIMATIONS ── */
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(16px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .stat-card { animation: fadeIn 0.4s ease both; }
  .stat-card:nth-child(1) { animation-delay: 0.05s; }
  .stat-card:nth-child(2) { animation-delay: 0.1s; }
  .stat-card:nth-child(3) { animation-delay: 0.15s; }
  .stat-card:nth-child(4) { animation-delay: 0.2s; }
  .stat-card:nth-child(5) { animation-delay: 0.25s; }

  .card { animation: fadeIn 0.4s ease both; animation-delay: 0.3s; }

  /* ── AVATAR COLORS ── */
  .avatar-admin { background: linear-gradient(135deg, #7c3aed, #a855f7); }
  .avatar-doctor { background: linear-gradient(135deg, #0d9488, #0369a1); }
  .avatar-nurse { background: linear-gradient(135deg, #3b82f6, #6366f1); }
  .avatar-secretary { background: linear-gradient(135deg, #f59e0b, #ef4444); }
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
    <a class="nav-item" href="{{ route('dashboard') }}">
      <span class="nav-icon">🏠</span> Tableau de bord
    </a>
    <a class="nav-item" href="{{ route('appointments.index') }}">
      <span class="nav-icon">📅</span> Rendez-vous
    </a>
    <a class="nav-item" href="{{ route('patients.index') }}">
      <span class="nav-icon">👥</span> Patients
    </a>
    <a class="nav-item" href="{{ route('doctors.index') }}">
      <span class="nav-icon">🩺</span> Médecins
    </a>

    <span class="nav-section-label">Administration</span>
    <a class="nav-item active" href="{{ route('utilisateurs.index') }}">
      <span class="nav-icon">🔐</span> Gestion Utilisateurs
      <span class="nav-badge">{{ $totalUsers }}</span>
    </a>

    <span class="nav-section-label">Paramètres</span>
    <a class="nav-item" href="#">
      <span class="nav-icon">⚙️</span> Configuration
    </a>
    <form method="POST" action="{{ route('logout') }}" style="width:100%;">
      @csrf
      <button type="submit" class="nav-item" style="color:rgba(239,68,68,0.7);">
        <span class="nav-icon">🚪</span> Déconnexion
      </button>
    </form>
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
      <div class="topbar-title">Gestion des Utilisateurs</div>
      <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span>›</span>
        <span>Utilisateurs</span>
      </div>
    </div>
    <div class="topbar-actions">
      <form method="GET" action="{{ route('utilisateurs.index') }}" class="search-input-wrapper" id="searchForm">
        <span>🔍</span>
        <input type="text" name="search" placeholder="Rechercher un utilisateur..." value="{{ request('search') }}" id="searchInput">
      </form>
      <a href="{{ route('utilisateurs.create') }}" class="btn btn-primary">
        ➕ Nouvel Utilisateur
      </a>
    </div>
  </header>

  <div class="content">
    <!-- STATS -->
    <div class="stats-row">
      <div class="stat-card teal">
        <div class="stat-icon">👥</div>
        <div class="stat-value">{{ $totalUsers }}</div>
        <div class="stat-label">Total Utilisateurs</div>
      </div>
      <div class="stat-card purple">
        <div class="stat-icon">🔐</div>
        <div class="stat-value">{{ $totalAdmins }}</div>
        <div class="stat-label">Administrateurs</div>
      </div>
      <div class="stat-card blue">
        <div class="stat-icon">🩺</div>
        <div class="stat-value">{{ $totalDoctors }}</div>
        <div class="stat-label">Médecins</div>
      </div>
      <div class="stat-card amber">
        <div class="stat-icon">💉</div>
        <div class="stat-value">{{ $totalNurses }}</div>
        <div class="stat-label">Infirmiers</div>
      </div>
      <div class="stat-card rose">
        <div class="stat-icon">📋</div>
        <div class="stat-value">{{ $totalSecretaries }}</div>
        <div class="stat-label">Secrétaires</div>
      </div>
    </div>

    <!-- USER TABLE -->
    <div class="card">
      <div class="card-header">
        <div class="card-title">Liste des Utilisateurs</div>
        <div class="card-actions">
          <div class="filter-tabs">
            <a href="{{ route('utilisateurs.index', request()->except('role')) }}" class="filter-tab {{ !request('role') ? 'active' : '' }}">Tous</a>
            <a href="{{ route('utilisateurs.index', array_merge(request()->except('role'), ['role' => 'admin'])) }}" class="filter-tab {{ request('role') === 'admin' ? 'active' : '' }}">Admins</a>
            <a href="{{ route('utilisateurs.index', array_merge(request()->except('role'), ['role' => 'doctor'])) }}" class="filter-tab {{ request('role') === 'doctor' ? 'active' : '' }}">Médecins</a>
            <a href="{{ route('utilisateurs.index', array_merge(request()->except('role'), ['role' => 'nurse'])) }}" class="filter-tab {{ request('role') === 'nurse' ? 'active' : '' }}">Infirmiers</a>
            <a href="{{ route('utilisateurs.index', array_merge(request()->except('role'), ['role' => 'secretary'])) }}" class="filter-tab {{ request('role') === 'secretary' ? 'active' : '' }}">Secrétaires</a>
          </div>
        </div>
      </div>
      <div class="table-container">
        @if($users->count() > 0)
        <table>
          <thead>
            <tr>
              <th>Utilisateur</th>
              <th>Rôle</th>
              <th>Email</th>
              <th>Date de création</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
            <tr>
              <td>
                <div class="user-cell">
                  <div class="user-avatar avatar-{{ $user->role }}">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                  <div>
                    <div class="user-name-text">{{ $user->name }}</div>
                    <div class="user-email-text">#U-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                  </div>
                </div>
              </td>
              <td>
                <span class="role-badge role-{{ $user->role }}">
                  @switch($user->role)
                    @case('admin') 🔐 Admin @break
                    @case('doctor') 🩺 Médecin @break
                    @case('nurse') 💉 Infirmier @break
                    @case('secretary') 📋 Secrétaire @break
                  @endswitch
                </span>
              </td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '—' }}</td>
              <td>
                <a href="{{ route('utilisateurs.show', $user) }}" class="action-btn" title="Voir détails">👁</a>
                <a href="{{ route('utilisateurs.edit', $user) }}" class="action-btn" title="Modifier">✏️</a>
                @if($user->id !== auth()->id())
                  <button class="action-btn danger" title="Supprimer" onclick="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}')">🗑</button>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @else
        <div class="empty-state">
          <div class="empty-icon">👤</div>
          <div class="empty-title">Aucun utilisateur trouvé</div>
          <div class="empty-text">
            @if(request('search') || request('role'))
              Essayez de modifier vos critères de recherche.
            @else
              Commencez par ajouter un nouvel utilisateur.
            @endif
          </div>
        </div>
        @endif
      </div>

      @if($users->hasPages())
      <div class="pagination-wrapper">
        <div class="pagination-info">
          Affichage de {{ $users->firstItem() }} à {{ $users->lastItem() }} sur {{ $users->total() }} utilisateurs
        </div>
        <div class="pagination-links">
          @if($users->onFirstPage())
            <span class="disabled">‹ Préc.</span>
          @else
            <a href="{{ $users->previousPageUrl() }}">‹ Préc.</a>
          @endif

          @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
            @if($page == $users->currentPage())
              <span class="current">{{ $page }}</span>
            @else
              <a href="{{ $url }}">{{ $page }}</a>
            @endif
          @endforeach

          @if($users->hasMorePages())
            <a href="{{ $users->nextPageUrl() }}">Suiv. ›</a>
          @else
            <span class="disabled">Suiv. ›</span>
          @endif
        </div>
      </div>
      @endif
    </div>
  </div>
</main>

<!-- DELETE CONFIRMATION MODAL -->
<div class="modal-overlay" id="deleteModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">⚠️ Confirmer la suppression</div>
      <button class="modal-close" onclick="closeDeleteModal()">✕</button>
    </div>
    <div class="modal-body">
      <p>Êtes-vous sûr de vouloir supprimer l'utilisateur <span class="user-delete-name" id="deleteUserName"></span> ? Cette action est irréversible.</p>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeDeleteModal()">Annuler</button>
      <form id="deleteForm" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">🗑 Supprimer</button>
      </form>
    </div>
  </div>
</div>

<!-- TOAST NOTIFICATIONS -->
<div class="toast success" id="successToast">✅ <span id="successMsg"></span></div>
<div class="toast error" id="errorToast">❌ <span id="errorMsg"></span></div>

<script>
  // Delete confirmation
  function confirmDelete(userId, userName) {
    document.getElementById('deleteUserName').textContent = userName;
    document.getElementById('deleteForm').action = '/utilisateurs/' + userId;
    document.getElementById('deleteModal').classList.add('open');
  }

  function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('open');
  }

  document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
  });

  // Toast notifications
  @if(session('success'))
    showToast('success', @json(session('success')));
  @endif

  @if(session('error'))
    showToast('error', @json(session('error')));
  @endif

  function showToast(type, message) {
    const toast = document.getElementById(type + 'Toast');
    document.getElementById(type + 'Msg').textContent = message;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 4000);
  }

  // Search debounce
  let searchTimeout;
  document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
      document.getElementById('searchForm').submit();
    }, 500);
  });
</script>
</body>
</html>
