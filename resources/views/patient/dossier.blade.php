@extends('patient.layout')

@section('title', 'Mon Dossier')

@section('content')

<div class="pt-page-header">
    <h1>Mon <em>Dossier Médical</em></h1>
    <p class="pt-page-subtitle">Vos informations médicales en lecture seule. Contactez le cabinet pour toute mise à jour.</p>
</div>

@if(!$patient)
<div class="pt-card" style="text-align:center;padding:48px;">
    <svg viewBox="0 0 24 24" style="width:52px;height:52px;stroke:var(--pt-accent-mid);fill:none;stroke-width:1.2;display:block;margin:0 auto 14px;">
        <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/>
    </svg>
    <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.3rem;color:var(--pt-text-primary);margin-bottom:8px;">Dossier non trouvé</h3>
    <p style="color:var(--pt-text-muted);font-size:14px;">Votre dossier médical n'est pas encore associé à ce compte.<br>Veuillez contacter le cabinet médical.</p>
</div>
@else

{{-- Identity Card --}}
<div class="pt-card" style="margin-bottom:22px;background:linear-gradient(135deg,var(--pt-accent) 0%,var(--pt-accent-2) 100%);color:#fff;position:relative;overflow:hidden;">
    <div style="position:absolute;top:-30px;right:-30px;width:130px;height:130px;border-radius:50%;background:rgba(255,255,255,.08);"></div>
    <div style="position:absolute;bottom:-20px;right:60px;width:80px;height:80px;border-radius:50%;background:rgba(255,255,255,.06);"></div>
    <div style="display:flex;align-items:center;gap:20px;">
        <div style="width:64px;height:64px;border-radius:16px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:700;flex-shrink:0;">
            {{ strtoupper(substr($patient->first_name, 0, 1)) }}{{ strtoupper(substr($patient->last_name, 0, 1)) }}
        </div>
        <div>
            <div style="font-size:11px;letter-spacing:1px;text-transform:uppercase;opacity:.75;margin-bottom:4px;">Patient</div>
            <div style="font-family:'Cormorant Garamond',serif;font-size:1.8rem;font-weight:600;line-height:1.1;">{{ $patient->first_name }} {{ $patient->last_name }}</div>
            @if($patient->birth_date)
            <div style="font-size:13px;opacity:.85;margin-top:4px;">
                Né(e) le {{ \Carbon\Carbon::parse($patient->birth_date)->isoFormat('DD MMMM YYYY') }}
                ({{ \Carbon\Carbon::parse($patient->birth_date)->age }} ans)
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Personal Info --}}
<div class="pt-card" style="margin-bottom:18px;">
    <div class="pt-section-title">Informations personnelles</div>
    <div class="pt-info-grid">
        <div class="pt-info-item">
            <span class="pt-info-label">Genre</span>
            <span class="pt-info-value {{ !$patient->gender ? 'empty' : '' }}">{{ $patient->gender ?? 'Non renseigné' }}</span>
        </div>
        <div class="pt-info-item">
            <span class="pt-info-label">Téléphone</span>
            <span class="pt-info-value {{ !$patient->phone ? 'empty' : '' }}">{{ $patient->phone ?? 'Non renseigné' }}</span>
        </div>
        <div class="pt-info-item">
            <span class="pt-info-label">Email</span>
            <span class="pt-info-value {{ !$patient->email ? 'empty' : '' }}">{{ $patient->email ?? 'Non renseigné' }}</span>
        </div>
        <div class="pt-info-item">
            <span class="pt-info-label">Nationalité</span>
            <span class="pt-info-value {{ !$patient->nationality ? 'empty' : '' }}">{{ $patient->nationality ?? 'Non renseigné' }}</span>
        </div>
        <div class="pt-info-item">
            <span class="pt-info-label">CIN</span>
            <span class="pt-info-value {{ !$patient->cin ? 'empty' : '' }}">{{ $patient->cin ?? 'Non renseigné' }}</span>
        </div>
        <div class="pt-info-item">
            <span class="pt-info-label">Adresse</span>
            <span class="pt-info-value {{ !$patient->address ? 'empty' : '' }}">{{ $patient->address ?? 'Non renseignée' }}</span>
        </div>
    </div>
</div>

{{-- Insurance --}}
<div class="pt-card" style="margin-bottom:18px;">
    <div class="pt-section-title">Assurance</div>
    <div class="pt-info-grid">
        <div class="pt-info-item">
            <span class="pt-info-label">Assureur</span>
            <span class="pt-info-value {{ !$patient->assurance ? 'empty' : '' }}">{{ $patient->assurance ?? 'Non renseigné' }}</span>
        </div>
        <div class="pt-info-item">
            <span class="pt-info-label">N° Assurance</span>
            <span class="pt-info-value {{ !$patient->num_assurance ? 'empty' : '' }}">{{ $patient->num_assurance ?? 'Non renseigné' }}</span>
        </div>
    </div>
</div>

{{-- Medical Info --}}
<div class="pt-card" style="margin-bottom:18px;">
    <div class="pt-section-title">Données médicales</div>
    <div class="pt-info-grid">
        <div class="pt-info-item">
            <span class="pt-info-label">Groupe Sanguin</span>
            <span class="pt-info-value {{ !$patient->groupe_sanguin ? 'empty' : '' }}" style="font-size:1.1rem;font-weight:700;color:var(--pt-accent);">
                {{ $patient->groupe_sanguin ?? '—' }}
            </span>
        </div>
        <div class="pt-info-item">
            <span class="pt-info-label">Langue parlée</span>
            <span class="pt-info-value {{ !$patient->langue_parlee ? 'empty' : '' }}">{{ $patient->langue_parlee ?? 'Non renseigné' }}</span>
        </div>
    </div>

    <div style="margin-top:18px;display:grid;grid-template-columns:1fr 1fr;gap:16px;">
        @foreach([
            ['allergies',          'Allergies'],
            ['maladies_chroniques','Maladies chroniques'],
            ['medicaments_cours',  'Médicaments en cours'],
            ['antecedents_personnels', 'Antécédents personnels'],
            ['antecedents_familiaux',  'Antécédents familiaux'],
            ['hospitalisations',       'Hospitalisations'],
        ] as [$field, $label])
        <div style="padding:14px;background:var(--pt-page-bg);border-radius:10px;">
            <div class="pt-info-label" style="margin-bottom:6px;">{{ $label }}</div>
            <div class="pt-info-value {{ !$patient->$field ? 'empty' : '' }}" style="font-size:13px;line-height:1.55;">
                {{ $patient->$field ?? 'Non renseigné' }}
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Note --}}
<div style="display:flex;align-items:center;gap:10px;padding:14px 18px;background:var(--pt-accent-light);border-radius:10px;font-size:12.5px;color:var(--pt-text-secondary);">
    <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:none;stroke:var(--pt-accent);stroke-width:2;flex-shrink:0;"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
    Ces informations sont gérées par le personnel soignant du cabinet. Pour toute correction, veuillez contacter l'accueil.
</div>

@endif

@endsection
