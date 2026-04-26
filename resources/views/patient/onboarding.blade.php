@extends('patient.layout')

@section('title', 'Bienvenue - Complétez votre profil')

@section('content')

    <link rel="stylesheet" href="{{ asset('assets/admin/css/style_ajouterPatient.css') }}">

    <style>
        /* ── Layout override ── */
        .pt-sidebar { display: none !important; }
        .pt-main {
            margin-left: 0 !important;
            width: 100% !important;
            padding: clamp(20px, 5vw, 48px) clamp(16px, 4vw, 40px) !important;
        }

        /* ── Page wrapper ── */
        .ob-wrapper { max-width: 860px; margin: 0 auto; }

        /* ── Header ── */
        .ob-header { text-align: center; margin-bottom: clamp(28px, 5vw, 48px); }
        .ob-header h1 {
            font-size: clamp(1.5rem, 4vw, 2.1rem);
            font-weight: 700;
            color: var(--pt-text-dark);
            margin: 0 0 10px;
            line-height: 1.2;
        }
        .ob-header p {
            color: var(--pt-text-secondary);
            font-size: clamp(0.9rem, 2vw, 1rem);
            max-width: 560px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* ── Progress steps ── */
        .ob-steps {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            margin-bottom: clamp(24px, 4vw, 40px);
        }
        .ob-step { display: flex; flex-direction: column; align-items: center; gap: 6px; position: relative; }
        .ob-step-circle {
            width: 36px; height: 36px;
            border-radius: 50%;
            border: 2px solid var(--pt-accent);
            background: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700;
            color: var(--pt-accent);
            transition: background .2s, color .2s;
            position: relative; z-index: 1;
        }
        .ob-step.active .ob-step-circle,
        .ob-step.done  .ob-step-circle { background: var(--pt-accent); color: #fff; }
        .ob-step-label { font-size: 11px; color: var(--pt-text-muted); white-space: nowrap; font-weight: 500; }
        .ob-step.active .ob-step-label { color: var(--pt-accent); font-weight: 600; }
        .ob-step-line {
            flex: 1; height: 2px;
            background: var(--pt-sidebar-border);
            min-width: 40px; max-width: 80px;
            margin-bottom: 22px;
        }
        @media (max-width: 420px) {
            .ob-step-label { display: none; }
            .ob-step-line { min-width: 20px; }
        }

        /* ── Card ── */
        .ob-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(0,0,0,.06);
            overflow: hidden;
        }

        /* ── Toggle card ── */
        .ob-toggle-wrap { padding: clamp(16px, 3vw, 28px) clamp(16px, 3vw, 28px) 0; }
        .app-toggle-card {
            display: flex; align-items: center; gap: 16px;
            padding: 16px 18px;
            border: 2px solid var(--pt-accent);
            border-radius: 14px;
            cursor: pointer;
            background: var(--pt-accent-light, #eef4ff);
            transition: box-shadow .15s;
            -webkit-user-select: none; user-select: none;
        }
        .app-toggle-card:hover { box-shadow: 0 0 0 3px rgba(var(--pt-accent-rgb, 74,144,226),.15); }
        .toggle-indicator {
            flex-shrink: 0;
            width: 24px; height: 24px;
            border-radius: 50%;
            border: 2px solid var(--pt-accent);
            position: relative;
            transition: border-color .2s;
        }
        .inner-dot {
            position: absolute; inset: 4px;
            background: var(--pt-accent);
            border-radius: 50%;
            transition: opacity .2s;
        }

        /* ── Sections ── */
        .app-form-section {
            padding: clamp(20px, 3vw, 32px) clamp(16px, 3vw, 28px);
            border-top: 1px solid var(--pt-sidebar-border, #eef0f3);
        }
        .app-form-section:first-of-type { border-top: none; }
        .app-form-section-header { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; }
        .app-form-section-icon {
            width: 38px; height: 38px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .app-form-section-header h3 { margin: 0; font-size: 1rem; font-weight: 600; color: var(--pt-text-dark); }

        /* ── Grid ── */
        .app-form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        @media (max-width: 560px) { .app-form-grid { grid-template-columns: 1fr; } }

        /* ── Form controls ── */
        .app-form-group { display: flex; flex-direction: column; gap: 6px; }
        .app-form-label {
            font-size: 12.5px; font-weight: 600;
            color: var(--pt-text-secondary, #5a6172);
            letter-spacing: .02em; text-transform: uppercase;
        }
        .app-form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--pt-sidebar-border, #e2e6ec);
            border-radius: 10px;
            font-size: 14px;
            color: var(--pt-text-dark);
            background: var(--pt-bg-surface, #fafbfc);
            transition: border-color .15s, box-shadow .15s;
            box-sizing: border-box;
            appearance: auto;
        }
        .app-form-control:focus {
            outline: none;
            border-color: var(--pt-accent);
            box-shadow: 0 0 0 3px rgba(var(--pt-accent-rgb, 74,144,226),.12);
            background: #fff;
        }

        /* ── Input en erreur ── */
        .app-form-control.is-invalid {
            border-color: #e53e3e !important;
            box-shadow: 0 0 0 3px rgba(229,62,62,.12) !important;
            background: #fff8f8;
        }

        /* ── Message d'erreur sous l'input ── */
        .field-error {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: #e53e3e;
            font-weight: 500;
            margin-top: 2px;
            animation: fadeInDown .2s ease;
        }
        .field-error svg { flex-shrink: 0; }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-4px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        textarea.app-form-control { resize: vertical; min-height: 72px; }
        .ob-full { grid-column: 1 / -1; }

        /* ── Submit ── */
        .ob-submit {
            padding: clamp(20px, 3vw, 28px) clamp(16px, 3vw, 28px);
            border-top: 1px solid var(--pt-sidebar-border, #eef0f3);
            display: flex; justify-content: center;
        }
        .pt-btn-primary {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 14px 36px;
            font-size: 15px; font-weight: 600;
            border-radius: 12px; border: none;
            background: var(--pt-accent); color: #fff;
            cursor: pointer;
            width: 100%; max-width: 380px;
            transition: opacity .15s, transform .1s;
        }
        .pt-btn-primary:hover  { opacity: .88; }
        .pt-btn-primary:active { transform: scale(.98); }
    </style>

    <div class="ob-wrapper">

        {{-- ── Header ── --}}
        <div class="ob-header">
            <h1>Bienvenue, {{ $patient->first_name ?? Auth::user()->name }}</h1>
            <p>Afin de pouvoir prendre rendez-vous et consulter votre dossier médical, merci de compléter les informations
                ci-dessous. Ces données resteront strictement confidentielles.</p>
        </div>

        {{-- ── Progress indicator ── --}}
        <div class="ob-steps" aria-hidden="true">
            <div class="ob-step active">
                <div class="ob-step-circle">1</div>
                <span class="ob-step-label">Profil</span>
            </div>
            <div class="ob-step-line"></div>
            <div class="ob-step">
                <div class="ob-step-circle">2</div>
                <span class="ob-step-label">Médical</span>
            </div>
            <div class="ob-step-line"></div>
            <div class="ob-step">
                <div class="ob-step-circle">3</div>
                <span class="ob-step-label">Confirmation</span>
            </div>
        </div>

        {{-- ── Main card ── --}}
        <div class="ob-card">
            <form id="patientForm" action="{{ route('patient.onboarding.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- ── Toggle majeur / mineur ── --}}
                <div class="ob-toggle-wrap">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="app-form-label" style="display:block;margin-bottom:8px;">Type de profil patient</label>

                        {{--
                            CORRECTION TOGGLE :
                            On utilise un <button type="button"> avec data-checked pour éviter
                            tout conflit avec le label HTML natif qui déclenchait 2 events.
                        --}}
                        <input type="hidden" name="is_majeur" id="is_majeur_hidden" value="{{ old('is_majeur', '1') }}">

                        <button type="button" id="toggleBtn" class="app-toggle-card" aria-pressed="true">
                            <div style="flex:1;">
                                <strong id="toggleTitle" style="display:block;color:var(--pt-text-dark);font-size:14px;">Patient majeur</strong>
                                <small id="toggleSub" style="color:var(--pt-text-muted);font-size:12px;">Je complète mon propre profil (18 ans ou plus)</small>
                            </div>
                            <div class="toggle-indicator">
                                <div class="inner-dot" id="innerDot"></div>
                            </div>
                        </button>
                    </div>
                </div>

                {{-- ══ BLOC MAJEUR ══ --}}
                <div id="bloc-majeur">

                    {{-- Informations personnelles --}}
                    <div class="app-form-section">
                        <div class="app-form-section-header">
                            <div class="app-form-section-icon" style="background:var(--pt-accent-light);color:var(--pt-accent);">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <h3>Informations personnelles</h3>
                        </div>

                        <div class="app-form-grid">

                            <div class="app-form-group">
                                <label class="app-form-label" for="first_name">Nom <span style="color:red;">*</span></label>
                                <input type="text" name="first_name" id="first_name"
                                    class="app-form-control @error('first_name') is-invalid @enderror"
                                    value="{{ old('first_name', $patient->first_name ?? '') }}" required>
                                @error('first_name')
                                    <span class="field-error">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="app-form-group">
                                <label class="app-form-label" for="last_name">Prénom <span style="color:red;">*</span></label>
                                <input type="text" name="last_name" id="last_name"
                                    class="app-form-control @error('last_name') is-invalid @enderror"
                                    value="{{ old('last_name', $patient->last_name ?? '') }}" required>
                                @error('last_name')
                                    <span class="field-error">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="app-form-group">
                                <label class="app-form-label" for="gender">Sexe <span style="color:red;">*</span></label>
                                <select name="gender" id="gender"
                                    class="app-form-control @error('gender') is-invalid @enderror" required>
                                    <option value="">Sélectionner</option>
                                    <option value="male"   {{ old('gender', $patient->gender ?? '') == 'male'   ? 'selected' : '' }}>Masculin</option>
                                    <option value="female" {{ old('gender', $patient->gender ?? '') == 'female' ? 'selected' : '' }}>Féminin</option>
                                </select>
                                @error('gender')
                                    <span class="field-error">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="app-form-group">
                                <label class="app-form-label" for="birth_date">Date de naissance <span style="color:red;">*</span></label>
                                <input type="date" name="birth_date" id="birth_date"
                                    class="app-form-control @error('birth_date') is-invalid @enderror"
                                    value="{{ old('birth_date', $patient->birth_date ?? '') }}" required>
                                @error('birth_date')
                                    <span class="field-error">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="app-form-group">
                                <label class="app-form-label" for="cin">CIN / Passeport <span style="color:red;">*</span></label>
                                <input type="text" name="cin" id="cin"
                                    class="app-form-control @error('cin') is-invalid @enderror"
                                    value="{{ old('cin', $patient->cin ?? '') }}" placeholder="Ex: AB123456" required>
                                @error('cin')
                                    <span class="field-error">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="app-form-group">
                                <label class="app-form-label" for="phone">Téléphone <span style="color:red;">*</span></label>
                                <input type="text" name="phone" id="phone"
                                    class="app-form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $patient->phone ?? '') }}" placeholder="06XXXXXXXX" required>
                                @error('phone')
                                    <span class="field-error">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                        </div>
                    </div>

                    {{-- Dossier médical --}}
                    <div class="app-form-section">
                        <div class="app-form-section-header">
                            <div class="app-form-section-icon" style="background:var(--pt-accent-light);color:var(--pt-accent);">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                </svg>
                            </div>
                            <h3>Dossier médical <span style="font-weight:400;color:var(--pt-text-muted);font-size:.9rem;">(optionnel)</span></h3>
                        </div>

                        <div class="app-form-grid">
                            <div class="app-form-group">
                                <label class="app-form-label" for="assurance">Assurance</label>
                                <select name="assurance" id="assurance" class="app-form-control">
                                    <option value="Aucune">Pas d'assurance</option>
                                    <option value="CNSS">CNSS</option>
                                    <option value="CNOPS">CNOPS</option>
                                    <option value="AMO">AMO</option>
                                    <option value="Mutuelle Privée">Mutuelle Privée</option>
                                </select>
                            </div>
                            <div class="app-form-group">
                                <label class="app-form-label" for="num_assurance">Numéro d'assurance</label>
                                <input type="text" name="num_assurance" id="num_assurance" class="app-form-control" placeholder="Numéro ID">
                            </div>
                            <div class="app-form-group ob-full">
                                <label class="app-form-label">Allergies connues</label>
                                <textarea name="allergies" class="app-form-control" rows="2" placeholder="Pénicilline, arachides, ..."></textarea>
                            </div>
                            <div class="app-form-group ob-full">
                                <label class="app-form-label">Maladies chroniques</label>
                                <textarea name="maladies_chroniques" class="app-form-control" rows="2" placeholder="Diabète, Hypertension, ..."></textarea>
                            </div>
                        </div>
                    </div>

                </div>{{-- /#bloc-majeur --}}

                {{-- ══ BLOC MINEUR ══ --}}
                <div id="bloc-mineur" style="display:none;">
                    <div class="app-form-section">
                        <div class="app-form-section-header">
                            <div class="app-form-section-icon" style="background:var(--pt-accent-light);color:var(--pt-accent);">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                                </svg>
                            </div>
                            <h3>Mineur &amp; Tuteur</h3>
                        </div>

                        <div class="app-form-grid">

                            <div class="app-form-group">
                                <label class="app-form-label" for="first_name_mineur">Nom enfant <span style="color:red;">*</span></label>
                                <input type="text" name="first_name_mineur" id="first_name_mineur"
                                    class="app-form-control @error('first_name_mineur') is-invalid @enderror">
                                @error('first_name_mineur')
                                    <span class="field-error">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="app-form-group">
                                <label class="app-form-label" for="last_name_mineur">Prénom enfant <span style="color:red;">*</span></label>
                                <input type="text" name="last_name_mineur" id="last_name_mineur"
                                    class="app-form-control @error('last_name_mineur') is-invalid @enderror">
                                @error('last_name_mineur')
                                    <span class="field-error">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="app-form-group">
                                <label class="app-form-label" for="birth_date_mineur">Date de naissance (enfant) <span style="color:red;">*</span></label>
                                <input type="date" name="birth_date_mineur" id="birth_date_mineur"
                                    class="app-form-control @error('birth_date_mineur') is-invalid @enderror">
                                @error('birth_date_mineur')
                                    <span class="field-error">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="app-form-group">
                                <label class="app-form-label" for="type_responsable">Lien de parenté <span style="color:red;">*</span></label>
                                <select name="type_responsable" id="type_responsable"
                                    class="app-form-control @error('type_responsable') is-invalid @enderror">
                                    <option value="Père">Père</option>
                                    <option value="Mère">Mère</option>
                                    <option value="Tuteur Légal">Tuteur Légal</option>
                                </select>
                                @error('type_responsable')
                                    <span class="field-error">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            {{-- Séparateur tuteur --}}
                            <div class="ob-full" style="margin:4px 0 -4px;padding-top:12px;border-top:1px solid var(--pt-sidebar-border);">
                                <p style="font-size:12px;font-weight:600;color:var(--pt-text-muted);text-transform:uppercase;letter-spacing:.04em;margin:0;">
                                    Informations du responsable</p>
                            </div>

                            <div class="app-form-group">
                                <label class="app-form-label" for="nom_responsable">Nom responsable <span style="color:red;">*</span></label>
                                <input type="text" name="nom_responsable" id="nom_responsable"
                                    class="app-form-control @error('nom_responsable') is-invalid @enderror"
                                    value="{{ old('nom_responsable', $patient->first_name ?? '') }}">
                                @error('nom_responsable')
                                    <span class="field-error">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="app-form-group">
                                <label class="app-form-label" for="prenom_responsable">Prénom responsable <span style="color:red;">*</span></label>
                                <input type="text" name="prenom_responsable" id="prenom_responsable"
                                    class="app-form-control @error('prenom_responsable') is-invalid @enderror"
                                    value="{{ old('prenom_responsable', $patient->last_name ?? '') }}">
                                @error('prenom_responsable')
                                    <span class="field-error">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="app-form-group">
                                <label class="app-form-label" for="cin_responsable">CIN responsable <span style="color:red;">*</span></label>
                                <input type="text" name="cin_responsable" id="cin_responsable"
                                    class="app-form-control @error('cin_responsable') is-invalid @enderror"
                                    placeholder="Ex: AB123456">
                                @error('cin_responsable')
                                    <span class="field-error">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="app-form-group">
                                <label class="app-form-label" for="phone_responsable">Téléphone responsable <span style="color:red;">*</span></label>
                                <input type="text" name="phone_responsable" id="phone_responsable"
                                    class="app-form-control @error('phone_responsable') is-invalid @enderror"
                                    value="{{ old('phone_responsable', $patient->phone ?? '') }}">
                                @error('phone_responsable')
                                    <span class="field-error">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>{{-- /#bloc-mineur --}}

                {{-- Submit --}}
                <div class="ob-submit">
                    <button type="submit" class="pt-btn pt-btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v14a2 2 0 01-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Enregistrer mon profil
                    </button>
                </div>

            </form>
        </div>{{-- /.ob-card --}}

    </div>{{-- /.ob-wrapper --}}

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        /* ─── Éléments ─── */
        const btn        = document.getElementById('toggleBtn');
        const hiddenIn   = document.getElementById('is_majeur_hidden');
        const blocMajeur = document.getElementById('bloc-majeur');
        const blocMineur = document.getElementById('bloc-mineur');
        const innerDot   = document.getElementById('innerDot');
        const toggleTitle = document.getElementById('toggleTitle');
        const toggleSub   = document.getElementById('toggleSub');

        const majeurRequired = ['first_name','last_name','gender','birth_date','phone','cin'];
        const mineurRequired = ['first_name_mineur','last_name_mineur','birth_date_mineur',
                                'nom_responsable','prenom_responsable','cin_responsable','phone_responsable'];

        /* ─── État initial ─── */
        // Restaure l'état après erreur de validation côté serveur
        let isMajeur = '{{ old('is_majeur', '1') }}' !== '0';

        /* ─── Appliquer l'état ─── */
        function applyState() {
            hiddenIn.value = isMajeur ? '1' : '0';
            btn.setAttribute('aria-pressed', isMajeur ? 'true' : 'false');
            innerDot.style.opacity = isMajeur ? '1' : '0';

            if (isMajeur) {
                blocMajeur.style.display = 'block';
                blocMineur.style.display = 'none';
                toggleTitle.textContent = 'Patient majeur';
                toggleSub.textContent   = 'Je complète mon propre profil (18 ans ou plus)';
                majeurRequired.forEach(id => { const el = document.getElementById(id); if (el) el.setAttribute('required',''); });
                mineurRequired.forEach(id => { const el = document.getElementById(id); if (el) el.removeAttribute('required'); });
            } else {
                blocMajeur.style.display = 'none';
                blocMineur.style.display = 'block';
                toggleTitle.textContent = 'Patient mineur';
                toggleSub.textContent   = 'Je complète le profil d\'un enfant (moins de 18 ans)';
                majeurRequired.forEach(id => { const el = document.getElementById(id); if (el) el.removeAttribute('required'); });
                mineurRequired.forEach(id => { const el = document.getElementById(id); if (el) el.setAttribute('required',''); });
            }
        }

        /* ─── Click sur le bouton-card (1 seul handler, aucun conflit) ─── */
        btn.addEventListener('click', function () {
            isMajeur = !isMajeur;
            applyState();
        });

        /* ─── Init ─── */
        applyState();
    });
    </script>

@endsection