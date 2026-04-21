@extends('layouts.sidebar')

@section('content')
<div class="appointments-page-wrapper">
    <div class="app-topbar">
        <div class="app-breadcrumb">
            <a href="{{ route('patients.index') }}">Accueil</a>
            <span class="sep">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </span>
            <span class="current">Modifier le rendez-vous</span>
        </div>
    </div>

    <div class="app-section-title">
        <h3>Modification du Rendez-vous #{{ $appointment->id }}</h3>
    </div>

    <form id="appointmentForm" action="{{ route('appointments.update', $appointment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="app-form-section">
            <div class="app-form-section-header">
                <div class="app-form-section-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </div>
                <h3 style="margin:0; font-size: 1.1rem; font-weight: 600;">Détails de mise à jour</h3>
            </div>

            <div class="app-form-grid">
                <div class="app-form-group">
                    <label class="app-form-label">Statut</label>
                    <select name="status" class="app-form-control">
                        @foreach(['planned', 'completed', 'cancelled', 'urgent'] as $s)
                            <option value="{{ $s }}" {{ $appointment->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="app-form-group" style="margin-top: 20px;">
                <label class="app-form-label">Notes ou observations</label>
                <textarea name="notes" class="app-form-control" rows="4" placeholder="Ajouter un compte-rendu ou une note...">{{ $appointment->notes }}</textarea>
            </div>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 30px; justify-content: flex-end;">
            <a href="{{ route('patients.index') }}" class="app-btn app-btn-secondary">Annuler</a>
            <button type="submit" class="app-btn app-btn-primary" style="padding-left: 30px; padding-right: 30px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v14a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection
