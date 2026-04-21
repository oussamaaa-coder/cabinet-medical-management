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
            <span class="current">Ajouter un patient</span>
        </div>
    </div>

    <div class="app-section-title">
        <h3>Nouveau Dossier Médical</h3>
    </div>

    <form id="patientForm" action="{{ route('patients.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Toggle majeur/mineur -->
        <div class="form-group">
            <label class="app-form-label">Type de patient</label>
            <input type="checkbox" id="is_majeur" name="is_majeur" value="1" checked style="display:none;">
            <label for="is_majeur" class="app-toggle-card">
                <div style="flex: 1;">
                    <strong style="display:block; color: var(--text-primary);">Patient majeur</strong>
                    <small style="color: var(--text-muted);">18 ans ou plus — Capable juridiquement</small>
                </div>
                <div class="toggle-indicator" style="width: 24px; height: 24px; border-radius: 50%; border: 2px solid var(--accent); position: relative;">
                    <div class="inner-dot" style="position: absolute; top: 4px; left: 4px; right: 4px; bottom: 4px; background: var(--accent); border-radius: 50%;"></div>
                </div>
            </label>
        </div>

        <!-- ══════════ BLOC MAJEUR ══════════ -->
        <div id="bloc-majeur">
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
                        <input type="text" name="first_name" id="first_name" class="app-form-control" placeholder="Entrez le nom" required>
                    </div>

                    <div class="app-form-group">
                        <label class="app-form-label">Prénom <span style="color: var(--danger);">*</span></label>
                        <input type="text" name="last_name" id="last_name" class="app-form-control" placeholder="Entrez le prénom" required>
                    </div>

                    <div class="app-form-group">
                        <label class="app-form-label">Sexe <span style="color: var(--danger);">*</span></label>
                        <select name="gender" id="gender" class="app-form-control" required>
                            <option value="">Sélectionner</option>
                            <option value="male">Masculin</option>
                            <option value="female">Féminin</option>
                        </select>
                    </div>

                    <div class="app-form-group">
                        <label class="app-form-label">Date de naissance <span style="color: var(--danger);">*</span></label>
                        <input type="date" name="birth_date" id="birth_date" class="app-form-control" required>
                    </div>

                    <div class="app-form-group">
                        <label class="app-form-label">CIN / Passeport</label>
                        <input type="text" name="cin" id="cin" class="app-form-control" placeholder="Ex: AB123456">
                    </div>

                    <div class="app-form-group">
                        <label class="app-form-label">Téléphone <span style="color: var(--danger);">*</span></label>
                        <input type="text" name="phone" id="phone" class="app-form-control" placeholder="06XXXXXXXX" required>
                    </div>

                    <div class="app-form-group">
                        <label class="app-form-label">Email</label>
                        <input type="email" name="email" id="email" class="app-form-control" placeholder="exemple@email.com">
                    </div>
                </div>

                <div class="app-form-group" style="margin-top: 20px;">
                    <label class="app-form-label">Photo du patient</label>
                    <div style="border: 2px border-style: dashed; border-color: var(--border); border-radius: var(--radius-md); padding: 20px; text-align: center; background: var(--bg-field); cursor: pointer;" onclick="document.getElementById('photo').click()">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted); margin-bottom: 10px;"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        <div id="photo-label-text" style="font-size: 0.9rem; color: var(--accent); font-weight: 500;">Cliquer pour télécharger une photo</div>
                        <input type="file" name="photo" id="photo" accept="image/*" style="display:none;">
                    </div>
                </div>
            </div>

            <!-- Medical Data -->
            <div class="app-form-section">
                <div class="app-form-section-header">
                    <div class="app-form-section-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <h3 style="margin:0; font-size: 1.1rem; font-weight: 600;">Données Médicales</h3>
                </div>

                <div class="app-form-grid">
                    <div class="app-form-group">
                        <label class="app-form-label">Assurance</label>
                        <select name="assurance" id="assurance" class="app-form-control">
                            <option value="">Pas d'assurance</option>
                            <option value="CNSS">CNSS</option>
                            <option value="CNOPS">CNOPS</option>
                            <option value="RAMED">RAMED</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                    <div class="app-form-group">
                        <label class="app-form-label">Numéro d'assurance</label>
                        <input type="text" name="num_assurance" class="app-form-control" placeholder="Numéro ID">
                    </div>
                </div>

                <div class="app-form-group">
                    <label class="app-form-label">Allergies connues</label>
                    <textarea name="allergies" class="app-form-control" rows="2" placeholder="Pénicilline, arachides, ..."></textarea>
                </div>
            </div>
        </div>

        <!-- ══════════ BLOC MINEUR ══════════ -->
        <div id="bloc-mineur" style="display:none;">
            <div class="app-form-section">
                <div class="app-form-section-header">
                    <div class="app-form-section-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                    </div>
                    <h3 style="margin:0; font-size: 1.1rem; font-weight: 600;">Mineur & Tuteur</h3>
                </div>

                <div class="app-form-grid">
                    <div class="app-form-group">
                        <label class="app-form-label">Nom Enfant <span style="color: var(--danger);">*</span></label>
                        <input type="text" name="first_name_mineur" id="first_name_mineur" class="app-form-control">
                    </div>
                    <div class="app-form-group">
                        <label class="app-form-label">Prénom Enfant <span style="color: var(--danger);">*</span></label>
                        <input type="text" name="last_name_mineur" id="last_name_mineur" class="app-form-control">
                    </div>
                    <div class="app-form-group">
                        <label class="app-form-label">Date de naissance <span style="color: var(--danger);">*</span></label>
                        <input type="date" name="birth_date_mineur" id="birth_date_mineur" class="app-form-control">
                    </div>
                    <div class="app-form-group">
                        <label class="app-form-label">Nom du Tuteur <span style="color: var(--danger);">*</span></label>
                        <input type="text" name="nom_responsable" id="nom_responsable" class="app-form-control" placeholder="Père, Mère, etc.">
                    </div>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 30px; justify-content: flex-end;">
            <a href="{{ route('patients.index') }}" class="app-btn app-btn-secondary">Annuler</a>
            <button type="submit" class="app-btn app-btn-primary" style="padding-left: 30px; padding-right: 30px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v14a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Enregistrer le Patient
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

        const photoInput = document.getElementById('photo');
        const photoLabel = document.getElementById('photo-label-text');
        if(photoInput) {
            photoInput.addEventListener('change', function() {
                if(this.files && this.files[0]) {
                    photoLabel.textContent = "Fichier sélectionné : " + this.files[0].name;
                    photoLabel.style.color = "var(--success)";
                }
            });
        }

        toggleRequired();
    });
</script>
@endsection
