@extends('patient.layout')

@section('title', 'Ordonnance')

@section('content')

{{-- Print controls (hidden when printing) --}}
<div class="no-print" style="margin-bottom:24px;display:flex;justify-content:space-between;align-items:center;">
    <a href="{{ route('patient.prescriptions') }}" class="pt-btn pt-btn-outline">
        <svg viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
        Retour
    </a>
    <button onclick="window.print()" class="pt-btn pt-btn-primary">
        <svg viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
        Imprimer / PDF
    </button>
</div>

{{-- Prescription Document --}}
<div class="pt-card pt-print-area" id="prescription-print">

    {{-- Header --}}
    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:32px;padding-bottom:24px;border-bottom:2px solid var(--pt-sidebar-border);">
        <div>
            <div style="font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-weight:600;color:var(--pt-accent);margin-bottom:4px;">Cabinet Médical</div>
            <div style="font-size:13px;color:var(--pt-text-muted);">Ordonnance Médicale</div>
        </div>
        <div style="text-align:right;">
            <div style="font-size:12px;color:var(--pt-text-muted);margin-bottom:3px;">Date</div>
            <div style="font-size:15px;font-weight:600;color:var(--pt-text-primary);">
                {{ \Carbon\Carbon::parse($prescription->prescription_date)->isoFormat('DD MMMM YYYY') }}
            </div>
            <div style="margin-top:8px;padding:4px 12px;background:var(--pt-accent-light);border-radius:20px;font-size:11px;font-weight:700;color:var(--pt-accent);">
                Réf : #{{ str_pad($prescription->id, 5, '0', STR_PAD_LEFT) }}
            </div>
        </div>
    </div>

    {{-- Doctor & Patient --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:32px;">

        <div style="padding:18px;background:var(--pt-accent-light);border-radius:12px;">
            <div style="font-size:10px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--pt-text-label);margin-bottom:8px;">Prescripteur</div>
            <div style="font-family:'Cormorant Garamond',serif;font-size:1.1rem;font-weight:600;color:var(--pt-text-primary);">
                Dr. {{ $prescription->doctor->name ?? '—' }}
            </div>
        </div>

        <div style="padding:18px;border:1px solid var(--pt-sidebar-border);border-radius:12px;">
            <div style="font-size:10px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--pt-text-label);margin-bottom:8px;">Patient</div>
            <div style="font-size:15px;font-weight:600;color:var(--pt-text-primary);">
                {{ $prescription->patient->first_name }} {{ $prescription->patient->last_name }}
            </div>
            @if($prescription->patient->birth_date)
            <div style="font-size:12px;color:var(--pt-text-muted);margin-top:3px;">
                Né(e) le {{ \Carbon\Carbon::parse($prescription->patient->birth_date)->format('d/m/Y') }}
            </div>
            @endif
        </div>

    </div>

    {{-- Diagnosis --}}
    @if($prescription->diagnosis)
    <div style="margin-bottom:24px;padding:16px 20px;background:var(--pt-page-bg);border-radius:10px;border-left:3px solid var(--pt-accent);">
        <div style="font-size:10px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--pt-text-label);margin-bottom:6px;">Diagnostic</div>
        <div style="font-size:14px;color:var(--pt-text-primary);line-height:1.6;">{{ $prescription->diagnosis }}</div>
    </div>
    @endif

    {{-- Medications --}}
    <div style="margin-bottom:24px;">
        <div style="font-size:10px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--pt-text-label);margin-bottom:12px;">Médicaments prescrits</div>

        @if($prescription->items->count())
        <ul class="pt-rx-items-list">
            @foreach($prescription->items as $item)
            <li>
                <div>
                    <div class="pt-rx-item-name">{{ $item->medicine_name ?? '—' }}</div>
                    @if($item->dosage)
                    <div class="pt-rx-item-detail">{{ $item->dosage }}</div>
                    @endif
                </div>
                @if($item->duration)
                <div style="font-size:12px;color:var(--pt-accent);font-weight:600;white-space:nowrap;">
                    {{ $item->duration }}
                </div>
                @endif
            </li>
            @endforeach
        </ul>
        @else
        <p style="color:var(--pt-text-muted);font-size:13px;">Aucun médicament listé.</p>
        @endif
    </div>

    {{-- Notes --}}
    @if($prescription->notes)
    <div style="margin-bottom:24px;padding:14px 18px;background:var(--pt-page-bg);border-radius:10px;">
        <div style="font-size:10px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--pt-text-label);margin-bottom:6px;">Notes supplémentaires</div>
        <div style="font-size:13.5px;color:var(--pt-text-secondary);line-height:1.65;">{{ $prescription->notes }}</div>
    </div>
    @endif

    {{-- Signature --}}
    <div style="display:flex;justify-content:flex-end;margin-top:32px;padding-top:20px;border-top:1px solid var(--pt-sidebar-border);">
        <div style="text-align:center;min-width:180px;">
            <div style="font-size:11px;color:var(--pt-text-muted);margin-bottom:6px;">Signature du médecin</div>
            <div style="height:50px;border-bottom:1.5px solid var(--pt-sidebar-border);margin-bottom:6px;"></div>
            <div style="font-size:12px;font-weight:600;color:var(--pt-text-primary);">Dr. {{ $prescription->doctor->name ?? '—' }}</div>
        </div>
    </div>

</div>

@endsection
