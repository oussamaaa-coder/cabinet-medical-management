@extends('layouts.sidebar')

@section('content')
<div class="doctors-page-wrapper">
    <!-- Unified Topbar -->
    <div class="app-topbar">
        <div class="app-breadcrumb">
            <a href="{{ route('doctors.index') }}">Médecins</a>
            <span class="sep">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </span>
            <span class="current">Liste complète</span>
        </div>

        @if(auth()->user()->isAdmin())
        <a href="{{ route('doctors.create') }}" class="app-btn app-btn-primary">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="16" y1="11" x2="22" y2="11"/>
            </svg>
            Nouveau Médecin
        </a>
        @endif
    </div>

    <!-- Main Content Card -->
    <div class="app-card">
        <div class="app-topbar" style="padding-top: 0; margin-bottom: 25px; border-bottom: 1px solid var(--border); padding-bottom: 20px;">
            <div class="header-left">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text-primary);">Annuaire Médical</h3>
                <span class="badge app-badge-pill" style="margin-left: 12px;">{{ $doctors->total() }} total</span>
            </div>
            
            <form action="{{ route('doctors.index') }}" method="GET" class="app-search-bar">
                <div style="position: relative;">
                    <svg style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; fill: none; stroke: var(--text-muted); stroke-width: 2;" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" name="search" class="app-form-control app-search-input" style="padding-left: 44px;" placeholder="Nom, spécialité..." value="{{ request('search') }}">
                </div>
                <button type="submit" class="app-btn app-btn-primary">Filtrer</button>
                @if(request('search'))
                    <a href="{{ route('doctors.index') }}" class="app-btn app-btn-secondary">Réinitialiser</a>
                @endif
            </form>
        </div>

        <div class="app-table-wrapper">
            <table class="app-table">
                <thead>
                    <tr>
                        <th>Identité</th>
                        <th>Coordonnées</th>
                        <th>Spécialité</th>
                        <th>Services</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($doctors as $doctor)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 40px; height: 40px; border-radius: 12px; background: var(--accent-light); color: var(--accent); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem;">
                                    {{ strtoupper(substr($doctor->first_name, 0, 1) . substr($doctor->last_name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--text-primary);">Dr. {{ $doctor->last_name }} {{ $doctor->first_name }}</div>
                                    <div style="font-size: 0.75rem; color: var(--text-muted);">Cabinet #{{ $doctor->id + 100 }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; flex-direction: column; gap: 2px;">
                                <span style="font-size: 0.85rem; color: var(--text-secondary);">{{ $doctor->email }}</span>
                                <span style="font-size: 0.8rem; color: var(--text-muted);">{{ $doctor->phone ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge app-badge-pill" style="background: var(--bg-field); color: var(--text-secondary); border: 1px solid var(--border);">
                                {{ $doctor->speciality ?? 'Médecine Générale' }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 4px;">
                                <span style="width: 8px; height: 8px; border-radius: 50%; background: #34d399;" title="Disponible"></span>
                                <span style="font-size: 0.8rem; color: var(--text-muted);">Actif</span>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <a href="{{ route('doctors.show', $doctor->id) }}" class="app-btn-action" title="Consulter">
                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('doctors.edit', $doctor->id) }}" class="app-btn-action" title="Modifier">
                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Supprimer ce profil ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="app-btn-action delete" title="Supprimer">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">Aucun médecin trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="app-pagination">
            {{ $doctors->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection