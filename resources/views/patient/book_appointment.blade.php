@extends('patient.layout')

@section('title', 'Prendre un Rendez-vous')

@section('content')

<div class="pt-page-header">
    <h1>Prendre un <em>Rendez-vous</em></h1>
    <p class="pt-page-subtitle">Choisissez un médecin, une date et un créneau disponible.</p>
</div>

@if($errors->any())
<div class="pt-alert pt-alert-error">
    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
    <div>
        @foreach($errors->all() as $err)
            <div>{{ $err }}</div>
        @endforeach
    </div>
</div>
@endif

<div style="display:grid;grid-template-columns:1.6fr 1fr;gap:24px;align-items:start;">

    {{-- Booking Form --}}
    <div class="pt-card">
        <div class="pt-section-title">Détails du rendez-vous</div>

        <form method="POST" action="{{ route('patient.appointments.store') }}">
            @csrf

            <div class="pt-form-grid" style="row-gap:20px;">

                {{-- Doctor --}}
                <div class="pt-field span2">
                    <label class="pt-label" for="doctor_id">Médecin</label>
                    <select id="doctor_id" name="doctor_id" class="pt-select" required>
                        <option value="">— Choisissez un médecin —</option>
                        @foreach($doctors as $doc)
                        <option value="{{ $doc->id }}" {{ old('doctor_id') == $doc->id ? 'selected' : '' }}>
                            Dr. {{ $doc->first_name }} {{ $doc->last_name }} — {{ $doc->specialty }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Type --}}
                <div class="pt-field span2">
                    <label class="pt-label" for="type">Type de consultation</label>
                    <select id="type" name="type" class="pt-select" required>
                        <option value="">— Sélectionnez —</option>
                        <option value="Consultation" {{ old('type') === 'Consultation' ? 'selected' : '' }}>Consultation</option>
                        <option value="Contrôle" {{ old('type') === 'Contrôle' ? 'selected' : '' }}>Contrôle</option>
                        <option value="Urgence" {{ old('type') === 'Urgence' ? 'selected' : '' }}>Urgence</option>
                        <option value="Bilan" {{ old('type') === 'Bilan' ? 'selected' : '' }}>Bilan</option>
                        <option value="Suivi" {{ old('type') === 'Suivi' ? 'selected' : '' }}>Suivi</option>
                    </select>
                </div>

                {{-- Date --}}
                <div class="pt-field">
                    <label class="pt-label" for="date">Date</label>
                    <input type="date" id="date" name="date" class="pt-input"
                        min="{{ date('Y-m-d') }}" value="{{ old('date') }}" required>
                </div>

                {{-- Time range --}}
                <div class="pt-field">
                    <label class="pt-label">Créneau horaire</label>
                    <div style="display:flex;gap:8px;align-items:center;">
                        <input type="time" name="start_time" class="pt-input" value="{{ old('start_time', '09:00') }}" required>
                        <span style="color:var(--pt-text-muted);font-size:13px;flex-shrink:0;">→</span>
                        <input type="time" name="end_time" class="pt-input" value="{{ old('end_time', '09:30') }}" required>
                    </div>
                </div>

                {{-- Notes --}}
                <div class="pt-field span2">
                    <label class="pt-label" for="notes">Notes / Motif (facultatif)</label>
                    <textarea id="notes" name="notes" class="pt-textarea"
                        placeholder="Décrivez brièvement le motif de votre visite...">{{ old('notes') }}</textarea>
                </div>

            </div>

            <div style="margin-top:24px;display:flex;gap:12px;">
                <button type="submit" class="pt-btn pt-btn-primary">
                    <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                    Confirmer le rendez-vous
                </button>
                <a href="{{ route('patient.appointments') }}" class="pt-btn pt-btn-outline">Annuler</a>
            </div>
        </form>
    </div>

    {{-- Info Panel --}}
    <div>
        <div class="pt-card pt-card-sm" style="margin-bottom:16px;background:linear-gradient(135deg,var(--pt-accent),var(--pt-accent-2));color:#fff;">
            <div style="font-weight:700;margin-bottom:6px;font-size:14px;">📋 Comment ça marche ?</div>
            <ol style="padding-left:18px;font-size:13px;line-height:1.8;opacity:.9;">
                <li>Choisissez votre médecin</li>
                <li>Sélectionnez une date disponible</li>
                <li>Indiquez le créneau souhaité</li>
                <li>Confirmez votre demande</li>
            </ol>
        </div>

        <div class="pt-card pt-card-sm">
            <div style="font-weight:600;font-size:13px;color:var(--pt-text-primary);margin-bottom:10px;">⚕️ Médecins disponibles</div>
            @foreach($doctors as $doc)
            <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid var(--pt-sidebar-border);">
                <div style="width:34px;height:34px;border-radius:9px;background:var(--pt-accent-light);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;color:var(--pt-accent);">
                    {{ strtoupper(substr($doc->first_name, 0, 1)) }}{{ strtoupper(substr($doc->last_name, 0, 1)) }}
                </div>
                <div>
                    <div style="font-size:13px;font-weight:600;color:var(--pt-text-primary);">Dr. {{ $doc->first_name }} {{ $doc->last_name }}</div>
                    <div style="font-size:11px;color:var(--pt-text-muted);">{{ $doc->specialty }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

@endsection
