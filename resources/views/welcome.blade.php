{{-- <!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MediCal — Gestion de Rendez-vous</title>
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

  .user-avatar {
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

  .user-info .user-name {
    font-size: 13px;
    font-weight: 500;
    color: white;
  }

  .user-info .user-role {
    font-size: 11px;
    color: rgba(255,255,255,0.4);
    margin-top: 1px;
  }

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

  .topbar-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 22px;
    font-weight: 500;
    color: var(--deep);
  }

  .topbar-actions {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .search-bar {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--warm);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 8px 14px;
    font-size: 13px;
    color: var(--muted);
    width: 240px;
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

  .btn-outline:hover {
    background: var(--warm);
  }

  /* ── CONTENT ── */
  .content {
    padding: 32px 36px;
    flex: 1;
  }

  /* ── STATS ── */
  .stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 32px;
  }

  .stat-card {
    background: var(--white);
    border-radius: 16px;
    padding: 24px;
    border: 1px solid var(--border);
    position: relative;
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
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
  .stat-card.amber::before { background: var(--accent); }
  .stat-card.green::before { background: var(--success); }
  .stat-card.blue::before { background: #3b82f6; }

  .stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-bottom: 16px;
  }

  .stat-card.teal .stat-icon { background: rgba(13,148,136,0.1); }
  .stat-card.amber .stat-icon { background: rgba(245,158,11,0.1); }
  .stat-card.green .stat-icon { background: rgba(16,185,129,0.1); }
  .stat-card.blue .stat-icon { background: rgba(59,130,246,0.1); }

  .stat-value {
    font-family: 'Cormorant Garamond', serif;
    font-size: 36px;
    font-weight: 600;
    color: var(--deep);
    line-height: 1;
    margin-bottom: 4px;
  }

  .stat-label {
    font-size: 12px;
    color: var(--muted);
    font-weight: 400;
    text-transform: uppercase;
    letter-spacing: 0.08em;
  }

  .stat-trend {
    position: absolute;
    top: 24px;
    right: 24px;
    font-size: 11px;
    font-weight: 600;
    padding: 4px 8px;
    border-radius: 6px;
  }

  .trend-up { background: rgba(16,185,129,0.1); color: var(--success); }
  .trend-down { background: rgba(239,68,68,0.1); color: var(--danger); }

  /* ── GRID LAYOUT ── */
  .grid-2 {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 24px;
    margin-bottom: 24px;
  }

  /* ── CALENDAR ── */
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
  }

  .card-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 18px;
    font-weight: 500;
    color: var(--deep);
  }

  .card-body { padding: 24px; }

  /* ── CALENDAR WIDGET ── */
  .cal-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
  }

  .cal-month {
    font-weight: 600;
    font-size: 15px;
    color: var(--deep);
  }

  .cal-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: 1px solid var(--border);
    background: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: var(--muted);
    transition: all 0.15s;
  }

  .cal-btn:hover { background: var(--warm); color: var(--teal); }

  .cal-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 4px;
    text-align: center;
  }

  .cal-day-name {
    font-size: 10px;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    padding: 4px 0 8px;
  }

  .cal-day {
    padding: 8px 4px;
    border-radius: 8px;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.15s;
    color: var(--text);
    position: relative;
  }

  .cal-day:hover { background: var(--warm); }
  .cal-day.other-month { color: var(--border); }
  .cal-day.today {
    background: var(--teal);
    color: white;
    font-weight: 600;
  }

  .cal-day.has-rdv::after {
    content: '';
    position: absolute;
    bottom: 3px;
    left: 50%;
    transform: translateX(-50%);
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: var(--accent);
  }

  .cal-day.today.has-rdv::after { background: white; }

  /* ── UPCOMING ── */
  .rdv-list { display: flex; flex-direction: column; gap: 12px; }

  .rdv-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px;
    border-radius: 12px;
    background: var(--warm);
    cursor: pointer;
    transition: all 0.15s;
    border: 1px solid transparent;
  }

  .rdv-item:hover {
    border-color: var(--teal);
    background: white;
    box-shadow: 0 2px 12px rgba(13,148,136,0.1);
  }

  .rdv-time {
    text-align: center;
    min-width: 46px;
  }

  .rdv-time .hour {
    font-size: 16px;
    font-weight: 600;
    color: var(--teal);
    font-family: 'Cormorant Garamond', serif;
  }

  .rdv-time .period {
    font-size: 10px;
    color: var(--muted);
    text-transform: uppercase;
  }

  .rdv-divider {
    width: 1px;
    height: 40px;
    background: var(--border);
  }

  .rdv-info .rdv-patient {
    font-size: 13px;
    font-weight: 600;
    color: var(--deep);
  }

  .rdv-info .rdv-type {
    font-size: 12px;
    color: var(--muted);
    margin-top: 2px;
  }

  .rdv-status {
    margin-left: auto;
    font-size: 11px;
    font-weight: 500;
    padding: 4px 10px;
    border-radius: 20px;
  }

  .status-confirme { background: rgba(16,185,129,0.1); color: var(--success); }
  .status-attente { background: rgba(245,158,11,0.1); color: var(--accent); }
  .status-urgent { background: rgba(239,68,68,0.1); color: var(--danger); }

  /* ── PATIENT TABLE ── */
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

  .patient-cell {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .patient-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 600;
    color: white;
    flex-shrink: 0;
  }

  .patient-name { font-weight: 500; color: var(--deep); }
  .patient-id { font-size: 11px; color: var(--muted); }

  .action-btn {
    width: 30px;
    height: 30px;
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
    width: 520px;
    max-width: 90vw;
    max-height: 90vh;
    overflow-y: auto;
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
    font-size: 22px;
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

  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
  .form-group { margin-bottom: 18px; }
  .form-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 8px;
  }

  .form-input, .form-select {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-size: 14px;
    font-family: 'DM Sans', sans-serif;
    color: var(--text);
    background: var(--warm);
    transition: border-color 0.15s;
    outline: none;
  }

  .form-input:focus, .form-select:focus {
    border-color: var(--teal);
    background: white;
    box-shadow: 0 0 0 3px rgba(13,148,136,0.1);
  }

  .modal-footer {
    padding: 20px 28px 28px;
    display: flex;
    gap: 12px;
    justify-content: flex-end;
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

  .card { animation: fadeIn 0.4s ease both; animation-delay: 0.25s; }

  /* ── NOTIFICATION DOT ── */
  .notif-btn {
    position: relative;
    width: 38px;
    height: 38px;
    border-radius: 10px;
    border: 1px solid var(--border);
    background: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    transition: all 0.15s;
  }

  .notif-btn:hover { background: var(--warm); }

  .notif-btn::after {
    content: '';
    position: absolute;
    top: 8px;
    right: 8px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--danger);
    border: 2px solid white;
  }

  .chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    font-weight: 500;
    padding: 4px 10px;
    border-radius: 20px;
    background: rgba(13,148,136,0.08);
    color: var(--teal);
    border: 1px solid rgba(13,148,136,0.2);
  }

  .tab-group {
    display: flex;
    gap: 4px;
    background: var(--warm);
    padding: 4px;
    border-radius: 10px;
    border: 1px solid var(--border);
  }

  .tab {
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
  }

  .tab.active {
    background: white;
    color: var(--deep);
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
  }
</style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-text">MediCal</div>
    <div class="logo-sub">Gestion de Rendez-vous</div>
  </div>
  <nav class="sidebar-nav">
    <span class="nav-section-label">Principal</span>
    <button class="nav-item active" onclick="switchView('dashboard')">
      <span class="nav-icon">🏠</span> Tableau de bord
    </button>
    <button class="nav-item" onclick="switchView('agenda')">
      <span class="nav-icon">📅</span> Agenda
      <span class="nav-badge">8</span>
    </button>
    <button class="nav-item" onclick="switchView('patients')">
      <span class="nav-icon">👥</span> Patients
    </button>

    <span class="nav-section-label">Gestion</span>
    <button class="nav-item" onclick="openModal()">
      <span class="nav-icon">➕</span> Nouveau RDV
    </button>
    <button class="nav-item">
      <span class="nav-icon">💊</span> Ordonnances
    </button>
    <button class="nav-item">
      <span class="nav-icon">📋</span> Dossiers
    </button>
    <button class="nav-item">
      <span class="nav-icon">💬</span> Messages
      <span class="nav-badge">3</span>
    </button>

    <span class="nav-section-label">Paramètres</span>
    <button class="nav-item">
      <span class="nav-icon">⚙️</span> Configuration
    </button>
    <button class="nav-item">
      <span class="nav-icon">❓</span> Aide
    </button>
  </nav>
  <div class="sidebar-user">
    <div class="user-avatar">DR</div>
    <div class="user-info">
      <div class="user-name">Dr. Rachida Alaoui</div>
      <div class="user-role">Médecin Généraliste</div>
    </div>
  </div>
</aside>

<!-- MAIN -->
<main class="main">
  <header class="topbar">
    <div class="topbar-title" id="page-title">Tableau de bord</div>
    <div class="topbar-actions">
      <div class="search-bar">
        🔍 <input type="text" placeholder="Rechercher un patient..." style="border:none;background:none;outline:none;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);width:180px;">
      </div>
      <button class="notif-btn">🔔</button>
      <button class="btn btn-primary" onclick="openModal()">
        ➕ Nouveau RDV
      </button>
    </div>
  </header>

  <div class="content">

    <!-- STATS -->
    <div class="stats-row">
      <div class="stat-card teal">
        <div class="stat-icon">📅</div>
        <div class="stat-trend trend-up">↑ 12%</div>
        <div class="stat-value">28</div>
        <div class="stat-label">RDV aujourd'hui</div>
      </div>
      <div class="stat-card amber">
        <div class="stat-icon">⏳</div>
        <div class="stat-trend trend-down">↓ 3</div>
        <div class="stat-value">5</div>
        <div class="stat-label">En attente</div>
      </div>
      <div class="stat-card green">
        <div class="stat-icon">✅</div>
        <div class="stat-trend trend-up">↑ 8%</div>
        <div class="stat-value">21</div>
        <div class="stat-label">Confirmés</div>
      </div>
      <div class="stat-card blue">
        <div class="stat-icon">👤</div>
        <div class="stat-trend trend-up">↑ 4%</div>
        <div class="stat-value">342</div>
        <div class="stat-label">Patients actifs</div>
      </div>
    </div>

    <!-- CALENDAR + UPCOMING -->
    <div class="grid-2">

      <!-- Calendar -->
      <div class="card">
        <div class="card-header">
          <div class="card-title">Planning du jour</div>
          <div class="tab-group">
            <button class="tab active">Aujourd'hui</button>
            <button class="tab">Semaine</button>
            <button class="tab">Mois</button>
          </div>
        </div>
        <div class="card-body">
          <div class="cal-nav">
            <button class="cal-btn">‹</button>
            <span class="cal-month">Février 2026</span>
            <button class="cal-btn">›</button>
          </div>
          <div class="cal-grid">
            <div class="cal-day-name">Lu</div>
            <div class="cal-day-name">Ma</div>
            <div class="cal-day-name">Me</div>
            <div class="cal-day-name">Je</div>
            <div class="cal-day-name">Ve</div>
            <div class="cal-day-name">Sa</div>
            <div class="cal-day-name">Di</div>
            <!-- Jan overflow -->
            <div class="cal-day other-month">27</div>
            <div class="cal-day other-month">28</div>
            <div class="cal-day other-month">29</div>
            <div class="cal-day other-month">30</div>
            <div class="cal-day other-month">31</div>
            <!-- Feb -->
            <div class="cal-day">1</div>
            <div class="cal-day">2</div>
            <div class="cal-day has-rdv">3</div>
            <div class="cal-day has-rdv">4</div>
            <div class="cal-day has-rdv">5</div>
            <div class="cal-day has-rdv">6</div>
            <div class="cal-day has-rdv">7</div>
            <div class="cal-day">8</div>
            <div class="cal-day">9</div>
            <div class="cal-day has-rdv">10</div>
            <div class="cal-day has-rdv">11</div>
            <div class="cal-day has-rdv">12</div>
            <div class="cal-day">13</div>
            <div class="cal-day">14</div>
            <div class="cal-day">15</div>
            <div class="cal-day">16</div>
            <div class="cal-day today has-rdv">17</div>
            <div class="cal-day has-rdv">18</div>
            <div class="cal-day has-rdv">19</div>
            <div class="cal-day">20</div>
            <div class="cal-day">21</div>
            <div class="cal-day">22</div>
            <div class="cal-day has-rdv">23</div>
            <div class="cal-day">24</div>
            <div class="cal-day">25</div>
            <div class="cal-day">26</div>
            <div class="cal-day">27</div>
            <div class="cal-day">28</div>
            <div class="cal-day other-month">1</div>
            <div class="cal-day other-month">2</div>
          </div>

          <!-- Today slots preview -->
          <div style="margin-top:20px;border-top:1px solid var(--border);padding-top:16px;">
            <div style="font-size:11px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.1em;margin-bottom:12px;">Créneaux du 17 février</div>
            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:8px;">
              <div style="padding:8px;border-radius:8px;background:rgba(13,148,136,0.1);text-align:center;font-size:12px;font-weight:600;color:var(--teal);border:1.5px solid rgba(13,148,136,0.2);">09:00</div>
              <div style="padding:8px;border-radius:8px;background:rgba(13,148,136,0.1);text-align:center;font-size:12px;font-weight:600;color:var(--teal);border:1.5px solid rgba(13,148,136,0.2);">10:30</div>
              <div style="padding:8px;border-radius:8px;background:rgba(245,158,11,0.1);text-align:center;font-size:12px;font-weight:600;color:var(--accent);border:1.5px dashed rgba(245,158,11,0.3);">14:00</div>
              <div style="padding:8px;border-radius:8px;background:var(--warm);text-align:center;font-size:12px;color:var(--muted);border:1px dashed var(--border);">Libre</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Upcoming -->
      <div class="card">
        <div class="card-header">
          <div class="card-title">Prochains RDV</div>
          <span class="chip">📍 Aujourd'hui</span>
        </div>
        <div class="card-body">
          <div class="rdv-list">
            <div class="rdv-item">
              <div class="rdv-time">
                <div class="hour">09:00</div>
                <div class="period">matin</div>
              </div>
              <div class="rdv-divider"></div>
              <div class="rdv-info">
                <div class="rdv-patient">Fatima Benali</div>
                <div class="rdv-type">🩺 Consultation générale</div>
              </div>
              <span class="rdv-status status-confirme">Confirmé</span>
            </div>
            <div class="rdv-item">
              <div class="rdv-time">
                <div class="hour">10:30</div>
                <div class="period">matin</div>
              </div>
              <div class="rdv-divider"></div>
              <div class="rdv-info">
                <div class="rdv-patient">Mohamed Idrissi</div>
                <div class="rdv-type">💉 Suivi tension</div>
              </div>
              <span class="rdv-status status-confirme">Confirmé</span>
            </div>
            <div class="rdv-item">
              <div class="rdv-time">
                <div class="hour">14:00</div>
                <div class="period">après</div>
              </div>
              <div class="rdv-divider"></div>
              <div class="rdv-info">
                <div class="rdv-patient">Aicha Chraibi</div>
                <div class="rdv-type">🔬 Résultats analyses</div>
              </div>
              <span class="rdv-status status-attente">En attente</span>
            </div>
            <div class="rdv-item">
              <div class="rdv-time">
                <div class="hour">15:30</div>
                <div class="period">après</div>
              </div>
              <div class="rdv-divider"></div>
              <div class="rdv-info">
                <div class="rdv-patient">Youssef Tazi</div>
                <div class="rdv-type">🚨 Urgence — douleur</div>
              </div>
              <span class="rdv-status status-urgent">Urgent</span>
            </div>
            <div class="rdv-item">
              <div class="rdv-time">
                <div class="hour">17:00</div>
                <div class="period">soir</div>
              </div>
              <div class="rdv-divider"></div>
              <div class="rdv-info">
                <div class="rdv-patient">Sara Mansouri</div>
                <div class="rdv-type">📋 Bilan annuel</div>
              </div>
              <span class="rdv-status status-confirme">Confirmé</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- PATIENT TABLE -->
    <div class="card">
      <div class="card-header">
        <div class="card-title">Liste des patients récents</div>
        <div style="display:flex;gap:10px;align-items:center;">
          <button class="btn btn-outline" style="font-size:12px;padding:7px 14px;">⬇ Exporter</button>
          <button class="btn btn-primary" style="font-size:12px;padding:7px 14px;" onclick="openModal()">➕ Ajouter</button>
        </div>
      </div>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Patient</th>
              <th>Prochain RDV</th>
              <th>Type</th>
              <th>Statut</th>
              <th>Médecin</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <div class="patient-cell">
                  <div class="patient-avatar" style="background:linear-gradient(135deg,#0d9488,#0369a1)">FB</div>
                  <div>
                    <div class="patient-name">Fatima Benali</div>
                    <div class="patient-id">#P-0042</div>
                  </div>
                </div>
              </td>
              <td>17 Fév 2026 — 09:00</td>
              <td><span class="chip">Consultation</span></td>
              <td><span class="rdv-status status-confirme">Confirmé</span></td>
              <td>Dr. Alaoui</td>
              <td>
                <button class="action-btn" title="Voir dossier">👁</button>
                <button class="action-btn" title="Modifier RDV">✏️</button>
                <button class="action-btn" title="Annuler">✕</button>
              </td>
            </tr>
            <tr>
              <td>
                <div class="patient-cell">
                  <div class="patient-avatar" style="background:linear-gradient(135deg,#7c3aed,#db2777)">MI</div>
                  <div>
                    <div class="patient-name">Mohamed Idrissi</div>
                    <div class="patient-id">#P-0039</div>
                  </div>
                </div>
              </td>
              <td>17 Fév 2026 — 10:30</td>
              <td><span class="chip" style="background:rgba(245,158,11,.1);color:var(--accent);border-color:rgba(245,158,11,.3)">Suivi</span></td>
              <td><span class="rdv-status status-confirme">Confirmé</span></td>
              <td>Dr. Alaoui</td>
              <td>
                <button class="action-btn">👁</button>
                <button class="action-btn">✏️</button>
                <button class="action-btn">✕</button>
              </td>
            </tr>
            <tr>
              <td>
                <div class="patient-cell">
                  <div class="patient-avatar" style="background:linear-gradient(135deg,#059669,#0d9488)">AC</div>
                  <div>
                    <div class="patient-name">Aicha Chraibi</div>
                    <div class="patient-id">#P-0051</div>
                  </div>
                </div>
              </td>
              <td>17 Fév 2026 — 14:00</td>
              <td><span class="chip" style="background:rgba(59,130,246,.1);color:#3b82f6;border-color:rgba(59,130,246,.3)">Analyses</span></td>
              <td><span class="rdv-status status-attente">En attente</span></td>
              <td>Dr. Alaoui</td>
              <td>
                <button class="action-btn">👁</button>
                <button class="action-btn">✏️</button>
                <button class="action-btn">✕</button>
              </td>
            </tr>
            <tr>
              <td>
                <div class="patient-cell">
                  <div class="patient-avatar" style="background:linear-gradient(135deg,#dc2626,#f59e0b)">YT</div>
                  <div>
                    <div class="patient-name">Youssef Tazi</div>
                    <div class="patient-id">#P-0063</div>
                  </div>
                </div>
              </td>
              <td>17 Fév 2026 — 15:30</td>
              <td><span class="chip" style="background:rgba(239,68,68,.1);color:var(--danger);border-color:rgba(239,68,68,.3)">Urgence</span></td>
              <td><span class="rdv-status status-urgent">Urgent</span></td>
              <td>Dr. Alaoui</td>
              <td>
                <button class="action-btn">👁</button>
                <button class="action-btn">✏️</button>
                <button class="action-btn">✕</button>
              </td>
            </tr>
            <tr>
              <td>
                <div class="patient-cell">
                  <div class="patient-avatar" style="background:linear-gradient(135deg,#0891b2,#6366f1)">SM</div>
                  <div>
                    <div class="patient-name">Sara Mansouri</div>
                    <div class="patient-id">#P-0028</div>
                  </div>
                </div>
              </td>
              <td>17 Fév 2026 — 17:00</td>
              <td><span class="chip">Bilan</span></td>
              <td><span class="rdv-status status-confirme">Confirmé</span></td>
              <td>Dr. Alaoui</td>
              <td>
                <button class="action-btn">👁</button>
                <button class="action-btn">✏️</button>
                <button class="action-btn">✕</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</main>

