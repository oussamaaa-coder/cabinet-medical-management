@extends('layouts.sidebar')

@section('content')
<div class="patients-page-wrapper">
    <div class="topbar">
        <div class="breadcrumb">
            <a href="{{ route('patients.index') }}">Patients</a>
            <span class="sep">›</span>
            <span class="current">Aperçu</span>
        </div>

        <a href="{{ route('patients.create') }}" class="btn-new">
            <svg viewbox="0 0 24 24">
                <path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <line x1="19" y1="8" x2="19" y2="14"/>
                <line x1="16" y1="11" x2="22" y2="11"/>
            </svg>
            Nouveau patient
        </a>
    </div>

    <div class="section-title">
        <h3>Statistiques & Filtres</h3>
    </div>

    <div class="stats-grid">
        <!-- Card 1 : Total Patients -->
        <div id="card-total-patients" class="stat-card active">
            <div class="card_icon">
                <svg viewbox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                </svg>
            </div>
            <div class="card_info">
                <div class="card_value">{{ $totalPatients }}</div>
                <div class="card_label">Total Patients</div>
            </div>
            <div class="card_arrow">
                <svg viewbox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            </div>
        </div>

        <!-- Card 2 : Planifiés aujourd'hui -->
        <div id="card-scheduled" class="stat-card">
            <div class="card_icon">
                <svg viewbox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                    <path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01"/>
                </svg>
            </div>
            <div class="card_info">
                <div class="card_value">{{ $patientsPlannedToday }}</div>
                <div class="card_label">Planifiés aujourd'hui</div>
            </div>
            <div class="card_arrow">
                <svg viewbox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            </div>
        </div>

        <!-- Card 3 : Consultés aujourd'hui -->
        <div id="card-consulted" class="stat-card">
            <div class="card_icon">
                <svg viewbox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div class="card_info">
                <div class="card_value">{{ $patientsConsultedToday }}</div>
                <div class="card_label">Consultés aujourd'hui</div>
            </div>
            <div class="card_arrow">
                <svg viewbox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            </div>
        </div>
    </div>

    <div class="dashboard-content">
        <!-- Section: Liste des Patients -->
        <div id="section-patients" class="content-panel active">
            <div class="panel-header">
                <div class="header-left">
                    <h3>Tous les Patients</h3>
                    <span class="badge">{{ $totalPatients }}</span>
                </div>
                <form action="{{ route('patients.index') }}" method="GET" class="search-box">
                    <div class="search-input-wrapper">
                        <svg class="search-icon" viewbox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" name="search" id="search-input" placeholder="Rechercher un patient..." value="{{ request('search') }}">
                    </div>
                    <button type="submit" class="btn-primary">Chercher</button>
                    @if(request('search'))
                        <a href="{{ route('patients.index') }}" class="btn-ghost">Reset</a>
                    @endif
                </form>
            </div>
            
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Nom & Prénom</th>
                            <th>CIN</th>
                            <th>Coordonnées</th>
                            <th>Téléphone</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="patients-tbody">
                        @forelse($patients as $patient)
                        <tr>
                            <td>
                                <div class="patient-name-cell">
                                    <div class="initials-avatar">{{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}</div>
                                    <span>{{ $patient->last_name }} {{ $patient->first_name }}</span>
                                </div>
                            </td>
                            <td><span class="mono-text">{{ $patient->cin ?? '—' }}</span></td>
                            <td>
                                <div class="coord-cell">
                                    <span class="email-text">{{ $patient->email ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td>{{ $patient->phone }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('patients.show', $patient->id) }}" class="btn-icon view" title="Voir détails">
                                        <svg viewbox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ route('patients.edit', $patient->id) }}" class="btn-icon edit" title="Modifier">
                                        <svg viewbox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Confirmer la suppression ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon delete" title="Supprimer">
                                            <svg viewbox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="empty-row">Aucun patient dans la base.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="pagination-container">
                {{ $patients->appends(request()->query())->links() }}
            </div>
        </div>

        <!-- Section: Planifiés aujourd'hui -->
        <div id="section-scheduled" class="content-panel">
            <div class="panel-header">
                <div class="header-left">
                    <h3>RDV Planifiés</h3>
                    <span class="badge">{{ $appointmentsPlanned->count() }}</span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Coordonnées</th>
                            <th>Médecin</th>
                            <th>Heure</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointmentsPlanned as $appointment)
                        <tr>
                            <td>
                                <div class="patient-name-cell">
                                    <div class="initials-avatar green">{{ strtoupper(substr($appointment->patient->first_name, 0, 1) . substr($appointment->patient->last_name, 0, 1)) }}</div>
                                    <span>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="coord-cell">
                                    <span class="phone-text">{{ $appointment->patient->phone ?? '—' }}</span>
                                </div>
                            </td>
                            <td><div class="dr-pill">Dr. {{ $appointment->doctor->last_name }}</div></td>
                            <td><span class="time-text">{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</span></td>
                            <td><span class="status-pill scheduled">Confirmé</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="empty-row">Aucun rendez-vous pour aujourd'hui.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section: Consultés aujourd'hui -->
        <div id="section-consulted" class="content-panel">
            <div class="panel-header">
                <div class="header-left">
                    <h3>Patients Consultés</h3>
                    <span class="badge blue">{{ $appointmentsConsulted->count() }}</span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Coordonnées</th>
                            <th>Médecin</th>
                            <th>Heure</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointmentsConsulted as $appointment)
                        <tr>
                            <td>
                                <div class="patient-name-cell">
                                    <div class="initials-avatar blue">{{ strtoupper(substr($appointment->patient->first_name, 0, 1) . substr($appointment->patient->last_name, 0, 1)) }}</div>
                                    <span>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="coord-cell">
                                    <span class="phone-text">{{ $appointment->patient->phone ?? '—' }}</span>
                                </div>
                            </td>
                            <td><div class="dr-pill">Dr. {{ $appointment->doctor->last_name }}</div></td>
                            <td><span class="time-text">{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</span></td>
                            <td><span class="status-pill completed">Consulté</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="empty-row">Aucune consultation terminée aujourd'hui.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
      --accent: #3a7d5c;
      --accent-light: #eaf3ee;
      --accent-mid: #c4ddd0;
      --accent-dark: #2a6048;
      --accent-glow: rgba(58, 125, 92, 0.15);
      --text-primary: #1a2b22;
      --text-secondary: #4a6358;
      --text-muted: #8aad9c;
      --border: #dce8e1;
      --bg-field: #f4f7f5;
      --bg-page: #f8faf9;
      --card-bg: #ffffff;
      --shadow-sm: 0 2px 4px rgba(0,0,0,0.02);
      --shadow-md: 0 10px 15px -3px rgba(0,0,0,0.05);
      --ease: cubic-bezier(0.4, 0, 0.2, 1);
    }

    [data-theme="dark"] {
      --text-primary: #e2ede7;
      --text-secondary: #9fbfb0;
      --text-muted: #5a7d6e;
      --border: rgba(255, 255, 255, 0.1);
      --bg-field: #151e1a;
      --bg-page: #0f1a14;
      --card-bg: #1a2620;
      --accent-light: #1a2d23;
      --accent-mid: #233629;
      --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .patients-page-wrapper {
        padding: 24px;
        color: var(--text-primary);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Topbar */
    .topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
    }

    .breadcrumb a { color: var(--text-muted); text-decoration: none; transition: color 0.2s; }
    .breadcrumb a:hover { color: var(--accent); }
    .breadcrumb .sep { color: var(--border); font-size: 1.2rem; }
    .breadcrumb .current { color: var(--text-primary); font-weight: 600; }

    .btn-new {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--accent);
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s var(--ease);
        box-shadow: 0 4px 12px var(--accent-glow);
    }

    .btn-new:hover { background: var(--accent-dark); transform: translateY(-2px); }
    .btn-new svg { width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2.5; }

    .section-title h3 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 16px;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: var(--card-bg);
        padding: 24px;
        border-radius: 16px;
        border: 2px solid transparent;
        display: flex;
        align-items: center;
        gap: 20px;
        cursor: pointer;
        transition: all 0.3s var(--ease);
        box-shadow: var(--shadow-sm);
        position: relative;
    }

    .stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); border-color: var(--accent-light); }
    .stat-card.active { border-color: var(--accent); background: var(--accent-light); }

    .card_icon {
        width: 56px;
        height: 56px;
        background: var(--bg-field);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent);
        transition: all 0.2s;
    }

    .stat-card.active .card_icon { background: white; }
    .card_icon svg { width: 28px; height: 28px; fill: none; stroke: currentColor; stroke-width: 2; }

    .card_info { flex: 1; }
    .card_value { font-size: 2rem; font-weight: 800; color: var(--text-primary); line-height: 1; margin-bottom: 4px; }
    .card_label { font-size: 0.9rem; color: var(--text-secondary); font-weight: 600; }

    .card_arrow { opacity: 0; transition: all 0.2s; }
    .stat-card:hover .card_arrow { opacity: 1; transform: translateX(5px); }
    .card_arrow svg { width: 20px; height: 20px; fill: none; stroke: var(--accent); stroke-width: 2; }

    /* Panels */
    .content-panel { display: none; background: var(--card-bg); border-radius: 20px; border: 1px solid var(--border); overflow: hidden; box-shadow: var(--shadow-sm); }
    .content-panel.active { display: block; animation: slideUp 0.4s var(--ease); }

    @keyframes slideUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    .panel-header { padding: 24px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; gap: 20px; flex-wrap: wrap; }
    .header-left { display: flex; align-items: center; gap: 12px; }
    .header-left h3 { font-size: 1.25rem; font-weight: 700; color: var(--text-primary); }
    .badge { background: var(--accent-light); color: var(--accent); padding: 4px 12px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; }
    .badge.blue { background: #e0f2fe; color: #0369a1; }

    /* Search Box */
    .search-box { display: flex; gap: 12px; align-items: center; }
    .search-input-wrapper { position: relative; }
    .search-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; fill: none; stroke: var(--text-muted); stroke-width: 2; }
    .search-input-wrapper input { padding: 10px 16px 10px 44px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg-field); width: 280px; font-size: 0.9rem; outline: none; transition: all 0.2s; }
    .search-input-wrapper input:focus { border-color: var(--accent); background: white; box-shadow: 0 0 0 4px var(--accent-glow); }

    .btn-primary { background: var(--text-primary); color: white; border: none; padding: 10px 20px; border-radius: 10px; font-weight: 600; cursor: pointer; transition: 0.2s; }
    .btn-primary:hover { opacity: 0.9; }
    .btn-ghost { color: var(--text-muted); text-decoration: none; font-weight: 600; font-size: 0.9rem; padding: 8px; }

    /* Modern Table */
    .table-responsive { width: 100%; overflow-x: auto; }
    .modern-table { width: 100%; border-collapse: collapse; min-width: 800px; }
    .modern-table th { text-align: left; padding: 16px 24px; background: var(--bg-field); color: var(--text-secondary); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; }
    .modern-table td { padding: 16px 24px; border-bottom: 1px solid var(--border); vertical-align: middle; }
    .modern-table tbody tr { transition: background 0.2s; }
    .modern-table tbody tr:hover { background: var(--accent-light); opacity: 0.9; }
    
    .patient-name-cell { display: flex; align-items: center; gap: 12px; font-weight: 600; color: var(--text-primary); }
    .initials-avatar { width: 36px; height: 36px; border-radius: 10px; background: var(--accent-light); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 700; }
    .initials-avatar.green { background: #dcfce7; color: #15803d; }
    .initials-avatar.blue { background: #e0f2fe; color: #0369a1; }

    .mono-text { font-family: 'JetBrains Mono', monospace; font-size: 0.85rem; color: var(--text-secondary); }
    .email-text { font-size: 0.85rem; color: var(--text-secondary); }
    .dr-pill { display: inline-block; padding: 4px 10px; background: #fff5eb; color: #9a3412; border-radius: 6px; font-weight: 600; font-size: 0.8rem; }
    .time-text { font-weight: 700; color: var(--text-primary); }
    
    .status-pill { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.02em; }
    .status-pill.scheduled { background: #ecfdf5; color: #059669; }
    .status-pill.completed { background: #f0f9ff; color: #0284c7; }

    .action-buttons { display: flex; gap: 8px; justify-content: flex-end; }
    .btn-icon { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s; border: none; cursor: pointer; background: transparent; }
    .btn-icon svg { width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2; }
    .btn-icon.view { color: var(--accent); }
    .btn-icon.view:hover { background: var(--accent-light); }
    .btn-icon.edit { color: #2563eb; }
    .btn-icon.edit:hover { background: #eff6ff; }
    .btn-icon.delete { color: #dc2626; }
    .btn-icon.delete:hover { background: #fef2f2; }

    .empty-row { text-align: center; padding: 48px !important; color: var(--text-muted); font-style: italic; }

    .pagination-container { padding: 32px 24px; display: flex; justify-content: flex-end; }

    /* Fix Laravel Pagination Conflict */
    .pagination-container nav > div:first-child { display: none !important; }
    .pagination-container nav > div:last-child { 
        display: flex !important; 
        flex-direction: row-reverse !important;
        align-items: center;
        gap: 16px;
    }
    .pagination-container nav p { display: none !important; } /* Hide "Showing..." text */

    /* Custom Pagination Styling */
    .pagination-container nav svg { width: 18px; height: 18px; }
    
    .pagination-container .pagination, 
    .pagination-container ul,
    .pagination-container nav > div:last-child > div:last-child {
        display: flex !important;
        list-style: none;
        gap: 6px;
        padding: 0;
        margin: 0;
        align-items: center;
    }

    /* Target the actual link/span elements more precisely */
    .pagination-container nav a,
    .pagination-container nav span {
        display: flex !important;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 12px;
        border-radius: 10px;
        border: 1px solid var(--border);
        background: var(--card-bg);
        color: var(--text-secondary);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s var(--ease);
    }

    .pagination-container nav span[aria-current="page"],
    .pagination-container nav .active,
    .pagination-container .page-item.active .page-link {
        background: var(--accent) !important;
        border-color: var(--accent) !important;
        color: white !important;
        box-shadow: 0 4px 10px var(--accent-glow);
    }

    .pagination-container nav a:hover {
        background: var(--accent-light) !important;
        border-color: var(--accent-mid) !important;
        color: var(--accent-dark) !important;
        transform: translateY(-2px);
    }

    .pagination-container nav span[aria-disabled="true"],
    .pagination-container nav .disabled {
        opacity: 0.4;
        background: var(--bg-field) !important;
        cursor: not-allowed;
    }

    @media (max-width: 1024px) {
        .panel-header { flex-direction: column; align-items: flex-start; }
        .search-box { width: 100%; }
        .search-input-wrapper { flex: 1; }
        .search-input-wrapper input { width: 100%; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = {
            'total': document.getElementById('card-total-patients'),
            'scheduled': document.getElementById('card-scheduled'),
            'consulted': document.getElementById('card-consulted')
        };

        const sections = {
            'total': document.getElementById('section-patients'),
            'scheduled': document.getElementById('section-scheduled'),
            'consulted': document.getElementById('section-consulted')
        };

        function switchSection(key) {
            Object.values(sections).forEach(s => s.classList.remove('active'));
            sections[key].classList.add('active');

            Object.values(cards).forEach(c => c.classList.remove('active'));
            cards[key].classList.add('active');
        }

        Object.keys(cards).forEach(key => {
            if (cards[key]) {
                cards[key].addEventListener('click', () => switchSection(key));
            }
        });

        // Search highlight logic (optional client-side filter)
        const searchInput = document.getElementById('search-input');
        const tbody = document.getElementById('patients-tbody');
        
        if(searchInput && tbody) {
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                const rows = tbody.querySelectorAll('tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(query) ? '' : 'none';
                });
            });
        }
    });
</script>
@endsection
