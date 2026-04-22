@extends('patient.layout')

@section('title', 'Tableau de bord')

@section('content')

{{-- Page Header --}}
<div class="pt-page-header">
    <h1>Bonjour, <em>{{ explode(' ', auth()->user()->name)[0] }}</em></h1>
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
        <div class="pt-stat-icon-simple">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
        </div>
        <div class="pt-stat-value">{{ $upcomingCount ?? 0 }}</div>
        <div class="pt-stat-label">RDV à venir</div>
    </div>

    <div class="pt-stat-card" style="animation-delay:60ms">
        <div class="pt-stat-icon-simple text-emerald-600">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                <polyline points="13 2 13 9 20 9"></polyline>
                <line x1="9" y1="14" x2="15" y2="14"></line>
                <line x1="9" y1="18" x2="15" y2="18"></line>
            </svg>
        </div>
        <div class="pt-stat-value">{{ $prescriptions->count() ?? 0 }}</div>
        <div class="pt-stat-label">Ordonnances</div>
    </div>

    <div class="pt-stat-card" style="animation-delay:120ms">
        <div class="pt-stat-icon-simple text-emerald-600">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
            </svg>
        </div>
        <div class="pt-stat-value">{{ $patient ? 'Actif' : '—' }}</div>
        <div class="pt-stat-label">Statut Dossier</div>
    </div>
</div>

