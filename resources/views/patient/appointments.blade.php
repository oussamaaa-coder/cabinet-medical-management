@extends('patient.layout')

@section('title', 'Mes Rendez-vous')

@section('content')

<div class="pt-page-header">
    <h1>Mes <em>Rendez-vous</em></h1>
    <p class="pt-page-subtitle">Historique et suivi de tous vos rendez-vous médicaux.</p>
</div>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
    <span style="font-size:13px;color:var(--pt-text-muted);">{{ $appointments->total() ?? 0 }} rendez-vous au total</span>
    <a href="{{ route('patient.appointments.book') }}" class="pt-btn pt-btn-primary">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 8v8M8 12h8"/></svg>
        Prendre un RDV
    </a>
</div>

{{-- Flash --}}
@if(session('success'))
<div class="pt-alert pt-alert-success">
    <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/></svg>
    {{ session('success') }}
</div>
@endif

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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appt)
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
                                @case('planned')   ● Planifié @break
                                @case('completed') ✓ Terminé @break
                                @case('cancelled') ✕ Annulé @break
                                @case('urgent')    ⚡ Urgent @break
                            @endswitch
                        </span>
                    </td>
                    <td>
                        @if($appt->status === 'planned' && \Carbon\Carbon::parse($appt->date)->gte(\Carbon\Carbon::today()))
                        <form method="POST" action="{{ route('patient.appointments.cancel', $appt->id) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="pt-btn pt-btn-danger"
                                onclick="return confirm('Annuler ce rendez-vous ?')">
                                Annuler
                            </button>
                        </form>
                        @else
                        <span style="color:var(--pt-text-muted);font-size:12px;">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:40px;color:var(--pt-text-muted);">
                        <svg viewBox="0 0 24 24" style="width:40px;height:40px;stroke:var(--pt-accent-mid);fill:none;stroke-width:1.2;display:block;margin:0 auto 12px;">
                            <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                        </svg>
                        Aucun rendez-vous trouvé.<br>
                        <a href="{{ route('patient.appointments.book') }}" class="pt-btn pt-btn-primary" style="margin-top:14px;display:inline-flex;">Prendre un RDV</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
@if($appointments->hasPages())
<div class="pt-pagination">
    {{ $appointments->links() }}
</div>
@endif

@endsection
