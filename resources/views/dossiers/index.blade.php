@extends('layouts.sidebar')

@section('title', 'Dossiers Patients')

@section('content')
<link rel="stylesheet" href="{{ asset('asset/css/style_global.css') }}">
<link rel="stylesheet" href="{{ asset('asset/css/style_dashboard_admin.css') }}">

<div class="main-user-admin">
    {{-- Topbar --}}
    <div class="app-topbar">
        <div class="app-breadcrumb">
            <a href="{{ route('dashboard') }}">MediCal</a>
            <span class="sep">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </span>
            <span class="current">Dossiers Médicaux</span>
        </div>

        <div class="topbar-actions">
            <span class="app-badge app-badge-pill" style="font-weight: 600; background: var(--accent-light); color: var(--accent);">
                {{ now()->translatedFormat('l d F Y') }}
            </span>
        </div>
    </div>

    <div class="content">
        {{-- Header Section --}}
        <div class="app-section-title" style="margin-bottom: 40px;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                <span style="width: 24px; height: 2px; background: var(--accent); border-radius: 2px;"></span>
                <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--accent);">Espace Médical</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: flex-end; gap: 24px; flex-wrap: wrap;">
                <div>
                    <h1 style="font-family: 'Outfit', sans-serif; font-size: 2.5rem; font-weight: 800; color: var(--text-primary); margin: 0; letter-spacing: -0.02em;">
                        Dossiers <span style="color: var(--accent);">Patients</span>
                    </h1>
                    <p style="color: var(--text-muted); margin-top: 8px; font-size: 1rem;">Accédez rapidement à l'historique médical complet de vos patients.</p>
                </div>

                <form action="{{ route('dossiers.index') }}" method="GET" class="app-search-bar" style="background: var(--bg-card); padding: 6px; border-radius: 16px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
                    <div style="position: relative; flex-grow: 1;">
                        <svg style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; fill: none; stroke: var(--text-muted); stroke-width: 2;" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" name="search" class="app-form-control" style="padding-left: 44px; width: 320px; border: none; background: transparent;" placeholder="Rechercher par nom, CIN..." value="{{ request('search') }}">
                    </div>
                    <button type="submit" class="app-btn app-btn-primary">Filtrer</button>
                    @if(request('search'))
                        <a href="{{ route('dossiers.index') }}" class="app-btn app-btn-secondary" style="padding: 10px;">✕</a>
                    @endif
                </form>
            </div>
        </div>

        {{-- Folders Grid --}}
        <div class="app-grid">
            @forelse($patients as $patient)
                <div class="app-folder-card">
                    <div class="app-folder-status" style="background: {{ $patient->is_majeur ? 'var(--accent)' : '#d97706' }}; height: 5px;"></div>
                    <div class="app-folder-body">
                        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                            <div class="app-avatar-lg" style="width: 54px; height: 54px; border-radius: 14px; font-size: 1.1rem;">
                                @if($patient->photo)
                                    <img src="{{ asset($patient->photo) }}" alt="" style="width: 100%; height: 100%; object-fit: cover; border-radius: 14px;">
                                @else
                                    {{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}
                                @endif
                            </div>
                            <div>
                                <h3 style="margin: 0; font-size: 1.05rem; font-weight: 700; color: var(--text-primary);">{{ $patient->last_name }} {{ $patient->first_name }}</h3>
                                <div style="display: flex; align-items: center; gap: 6px; font-size: 0.8rem; color: var(--text-muted); margin-top: 4px;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="4" width="20" height="16" rx="2"/><line x1="7" y1="9" x2="17" y2="9"/><line x1="7" y1="13" x2="12" y2="13"/></svg>
                                    {{ $patient->cin ?? 'N/A' }}
                                    <span style="margin: 0 4px; opacity: 0.3;">•</span>
                                    <span class="app-badge" style="padding: 2px 8px; font-size: 0.65rem; background: {{ $patient->is_majeur ? 'var(--accent-light)' : '#fef3c7' }}; color: {{ $patient->is_majeur ? 'var(--accent)' : '#d97706' }};">
                                        {{ $patient->is_majeur ? 'Majeur' : 'Mineur' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div style="background: var(--bg-field); border-radius: 12px; padding: 12px; margin-bottom: 20px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; padding-bottom: 8px; border-bottom: 1px dashed var(--border);">
                                <span style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; color: var(--text-label);">Groupe Sanguin</span>
                                @if($patient->groupe_sanguin)
                                    <span style="font-family: 'Outfit', sans-serif; font-weight: 700; color: #cc2d2d; font-size: 0.9rem;">{{ $patient->groupe_sanguin }}</span>
                                @else
                                    <span style="font-size: 0.8rem; color: var(--text-muted); font-style: italic;">—</span>
                                @endif
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; color: var(--text-label);">Téléphone</span>
                                <span style="font-family: 'DM Mono', monospace; font-size: 0.85rem; color: var(--text-secondary); font-weight: 500;">{{ $patient->phone }}</span>
                            </div>
                        </div>

                        <a href="{{ route('patients.show', $patient->id) }}" class="app-btn app-btn-outline" style="width: 100%; justify-content: space-between; padding-left: 20px; font-size: 0.85rem;">
                            <span>Ouvrir le dossier</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 12-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; background: var(--bg-card); border-radius: 20px; border: 1.5px dashed var(--border); padding: 80px 40px; text-align: center;">
                    <div style="width: 64px; height: 64px; background: var(--accent-light); color: var(--accent); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 12-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary); margin-bottom: 8px;">Aucun dossier trouvé</h3>
                    <p style="color: var(--text-muted); margin-bottom: 24px;">Essayez d'ajuster vos critères de recherche.</p>
                    <a href="{{ route('dossiers.index') }}" class="app-btn app-btn-primary">Voir tous les patients</a>
                </div>
            @endforelse
        </div>

        @if($patients->hasPages())
            <div class="app-pagination">
                {{ $patients->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection