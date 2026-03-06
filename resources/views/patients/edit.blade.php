@extends('layouts.sidebar')

@section('title', 'Modifier le Patient')

@section('content')
<link rel="stylesheet" href="{{ asset('asset/css/style_ajouterPatient.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,300;0,400;0,600;1,300&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

<div class="patient-page">
    <div class="page-title">
        <div class="page-title-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
        </div>
        <div>
            <h2>Modifier le patient</h2>
            <span>{{ $patient->first_name }} {{ $patient->last_name }}</span>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" style="background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
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
        <input type="checkbox" id="is_majeur" name="is_majeur" value="1" {{ $patient->is_majeur ? 'checked' : '' }} style="display: none;">
        <label for="is_majeur" class="toggle-card">
            <div class="toggle-pill"></div>
            <div class="toggle-label-text">
                <strong>Patient majeur</strong>
                <small>18 ans ou plus</small>
            </div>
            <svg style="margin-left:auto;width:20px;height:20px;color:var(--text-muted)" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </label>

        <!-- ══════════ BLOC MAJEUR ══════════ -->
        <div id="bloc-majeur" style="{{ $patient->is_majeur ? 'display:block;' : 'display:none;' }}">
            <div class="section-card">
                <div class="section-header">
                    <h3>Informations Générales</h3>
                </div>
                <div class="fields-grid">
                    <div class="form-group">
                        <label>Nom <span class="required-star">*</span></label>
                        <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $patient->first_name }}">
                    </div>
                    <div class="form-group">
                        <label>Prénom <span class="required-star">*</span></label>
                        <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $patient->last_name }}">
                    </div>
                    <div class="form-group">
                        <label>Sexe <span class="required-star">*</span></label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="male" {{ $patient->gender == 'male' ? 'selected' : '' }}>Masculin</option>
                            <option value="female" {{ $patient->gender == 'female' ? 'selected' : '' }}>Féminin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date de naissance <span class="required-star">*</span></label>
                        <input type="date" name="birth_date" id="birth_date" class="form-control" value="{{ $patient->birth_date }}">
                    </div>
                    <div class="form-group">
                        <label>CIN / Passeport</label>
                        <input type="text" name="cin" id="cin" class="form-control" value="{{ $patient->cin }}">
                    </div>
                    <div class="form-group">
                        <label>Téléphone <span class="required-star">*</span></label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ $patient->phone }}">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ $patient->email }}">
                    </div>
                    <div class="form-group">
                        <label>Groupe Sanguin</label>
                        <select name="groupe_sanguin" class="form-control">
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
            <div class="section-card">
                <div class="section-header">
                    <h4>Informations Enfant</h4>
                </div>
                <div class="fields-grid">
                    <div class="form-group">
                        <label>Nom <span class="required-star">*</span></label>
                        <input type="text" name="first_name_mineur" id="first_name_mineur" class="form-control" value="{{ $patient->first_name }}">
                    </div>
                    <div class="form-group">
                        <label>Prénom <span class="required-star">*</span></label>
                        <input type="text" name="last_name_mineur" id="last_name_mineur" class="form-control" value="{{ $patient->last_name }}">
                    </div>
                    <div class="form-group">
                        <label>Sexe <span class="required-star">*</span></label>
                        <select name="gender_mineur" id="gender_mineur" class="form-control">
                            <option value="Masculin" {{ $patient->gender == 'male' ? 'selected' : '' }}>Masculin</option>
                            <option value="Féminin" {{ $patient->gender == 'female' ? 'selected' : '' }}>Féminin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date de naissance <span class="required-star">*</span></label>
                        <input type="date" name="birth_date_mineur" id="birth_date_mineur" class="form-control" value="{{ $patient->birth_date }}">
                    </div>
                </div>
            </div>

            <div class="section-card">
                <div class="section-header">
                    <h4>Responsable Légal</h4>
                </div>
                <div class="fields-grid">
                    <div class="form-group">
                        <label>Type <span class="required-star">*</span></label>
                        <select name="type_responsable" id="type_responsable" class="form-control">
                            <option value="Parent" {{ $patient->type_responsable == 'Parent' ? 'selected' : '' }}>Parent</option>
                            <option value="Tuteur" {{ $patient->type_responsable == 'Tuteur' ? 'selected' : '' }}>Tuteur</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>CIN Responsable <span class="required-star">*</span></label>
                        <input type="text" name="cin_responsable" id="cin_responsable" class="form-control" value="{{ $patient->cin_responsable }}">
                    </div>
                    <div class="form-group">
                        <label>Nom <span class="required-star">*</span></label>
                        <input type="text" name="nom_responsable" id="nom_responsable" class="form-control" value="{{ $patient->nom_responsable }}">
                    </div>
                    <div class="form-group">
                        <label>Prénom <span class="required-star">*</span></label>
                        <input type="text" name="prenom_responsable" id="prenom_responsable" class="form-control" value="{{ $patient->prenom_responsable }}">
                    </div>
                    <div class="form-group">
                        <label>Téléphone <span class="required-star">*</span></label>
                        <input type="text" name="phone_responsable" id="phone_responsable" class="form-control" value="{{ $patient->phone_responsable }}">
                    </div>
                    <div class="form-group">
                        <label>Groupe Sanguin Enfant</label>
                        <select name="groupe_sanguin_mineur" id="groupe_sanguin_mineur" class="form-control">
                            <option value="">Sélectionner</option>
                            @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $g)
                                <option value="{{ $g }}" {{ $patient->groupe_sanguin == $g ? 'selected' : '' }}>{{ $g }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('patients.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

<script>
    const checkbox = document.getElementById('is_majeur');
    const blocMajeur = document.getElementById('bloc-majeur');
    const blocMineur = document.getElementById('bloc-mineur');

    const majeurRequired = [
        document.getElementById('first_name'),
        document.getElementById('last_name'),
        document.getElementById('gender'),
        document.getElementById('birth_date'),
        document.getElementById('phone')
    ];

    const mineurRequired = [
        document.getElementById('first_name_mineur'),
        document.getElementById('last_name_mineur'),
        document.getElementById('gender_mineur'),
        document.getElementById('birth_date_mineur'),
        document.getElementById('type_responsable'),
        document.getElementById('cin_responsable'),
        document.getElementById('nom_responsable'),
        document.getElementById('prenom_responsable'),
        document.getElementById('phone_responsable')
    ];

    function toggleRequired() {
        if (checkbox.checked) {
            blocMajeur.style.display = 'block';
            blocMineur.style.display = 'none';
            majeurRequired.forEach(el => el.setAttribute('required', ''));
            mineurRequired.forEach(el => el.removeAttribute('required'));
        } else {
            blocMajeur.style.display = 'none';
            blocMineur.style.display = 'block';
            majeurRequired.forEach(el => el.removeAttribute('required'));
            mineurRequired.forEach(el => el.setAttribute('required', ''));
        }
    }

    checkbox.addEventListener('change', toggleRequired);
    toggleRequired();
</script>
@endsection
