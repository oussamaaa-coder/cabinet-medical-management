@extends('layouts.sidebar')

@section('content')
<div class="patient-dossier-wrapper">
    <!-- Topbar -->
    <div class="app-topbar">
        <div class="app-breadcrumb">
            <a href="{{ route('patients.index') }}">Patients</a>
            <span class="sep">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </span>
            <span class="current">Dossier Patient</span>
        </div>

        <div style="display: flex; gap: 12px;">
            <a href="{{ route('prescriptions.create', ['patient_id' => $patient->id]) }}" class="app-btn app-btn-secondary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
                Nouvelle Ordonnance
            </a>
            <a href="{{ route('patients.edit', $patient->id) }}" class="app-btn app-btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Modifier le Dossier
            </a>
        </div>
    </div>

    <!-- Profile Header Card -->
    <div class="app-profile-header">
        <div class="app-profile-main">
            <div class="app-avatar-lg">
                @if($patient->photo)
                    <img src="{{ asset($patient->photo) }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: inherit;" alt="Photo patient">
                @else
                    {{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}
                @endif
            </div>
            <div class="app-identity">
                <h1>{{ $patient->first_name }} {{ $patient->last_name }}</h1>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span class="badge {{ $patient->is_majeur ? 'app-badge-pill' : 'badge-warning' }}" style="background: {{ $patient->is_majeur ? 'var(--accent-light)' : '#fef9c3' }}; color: {{ $patient->is_majeur ? 'var(--accent)' : '#a16207' }};">
                        {{ $patient->is_majeur ? 'Patient Majeur' : 'Patient Mineur' }}
                    </span>
                    <span style="color: var(--text-muted); font-size: 0.9rem;">ID: #{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>
        </div>
        <div style="display: flex; gap: 32px; text-align: right;">
            <div>
                <div style="font-size: 0.75rem; color: var(--text-label); font-weight: 700; text-transform: uppercase;">Groupe Sanguin</div>
                <div style="font-size: 1.25rem; font-weight: 800; color: var(--danger);">{{ $patient->groupe_sanguin ?? '—' }}</div>
            </div>
            <div>
                <div style="font-size: 0.75rem; color: var(--text-label); font-weight: 700; text-transform: uppercase;">Assurance</div>
                <div style="font-size: 1.1rem; font-weight: 700; color: var(--text-primary);">{{ $patient->assurance ?? 'Aucune' }}</div>
            </div>
        </div>
    </div>

    <!-- Dossier Content with Tabs -->
    <div x-data="{ activeTab: 'details' }">
        <!-- Tab Navigation -->
        <div class="app-tabs">
            <button @click="activeTab = 'details'" :class="{ 'app-tab-btn active': activeTab === 'details', 'app-tab-btn': activeTab !== 'details' }">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Informations
            </button>
            <button @click="activeTab = 'appointments'" :class="{ 'app-tab-btn active': activeTab === 'appointments', 'app-tab-btn': activeTab !== 'appointments' }">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Rendez-vous
                <span style="margin-left: 6px; font-size: 0.75rem; padding: 2px 6px; background: var(--bg-field); border-radius: 6px; color: var(--text-secondary);">{{ $patient->appointments->count() }}</span>
            </button>
            <button @click="activeTab = 'prescriptions'" :class="{ 'app-tab-btn active': activeTab === 'prescriptions', 'app-tab-btn': activeTab !== 'prescriptions' }">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Ordonnances
                <span style="margin-left: 6px; font-size: 0.75rem; padding: 2px 6px; background: var(--bg-field); border-radius: 6px; color: var(--text-secondary);">{{ $patient->prescriptions->count() }}</span>
            </button>
        </div>

        <!-- Tab Panels -->
        <div style="margin-top: 24px;">
            <!-- Details Tab -->
            <div x-show="activeTab === 'details'" style="animation: slideUp 0.3s ease-out;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 24px;">
                    <!-- Panel: Coordonnées -->
                    <div class="app-info-panel">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; color: var(--accent);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <h3 style="margin:0; font-size: 1.05rem; font-weight: 700;">Coordonnées & État Civil</h3>
                        </div>
                        <div class="app-info-item"><span class="app-info-label">Sexe</span><span class="app-info-value">{{ $patient->gender == 'male' ? 'Masculin' : 'Féminin' }}</span></div>
                        <div class="app-info-item"><span class="app-info-label">Date de Naissance</span><span class="app-info-value">{{ \Carbon\Carbon::parse($patient->birth_date)->format('d/m/Y') }}</span></div>
                        <div class="app-info-item"><span class="app-info-label">Téléphone</span><span class="app-info-value accent">{{ $patient->phone ?? '—' }}</span></div>
                        <div class="app-info-item"><span class="app-info-label">Email</span><span class="app-info-value">{{ $patient->email ?? '—' }}</span></div>
                        <div class="app-info-item"><span class="app-info-label">CIN / Passeport</span><span class="app-info-value" style="font-family: monospace;">{{ $patient->cin ?? 'Non renseigné' }}</span></div>
                    </div>

                    @if(!$patient->is_majeur)
                    <!-- Panel: Responsable Légal -->
                    <div class="app-info-panel">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; color: var(--warning);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                            <h3 style="margin:0; font-size: 1.05rem; font-weight: 700;">Responsable Légal</h3>
                        </div>
                        <div class="app-info-item"><span class="app-info-label">Type / Relation</span><span class="app-info-value">{{ $patient->type_responsable }}</span></div>
                        <div class="app-info-item"><span class="app-info-label">Nom complet</span><span class="app-info-value">{{ $patient->nom_responsable }} {{ $patient->prenom_responsable }}</span></div>
                        <div class="app-info-item"><span class="app-info-label">Téléphone</span><span class="app-info-value accent">{{ $patient->phone_responsable }}</span></div>
                        <div class="app-info-item"><span class="app-info-label">CIN Responsable</span><span class="app-info-value" style="font-family: monospace;">{{ $patient->cin_responsable }}</span></div>
                    </div>
                    @endif

                    <!-- Panel: Antécédents (Full Width) -->
                    <div class="app-info-panel" style="grid-column: 1 / -1;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; color: var(--accent);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
                            <h3 style="margin:0; font-size: 1.05rem; font-weight: 700;">Antécédents & Observations Médicales</h3>
                        </div>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 32px;">
                            <div>
                                <div style="font-size: 0.75rem; color: var(--text-label); font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">Antécédents Personnels</div>
                                <div style="color: var(--text-secondary); line-height: 1.6;">{{ $patient->antecedents_personnels ?? 'Néant' }}</div>
                            </div>
                            <div>
                                <div style="font-size: 0.75rem; color: var(--text-label); font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">Antécédents Familiaux</div>
                                <div style="color: var(--text-secondary); line-height: 1.6;">{{ $patient->antecedents_familiaux ?? 'Néant' }}</div>
                            </div>
                            <div>
                                <div style="font-size: 0.75rem; color: var(--danger); font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">Allergies Connues</div>
                                <div style="color: var(--danger); font-weight: 600; line-height: 1.6;">{{ $patient->allergies ?? 'Aucune' }}</div>
                            </div>
                            <div>
                                <div style="font-size: 0.75rem; color: var(--text-label); font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">Notes Développement</div>
                                <div style="color: var(--text-secondary); line-height: 1.6;">{{ $patient->developpement_psychomoteur ?? '—' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appointments Tab -->
            <div x-show="activeTab === 'appointments'" style="animation: slideUp 0.3s ease-out;">
                <div class="app-card">
                    <div class="app-table-wrapper">
                        <table class="app-table">
                            <thead>
                                <tr>
                                    <th>Date & Heure</th>
                                    <th>Type / Motif</th>
                                    <th>Médecin consultant</th>
                                    <th>Statut</th>
                                    <th style="text-align: right;">Observations</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($patient->appointments as $appointment)
                                    <tr>
                                        <td>
                                            <div style="font-weight: 600; color: var(--text-primary);">{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</div>
                                            <div style="font-size: 0.8rem; color: var(--text-muted);">{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</div>
                                        </td>
                                        <td><span class="badge app-badge-pill" style="background: var(--bg-field); color: var(--text-secondary);">{{ $appointment->type }}</span></td>
                                        <td><span style="font-weight: 500; color: var(--text-primary);">Dr. {{ $appointment->doctor->last_name ?? '—' }}</span></td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'planned' => ['bg' => '#eff6ff', 'text' => '#1d4ed8'],
                                                    'completed' => ['bg' => 'var(--accent-light)', 'text' => 'var(--accent)'],
                                                    'urgent' => ['bg' => '#fff7ed', 'text' => '#c2410c'],
                                                    'cancelled' => ['bg' => '#fef2f2', 'text' => '#b91c1c']
                                                ];
                                                $col = $statusColors[$appointment->status] ?? ['bg' => '#f3f4f6', 'text' => '#374151'];
                                            @endphp
                                            <span class="badge app-badge" style="background: {{ $col['bg'] }}; color: {{ $col['text'] }};">{{ ucfirst($appointment->status) }}</span>
                                        </td>
                                        <td style="text-align: right; font-size: 0.85rem; color: var(--text-muted);">{{ Str::limit($appointment->notes, 40) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" style="text-align: center; padding: 48px; color: var(--text-muted);">Aucun historique de rendez-vous.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Prescriptions Tab -->
            <div x-show="activeTab === 'prescriptions'" style="animation: slideUp 0.3s ease-out;">
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                    @forelse($patient->prescriptions as $prescription)
                        <div class="app-card" style="padding: 20px; transition: all 0.2s; cursor: default;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                                <div style="width: 44px; height: 44px; background: var(--bg-field); border-radius: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                    <span style="font-size: 1rem; font-weight: 800; color: var(--accent); line-height: 1;">{{ \Carbon\Carbon::parse($prescription->prescription_date)->format('d') }}</span>
                                    <span style="font-size: 0.6rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted);">{{ \Carbon\Carbon::parse($prescription->prescription_date)->translatedFormat('M Y') }}</span>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-weight: 700; color: var(--text-primary); font-size: 0.95rem;">Dr. {{ $prescription->doctor->name ?? '—' }}</div>
                                    <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $prescription->items->count() }} Médicament(s)</div>
                                </div>
                            </div>
                            <div style="margin-bottom: 20px; padding-top: 15px; border-top: 1px solid var(--border);">
                                <div style="font-size: 0.7rem; color: var(--text-label); text-transform: uppercase; margin-bottom: 6px; font-weight: 700;">Observations</div>
                                <p style="font-size: 0.85rem; color: var(--text-secondary); margin: 0; line-height: 1.5;">{{ Str::limit($prescription->diagnosis ?? $prescription->notes, 100) }}</p>
                            </div>
                            <div style="display: flex; border-top: 1px solid var(--border); padding-top: 15px; gap: 12px; justify-content: space-between;">
                                <a href="{{ route('prescriptions.print', $prescription->id) }}" target="_blank" class="app-btn-action" style="width: auto; padding: 0 12px; font-size: 0.75rem; gap: 6px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2m-12 0v5h12v-5m-12 0h12"/></svg>
                                    Imprimer
                                </a>
                                <a href="{{ route('prescriptions.show', $prescription->id) }}" class="app-btn app-btn-secondary" style="font-size: 0.75rem; padding: 6px 12px; border-radius: 8px;">Voir l'ordonnance</a>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: 1 / -1; text-align: center; padding: 60px 40px; color: var(--text-muted);">
                             <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 16px; opacity: 0.5;"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                             <p>Aucune ordonnance émise pour ce patient.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
    @keyframes slideUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .patient-dossier-wrapper { min-h: 100vh; }
</style>
@endsection