{{-- Main Grid --}}
<div class="pt-dashboard-main-grid">

    {{-- Left Column: Appointments --}}
    <div class="pt-dashboard-col">
        @if($nextAppointment)
        <div class="pt-next-appt-card" style="animation-delay:80ms">
            <div class="pt-next-appt-header">
                <span class="pt-next-tag">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    Prochain RDV
                </span>
                <div class="pt-next-appt-date-badge">
                    <span class="day">{{ \Carbon\Carbon::parse($nextAppointment->date)->format('d') }}</span>
                    <span class="month">{{ strtoupper(\Carbon\Carbon::parse($nextAppointment->date)->isoFormat('MMM')) }}</span>
                </div>
            </div>
            <div class="pt-next-appt-body">
                <h3>Dr. {{ $nextAppointment->doctor->first_name ?? '' }} {{ $nextAppointment->doctor->last_name ?? '' }}</h3>
                <p class="pt-next-meta">{{ $nextAppointment->type ?? 'Consultation Générale' }}</p>
                <div class="pt-next-details">
                    <div class="detail-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        {{ \Carbon\Carbon::parse($nextAppointment->start_time)->format('H:i') }}
                    </div>
                    <div class="detail-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        Cabinet Médical
                    </div>
                </div>
            </div>
            <div class="pt-next-appt-footer">
                <form method="POST" action="{{ route('patient.appointments.cancel', $nextAppointment->id) }}">
                    @csrf
                    <button type="submit" class="pt-btn-cancel" onclick="return confirm('Annuler ce rendez-vous ?')">
                        Annuler le rendez-vous
                    </button>
                </form>
                <a href="{{ route('patient.appointments') }}" class="pt-btn-manage">Gérer mes RDV</a>
            </div>
        </div>
        @else
        <div class="pt-card pt-card-empty" style="animation-delay:80ms">
            <div class="pt-no-appt">
                <div class="empty-icon-simple">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
                <h3>Aucun rendez-vous</h3>
                <p>Besoin d'un check-up ? Prenez rendez-vous avec nos spécialistes en quelques clics.</p>
                <a href="{{ route('patient.appointments.book') }}" class="pt-btn pt-btn-primary">
                    Prendre un rendez-vous
                </a>
            </div>
        </div>
        @endif
    </div>

    {{-- Right Column: Prescriptions --}}
    <div class="pt-dashboard-col">
        <div class="pt-card" style="animation-delay:120ms">
            <div class="pt-section-title">
                <span>Ordonnances récentes</span>
                <a href="{{ route('patient.prescriptions') }}" class="view-all">Voir tout</a>
            </div>

            <div class="pt-rx-list">
                @forelse($prescriptions as $rx)
                <a href="{{ route('patient.prescriptions.show', $rx->id) }}" class="pt-rx-mini-card">
                    <div class="rx-info">
                        <span class="rx-date">{{ \Carbon\Carbon::parse($rx->prescription_date)->isoFormat('D MMMM YYYY') }}</span>
                        <span class="rx-title">{{ Str::limit($rx->diagnosis ?? 'Ordonnance médicale', 30) }}</span>
                        <span class="rx-doc">Dr. {{ $rx->doctor->name ?? 'Médecin' }}</span>
                    </div>
                    <div class="rx-arrow">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"></path></svg>
                    </div>
                </a>
                @empty
                <div class="pt-empty-state">
                    <p>Aucune ordonnance disponible.</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="pt-quick-actions" style="margin-top:20px; animation-delay:160ms">
            <div class="pt-card">
                <div class="pt-section-title">Actions rapides</div>
                <div class="quick-links">
                    <a href="{{ route('patient.appointments.book') }}" class="q-link">
                        <div class="q-icon-simple"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><path d="M12 8v8"></path><path d="M8 12h8"></path></svg></div>
                        <span>Nouveau RDV</span>
                    </a>
                    <a href="{{ route('patient.dossier') }}" class="q-link">
                        <div class="q-icon-simple"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 12-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg></div>
                        <span>Mon Dossier</span>
                    </a>
                    <a href="{{ route('patient.appointments') }}" class="q-link">
                        <div class="q-icon-simple"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></div>
                        <span>Calendrier</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    /* Custom styles for the new dashboard elements */
    .pt-dashboard-main-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 24px;
        align-items: start;
    }

    @media (max-width: 1100px) {
        .pt-dashboard-main-grid { grid-template-columns: 1fr; }
    }

    /* Simplified Stat Icons (No Background) */
    .pt-stat-icon-simple {
        width: 32px;
        height: 32px;
        color: var(--pt-accent);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }
    .pt-stat-icon-simple svg { width: 100%; height: 100%; }

    /* Next Appointment Card - Digital Ticket Look */
    .pt-next-appt-card {
        background: white;
        border-radius: 24px;
        padding: 0;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        border: 1px solid rgba(45, 143, 111, 0.08);
        position: relative;
        animation: ptFadeUp 500ms var(--pt-ease) both;
    }

    @media (max-width: 640px) {
        .pt-next-appt-card { border-radius: 16px; }
    }

    .pt-next-appt-header {
        background: linear-gradient(135deg, var(--pt-accent), var(--pt-accent-2));
        padding: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
    }

    .pt-next-appt-date-badge {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        padding: 8px 14px;
        border-radius: 14px;
        text-align: center;
        display: flex;
        flex-direction: column;
        line-height: 1.1;
    }

    .pt-next-appt-date-badge .day { font-size: 1.4rem; font-weight: 800; }
    .pt-next-appt-date-badge .month { font-size: 0.65rem; font-weight: 700; opacity: 0.9; }

    .pt-next-appt-body {
        padding: 32px;
    }

    .pt-next-appt-body h3 {
        font-family: 'Outfit', sans-serif;
        font-size: 1.6rem;
        font-weight: 600;
        color: var(--pt-text-primary);
        margin-bottom: 4px;
    }

    .pt-next-meta {
        color: var(--pt-accent);
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 20px;
    }

    @media (max-width: 640px) {
        .pt-next-appt-body { padding: 24px; }
        .pt-next-appt-body h3 { font-size: 1.3rem; }
    }

    .pt-next-details {
        display: flex;
        gap: 24px;
        padding-top: 20px;
        border-top: 1px dashed var(--pt-sidebar-border);
        flex-wrap: wrap;
    }

    @media (max-width: 640px) {
        .pt-next-details { gap: 16px; }
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: var(--pt-text-secondary);
        font-weight: 500;
    }

    .detail-item svg { width: 16px; height: 16px; stroke: var(--pt-accent); stroke-width: 2; fill: none; }

    .pt-next-appt-footer {
        padding: 20px 32px;
        background: #fcfdfc;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid rgba(0,0,0,0.03);
    }

    @media (max-width: 640px) {
        .pt-next-appt-footer {
            flex-direction: column;
            gap: 12px;
            padding: 16px 24px;
            align-items: stretch;
            text-align: center;
        }
    }

    .pt-btn-cancel {
        background: transparent;
        border: none;
        color: #ef4444;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        padding: 8px 0;
    }

    .pt-btn-cancel:hover { text-decoration: underline; }

    .pt-btn-manage {
        color: var(--pt-text-muted);
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
    }

    /* RX Mini List */
    .pt-rx-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .pt-rx-mini-card {
        display: flex;
        align-items: center;
        padding: 16px;
        border-radius: 16px;
        background: #f8faf9;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }

    .pt-rx-mini-card:hover {
        background: white;
        border-color: var(--pt-accent);
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        transform: translateX(4px);
    }

    .rx-info { display: flex; flex-direction: column; flex: 1; }
    .rx-date { font-size: 11px; color: var(--pt-text-muted); font-weight: 600; }
    .rx-title { font-size: 14px; font-weight: 700; color: var(--pt-text-primary); margin: 2px 0; }
    .rx-doc { font-size: 12px; color: var(--pt-text-secondary); }

    .rx-arrow svg { width: 18px; height: 18px; stroke: var(--pt-text-muted); fill: none; stroke-width: 2; }

    /* Quick Links */
    .quick-links {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }

    @media (max-width: 640px) {
        .quick-links { grid-template-columns: 1fr; }
        .q-link { flex-direction: row; justify-content: flex-start; padding: 12px 16px; }
        .q-link span { font-size: 13px; }
    }

    .q-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        padding: 16px 10px;
        background: #f8faf9;
        border-radius: 16px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .q-link:hover { background: var(--pt-accent-light); transform: translateY(-3px); }

    .q-icon-simple {
        width: 32px; height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--pt-accent);
    }

    .q-icon-simple svg { width: 100%; height: 100%; }
    .q-link span { font-size: 11px; font-weight: 700; color: var(--pt-text-secondary); text-align: center; }

    .pt-section-title span { font-family: 'Outfit', sans-serif; font-weight: 700; }
    .view-all { font-size: 12px; color: var(--pt-accent); text-decoration: none; font-weight: 700; }

    .pt-card-empty {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 300px;
        text-align: center;
        background: linear-gradient(to bottom, #ffffff, #fcfdfc);
    }

    .empty-icon-simple {
        width: 48px; height: 48px;
        color: var(--pt-accent-mid);
        margin: 0 auto 20px;
    }

    .empty-icon-simple svg { width: 100%; height: 100%; }
    .pt-no-appt h3 { font-family: 'Outfit', sans-serif; font-size: 1.4rem; font-weight: 700; margin-bottom: 8px; }
    .pt-no-appt p { font-size: 14px; color: var(--pt-text-muted); max-width: 250px; margin: 0 auto 24px; }
</style>

@endsection
