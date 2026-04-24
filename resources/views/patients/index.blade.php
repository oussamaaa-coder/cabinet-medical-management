@extends('layouts.sidebar')

@section('content')
<div class="patients-page-wrapper">
    <div class="app-topbar">
        <div class="app-breadcrumb">
            <a href="{{ route('patients.index') }}">Patients</a>
            <span class="sep">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </span>
            <span class="current">Aperçu</span>
        </div>

        <a href="{{ route('patients.create') }}" class="app-btn app-btn-primary">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <line x1="19" y1="8" x2="19" y2="14"/>
                <line x1="16" y1="11" x2="22" y2="11"/>
            </svg>
            Nouveau patient
        </a>
    </div>

    <div class="app-section-title" style="margin-bottom: 16px;">
        <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em;">Statistiques & Filtres</h3>
    </div>

    <div class="stats-grid">
        <!-- Card 1 : Total Patients -->
        <div id="card-total-patients" class="stat-card active">
            <div class="card_icon">
                <svg viewBox="0 0 24 24">
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
                <svg viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            </div>
        </div>

        <!-- Card 2 : Planifiés aujourd'hui -->
        <div id="card-scheduled" class="stat-card">
            <div class="card_icon">
                <svg viewBox="0 0 24 24">
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
                <svg viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            </div>
        </div>

        <!-- Card 3 : Consultés aujourd'hui -->
        <div id="card-consulted" class="stat-card">
            <div class="card_icon">
                <svg viewBox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div class="card_info">
                <div class="card_value">{{ $patientsConsultedToday }}</div>
                <div class="card_label">Consultés aujourd'hui</div>
            </div>
            <div class="card_arrow">
                <svg viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            </div>
        </div>
    </div>

    <div class="dashboard-content">
        <!-- Section: Liste des Patients -->
        <div id="section-patients" class="content-panel active app-card">
            <div class="app-topbar" style="border-bottom: 1px solid var(--border); padding-bottom: 20px; margin-bottom: 20px;">
                <div class="header-left">
                    <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text-primary);">Tous les Patients</h3>
                    <span class="badge app-badge-pill" style="margin-left: 12px;">{{ $totalPatients }}</span>
                </div>
                <form action="{{ route('patients.index') }}" method="GET" class="app-search-bar" style="flex-grow: 1; max-width: 500px;">
                    <div style="position: relative; flex-grow: 1;">
                        <svg style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; fill: none; stroke: var(--text-muted); stroke-width: 2;" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" name="search" id="search-input" class="app-form-control search-input-responsive" placeholder="Rechercher un patient..." value="{{ request('search') }}" style="width: 100%;">
                    </div>
                    <button type="submit" class="app-btn app-btn-primary">Chercher</button>
                    @if(request('search'))
                        <a href="{{ route('patients.index') }}" class="app-btn app-btn-secondary">Reset</a>
                    @endif
                </form>
            </div>
            
            <div class="app-table-wrapper">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th>Nom & Prénom</th>
                            <th>CIN</th>
                            <th>Coordonnées</th>
                            <th>Téléphone</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="patients-tbody">
                        @forelse($patients as $patient)
                        <tr>
                            <td data-label="Nom & Prénom">
                                <div style="display: flex; align-items: center; gap: 12px; font-weight: 600; color: var(--text-primary);">
                                    <div style="width: 36px; height: 36px; border-radius: 10px; background: var(--accent-light); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 700;">{{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}</div>
                                    <span>{{ $patient->last_name }} {{ $patient->first_name }}</span>
                                </div>
                            </td>
                            <td data-label="CIN"><span style="font-family: 'Outfit', monospace; font-size: 0.85rem; color: var(--text-secondary);">{{ $patient->cin ?? '—' }}</span></td>
                            <td data-label="Coordonnées">
                                <div class="coord-cell">
                                    <span style="font-size: 0.85rem; color: var(--text-secondary);">{{ $patient->email ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td data-label="Téléphone">{{ $patient->phone }}</td>
                            <td data-label="Actions">
                                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                    <a href="{{ route('patients.show', $patient->id) }}" class="app-btn-action" title="Voir détails">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ route('patients.edit', $patient->id) }}" class="app-btn-action" title="Modifier">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Confirmer la suppression ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="app-btn-action delete" title="Supprimer">
                                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 48px; color: var(--text-muted); font-style: italic;">Aucun patient dans la base.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="app-pagination">
                {{ $patients->appends(request()->query())->links() }}
            </div>
        </div>
        <!-- ... (scheduled and consulted sections similarly updated) ... -->
    </div>
</div>

<style>
    /* Specific styles for statistics cards that are unique to this page */
    /* Statistics Grid Responsiveness */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    @media (max-width: 640px) {
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }
        
        .stat-card {
            padding: 16px;
            gap: 12px;
        }

        .card_value {
            font-size: 1.5rem;
        }

        .card_icon {
            width: 44px;
            height: 44px;
        }

        .card_icon svg {
            width: 20px;
            height: 20px;
        }
    }

    /* Table Responsiveness */
    @media (max-width: 768px) {
        .app-table thead {
            display: none;
        }

        .app-table tr {
            display: block;
            margin-bottom: 16px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--bg-card);
            padding: 8px;
        }

        .app-table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: right;
            padding: 12px 16px;
            border-bottom: 1px dashed var(--border);
            gap: 12px;
        }

        .app-table td:last-child {
            border-bottom: none;
        }

        .app-table td::before {
            content: attr(data-label);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.65rem;
            color: var(--text-label);
            text-align: left;
            flex-shrink: 0;
            min-width: 100px;
        }

        .coord-cell {
            text-align: right;
            word-break: break-all;
        }

        .app-table td > div {
            display: flex;
            justify-content: flex-end;
            width: 100%;
        }
    }

    .search-input-responsive {
        padding-left: 44px;
        width: 280px;
    }

    @media (max-width: 1024px) {
        .search-input-responsive {
            width: 100%;
        }
        
        .app-search-bar {
            width: 100%;
        }
    }

    .stat-card {
        background: var(--bg-card);
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

    .stat-card.active .card_icon { background: var(--bg-card); }
    .card_icon svg { width: 28px; height: 28px; fill: none; stroke: currentColor; stroke-width: 2; }

    .card_info { flex: 1; }
    .card_value { font-size: 2rem; font-weight: 800; color: var(--text-primary); line-height: 1; margin-bottom: 4px; }
    .card_label { font-size: 0.9rem; color: var(--text-secondary); font-weight: 600; }

    .card_arrow { opacity: 0; transition: all 0.2s; }
    .stat-card:hover .card_arrow { opacity: 1; transform: translateX(5px); }
    .card_arrow svg { width: 20px; height: 20px; fill: none; stroke: var(--accent); stroke-width: 2; }

    .content-panel { display: none; }
    .content-panel.active { display: block; animation: slideUp 0.4s var(--ease); }

    @keyframes slideUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

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
            if(sections[key]) sections[key].classList.add('active');

            Object.values(cards).forEach(c => c.classList.remove('active'));
            if(cards[key]) cards[key].classList.add('active');
        }

        Object.keys(cards).forEach(key => {
            if (cards[key]) {
                cards[key].addEventListener('click', () => switchSection(key));
            }
        });

        // Search highlight logic
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
