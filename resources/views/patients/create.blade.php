<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('asset/css/style_ajouterPatient.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,300;0,400;0,600;1,300&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <title>Ajouter patient</title>
</head>
<body>
@extends('layouts.sidebar')
@section('content')
<div class="patient-page">

  <!-- Page title -->
  <div class="page-title">
    <div class="page-title-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
        <path d="M16 11h4m-2-2v4M8 11h.01M12 11h.01M6 5H4a1 1 0 00-1 1v13a1 1 0 001 1h16a1 1 0 001-1V6a1 1 0 00-1-1h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
      </svg>
    </div>
    <div>
      <h2>Ajouter un patient</h2>
      <span>Nouveau dossier médical</span>
    </div>
  </div>

  <form id="patientForm" action="{{ route('patients.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Toggle majeur/mineur -->
    <input type="checkbox" id="is_majeur" name="is_majeur" value="1" checked>
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
    <div id="bloc-majeur">

      <!-- Informations générales -->
      <div class="section-card">
        <div class="section-header">
          <div class="section-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
          </div>
          <h3>Informations Générales</h3>
        </div>

        <div class="fields-grid">

          <!-- Nom -->
          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"/><path d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
              Nom <span class="required-star">*</span>
            </label>
            <input type="text" name="first_name" id="first_name" class="form-control" required>
          </div>

          <!-- Prénom -->
          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"/><path d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
              Prénom <span class="required-star">*</span>
            </label>
            <input type="text" name="last_name" id="last_name" class="form-control" required>
          </div>

          <!-- Sexe -->
          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="4"/><path d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>
              Sexe <span class="required-star">*</span>
            </label>
            <select name="gender" id="gender" class="form-control" required>
              <option value="">Sélectionner</option>
              <option value="male">Masculin</option>
              <option value="female">Féminin</option>
            </select>
          </div>

          <!-- Date de naissance -->
          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
              Date de naissance <span class="required-star">*</span>
            </label>
            <input type="date" name="birth_date" id="birth_date" class="form-control" required>
          </div>

          <!-- CIN -->
          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20M6 15h4M14 15h4"/></svg>
              CIN / Passeport
            </label>
            <input type="text" name="cin" id="cin" class="form-control" placeholder="Ex: AB123456">
          </div>

          <!-- Téléphone -->
          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 01.07 1.18 2 2 0 012.05 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
              Téléphone <span class="required-star">*</span>
            </label>
            <input type="text" name="phone" id="phone" class="form-control" placeholder="06XXXXXXXX" required>
          </div>

          <!-- Email -->
          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
              Email
            </label>
            <input type="email" name="email" id="email" class="form-control" placeholder="exemple@email.com">
          </div>

          <!-- Nationalité -->
          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>
              Nationalité
            </label>
            <input type="text" name="nationality" id="nationality" class="form-control" placeholder="Ex: Marocaine">
          </div>

          <!-- Langue(s) -->
          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
              Langue(s) parlée(s)
            </label>
            <input type="text" name="langue_parlee" id="langue_parlee" class="form-control" placeholder="Français, Arabe, ...">
          </div>

          <!-- Photo -->
          <div class="form-group full-width">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/><circle cx="12" cy="13" r="4"/></svg>
              Photo du patient
            </label>
            <div class="file-upload-wrapper">
              <label class="file-upload-label" for="photo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                <div>
                  <span>Choisir une photo</span>
                  <small class="field-hint" style="display:block">PNG, JPG — max. 2 MB</small>
                </div>
              </label>
              <input type="file" name="photo" id="photo" accept="image/*">
            </div>
          </div>

        </div>
      </div>

      <!-- Assurance -->
      <div class="section-card">
        <div class="section-header">
          <div class="section-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          </div>
          <h3>Assurance / Mutuelle</h3>
        </div>

        <div class="fields-grid">
          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
              Assurance / Mutuelle
            </label>
            <select name="assurance" id="assurance" class="form-control">
              <option value="">Sélectionner une assurance</option>
              <option value="ALLIANZ MAROC">ALLIANZ MAROC</option>
              <option value="ATLANTA SANAD">ATLANTA SANAD</option>
              <option value="AXA ASSURANCE MAROC">AXA ASSURANCE MAROC</option>
              <option value="CAT ASSURANCE ET RÉASSURANCE">CAT ASSURANCE ET RÉASSURANCE</option>
              <option value="CNOPS">CNOPS (Caisse Nationale des Organismes de Prévoyance)</option>
              <option value="CNSS">CNSS (Caisse Nationale de Sécurité Sociale)</option>
              <option value="MUTUELLE AGRICOLE MAROCAINE D'ASSURANCE (MAMDA)">MAMDA</option>
              <option value="MUTUELLE CENTRALE MAROCAINE D'ASSURANCE (MCMA)">MCMA</option>
              <option value="MUTUELLE D'ASSURANCES DES TRANSPORTEURS UNIS (MATU)">MATU</option>
              <option value="ROYALE MAROCAINE D'ASSURANCE (RMA)">RMA</option>
              <option value="SANLAM MAROC">SANLAM MAROC</option>
              <option value="WAFA ASSURANCE">WAFA ASSURANCE</option>
              <option value="Autre">Autre ...</option>
            </select>
          </div>

          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20M6 15h2M12 15h2"/></svg>
              Numéro d'assuré
            </label>
            <input type="text" name="num_assurance" id="num_assurance" class="form-control" placeholder="Numéro de police ou d'adhérent">
          </div>
        </div>
      </div>

      <!-- Données médicales -->
      <div class="section-card">
        <div class="section-header">
          <div class="section-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
          </div>
          <h3>Données médicales</h3>
        </div>

        <div class="fields-grid">

          <!-- Développement psychomoteur -->
          <div class="form-group full-width">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3M6.343 6.343l-.707-.707M12 21v-1M18 12a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
              Développement psychomoteur
            </label>
            <textarea name="developpement_psychomoteur" id="developpement_psychomoteur" class="form-control" placeholder="Notes sur le développement psychomoteur..."></textarea>
          </div>

          <!-- Antécédents familiaux -->
          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
              Antécédents familiaux
            </label>
            <input type="text" name="antecedents_familiaux" class="form-control" placeholder="Maladies héréditaires, ...">
          </div>

          <!-- Antécédents personnels -->
          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
              Antécédents personnels
            </label>
            <input type="text" name="antecedents_personnels" class="form-control" placeholder="Chirurgies, accidents, ...">
          </div>

          <!-- Allergies -->
          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
              Allergies connues
            </label>
            <input type="text" name="allergies" class="form-control" placeholder="Pénicilline, arachides, ...">
          </div>

          <!-- Maladies chroniques -->
          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
              Maladies chroniques
            </label>
            <input type="text" name="maladies_chroniques" class="form-control" placeholder="Diabète, hypertension, ...">
          </div>

          <!-- Médicaments -->
          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18.5 2.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L18.5 2.5z"/><path d="M15 6l3 3"/></svg>
              Médicaments en cours
            </label>
            <input type="text" name="medicaments_cours" class="form-control" placeholder="Metformine, Doliprane, ...">
          </div>

          <!-- Hospitalisations -->
          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M12 8v8M8 12h8"/></svg>
              Hospitalisations
            </label>
            <input type="text" name="hospitalisations" class="form-control" placeholder="Dates et motifs, ...">
          </div>

        </div>
      </div>

    </div><!-- /bloc-majeur -->


    <!-- ══════════ BLOC MINEUR ══════════ -->
    <div id="bloc-mineur" style="display:none;">

      <!-- Infos enfant -->
      <div class="section-card">
        <div class="section-header">
          <div class="section-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 2a5 5 0 100 10A5 5 0 0012 2zM4 20a8 8 0 1116 0"/></svg>
          </div>
          <h4>Informations Générales — Mineur</h4>
        </div>

        <div class="fields-grid">
          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"/><path d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
              Nom <span class="required-star">*</span>
            </label>
            <input type="text" name="first_name_mineur" id="first_name_mineur" class="form-control">
          </div>

          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"/><path d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
              Prénom <span class="required-star">*</span>
            </label>
            <input type="text" name="last_name_mineur" id="last_name_mineur" class="form-control">
          </div>

          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="4"/><path d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>
              Sexe <span class="required-star">*</span>
            </label>
            <select name="gender_mineur" id="gender_mineur" class="form-control">
              <option value="">Sélectionner</option>
              <option value="Masculin">Masculin</option>
              <option value="Féminin">Féminin</option>
            </select>
          </div>

          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
              Date de naissance <span class="required-star">*</span>
            </label>
            <input type="date" name="birth_date_mineur" id="birth_date_mineur" class="form-control">
          </div>
        </div>
      </div>

      <!-- Responsables légaux -->
      <div class="section-card">
        <div class="section-header">
          <div class="section-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
          </div>
          <h4>Responsables légaux</h4>
        </div>

        <div class="fields-grid">
          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              Type de responsable
            </label>
            <select name="type_responsable" id="type_responsable" class="form-control">
              <option value="">Sélectionner</option>
              <option value="Parent">Parent</option>
              <option value="Tuteur">Tuteur</option>
            </select>
          </div>

          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20M6 15h4M14 15h4"/></svg>
              CIN / Passeport <span class="required-star">*</span>
            </label>
            <input type="text" name="cin_responsable" id="cin_responsable" class="form-control">
          </div>

          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"/><path d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
              Nom <span class="required-star">*</span>
            </label>
            <input type="text" name="nom_responsable" id="nom_responsable" class="form-control">
          </div>

          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"/><path d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
              Prénom <span class="required-star">*</span>
            </label>
            <input type="text" name="prenom_responsable" id="prenom_responsable" class="form-control">
          </div>

          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 01.07 1.18 2 2 0 012.05 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
              Téléphone <span class="required-star">*</span>
            </label>
            <input type="text" name="phone_responsable" id="phone_responsable" class="form-control" placeholder="06XXXXXXXX">
          </div>

          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
              Email
            </label>
            <input type="email" name="email_responsable" class="form-control">
          </div>

          <div class="form-group full-width">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
              Profession
            </label>
            <input type="text" name="profession_responsable" class="form-control" placeholder="Médecin, Enseignant, ...">
          </div>
        </div>
      </div>

      <!-- Groupe sanguin mineur -->
      <div class="section-card">
        <div class="section-header">
          <div class="section-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 6v4m0 4h.01"/></svg>
          </div>
          <h4>Données médicales de base</h4>
        </div>
        <div class="fields-grid">
          <div class="form-group">
            <label>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 00-6.88 17.22C6.5 17.83 9.1 17 12 17s5.5.83 6.88 2.22A10 10 0 0012 2z"/><path d="M12 11a3 3 0 100-6 3 3 0 000 6z"/></svg>
              Groupe sanguin
            </label>
            <select name="groupe_sanguin_mineur" id="groupe_sanguin_mineur" class="form-control">
              <option value="">Sélectionner</option>
              <option value="A+">A+</option>
              <option value="A-">A-</option>
              <option value="B+">B+</option>
              <option value="B-">B-</option>
              <option value="AB+">AB+</option>
              <option value="AB-">AB-</option>
              <option value="O+">O+</option>
              <option value="O-">O-</option>
            </select>
          </div>
        </div>
      </div>

    </div><!-- /bloc-mineur -->

    <!-- Actions -->
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v14a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
        Enregistrer
      </button>
      <button type="reset" class="btn btn-secondary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg>
        Annuler
      </button>
    </div>

  </form>
</div>


<script>
  const checkbox  = document.getElementById('is_majeur');
  const blocMajeur = document.getElementById('bloc-majeur');
  const blocMineur = document.getElementById('bloc-mineur');

  // Select fields that are required in Majeur mode
  const majeurRequired = [
    document.getElementById('first_name'),
    document.getElementById('last_name'),
    document.getElementById('gender'),
    document.getElementById('birth_date'),
    document.getElementById('phone')
  ];

  // Select fields that should be required in Mineur mode
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

  // file upload feedback
  document.getElementById('photo').addEventListener('change', function () {
    const label = this.previousElementSibling;
    const span  = label.querySelector('span');
    if (this.files && this.files[0]) {
      span.textContent = this.files[0].name;
    }
  });

  // Initial state call
  toggleRequired();
</script>
@endsection

</body>
</html>
