@extends('patient.layout')

@section('title', 'Mes Archives')

@section('content')

<div class="pt-page-header">
    <h1>Mes <em>Archives</em></h1>
    <p class="pt-page-subtitle">Historique de vos rendez-vous passés et de vos anciennes ordonnances.</p>
</div>

<div style="margin-bottom: 40px;">
    <h2 class="pt-section-title">
        Historique des Rendez-vous
        <span class="pt-badge" style="background:var(--pt-accent-light);color:var(--pt-accent);">{{ $pastAppointments->total() ?? 0 }} au total</span>
    </h2>

    <div class="pt-card" style="padding:0;overflow:hidden;">
        <div class="pt-table-wrap">
            <table class="pt-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Médecin</th>
                        <th>Type</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pastAppointments as $appt)
                    <tr>
                        <td>
                            <strong>{{ \Carbon\Carbon::parse($appt->date)->isoFormat('DD MMM YYYY') }}</strong><br>
                            <span style="font-size:11px;color:var(--pt-text-muted);">{{ \Carbon\Carbon::parse($appt->date)->isoFormat('dddd') }}</span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($appt->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($appt->end_time)->format('H:i') }}</td>
                        <td>
                            <strong>Dr. {{ $appt->doctor->first_name ?? '' }} {{ $appt->doctor->last_name ?? '' }}</strong><br>
                            <span style="font-size:11.5px;color:var(--pt-text-muted);">{{ $appt->doctor->specialty ?? '' }}</span>
                        </td>
                        <td>{{ $appt->type ?? '—' }}</td>
                        <td>
                            <span class="pt-badge pt-badge-{{ $appt->status }}">
                                @switch($appt->status)
                                    @case('planned')   <svg viewBox="0 0 24 24" style="width:10px;height:10px;fill:currentColor;margin-right:4px;"><circle cx="12" cy="12" r="10"/></svg> Planifié @break
                                    @case('completed') <svg viewBox="0 0 24 24" style="width:10px;height:10px;fill:none;stroke:currentColor;stroke-width:3;margin-right:4px;"><polyline points="20 6 9 17 4 12"/></svg> Terminé @break
                                    @case('cancelled') <svg viewBox="0 0 24 24" style="width:10px;height:10px;fill:none;stroke:currentColor;stroke-width:3;margin-right:4px;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Annulé @break
                                    @case('urgent')    <svg viewBox="0 0 24 24" style="width:10px;height:10px;fill:currentColor;margin-right:2px;"><path d="M13 2 L3 14 L12 14 L11 22 L21 10 L12 10 Z"/></svg> Urgent @break
                                @endswitch
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:40px;color:var(--pt-text-muted);">
                            <svg viewBox="0 0 24 24" style="width:40px;height:40px;stroke:var(--pt-accent-mid);fill:none;stroke-width:1.2;display:block;margin:0 auto 12px;">
                                <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                            </svg>
                            Aucun rendez-vous passé trouvé.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($pastAppointments->hasPages())
    <div class="pt-pagination" style="margin-top:20px;">
        {{ $pastAppointments->appends(['prescriptions_page' => request('prescriptions_page')])->links() }}
    </div>
    @endif
</div>

<div>
    <h2 class="pt-section-title">
        Historique des Ordonnances
        <span class="pt-badge" style="background:var(--pt-accent-light);color:var(--pt-accent);">{{ $prescriptions->total() ?? 0 }} au total</span>
    </h2>

    <div class="pt-card" style="padding:0;">
        @forelse($prescriptions as $rx)
        <div style="padding:20px 24px;border-bottom:1px solid var(--pt-sidebar-border);">
            <div style="display:flex;gap:16px;align-items:flex-start;">

                <div class="pt-rx-icon">
                    <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><path d="M9 12h6M9 16h4"/></svg>
                </div>

                <div style="flex:1;min-width:0;">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;flex-wrap:wrap;">
                        <div>
                            <div class="pt-rx-date">{{ \Carbon\Carbon::parse($rx->prescription_date)->isoFormat('DD MMMM YYYY') }}</div>
                            <div class="pt-rx-diagnosis" style="font-size:15px;">{{ $rx->diagnosis ?? 'Ordonnance médicale' }}</div>
                            <div class="pt-rx-doctor">Prescrit par Dr. {{ $rx->doctor->name ?? '—' }}</div>
                            <div class="pt-rx-count" style="margin-top:6px;">
                                {{ $rx->items->count() }} médicament(s) prescrit(s)
                            </div>
                        </div>
                        <div style="display:flex;gap:8px;flex-shrink:0;">
                            <a href="{{ route('patient.prescriptions.show', $rx->id) }}" class="pt-btn pt-btn-outline pt-btn-sm">
                                <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                Voir
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:60px 20px;color:var(--pt-text-muted);">
            <svg viewBox="0 0 24 24" style="width:48px;height:48px;stroke:var(--pt-accent-mid);fill:none;stroke-width:1.2;display:block;margin:0 auto 14px;">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><path d="M9 12h6M9 16h4"/>
            </svg>
            <p style="font-size:14px;margin-bottom:6px;">Aucune ordonnance passée pour le moment.</p>
        </div>
        @endforelse
    </div>

    @if($prescriptions->hasPages())
    <div class="pt-pagination" style="margin-top:20px;">
        {{ $prescriptions->appends(['appointments_page' => request('appointments_page')])->links() }}
    </div>
    @endif
</div>

@endsection
