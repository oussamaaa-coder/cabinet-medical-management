@extends('layouts.sidebar')

@section('content')
<div class="prescription-view-wrapper">
    <!-- Topbar -->
    <div class="app-topbar">
        <div class="app-breadcrumb">
            <a href="{{ route('prescriptions.index') }}">Ordonnances</a>
            <span class="sep">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </span>
            <span class="current">Aperçu de l'ordonnance</span>
        </div>

        <div style="display: flex; gap: 12px;">
            <a href="{{ route('prescriptions.index') }}" class="app-btn app-btn-secondary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Retour
            </a>
            <a href="{{ route('prescriptions.print', $prescription->id) }}" target="_blank" class="app-btn app-btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Imprimer
            </a>
        </div>
    </div>

    <!-- The physical-style prescription document -->
    <div class="app-card" style="max-width: 800px; margin: 0 auto; padding: 60px; min-height: 800px; display: flex; flex-direction: column;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 40px; padding-bottom: 30px; border-bottom: 3px solid var(--accent);">
            <div class="clinic-header">
                <h1 style="font-size: 1.5rem; color: var(--accent); font-weight: 800; margin: 0 0 8px 0;">MediCal Cabinet</h1>
                <div style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.5;">
                    <p>123 Avenue des Oliviers, Casablanca</p>
                    <p>Tél: +212 5 22 00 00 00</p>
                </div>
            </div>
            <div style="text-align: right;">
                <h2 style="font-size: 1.25rem; color: var(--text-primary); font-weight: 700; margin: 0 0 4px 0;">Dr. {{ $prescription->doctor->name }}</h2>
                <div class="badge app-badge-pill" style="background: var(--accent-light); color: var(--accent);">Médecin Généraliste</div>
            </div>
        </div>

        <div style="background: var(--bg-field); padding: 24px; border-radius: var(--radius-md); margin-bottom: 40px; display: grid; grid-template-columns: 2fr 1fr; border: 1px solid var(--border);">
            <div>
                <span style="font-size: 0.7rem; color: var(--text-label); text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 4px;">Patient</span>
                <span style="font-size: 1.05rem; color: var(--text-primary); font-weight: 700;">{{ $prescription->patient->first_name }} {{ $prescription->patient->last_name }}</span>
            </div>
            <div style="text-align: right;">
                <span style="font-size: 0.7rem; color: var(--text-label); text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 4px;">Date</span>
                <span style="font-size: 1rem; color: var(--text-primary); font-weight: 600;">{{ \Carbon\Carbon::parse($prescription->prescription_date)->format('d/m/Y') }}</span>
            </div>
        </div>

        <div style="text-align: center; margin-bottom: 40px;">
            <h1 style="font-size: 2.5rem; color: var(--text-primary); font-weight: 800; letter-spacing: 4px; text-transform: uppercase; opacity: 0.9;">Ordonnance</h1>
        </div>

        <div style="flex: 1;">
            @foreach($prescription->items as $item)
            <div style="margin-bottom: 24px; border-left: 4px solid var(--accent); padding-left: 20px;">
                <div style="font-size: 1.1rem; font-weight: 700; color: var(--text-primary); margin-bottom: 6px;">{{ $item->medicine_name }}</div>
                <div style="font-size: 0.95rem; color: var(--text-secondary); font-style: italic; display: flex; align-items: center; gap: 8px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>Posologie: {{ $item->dosage }}</span>
                    @if($item->duration)
                        <span style="color: var(--border);">/</span>
                        <span>Durée: {{ $item->duration }}</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @if($prescription->notes)
        <div style="background: #fffbeb; border: 1px solid #fef3c7; padding: 20px; border-radius: 12px; margin-top: 40px;">
            <div style="font-size: 0.75rem; color: #b45309; text-transform: uppercase; font-weight: 800; margin-bottom: 6px;">Observations Particulières</div>
            <p style="color: #92400e; font-size: 0.95rem; margin: 0; line-height: 1.6;">{{ $prescription->notes }}</p>
        </div>
        @endif

        <div style="margin-top: 60px; display: flex; justify-content: space-between; align-items: flex-end; padding-top: 30px; border-top: 1px dashed var(--border);">
            <div style="font-size: 0.75rem; color: var(--text-muted);">
                Généré via Medox le {{ now()->format('d/m/Y à H:i') }}
            </div>
            <div style="text-align: center; width: 220px;">
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 60px; font-weight: 600;">Signature et Cachet</div>
                <div style="border-top: 1px solid var(--text-muted); padding-top: 8px; font-size: 0.7rem; color: var(--text-muted);">PR. {{ strtoupper($prescription->doctor->name) }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
