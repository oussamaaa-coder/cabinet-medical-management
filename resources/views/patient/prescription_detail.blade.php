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
<div class="pt-card pt-print-area" id="prescription-print" style="position:relative; overflow:hidden;">
    
    {{-- Subtle Watermark --}}
    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%) rotate(-45deg); font-size:120px; font-weight:900; color:rgba(0,0,0,0.02); pointer-events:none; z-index:0; text-transform:uppercase;">
        MediCal
    </div>

    {{-- Header --}}
    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:40px;padding-bottom:24px;border-bottom:3px solid var(--pt-accent); position:relative; z-index:1;">
        <div>
            <div style="font-family:'Outfit',sans-serif;font-size:1.8rem;font-weight:800;color:var(--pt-accent);margin-bottom:4px; letter-spacing:-1px;">MediCal <span style="color:var(--pt-text-primary)">Clinic</span></div>
            <div style="font-size:12px;color:var(--pt-text-muted); font-weight:600; text-transform:uppercase; letter-spacing:1px;">Ordonnance Officielle</div>
            <div style="font-size:11px;color:var(--pt-text-muted); margin-top:10px; max-width:200px;">Casablanca Finance City, Tour A, Bureau 402<br>Tél: +212 522-123456</div>
        </div>
        <div style="text-align:right;">
            <div class="no-print" style="display:inline-block; padding:10px; border:1px solid #eee; border-radius:12px; margin-bottom:12px;">
                {{-- Fake QR Code for Verification --}}
                <div style="width:60px; height:60px; background:repeating-conic-gradient(#000 0% 25%, #fff 0% 50%) 50% / 10px 10px;"></div>
                <div style="font-size:8px; font-weight:800; margin-top:5px; color:#aaa;">ID : {{ $prescription->id }}</div>
            </div>
            <div style="font-size:15px;font-weight:700;color:var(--pt-text-primary);">
                Le {{ \Carbon\Carbon::parse($prescription->prescription_date)->format('d/m/Y') }}
            </div>
        </div>
    </div>

    {{-- Doctor & Patient --}}
    <div style="display:grid;grid-template-columns:1.2fr 1fr;gap:30px;margin-bottom:40px; position:relative; z-index:1;">
        <div>
            <div style="font-size:10px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;color:var(--pt-accent);margin-bottom:8px;">Praticien Responsable</div>
            <div style="font-family:'Outfit',sans-serif;font-size:1.4rem;font-weight:700;color:var(--pt-text-primary);">
                Dr. {{ $prescription->doctor->name ?? '—' }}
            </div>
            <div style="font-size:13px; color:var(--pt-text-secondary); margin-top:4px;">{{ $prescription->doctor->specialty ?? 'Médecine Générale' }}</div>
            <div style="font-size:12px; color:var(--pt-text-muted); margin-top:2px;">Inscrit à l'Ordre National</div>
        </div>

        <div style="padding:20px; border:1.5px dashed #e2e8f0; border-radius:16px;">
            <div style="font-size:10px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;color:var(--pt-text-muted);margin-bottom:8px;">Patient</div>
            <div style="font-size:1.1rem;font-weight:700;color:var(--pt-text-primary);">
                {{ $prescription->patient->first_name }} {{ $prescription->patient->last_name }}
            </div>
            @if($prescription->patient->birth_date)
            <div style="font-size:12px;color:var(--pt-text-secondary);margin-top:4px; font-weight:500;">
                Âge: {{ \Carbon\Carbon::parse($prescription->patient->birth_date)->age }} ans
            </div>
            @endif
        </div>
    </div>

    {{-- Diagnosis --}}
    @if($prescription->diagnosis)
    <div style="margin-bottom:32px; position:relative; z-index:1;">
        <div style="font-size:10px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;color:var(--pt-text-muted);margin-bottom:10px;">Motif / Diagnostic</div>
        <div style="font-size:15px;color:var(--pt-text-primary); font-weight:500; font-style:italic;">« {{ $prescription->diagnosis }} »</div>
    </div>
    @endif

    {{-- Medications --}}
    <div style="margin-bottom:40px; position:relative; z-index:1;">
        <div style="font-size:10px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;color:var(--pt-accent);margin-bottom:15px; display:flex; align-items:center; gap:8px;">
            <span style="display:inline-block; width:15px; height:2px; background:var(--pt-accent);"></span>
            Prescription Médicamenteuse
        </div>

        @if($prescription->items->count())
        <div style="display:flex; flex-direction:column; gap:20px;">
            @foreach($prescription->items as $item)
            <div style="display:flex; justify-content:space-between; align-items:center; padding-bottom:15px; border-bottom:1px solid #f1f5f9;">
                <div>
                    <div style="font-size:16px; font-weight:700; color:var(--pt-text-primary); display:flex; align-items:center; gap:10px;">
                        <span style="font-size:20px; color:var(--pt-accent);">Rx</span>
                        {{ $item->medicine_name ?? '—' }}
                    </div>
                    @if($item->dosage)
                    <div style="font-size:13px; color:var(--pt-text-secondary); margin-left:35px; margin-top:2px;">Posologie: <strong>{{ $item->dosage }}</strong></div>
                    @endif
                </div>
                @if($item->duration)
                <div style="background:#f8fafc; padding:6px 12px; border-radius:8px; font-size:12px; font-weight:700; color:var(--pt-text-secondary);">
                    Durée: {{ $item->duration }}
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <p style="color:var(--pt-text-muted);font-size:13px;">Aucun médicament listé.</p>
        @endif
    </div>

    {{-- Notes --}}
    @if($prescription->notes)
    <div style="margin-bottom:40px; padding:20px; background:#fffcf0; border-radius:12px; border:1px solid #fef3c7; position:relative; z-index:1;">
        <div style="font-size:10px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;color:#b45309;margin-bottom:8px;">Recommandations Particulières</div>
        <div style="font-size:13px;color:#92400e;line-height:1.6; font-weight:500;">{{ $prescription->notes }}</div>
    </div>
    @endif

    {{-- Signature --}}
    <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-top:50px; position:relative; z-index:1;">
        <div style="font-size:10px; color:#94a3b8; max-width:250px;">
            Document généré électroniquement par MediCal. <br> 
            Valable pour une durée de 3 mois à compter de la date de prescription.
        </div>
        <div style="text-align:center;min-width:200px;">
            <div style="font-size:11px;color:var(--pt-text-muted);margin-bottom:10px; font-style:italic;">Cachet et Signature</div>
            <div style="position:relative; height:100px; display:flex; align-items:center; justify-content:center;">
                {{-- Professional Green Medical Stamp --}}
                <div style="width:110px; height:110px; border:2px solid rgba(16, 185, 129, 0.3); border-radius:50%; display:flex; flex-direction:column; align-items:center; justify-content:center; transform:rotate(-12deg); position:absolute; z-index:1;">
                    <div style="font-size:8px; color:rgba(16, 185, 129, 0.7); font-weight:800; text-transform:uppercase;">Clinique MediCal</div>
                    <div style="width:20px; height:20px; margin:4px 0;">
                        <svg viewBox="0 0 24 24" fill="rgba(16, 185, 129, 0.4)"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
                    </div>
                    <div style="font-size:7px; color:rgba(16, 185, 129, 0.7); font-weight:800;">CASABLANCA</div>
                </div>
                {{-- Dynamic Doctor Signature Name --}}
                <div style="font-family:'Alex Brush', cursive; font-size:2.2rem; color:#1e293b; z-index:2; margin-top:10px; text-shadow: 0 0 10px white;">
                    {{ $prescription->doctor->name ?? 'Dr. Signature' }}
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Alex+Brush&display=swap');
    
    .pt-print-area {
        background: white !important;
        box-shadow: 0 15px 40px rgba(0,0,0,0.08) !important;
        border-radius: 20px !important;
        padding: 60px !important;
    }

    @media print {
        @page { size: A4; margin: 10mm; }
        body { background: white !important; margin: 0 !important; font-size: 12px; }
        .pt-layout-sidebar, .pt-sidebar, .pt-mobile-nav, .no-print, [x-data^="chatbot"] { display: none !important; }
        .pt-layout-main, .pt-main { margin: 0 !important; padding: 0 !important; width: 100% !important; }
        
        .pt-print-area { 
            box-shadow: none !important; 
            border: none !important; 
            padding: 10px !important; 
            width: 100% !important; 
            margin: 0 !important;
            height: auto !important;
            page-break-inside: avoid;
        }

        /* Tighten layout for print */
        #prescription-print { min-height: 100%; display: flex; flex-direction: column; justify-content: space-between; }
        .pt-print-area header, .pt-print-area .header-section { margin-bottom: 20px !important; }
        .pt-print-area ul { margin-bottom: 15px !important; }
        .pt-print-area div { page-break-inside: avoid; }
    }
</style>

@endsection
