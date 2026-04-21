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
            <span class="current">Nouveau rendez-vous</span>
        </div>
    </div>

    <div class="app-section-title">
        <h3>Prendre un Rendez-vous</h3>
    </div>

    @if(session('error'))
        <div style="background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 16px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span style="font-weight: 600;">{{ session('error') }}</span>
        </div>
    @endif

    <form id="appointmentForm" action="{{ route('appointments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="type" value="Consultation">
        <input type="hidden" name="status" value="planned">

        <div class="app-form-section">
            <div class="app-form-section-header">
                <div class="app-form-section-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 style="margin:0; font-size: 1.1rem; font-weight: 600;">Détails du créneau</h3>
            </div>

            <div class="app-form-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <div class="app-form-group">
                    <label class="app-form-label">Patient <span style="color: var(--danger);">*</span></label>
                    <select name="patient_id" class="app-form-control @error('patient_id') is-invalid @enderror" required>
                        <option value="">Sélectionner un patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>{{ $patient->first_name }} {{ $patient->last_name }}</option>
                        @endforeach
                    </select>
                    @error('patient_id') <span style="color: var(--danger); font-size: 0.75rem;">{{ $message }}</span> @enderror
                </div>

                <div class="app-form-group">
                    <label class="app-form-label">Médecin <span style="color: var(--danger);">*</span></label>
                    <select name="doctor_id" class="app-form-control @error('doctor_id') is-invalid @enderror" required>
                        <option value="">Sélectionner un médecin</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>Dr. {{ $doctor->first_name }} {{ $doctor->last_name }} ({{ $doctor->specialty }})</option>
                        @endforeach
                    </select>
                    @error('doctor_id') <span style="color: var(--danger); font-size: 0.75rem;">{{ $message }}</span> @enderror
                </div>

                <div class="app-form-group">
                    <label class="app-form-label">Date <span style="color: var(--danger);">*</span></label>
                    <input type="date" name="date" class="app-form-control @error('date') is-invalid @enderror" value="{{ old('date', date('Y-m-d')) }}" required>
                    @error('date') <span style="color: var(--danger); font-size: 0.75rem;">{{ $message }}</span> @enderror
                </div>

                <div class="app-form-group">
                    <label class="app-form-label">Heure début <span style="color: var(--danger);">*</span></label>
                    <input type="time" name="start_time" class="app-form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time', '09:00') }}" required>
                    @error('start_time') <span style="color: var(--danger); font-size: 0.75rem;">{{ $message }}</span> @enderror
                </div>

                <div class="app-form-group">
                    <label class="app-form-label">Heure fin</label>
                    <input type="time" name="end_time" class="app-form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time') }}" placeholder="Calculé par défaut">
                    <p style="font-size: 0.7rem; color: var(--text-muted); margin-top: 4px;">Laissez vide pour +30 min.</p>
                    @error('end_time') <span style="color: var(--danger); font-size: 0.75rem;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="app-form-group" style="margin-top: 24px;">
                <label class="app-form-label">Notes ou motif</label>
                <textarea name="notes" class="app-form-control" rows="3" placeholder="Description courte...">{{ old('notes') }}</textarea>
            </div>
        </div>


        <div style="display: flex; gap: 12px; margin-top: 30px; justify-content: flex-end;">
            <a href="{{ route('patients.index') }}" class="app-btn app-btn-secondary">Annuler</a>
            <button type="submit" class="app-btn app-btn-primary" style="padding-left: 30px; padding-right: 30px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;"><path d="M12 4v16m8-8H4"></path></svg>
                Confirmer le RDV
            </button>
        </div>
    </form>
</div>
@endsection
