@extends('patient.layout')

@section('title', 'Mes Ordonnances')

@section('content')

<div class="pt-page-header">
    <h1>Mes <em>Ordonnances</em></h1>
    <p class="pt-page-subtitle">Consultez et imprimez vos ordonnances prescrites.</p>
</div>

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

                @if($rx->notes)
                <div style="margin-top:10px;padding:10px 14px;background:var(--pt-accent-light);border-radius:8px;font-size:12.5px;color:var(--pt-text-secondary);">
                    📝 {{ Str::limit($rx->notes, 120) }}
                </div>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div style="text-align:center;padding:60px 20px;color:var(--pt-text-muted);">
        <svg viewBox="0 0 24 24" style="width:48px;height:48px;stroke:var(--pt-accent-mid);fill:none;stroke-width:1.2;display:block;margin:0 auto 14px;">
            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><path d="M9 12h6M9 16h4"/>
        </svg>
        <p style="font-size:14px;margin-bottom:6px;">Aucune ordonnance pour le moment.</p>
        <p style="font-size:12px;">Vos ordonnances seront disponibles ici après vos consultations.</p>
    </div>
    @endforelse
</div>

@if($prescriptions->hasPages())
<div class="pt-pagination" style="margin-top:20px;">
    {{ $prescriptions->links() }}
</div>
@endif

@endsection
