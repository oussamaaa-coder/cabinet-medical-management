@extends('layouts.sidebar')

@section('content')
<div class="doctor-profile-wrapper">
    <!-- Topbar -->
    <div class="app-topbar">
        <div class="app-breadcrumb">
            <a href="{{ route('doctors.index') }}">Médecins</a>
            <span class="sep">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </span>
            <span class="current">Profil du Docteur</span>
        </div>

        <div style="display: flex; gap: 12px;">
            <a href="{{ route('doctors.index') }}" class="app-btn app-btn-secondary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Retour à la liste
            </a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('doctors.edit', $doctor->id) }}" class="app-btn app-btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Modifier le profil
            </a>
            @endif
        </div>
    </div>

    <!-- Doctor Header Card -->
    <div class="app-profile-header">
        <div class="app-profile-main">
            <div class="app-avatar-lg" style="box-shadow: 0 10px 25px var(--accent-glow);">
                <svg viewBox="0 0 24 24" width="44" height="44" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            </div>
            <div class="app-identity">
                <h1>Dr. {{ $doctor->last_name }} {{ $doctor->first_name }}</h1>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span class="badge app-badge-pill" style="background: var(--accent); color: white;">
                        {{ $doctor->speciality ?? 'Médecine Générale' }}
                    </span>
                    <span style="color: var(--text-muted); font-size: 0.9rem;">Expert Medox</span>
                </div>
            </div>
        </div>
        <div style="text-align: right;">
            <div style="font-size: 0.75rem; color: var(--text-label); font-weight: 700; text-transform: uppercase;">Disponibilité</div>
            <div style="display: flex; align-items: center; gap: 8px; justify-content: flex-end; margin-top: 4px;">
                <span style="width: 10px; height: 10px; border-radius: 50%; background: #34d399; box-shadow: 0 0 8px #34d39966;"></span>
                <span style="font-size: 1.1rem; font-weight: 700; color: var(--text-primary);">Disponible</span>
            </div>
        </div>
    </div>

    <!-- Info Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 24px;">
        <!-- Professional Info -->
        <div class="app-info-panel">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 24px; color: var(--accent);">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
                <h3 style="margin:0; font-size: 1.1rem; font-weight: 700;">Informations Professionnelles</h3>
            </div>
            
            <div class="app-info-item">
                <span class="app-info-label">Spécialité</span>
                <span class="app-info-value">{{ $doctor->speciality ?? 'Non spécifiée' }}</span>
            </div>
            <div class="app-info-item">
                <span class="app-info-label">Email professionnel</span>
                <span class="app-info-value accent">{{ $doctor->email }}</span>
            </div>
            <div class="app-info-item">
                <span class="app-info-label">Numéro de téléphone</span>
                <span class="app-info-value">{{ $doctor->phone ?? '—' }}</span>
            </div>
            <div class="app-info-item">
                <span class="app-info-label">Membre depuis</span>
                <span class="app-info-value">{{ $doctor->created_at->format('d/m/Y') }}</span>
            </div>
            <div class="app-info-item">
                <span class="app-info-label">Mot de passe de connexion</span>
                <span class="app-info-value" style="font-family: monospace; letter-spacing: 1px; color: var(--accent);">{{ $doctor->plain_password ?? '—' }}</span>
            </div>
        </div>

        <!-- Working Location -->
        <div class="app-info-panel">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 24px; color: var(--accent);">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <h3 style="margin:0; font-size: 1.1rem; font-weight: 700;">Lieu d'exercice</h3>
            </div>
            
            <div style="padding: 20px; background: var(--bg-field); border-radius: var(--radius-md); border: 1px solid var(--border);">
                 <div style="font-weight: 700; color: var(--text-primary); margin-bottom: 8px;">Centre Médical Medox Main</div>
                 <div style="font-size: 0.95rem; color: var(--text-secondary); line-height: 1.6;">
                    {{ $doctor->address ?? 'Adresse principale du centre' }}
                 </div>
                 <div style="margin-top: 16px; font-size: 0.85rem; color: var(--accent); font-weight: 600;">Cabinet #{{ $doctor->id + 100 }}</div>
            </div>
        </div>
    </div>
</div>

<style>
    .doctor-profile-wrapper { min-h: 100vh; }
</style>
@endsection