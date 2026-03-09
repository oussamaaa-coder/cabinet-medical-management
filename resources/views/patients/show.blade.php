@extends('layouts.sidebar')

@section('title', 'Dossier Patient — ' . $patient->first_name . ' ' . $patient->last_name)

@section('content')
<div class="patient-details-wrapper">
    <!-- Topbar Actions -->
    <div class="topbar">
        <div class="breadcrumb">
            <a href="{{ route('patients.index') }}">Patients</a>
            <span class="sep">›</span>
            <span class="current">Dossier Patient</span>
        </div>

        <div class="action-group">
            <a href="{{ route('prescriptions.create', ['patient_id' => $patient->id]) }}" class="btn-secondary">
                <svg viewbox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
                Nouvelle Ordonnance
            </a>
            <a href="{{ route('patients.edit', $patient->id) }}" class="btn-primary">
                <svg viewbox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Modifier
            </a>
        </div>
    </div>

    <!-- Patient Header Card -->
    <div class="patient-header-card">
        <div class="profile-main">
            <div class="avatar-container">
                @if($patient->photo)
                    <img src="{{ asset($patient->photo) }}" class="avatar-large" alt="Photo patient">
                @else
                    <div class="avatar-placeholder">
                        {{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <div class="identity-info">
                <div class="name-badge-row">
                    <h1>{{ $patient->first_name }} {{ $patient->last_name }}</h1>
                    <span class="status-pill {{ $patient->is_majeur ? 'majeur' : 'mineur' }}">
                        {{ $patient->is_majeur ? 'Majeur' : 'Mineur' }}
                    </span>
                </div>
                <div class="meta-info">
                    <span class="meta-item">
                        <strong>CIN:</strong> {{ $patient->cin ?? 'Non renseigné' }}
                    </span>
                    <span class="meta-sep">•</span>
                    <span class="meta-item">
                        <strong>Né(e) le:</strong> {{ \Carbon\Carbon::parse($patient->birth_date)->format('d/m/Y') }}
                    </span>
                </div>
            </div>
        </div>
        <div class="header-stats">
            <div class="mini-stat">
                <span class="label">Groupe Sanguin</span>
                <span class="value blood">{{ $patient->groupe_sanguin ?? '—' }}</span>
            </div>
            <div class="mini-stat">
                <span class="label">Assurance</span>
                <span class="value">{{ $patient->assurance ?? 'Aucune' }}</span>
            </div>
        </div>
    </div>

    <!-- Dossier Content with Tabs -->
    <div class="dossier-container" x-data="{ activeTab: 'details' }">
        <!-- Tab Navigation -->
        <div class="tab-nav">
            <button @click="activeTab = 'details'" :class="{ 'active': activeTab === 'details' }">
                <svg viewbox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Informations
            </button>
            <button @click="activeTab = 'appointments'" :class="{ 'active': activeTab === 'appointments' }">
                <svg viewbox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Rendez-vous
                <span class="count-badge">{{ $patient->appointments->count() }}</span>
            </button>
            <button @click="activeTab = 'prescriptions'" :class="{ 'active': activeTab === 'prescriptions' }">
                <svg viewbox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Ordonnances
                <span class="count-badge">{{ $patient->prescriptions->count() }}</span>
            </button>
        </div>

        <!-- Tab Panels -->
        <div class="tab-content">
            <!-- Details Tab -->
            <div x-show="activeTab === 'details'" class="tab-panel animate-fade-in">
                <div class="details-grid">
                    <!-- Contact & Info -->
                    <div class="info-panel">
                        <div class="panel-header">
                            <svg viewbox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <h3>Coordonnées</h3>
                        </div>
                        <div class="info-list">
                            <div class="info-item">
                                <span class="label">Sexe</span>
                                <span class="value">{{ $patient->gender == 'male' ? 'Masculin' : 'Féminin' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Téléphone</span>
                                <span class="value highlight">{{ $patient->phone ?? '—' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Email</span>
                                <span class="value">{{ $patient->email ?? '—' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Nationalité</span>
                                <span class="value">{{ $patient->nationality ?? 'Marocaine' }}</span>
                            </div>
                        </div>
                    </div>

                    @if(!$patient->is_majeur)
                    <div class="info-panel responsible-panel">
                        <div class="panel-header">
                            <svg viewbox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                            <h3>Responsable Légal</h3>
                        </div>
                        <div class="info-list">
                            <div class="info-item">
                                <span class="label">Type / Relation</span>
                                <span class="value">{{ $patient->type_responsable }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Nom complet</span>
                                <span class="value">{{ $patient->nom_responsable }} {{ $patient->prenom_responsable }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Téléphone</span>
                                <span class="value highlight">{{ $patient->phone_responsable }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">CIN Responsable</span>
                                <span class="value mono">{{ $patient->cin_responsable }}</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Medical History -->
                    <div class="info-panel full-width">
                        <div class="panel-header">
                            <svg viewbox="0 0 24 24"><path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
                            <h3>Antécédents & Remarques</h3>
                        </div>
                        <div class="medical-data-grid">
                            <div class="data-block">
                                <h4>Antécédents Personnels</h4>
                                <p>{{ $patient->antecedents_personnels ?? 'Néant' }}</p>
                            </div>
                            <div class="data-block">
                                <h4>Antécédents Familiaux</h4>
                                <p>{{ $patient->antecedents_familiaux ?? 'Néant' }}</p>
                            </div>
                            <div class="data-block">
                                <h4>Allergies</h4>
                                <p class="warning-text">{{ $patient->allergies ?? 'Aucune' }}</p>
                            </div>
                            <div class="data-block">
                                <h4>Note Psychomoteur</h4>
                                <p>{{ $patient->developpement_psychomoteur ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appointments Tab -->
            <div x-show="activeTab === 'appointments'" class="tab-panel animate-fade-in">
                <div class="table-card">
                    @if($patient->appointments->isEmpty())
                        <div class="empty-state">
                            <div class="icon-circle">
                                <svg viewbox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <p>Aucun rendez-vous enregistré pour ce patient.</p>
                            <a href="{{ route('agenda.index') }}" class="btn-secondary small">Aller à l'agenda</a>
                        </div>
                    @else
                        <table class="premium-table">
                            <thead>
                                <tr>
                                    <th>Date & Heure</th>
                                    <th>Type</th>
                                    <th>Médecin</th>
                                    <th>Statut</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($patient->appointments as $appointment)
                                    <tr>
                                        <td>
                                            <div class="date-time">
                                                <span class="d">{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</span>
                                                <span class="t">{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</span>
                                            </div>
                                        </td>
                                        <td><span class="type-tag">{{ $appointment->type }}</span></td>
                                        <td>Dr. {{ $appointment->doctor->last_name ?? '—' }}</td>
                                        <td>
                                            <span class="status-badge {{ $appointment->status }}">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                        </td>
                                        <td class="notes-cell" title="{{ $appointment->notes }}">{{ Str::limit($appointment->notes, 30) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            <!-- Prescriptions Tab -->
            <div x-show="activeTab === 'prescriptions'" class="tab-panel animate-fade-in">
                <div class="prescriptions-grid">
                    @forelse($patient->prescriptions as $prescription)
                        <div class="prescription-card">
                            <div class="pc-header">
                                <div class="pc-date">
                                    <span class="day">{{ \Carbon\Carbon::parse($prescription->prescription_date)->format('d') }}</span>
                                    <span class="month">{{ \Carbon\Carbon::parse($prescription->prescription_date)->translatedFormat('M Y') }}</span>
                                </div>
                                <div class="pc-meta">
                                    <span class="dr">Dr. {{ $prescription->doctor->name ?? '—' }}</span>
                                    <span class="items-count">{{ $prescription->items->count() }} Médicament(s)</span>
                                </div>
                            </div>
                            <div class="pc-body">
                                <h5>Diagnostic / Notes</h5>
                                <p>{{ Str::limit($prescription->diagnosis ?? $prescription->notes, 80) }}</p>
                            </div>
                            <div class="pc-footer">
                                <a href="{{ route('prescriptions.print', $prescription->id) }}" target="_blank" class="action-link">
                                    <svg viewbox="0 0 24 24"><path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2m-12 0v5h12v-5m-12 0h12"/></svg>
                                    Imprimer
                                </a>
                                <a href="{{ route('prescriptions.show', $prescription->id) }}" class="action-link primary">
                                    Voir détails
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="icon-circle">
                                <svg viewbox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <p>Aucune ordonnance émise.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
    :root {
      --accent: #3a7d5c;
      --accent-light: #eaf3ee;
      --accent-dark: #2a6048;
      --accent-mid: #8aad9c;
      --text-primary: #1a2b22;
      --text-secondary: #4a6358;
      --text-muted: #8aad9c;
      --border: #dce8e1;
      --bg-field: #f4f7f5;
      --shadow-soft: 0 10px 25px -5px rgba(0,0,0,0.05);
      --ease: cubic-bezier(0.4, 0, 0.2, 1);
    }

    .patient-details-wrapper { padding: 32px; font-family: 'Plus Jakarta Sans', sans-serif; background: #fbfcfb; min-h: 100vh; }

    /* Topbar */
    .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
    .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 0.9rem; }
    .breadcrumb a { color: var(--text-muted); text-decoration: none; transition: 0.2s; }
    .breadcrumb a:hover { color: var(--accent); }
    .breadcrumb .sep { color: var(--border); }
    .breadcrumb .current { color: var(--text-primary); font-weight: 600; }

    .action-group { display: flex; gap: 12px; }
    .btn-primary, .btn-secondary { display: flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 12px; font-weight: 600; text-decoration: none; transition: 0.2s var(--ease); font-size: 0.9rem; }
    
    .btn-primary { background: var(--accent); color: white; border: none; box-shadow: 0 4px 12px rgba(58,125,92,0.2); }
    .btn-primary:hover { background: var(--accent-dark); transform: translateY(-2px); }
    
    .btn-secondary { background: white; color: var(--text-primary); border: 1px solid var(--border); }
    .btn-secondary:hover { background: var(--bg-field); border-color: var(--accent-mid); }
    .btn-secondary.small { padding: 6px 14px; font-size: 0.8rem; border-radius: 8px; }
    
    .btn-primary svg, .btn-secondary svg { width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2; }

    /* Header Card */
    .patient-header-card {
        background: white; padding: 32px; border-radius: 24px; border: 1px solid var(--border);
        display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;
        box-shadow: var(--shadow-soft);
    }

    .profile-main { display: flex; align-items: center; gap: 24px; }
    .avatar-large { width: 96px; height: 96px; border-radius: 24px; object-fit: cover; border: 4px solid var(--accent-light); }
    .avatar-placeholder { width: 96px; height: 96px; border-radius: 24px; background: var(--accent-light); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 700; border: 4px solid var(--accent-light); }

    .identity-info h1 { font-size: 1.8rem; font-weight: 800; color: var(--text-primary); margin: 0; }
    .name-badge-row { display: flex; align-items: center; gap: 16px; margin-bottom: 8px; }
    
    .status-pill { padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
    .status-pill.majeur { background: #dcfce7; color: #15803d; }
    .status-pill.mineur { background: #fef9c3; color: #a16207; }

    .meta-info { display: flex; align-items: center; gap: 12px; color: var(--text-secondary); font-size: 0.9rem; }
    .meta-sep { color: var(--border); }

    .header-stats { display: flex; gap: 40px; }
    .mini-stat { display: flex; flex-direction: column; gap: 4px; }
    .mini-stat .label { font-size: 0.7rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; }
    .mini-stat .value { font-size: 1.1rem; font-weight: 700; color: var(--text-primary); }
    .mini-stat .value.blood { color: #dc2626; }

    /* Dossier Layout & Tabs */
    .tab-nav { 
        display: flex; gap: 16px; border-bottom: 1px solid var(--border); margin-bottom: 24px; padding: 0 8px;
    }
    .tab-nav button { 
        padding: 12px 20px; border: none; background: none; color: var(--text-muted); font-weight: 600; cursor: pointer;
        display: flex; align-items: center; gap: 10px; transition: 0.2s; position: relative; font-size: 0.95rem;
    }
    .tab-nav button:hover { color: var(--accent); }
    .tab-nav button.active { color: var(--accent); }
    .tab-nav button.active::after { 
        content: ''; position: absolute; bottom: -1px; left: 0; width: 100%; height: 2px; background: var(--accent); border-radius: 2px;
    }
    .tab-nav button svg { width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2; opacity: 0.7; }
    .count-badge { background: var(--bg-field); color: var(--text-secondary); padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; font-weight: 700; }
    .active .count-badge { background: var(--accent-light); color: var(--accent); }

    .tab-panel { min-height: 400px; }
    .animate-fade-in { animation: fadeIn 0.3s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    /* Tables & Cards */
    .table-card { background: white; border-radius: 20px; border: 1px solid var(--border); overflow: hidden; box-shadow: var(--shadow-soft); }
    .premium-table { width: 100%; border-collapse: collapse; text-align: left; }
    .premium-table th { background: #f9fbf9; padding: 16px 20px; font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; border-bottom: 1px solid var(--border); }
    .premium-table td { padding: 16px 20px; font-size: 0.9rem; border-bottom: 1px solid var(--bg-field); color: var(--text-primary); vertical-align: middle; }
    .premium-table tr:last-child td { border: none; }
    
    .date-time { display: flex; flex-direction: column; }
    .date-time .d { font-weight: 700; color: var(--text-primary); }
    .date-time .t { font-size: 0.8rem; color: var(--text-secondary); }

    .type-tag { padding: 4px 10px; background: var(--bg-field); border-radius: 8px; font-weight: 600; font-size: 0.8rem; color: var(--text-secondary); }
    .status-badge { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }
    .status-badge.planned { background: #eff6ff; color: #1d4ed8; }
    .status-badge.completed { background: #f0fdf4; color: #15803d; }
    .status-badge.urgent { background: #fff7ed; color: #c2410c; }
    .status-badge.cancelled { background: #fef2f2; color: #b91c1c; }

    /* Prescription Cards */
    .prescriptions-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px; }
    .prescription-card { background: white; border: 1px solid var(--border); border-radius: 20px; padding: 24px; box-shadow: var(--shadow-soft); display: flex; flex-direction: column; gap: 16px; transition: 0.2s; }
    .prescription-card:hover { transform: translateY(-4px); border-color: var(--accent-mid); }
    
    .pc-header { display: flex; gap: 16px; align-items: flex-start; }
    .pc-date { display: flex; flex-direction: column; align-items: center; background: var(--bg-field); padding: 8px; border-radius: 12px; min-w: 60px; }
    .pc-date .day { font-size: 1.2rem; font-weight: 800; color: var(--accent); }
    .pc-date .month { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); }
    
    .pc-meta { display: flex; flex-direction: column; }
    .pc-meta .dr { font-weight: 700; color: var(--text-primary); }
    .pc-meta .items-count { font-size: 0.8rem; color: var(--text-muted); }

    .pc-body h5 { font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; margin: 0 0 6px 0; }
    .pc-body p { font-size: 0.9rem; color: var(--text-secondary); margin: 0; line-height: 1.5; }

    .pc-footer { display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 16px; border-top: 1px solid var(--bg-field); }
    .action-link { display: flex; align-items: center; gap: 6px; font-size: 0.8rem; font-weight: 700; color: var(--text-muted); text-decoration: none; transition: 0.2s; }
    .action-link:hover { color: var(--accent); }
    .action-link.primary { color: var(--accent); }
    .action-link svg { width: 14px; height: 14px; fill: none; stroke: currentColor; stroke-width: 2.5; }

    /* Info Grid (Details Tab) */
    .details-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; }
    .info-panel { background: white; padding: 24px; border-radius: 20px; border: 1px solid var(--border); box-shadow: var(--shadow-soft); }
    .info-panel.full-width { grid-column: span 2; }
    .panel-header { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--bg-field); }
    .panel-header svg { width: 22px; height: 22px; fill: none; stroke: var(--accent); stroke-width: 2; }
    .panel-header h3 { font-size: 1.1rem; font-weight: 700; margin: 0; color: var(--text-primary); }

    .info-list { display: flex; flex-direction: column; gap: 12px; }
    .info-item { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px dashed var(--bg-field); }
    .info-item .label { color: var(--text-secondary); font-weight: 500; font-size: 0.95rem; }
    .info-item .value { color: var(--text-primary); font-weight: 600; font-size: 0.95rem; }
    .info-item .value.highlight { color: var(--accent); }
    .info-item .value.mono { font-family: 'JetBrains Mono', monospace; font-size: 0.85rem; }

    .medical-data-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 32px; }
    .data-block h4 { font-size: 0.85rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; }
    .data-block p { font-size: 0.95rem; line-height: 1.6; color: var(--text-secondary); margin: 0; }
    .warning-text { color: #dc2626 !important; font-weight: 600; }

    .empty-state { padding: 60px 40px; text-align: center; color: var(--text-muted); display: flex; flex-direction: column; align-items: center; gap: 16px; }
    .empty-state .icon-circle { width: 64px; height: 64px; background: var(--bg-field); border-radius: 32px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); }
    .empty-state .icon-circle svg { width: 32px; height: 32px; fill: none; stroke: currentColor; stroke-width: 1.5; }

    @media (max-width: 900px) {
        .patient-header-card { flex-direction: column; align-items: flex-start; gap: 24px; }
        .details-grid { grid-template-columns: 1fr; }
        .info-panel.full-width { grid-column: auto; }
        .medical-data-grid { grid-template-columns: 1fr; gap: 24px; }
        .tab-nav { flex-wrap: wrap; }
    }
</style>
@endsection
