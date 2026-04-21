@extends('layouts.sidebar')

@section('content')
<div class="patient-page-wrapper">
    <div class="app-topbar">
        <div class="app-breadcrumb">
            <a href="{{ route('patients.index') }}">Patients</a>
            <span class="sep">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </span>
            <span class="current">Modifier le patient</span>
        </div>
    </div>

    <div class="app-section-title">
        <h3>Modification du Dossier #{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }}</h3>
    </div>

    @if ($errors->any())
        <div class="app-card" style="border-left: 4px solid var(--danger); background: var(--warning-light);">
            <div style="color: var(--danger); font-weight: 700; margin-bottom: 8px;">Veuillez corriger les erreurs suivantes :</div>
            <ul style="margin: 0; padding-left: 20px; color: var(--danger); font-size: 0.9rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="patientForm" action="{{ route('patients.update', $patient->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Toggle majeur/mineur -->
        <div class="form-group">
            <label class="app-form-label">Type de patient</label>
            <input type="checkbox" id="is_majeur" name="is_majeur" value="1" {{ $patient->is_majeur ? 'checked' : '' }} style="display:none;">
            <label for="is_majeur" class="app-toggle-card">
                <div style="flex: 1;">
                    <strong style="display:block; color: var(--text-primary);">Patient majeur</strong>
                    <small style="color: var(--text-muted);">18 ans ou plus — Capable juridiquement</small>
                </div>
                <div class="toggle-indicator" style="width: 24px; height: 24px; border-radius: 50%; border: 2px solid var(--accent); position: relative;">
                    <div class="inner-dot" style="position: absolute; top: 4px; left: 4px; right: 4px; bottom: 4px; background: var(--accent); border-radius: 50%; {{ $patient->is_majeur ? '' : 'display:none;' }}"></div>
                </div>
            </label>
        </div>

        <!-- ══════════ BLOC MAJEUR ══════════ -->
        <div id="bloc-majeur" style="{{ $patient->is_majeur ? 'display:block;' : 'display:none;' }}">
            <div class="app-form-section">
                <div class="app-form-section-header">
                    <div class="app-form-section-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h3 style="margin:0; font-size: 1.1rem; font-weight: 600;">Informations Générales</h3>
                </div>

                <div class="app-form-grid">
                    <div class="app-form-group">
                        <label class="app-form-label">Nom <span style="color: var(--danger);">*</span></label>
                        <input type="text" name="first_name" id="first_name" class="app-form-control" value="{{ $patient->first_name }}">
                    </div>

                    <div class="app-form-group">
                        <label class="app-form-label">Prénom <span style="color: var(--danger);">*</span></label>
                        <input type="text" name="last_name" id="last_name" class="app-form-control" value="{{ $patient->last_name }}">
                    </div>

                    <div class="app-form-group">
                        <label class="app-form-label">Sexe <span style="color: var(--danger);">*</span></label>
                        <select name="gender" id="gender" class="app-form-control">
                            <option value="male" {{ $patient->gender == 'male' ? 'selected' : '' }}>Masculin</option>
                            <option value="female" {{ $patient->gender == 'female' ? 'selected' : '' }}>Féminin</option>
                        </select>
                    </div>

                    <div class="app-form-group">
                        <label class="app-form-label">Date de naissance <span style="color: var(--danger);">*</span></label>
                        <input type="date" name="birth_date" id="birth_date" class="app-form-control" value="{{ $patient->birth_date }}">
                    </div>

                    <div class="app-form-group">
                        <label class="app-form-label">CIN / Passeport</label>
                        <input type="text" name="cin" id="cin" class="app-form-control" value="{{ $patient->cin }}">
                    </div>

                    <div class="app-form-group">
                        <label class="app-form-label">Téléphone <span style="color: var(--danger);">*</span></label>
                        <input type="text" name="phone" id="phone" class="app-form-control" value="{{ $patient->phone }}">
                    </div>

                    <div class="app-form-group">
                        <label class="app-form-label">Email</label>
                        <input type="email" name="email" id="email" class="app-form-control" value="{{ $patient->email }}">
                    </div>

                    <div class="app-form-group">
                        <label class="app-form-label">Groupe Sanguin</label>
                        <select name="groupe_sanguin" class="app-form-control">
                            <option value="">Sélectionner</option>
                            @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $g)
                                <option value="{{ $g }}" {{ $patient->groupe_sanguin == $g ? 'selected' : '' }}>{{ $g }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- ══════════ BLOC MINEUR ══════════ -->
        <div id="bloc-mineur" style="{{ !$patient->is_majeur ? 'display:block;' : 'display:none;' }}">
            <div class="app-form-section">
                <div class="app-form-section-header">
                    <div class="app-form-section-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a5 5 0 100 10A5 5 0 0012 2zM4 20a8 8 0 1116 0"/></svg>
                    </div>
                    <h3 style="margin:0; font-size: 1.1rem; font-weight: 600;">Informations Enfant & Tuteur</h3>
                </div>

                <div class="app-form-grid">
                    <div class="app-form-group">
                        <label class="app-form-label">Nom Enfant <span style="color: var(--danger);">*</span></label>
                        <input type="text" name="first_name_mineur" id="first_name_mineur" class="app-form-control" value="{{ $patient->first_name }}">
                    </div>
                    <div class="app-form-group">
                        <label class="app-form-label">Prénom Enfant <span style="color: var(--danger);">*</span></label>
                        <input type="text" name="last_name_mineur" id="last_name_mineur" class="app-form-control" value="{{ $patient->last_name }}">
                    </div>
                    <div class="app-form-group">
                        <label class="app-form-label">Date de naissance <span style="color: var(--danger);">*</span></label>
                        <input type="date" name="birth_date_mineur" id="birth_date_mineur" class="app-form-control" value="{{ $patient->birth_date }}">
                    </div>
                    <div class="app-form-group">
                        <label class="app-form-label">Tuteur / Parent <span style="color: var(--danger);">*</span></label>
                        <input type="text" name="nom_responsable" id="nom_responsable" class="app-form-control" value="{{ $patient->nom_responsable }}">
                    </div>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 30px; justify-content: flex-end;">
            <a href="{{ route('patients.index') }}" class="app-btn app-btn-secondary">Annuler</a>
            <button type="submit" class="app-btn app-btn-primary" style="padding-left: 30px; padding-right: 30px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Mettre à jour
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('is_majeur');
        const blocMajeur = document.getElementById('bloc-majeur');
        const blocMineur = document.getElementById('bloc-mineur');
        const innerDot = document.querySelector('.inner-dot');

        const majeurRequired = ['first_name', 'last_name', 'gender', 'birth_date', 'phone'];
        const mineurRequired = ['first_name_mineur', 'last_name_mineur', 'birth_date_mineur', 'nom_responsable'];

        function toggleRequired() {
            if (checkbox.checked) {
                blocMajeur.style.display = 'block';
                blocMineur.style.display = 'none';
                innerDot.style.display = 'block';
                majeurRequired.forEach(id => document.getElementById(id).setAttribute('required', ''));
                mineurRequired.forEach(id => document.getElementById(id).removeAttribute('required'));
            } else {
                blocMajeur.style.display = 'none';
                blocMineur.style.display = 'block';
                innerDot.style.display = 'none';
                majeurRequired.forEach(id => document.getElementById(id).removeAttribute('required'));
                mineurRequired.forEach(id => document.getElementById(id).setAttribute('required', ''));
            }
        }

        checkbox.parentElement.addEventListener('click', function(e) {
            if(e.target !== checkbox) {
                checkbox.checked = !checkbox.checked;
                toggleRequired();
            }
        });

        toggleRequired();
    });
</script>
@endsection
