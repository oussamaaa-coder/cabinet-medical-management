@extends('patient.layout')

@section('title', 'Tableau de bord')

@section('content')

{{-- Page Header --}}
<div class="pt-page-header">
    <h1>Bonjour, <em>{{ explode(' ', auth()->user()->name)[0] }}</em> 👋</h1>
    <p class="pt-page-subtitle">Voici un aperçu de votre santé et de vos prochains rendez-vous.</p>
</div>

{{-- Flash Messages --}}
@if(session('success'))
<div class="pt-alert pt-alert-success">
    <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="pt-alert pt-alert-error">
    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
    {{ session('error') }}
</div>
@endif

{{-- Stat Cards --}}
<div class="pt-stat-grid">
    <div class="pt-stat-card" style="animation-delay:0ms">
        <div class="pt-stat-icon">
            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        </div>
        <div class="pt-stat-value">{{ $upcomingCount ?? 0 }}</div>
        <div class="pt-stat-label">RDV à venir</div>
    </div>

    <div class="pt-stat-card" style="animation-delay:60ms">
        <div class="pt-stat-icon">
            <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><path d="M9 12h6M9 16h4"/></svg>
        </div>
        <div class="pt-stat-value">{{ $prescriptions->count() ?? 0 }}</div>
        <div class="pt-stat-label">Ordonnances récentes</div>
    </div>

    <div class="pt-stat-card" style="animation-delay:120ms">
        <div class="pt-stat-icon">
            <svg viewBox="0 0 24 24"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
        </div>
        <div class="pt-stat-value">{{ $patient ? '✓' : '—' }}</div>
        <div class="pt-stat-label">Dossier médical</div>
    </div>
</div>

{{-- Main Grid --}}
<div style="display:grid; grid-template-columns:1.5fr 1fr; gap:22px; align-items:start;">

    {{-- Next Appointment --}}
    <div>
        @if($nextAppointment)
        <div class="pt-next-appt" style="animation-delay:80ms">
            <span class="pt-next-tag">✦ Prochain Rendez-vous</span>
            <h3>Dr. {{ $nextAppointment->doctor->first_name ?? '' }} {{ $nextAppointment->doctor->last_name ?? '' }}</h3>
            <p class="pt-next-meta">{{ $nextAppointment->type ?? 'Consultation' }}</p>
            <p class="pt-next-time">
                📅 {{ \Carbon\Carbon::parse($nextAppointment->date)->isoFormat('dddd D MMMM YYYY') }}
                &nbsp;·&nbsp;
                🕐 {{ \Carbon\Carbon::parse($nextAppointment->start_time)->format('H:i') }}
            </p>
            <div style="margin-top:20px;">
                <form method="POST" action="{{ route('patient.appointments.cancel', $nextAppointment->id) }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="pt-btn pt-btn-outline" style="color:#fff;border-color:rgba(255,255,255,.4);font-size:12px;padding:7px 14px;"
                        onclick="return confirm('Annuler ce rendez-vous ?')">
                        <svg viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
                        Annuler
                    </button>
                </form>
            </div>
        </div>
        @else
        <div class="pt-card" style="animation-delay:80ms">
            <div class="pt-no-appt">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                <p>Vous n'avez aucun rendez-vous à venir.</p>
                <a href="{{ route('patient.appointments.book') }}" class="pt-btn pt-btn-primary">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 8v8M8 12h8"/></svg>
                    Prendre un rendez-vous
                </a>
            </div>
        </div>
        @endif
    </div>

    {{-- Recent Prescriptions --}}
    <div class="pt-card" style="animation-delay:120ms">
        <div class="pt-section-title">
            Ordonnances récentes
            <a href="{{ route('patient.prescriptions') }}" class="pt-btn pt-btn-outline pt-btn-sm">Voir tout</a>
        </div>

        @forelse($prescriptions as $rx)
        <div class="pt-rx-card" style="margin-bottom:12px;">
            <div class="pt-rx-icon">
                <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><path d="M9 12h6M9 16h4"/></svg>
            </div>
            <div style="flex:1;min-width:0;">
                <div class="pt-rx-date">{{ \Carbon\Carbon::parse($rx->prescription_date)->format('d/m/Y') }}</div>
                <div class="pt-rx-diagnosis">{{ Str::limit($rx->diagnosis ?? 'Ordonnance', 40) }}</div>
                <div class="pt-rx-doctor">Dr. {{ $rx->doctor->name ?? '—' }}</div>
                <div class="pt-rx-count">{{ $rx->items->count() }} médicament(s)</div>
            </div>
            <a href="{{ route('patient.prescriptions.show', $rx->id) }}" class="pt-btn pt-btn-outline pt-btn-sm">Voir</a>
        </div>
        @empty
        <p style="color:var(--pt-text-muted);font-size:13px;padding:16px 0;">Aucune ordonnance pour le moment.</p>
        @endforelse
    </div>

</div>

{{-- Quick Actions --}}
<div class="pt-card" style="margin-top:22px;animation-delay:160ms">
    <div class="pt-section-title">Actions rapides</div>
    <div style="display:flex;gap:12px;flex-wrap:wrap;">
        <a href="{{ route('patient.appointments.book') }}" class="pt-btn pt-btn-primary">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 8v8M8 12h8"/></svg>
            Prendre un RDV
        </a>
        <a href="{{ route('patient.appointments') }}" class="pt-btn pt-btn-outline">
            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            Mes rendez-vous
        </a>
        <a href="{{ route('patient.prescriptions') }}" class="pt-btn pt-btn-outline">
            <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
            Mes ordonnances
        </a>
        <a href="{{ route('patient.dossier') }}" class="pt-btn pt-btn-outline">
            <svg viewBox="0 0 24 24"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
            Mon dossier
        </a>
    </div>
</div>

@endsection
