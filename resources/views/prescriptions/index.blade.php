@extends('layouts.sidebar')

@section('content')
<div class="prescriptions-page-wrapper">
    <div class="app-topbar">
        <div class="app-breadcrumb">
            <a href="{{ route('patients.index') }}">Accueil</a>
            <span class="sep">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </span>
            <span class="current">Registre des Ordonnances</span>
        </div>

        <a href="{{ route('prescriptions.create') }}" class="app-btn app-btn-primary">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4v16m8-8H4"></path>
            </svg>
            Nouvelle Ordonnance
        </a>
    </div>

    @if(session('success'))
        <div class="app-card" style="border-left: 4px solid var(--accent); background: var(--accent-light); padding: 15px; margin-bottom: 20px;">
            <div style="color: var(--accent); font-weight: 600;">{{ session('success') }}</div>
        </div>
    @endif

    <div class="app-card">
        <div class="app-table-wrapper">
            <table class="app-table">
                <thead>
                    <tr>
                        <th>Identifiant</th>
                        <th>Patient</th>
                        <th>Médecin</th>
                        <th>Date</th>
                        <th>Médicaments</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prescriptions as $prescription)
                    <tr>
                        <td><span style="font-family: 'Outfit', monospace; font-weight: 600; color: var(--text-muted);">#ORD-{{ str_pad($prescription->id, 5, '0', STR_PAD_LEFT) }}</span></td>
                        <td>
                            <div style="font-weight: 600; color: var(--text-primary);">{{ $prescription->patient->first_name }} {{ $prescription->patient->last_name }}</div>
                        </td>
                        <td><span style="font-size: 0.85rem; padding: 4px 10px; background: #fff5eb; color: #9a3412; border-radius: 6px; font-weight: 600;">Dr. {{ $prescription->doctor->name }}</span></td>
                        <td><span style="color: var(--text-secondary);">{{ \Carbon\Carbon::parse($prescription->prescription_date)->format('d/m/Y') }}</span></td>
                        <td>
                            <span class="badge app-badge-pill" style="background: var(--bg-field); color: var(--text-secondary); border: 1px solid var(--border);">
                                {{ $prescription->items->count() }} article(s)
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <a href="{{ route('prescriptions.show', $prescription->id) }}" class="app-btn-action" title="Voir">
                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                                <a href="{{ route('prescriptions.print', $prescription->id) }}" target="_blank" class="app-btn-action" title="Imprimer">
                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted); font-style: italic;">Aucune ordonnance enregistrée.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