<!-- MODAL NOUVEAU RDV -->
<div class="modal-overlay" id="modalOverlay" onclick="handleOverlayClick(event)">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Nouveau rendez-vous</div>
      <button class="modal-close" onclick="closeModal()">✕</button>
    </div>
    <div class="modal-body">
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Prénom</label>
          <input type="text" class="form-input" placeholder="Fatima">
        </div>
        <div class="form-group">
          <label class="form-label">Nom</label>
          <input type="text" class="form-input" placeholder="Benali">
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Téléphone</label>
        <input type="tel" class="form-input" placeholder="+212 6XX XXX XXX">
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Date</label>
          <input type="date" class="form-input" value="2026-02-17">
        </div>
        <div class="form-group">
          <label class="form-label">Heure</label>
          <input type="time" class="form-input" value="09:00">
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Type de consultation</label>
        <select class="form-select">
          <option>Consultation générale</option>
          <option>Suivi de traitement</option>
          <option>Résultats d'analyses</option>
          <option>Bilan annuel</option>
          <option>Urgence</option>
          <option>Téléconsultation</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Médecin</label>
        <select class="form-select">
          <option>Dr. Rachida Alaoui — Généraliste</option>
          <option>Dr. Hassan Bensouda — Cardiologue</option>
          <option>Dr. Nadia Qassimi — Pédiatre</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Notes</label>
        <textarea class="form-input" rows="3" placeholder="Informations supplémentaires..." style="resize:none;"></textarea>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeModal()">Annuler</button>
      <button class="btn btn-primary" onclick="saveRdv()">✅ Confirmer le RDV</button>
    </div>
  </div>
