@extends('layouts.sidebar')

@section('title', 'Gestion des Dossiers Patients')

@section('content')
<div class="dossiers-page-wrapper">
    <div class="topbar">
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">MediCal</a>
            <span class="sep">›</span>
            <span class="current">Dossiers Médicaux</span>
        </div>

        <div class="topbar-info">
             <span class="date-now">{{ now()->translatedFormat('l d F Y') }}</span>
        </div>
    </div>

    <div class="header-section">
        <div class="header-content">
            <div class="header-eyebrow">Espace médical</div>
            <h1>Dossiers <span class="h1-accent">Patients</span></h1>
            <p>Accédez rapidement à l'historique médical complet de vos patients.</p>
        </div>
        
        <form action="{{ route('dossiers.index') }}" method="GET" class="search-container">
            <div class="search-input-group">
                <svg viewbox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="search" placeholder="Rechercher par nom, CIN ou téléphone..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn-search">Filtrer</button>
            @if(request('search'))
                <a href="{{ route('dossiers.index') }}" class="btn-clear">✕</a>
            @endif
        </form>
    </div>

    <div class="dossiers-grid-container">
        @forelse($patients as $patient)
            <div class="dossier-card">
                <div class="card-status-bar {{ $patient->is_majeur ? 'majeur' : 'mineur' }}">
                    <span class="status-label">{{ $patient->is_majeur ? 'Majeur' : 'Mineur' }}</span>
                </div>
                <div class="card-body">
                    <div class="patient-profile">
                        <div class="avatar-wrapper">
                            @if($patient->photo)
                                <img src="{{ asset($patient->photo) }}" alt="Photo">
                            @else
                                <div class="avatar-placeholder">
                                    {{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="patient-info">
                            <h3>{{ $patient->last_name }} {{ $patient->first_name }}</h3>
                            <span class="patient-id">
                                <svg viewbox="0 0 24 24" width="12" height="12"><rect x="2" y="4" width="20" height="16" rx="2"/><line x1="7" y1="9" x2="17" y2="9"/><line x1="7" y1="13" x2="12" y2="13"/></svg>
                                {{ $patient->cin ?? '—' }}
                            </span>
                        </div>
                    </div>

                    <div class="patient-stats">
                        <div class="stat-item">
                            <span class="stat-label">
                                <svg viewbox="0 0 24 24" width="13" height="13"><path d="M12 2C6 2 2 7 2 12s4 10 10 10 10-4.5 10-10S18 2 12 2z"/><path d="M12 6v6l4 2"/></svg>
                                Groupe Sanguin
                            </span>
                            <span class="stat-value {{ $patient->groupe_sanguin ? 'has-blood' : '' }}">
                                @if($patient->groupe_sanguin)
                                    <span class="blood-badge">{{ $patient->groupe_sanguin }}</span>
                                @else
                                    <span class="empty-val">Non spécifié</span>
                                @endif
                            </span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <span class="stat-label">
                                <svg viewbox="0 0 24 24" width="13" height="13"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.63 19.79 19.79 0 01.17 4.05 2 2 0 012.18 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.91 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                                Téléphone
                            </span>
                            <span class="stat-value phone-val">{{ $patient->phone }}</span>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('patients.show', $patient->id) }}" class="btn-open-dossier">
                            <svg viewbox="0 0 24 24"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
                            Ouvrir le dossier
                            <svg class="arrow-icon" viewbox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="no-results">
                <div class="no-results-icon">
                    <svg viewbox="0 0 24 24"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
                </div>
                <h3>Aucun patient trouvé</h3>
                <p>Essayez une autre recherche ou vérifiez l'orthographe.</p>
                <a href="{{ route('dossiers.index') }}" class="btn-search">Voir tous les patients</a>
            </div>
        @endforelse
    </div>

    <div class="pagination-wrapper">
        {{ $patients->appends(request()->query())->links() }}
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
      --accent: #1a6b4a;
      --accent-2: #0e9966;
      --accent-light: #e8f5ef;
      --accent-mid: #b8deca;
      --accent-dark: #0d4f35;
      --accent-glow: rgba(26, 107, 74, 0.18);
      --accent-glow-strong: rgba(26, 107, 74, 0.28);
      --blood: #c0392b;
      --blood-bg: #fdf0ef;
      --minor: #d97706;
      --minor-light: #fef3c7;
      --text-primary: #0f1f17;
      --text-secondary: #3d5c4a;
      --text-muted: #7a9c8a;
      --border: #d8e8df;
      --border-hover: #a8ccb8;
      --bg-field: #f2f7f4;
      --bg-page: #f5f9f6;
      --bg-card: #ffffff;
      --shadow-xs: 0 1px 3px rgba(0,0,0,0.04);
      --shadow-sm: 0 4px 12px rgba(0,0,0,0.06);
      --shadow-md: 0 12px 32px rgba(0,0,0,0.09);
      --shadow-hover: 0 20px 48px rgba(26,107,74,0.12);
      --radius-card: 22px;
      --radius-btn: 14px;
      --ease: cubic-bezier(0.4, 0, 0.2, 1);
      --ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    [data-theme="dark"] {
      --text-primary: #e2ede7;
      --text-secondary: #9fbfb0;
      --text-muted: #5a7d6e;
      --border: rgba(255, 255, 255, 0.1);
      --bg-field: #151e1a;
      --bg-page: #0f1a14;
      --bg-card: #1a2620;
      --accent-light: #1a2d23;
      --accent-mid: #233629;
      --blood-bg: #2d1a1a;
      --minor-light: #2d261a;
      --shadow-sm: 0 4px 12px rgba(0,0,0,0.3);
      --shadow-md: 0 12px 32px rgba(0,0,0,0.4);
    }

    * { box-sizing: border-box; }

    .dossiers-page-wrapper {
        padding: 36px 44px;
        font-family: 'DM Sans', sans-serif;
        color: var(--text-primary);
        background: var(--bg-page);
        min-height: 100vh;
        position: relative;
    }

    /* Subtle background texture */
    .dossiers-page-wrapper::before {
        content: '';
        position: fixed;
        inset: 0;
        background: 
            radial-gradient(ellipse 80% 60% at 10% 10%, rgba(26,107,74,0.04) 0%, transparent 60%),
            radial-gradient(ellipse 60% 50% at 90% 90%, rgba(14,153,102,0.03) 0%, transparent 55%);
        pointer-events: none;
        z-index: 0;
    }

    .dossiers-page-wrapper > * { position: relative; z-index: 1; }

    /* ── Topbar ───────────────────────────── */
    .topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 44px;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        font-weight: 500;
        background: white;
        padding: 9px 18px;
        border-radius: 40px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-xs);
        letter-spacing: 0.01em;
    }

    .breadcrumb a { color: var(--text-muted); text-decoration: none; transition: color 0.2s; }
    .breadcrumb a:hover { color: var(--accent); }
    .breadcrumb .sep { color: var(--border); font-size: 1.1rem; line-height: 1; }
    .breadcrumb .current { color: var(--accent); font-weight: 700; }

    .date-now {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--accent-dark);
        background: var(--accent-light);
        padding: 9px 18px;
        border-radius: 40px;
        border: 1px solid var(--accent-mid);
        letter-spacing: 0.02em;
        text-transform: capitalize;
    }

    /* ── Header ───────────────────────────── */
    .header-section {
        margin-bottom: 52px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 32px;
        flex-wrap: wrap;
    }

    .header-eyebrow {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: var(--accent-2);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .header-eyebrow::before {
        content: '';
        display: inline-block;
        width: 24px;
        height: 2px;
        background: var(--accent-2);
        border-radius: 2px;
    }

    .header-content h1 {
        font-family: 'Sora', sans-serif;
        font-size: 2.8rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        margin: 0 0 10px 0;
        color: var(--text-primary);
        line-height: 1.1;
    }

    .h1-accent {
        color: var(--accent);
        position: relative;
    }

    .h1-accent::after {
        content: '';
        position: absolute;
        bottom: 4px;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--accent), var(--accent-2));
        border-radius: 2px;
        opacity: 0.4;
    }

    .header-content p {
        font-size: 1rem;
        color: var(--text-secondary);
        margin: 0;
        line-height: 1.6;
    }

    /* ── Search ───────────────────────────── */
    .search-container {
        display: flex;
        gap: 10px;
        background: white;
        padding: 7px;
        border-radius: 18px;
        border: 1.5px solid var(--border);
        box-shadow: var(--shadow-sm);
        width: 100%;
        max-width: 560px;
        transition: all 0.3s var(--ease);
        align-items: center;
    }

    .search-container:focus-within {
        border-color: var(--accent);
        box-shadow: 0 0 0 4px var(--accent-glow), var(--shadow-sm);
    }

    .search-input-group {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 11px;
        padding-left: 12px;
    }

    .search-input-group svg {
        width: 18px;
        height: 18px;
        fill: none;
        stroke: var(--text-muted);
        stroke-width: 2;
        flex-shrink: 0;
        transition: stroke 0.2s;
    }

    .search-container:focus-within .search-input-group svg {
        stroke: var(--accent);
    }

    .search-input-group input {
        border: none;
        outline: none;
        width: 100%;
        font-size: 0.9rem;
        font-family: 'DM Sans', sans-serif;
        color: var(--text-primary);
        background: transparent;
    }

    .search-input-group input::placeholder { color: var(--text-muted); }

    .btn-search {
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
        color: white;
        border: none;
        padding: 11px 22px;
        border-radius: var(--radius-btn);
        font-weight: 700;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.88rem;
        cursor: pointer;
        transition: all 0.25s var(--ease);
        letter-spacing: 0.01em;
        white-space: nowrap;
    }

    .btn-search:hover {
        background: linear-gradient(135deg, var(--accent-dark) 0%, var(--accent) 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px var(--accent-glow-strong);
    }

    .btn-search:active { transform: translateY(0); }

    .btn-clear {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: var(--bg-field);
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 700;
        border: 1px solid var(--border);
        transition: all 0.2s;
        flex-shrink: 0;
    }

    .btn-clear:hover {
        background: #fee2e2;
        border-color: #fca5a5;
        color: #dc2626;
    }

    /* ── Cards Grid ───────────────────────── */
    .dossiers-grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 26px;
    }

    .dossier-card {
        background: var(--bg-card);
        border-radius: var(--radius-card);
        overflow: hidden;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        transition: transform 0.38s var(--ease-spring), box-shadow 0.38s var(--ease), border-color 0.3s var(--ease);
        position: relative;
    }

    .dossier-card:hover {
        transform: translateY(-7px);
        box-shadow: var(--shadow-hover);
        border-color: var(--border-hover);
    }

    /* Status bar with label */
    .card-status-bar {
        height: 42px;
        width: 100%;
        display: flex;
        align-items: center;
        padding: 0 20px;
        gap: 8px;
    }

    .card-status-bar.majeur {
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
    }

    .card-status-bar.mineur {
        background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
    }

    .status-label {
        font-family: 'Sora', sans-serif;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: rgba(255,255,255,0.9);
    }

    .card-status-bar::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: rgba(255,255,255,0.7);
        flex-shrink: 0;
    }

    .card-body { padding: 26px 26px 22px; }

    /* ── Patient Profile ──────────────────── */
    .patient-profile {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 22px;
    }

    .avatar-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        overflow: hidden;
        background: var(--accent-light);
        border: 2px solid var(--accent-mid);
        box-shadow: 0 4px 14px rgba(26,107,74,0.12);
        flex-shrink: 0;
    }

    .avatar-wrapper img { width: 100%; height: 100%; object-fit: cover; }

    .avatar-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Sora', sans-serif;
        font-weight: 800;
        color: var(--accent);
        font-size: 1.15rem;
        letter-spacing: -0.02em;
    }

    .patient-info h3 {
        margin: 0 0 5px;
        font-family: 'Sora', sans-serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: -0.01em;
        line-height: 1.2;
    }

    .patient-id {
        font-size: 0.8rem;
        color: var(--text-muted);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .patient-id svg {
        fill: none;
        stroke: var(--text-muted);
        stroke-width: 2;
    }

    /* ── Stats Panel ──────────────────────── */
    .patient-stats {
        display: flex;
        flex-direction: column;
        gap: 0;
        margin-bottom: 22px;
        background: var(--bg-field);
        border-radius: 14px;
        border: 1px solid var(--border);
        overflow: hidden;
    }

    .stat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        transition: background 0.2s;
    }

    .stat-item:hover { background: rgba(26,107,74,0.04); }

    .stat-divider {
        height: 1px;
        background: var(--border);
        margin: 0 16px;
    }

    .stat-label {
        font-size: 0.76rem;
        color: var(--text-muted);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .stat-label svg {
        fill: none;
        stroke: var(--text-muted);
        stroke-width: 2;
        opacity: 0.7;
    }

    .stat-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-secondary);
    }

    .blood-badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        background: var(--blood-bg);
        color: var(--blood);
        border-radius: 8px;
        font-weight: 800;
        font-size: 0.85rem;
        border: 1px solid rgba(192,57,43,0.2);
        font-family: 'Sora', sans-serif;
    }

    .empty-val {
        font-size: 0.82rem;
        color: var(--text-muted);
        font-style: italic;
        font-weight: 400;
    }

    .phone-val {
        font-family: 'Sora', sans-serif;
        letter-spacing: 0.03em;
        font-size: 0.88rem;
    }

    /* ── CTA Button ───────────────────────── */
    .card-footer { padding-top: 4px; }

    .btn-open-dossier {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        width: 100%;
        background: white;
        color: var(--accent);
        border: 1.5px solid var(--accent-mid);
        padding: 13px 16px;
        border-radius: var(--radius-btn);
        font-family: 'DM Sans', sans-serif;
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.3s var(--ease);
        position: relative;
        overflow: hidden;
    }

    .btn-open-dossier::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
        opacity: 0;
        transition: opacity 0.3s var(--ease);
    }

    .btn-open-dossier:hover::before { opacity: 1; }

    .btn-open-dossier:hover {
        color: white;
        border-color: transparent;
        box-shadow: 0 8px 24px var(--accent-glow-strong);
        transform: translateY(-1px);
    }

    .btn-open-dossier > * { position: relative; z-index: 1; }

    .btn-open-dossier svg {
        width: 18px;
        height: 18px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        flex-shrink: 0;
    }

    .arrow-icon {
        margin-left: auto;
        opacity: 0;
        transform: translateX(-6px);
        transition: opacity 0.25s, transform 0.25s var(--ease);
    }

    .btn-open-dossier:hover .arrow-icon {
        opacity: 1;
        transform: translateX(0);
    }

    /* ── Empty State ──────────────────────── */
    .no-results {
        grid-column: 1 / -1;
        text-align: center;
        padding: 90px 40px;
        background: white;
        border-radius: 32px;
        border: 1.5px dashed var(--border);
    }

    .no-results-icon {
        width: 76px;
        height: 76px;
        background: var(--accent-light);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: var(--accent);
        border: 1px solid var(--accent-mid);
    }

    .no-results-icon svg { width: 38px; height: 38px; fill: none; stroke: currentColor; stroke-width: 1.5; }
    .no-results h3 { font-family: 'Sora', sans-serif; font-size: 1.6rem; font-weight: 800; margin-bottom: 8px; letter-spacing: -0.02em; }
    .no-results p { color: var(--text-secondary); margin-bottom: 28px; font-size: 0.95rem; }

    /* ── Pagination ───────────────────────── */
    .pagination-wrapper {
        margin-top: 56px;
        display: flex;
        justify-content: flex-end;
    }

    .pagination-wrapper nav > div:first-child { display: none !important; }
    .pagination-wrapper nav > div:last-child { 
        display: flex !important; 
        flex-direction: row-reverse !important;
        align-items: center;
        gap: 16px;
    }
    .pagination-wrapper nav p { display: none !important; }

    .pagination-wrapper nav svg { width: 16px; height: 16px; }
    
    .pagination-wrapper .pagination, 
    .pagination-wrapper ul,
    .pagination-wrapper nav > div:last-child > div:last-child {
        display: flex !important;
        list-style: none;
        gap: 5px;
        padding: 0;
        margin: 0;
        align-items: center;
    }

    .pagination-wrapper nav a,
    .pagination-wrapper nav span {
        display: flex !important;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        border-radius: 10px;
        border: 1.5px solid var(--border);
        background: white;
        color: var(--text-secondary);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.83rem;
        transition: all 0.2s var(--ease);
        font-family: 'DM Sans', sans-serif;
    }

    .pagination-wrapper nav span[aria-current="page"],
    .pagination-wrapper nav .active,
    .pagination-wrapper .page-item.active .page-link {
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%) !important;
        color: white !important;
        border-color: transparent !important;
        box-shadow: 0 4px 12px var(--accent-glow-strong);
    }

    .pagination-wrapper nav a:hover {
        background: var(--accent-light) !important;
        border-color: var(--accent-mid) !important;
        color: var(--accent-dark) !important;
        transform: translateY(-2px);
        box-shadow: var(--shadow-xs);
    }

    .pagination-wrapper nav span[aria-disabled="true"],
    .pagination-wrapper nav .disabled {
        opacity: 0.38;
        background: var(--bg-field) !important;
        cursor: not-allowed;
    }

    /* ── Responsive ───────────────────────── */
    @media (max-width: 900px) {
        .dossiers-grid-container { grid-template-columns: repeat(auto-fill, minmax(290px, 1fr)); gap: 18px; }
    }

    @media (max-width: 768px) {
        .dossiers-page-wrapper { padding: 20px 16px; }
        .header-section { flex-direction: column; align-items: stretch; gap: 20px; }
        .header-content h1 { font-size: 2.1rem; }
        .topbar { flex-direction: column; gap: 14px; align-items: flex-start; }
        .search-container { max-width: 100%; }
        .dossiers-grid-container { grid-template-columns: 1fr; }
    }
</style>
@endsection