</div>

<!-- SUCCESS TOAST -->
<div id="toast" style="position:fixed;bottom:28px;right:28px;background:var(--deep);color:white;padding:14px 20px;border-radius:12px;font-size:13px;font-weight:500;box-shadow:0 8px 32px rgba(0,0,0,0.2);transform:translateY(100px);opacity:0;transition:all .3s ease;z-index:999;border-left:4px solid var(--teal);">
  ✅ Rendez-vous enregistré avec succès
</div>

<script>
  function openModal() {
    document.getElementById('modalOverlay').classList.add('open');
  }

  function closeModal() {
    document.getElementById('modalOverlay').classList.remove('open');
  }

  function handleOverlayClick(e) {
    if (e.target === document.getElementById('modalOverlay')) closeModal();
  }

  function saveRdv() {
    closeModal();
    const toast = document.getElementById('toast');
    toast.style.transform = 'translateY(0)';
    toast.style.opacity = '1';
    setTimeout(() => {
      toast.style.transform = 'translateY(100px)';
      toast.style.opacity = '0';
    }, 3000);
  }

  function switchView(view) {
    document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
    event.currentTarget.classList.add('active');
    const titles = { dashboard: 'Tableau de bord', agenda: 'Agenda', patients: 'Patients' };
    document.getElementById('page-title').textContent = titles[view] || 'Tableau de bord';
  }

  // Calendar tab interaction
  document.querySelectorAll('.tab').forEach(tab => {
    tab.addEventListener('click', () => {
      tab.closest('.tab-group').querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
    });
  });
</script>
</body>
</html> --}}
