@extends('layouts.sidebar')

@section('title', 'Configuration')

@push('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/style_settings.css') }}">
@endpush

@section('content')
<div class="settings-container">

    {{-- ── Header ── --}}
    <div class="settings-header">
        <div>
            <h1 class="settings-title">Configuration</h1>
            <p class="settings-subtitle">Gérez les paramètres de votre cabinet médical</p>
        </div>
    </div>

    {{-- ── Alert Messages ── --}}
    @if(session('success'))
        <div class="alert alert-success">
            <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ── Tabs Navigation ── --}}
    @php $activeTab = session('active_tab', 'clinic'); @endphp

    <div class="settings-tabs" id="settingsTabs">
        <button type="button" class="tab-btn {{ $activeTab === 'clinic' ? 'active' : '' }}" data-tab="clinic">
            <svg viewBox="0 0 24 24"><path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z"/><path d="M9 21V12h6v9"/></svg>
            Clinique
        </button>
        <button type="button" class="tab-btn {{ $activeTab === 'appointments' ? 'active' : '' }}" data-tab="appointments">
            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            Rendez-vous
        </button>
        <button type="button" class="tab-btn {{ $activeTab === 'notifications' ? 'active' : '' }}" data-tab="notifications">
            <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
            Notifications
        </button>
        <button type="button" class="tab-btn {{ $activeTab === 'security' ? 'active' : '' }}" data-tab="security">
            <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
            Sécurité
        </button>
        <button type="button" class="tab-btn {{ $activeTab === 'theme' ? 'active' : '' }}" data-tab="theme">
            <svg viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
            Thème
        </button>
    </div>

    {{-- ══════════════════════════════════════════════════ --}}
    {{-- TAB 1 — Clinique --}}
    {{-- ══════════════════════════════════════════════════ --}}
    <div class="tab-panel {{ $activeTab === 'clinic' ? 'active' : '' }}" id="tab-clinic">
        <form method="POST" action="{{ route('settings.update') }}">
            @csrf
            <input type="hidden" name="tab" value="clinic">

            <div class="settings-card">
                <div class="settings-card-header">
                    <div class="settings-card-icon">
                        <svg viewBox="0 0 24 24"><path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z"/><path d="M9 21V12h6v9"/></svg>
                    </div>
                    <div>
                        <div class="settings-card-title">Informations de Cabinet Medical</div>
                        <div class="settings-card-desc">Ces informations apparaissent sur les ordonnances et documents officiels</div>
                    </div>
                </div>
                <div class="settings-card-body">
                    <div class="form-grid">
                        <div class="form-group full">
                            <label class="form-label" for="clinic_name">Nom de la Clinique <span class="required">*</span></label>
                            <input type="text" id="clinic_name" name="clinic_name"
                                class="form-input {{ $errors->has('clinic_name') ? 'is-invalid' : '' }}"
                                value="{{ old('clinic_name', $settings['clinic_name']) }}"
                                placeholder="Ex : Cabinet Médical Al-Nour"
                                required>
                            @error('clinic_name')<p class="input-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="clinic_phone">Téléphone</label>
                            <input type="text" id="clinic_phone" name="clinic_phone"
                                class="form-input {{ $errors->has('clinic_phone') ? 'is-invalid' : '' }}"
                                value="{{ old('clinic_phone', $settings['clinic_phone']) }}"
                                placeholder="+212 5 22 00 00 00">
                            @error('clinic_phone')<p class="input-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="clinic_email">Email</label>
                            <input type="email" id="clinic_email" name="clinic_email"
                                class="form-input {{ $errors->has('clinic_email') ? 'is-invalid' : '' }}"
                                value="{{ old('clinic_email', $settings['clinic_email']) }}"
                                placeholder="contact@clinique.ma">
                            @error('clinic_email')<p class="input-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group full">
                            <label class="form-label" for="clinic_address">Adresse</label>
                            <input type="text" id="clinic_address" name="clinic_address"
                                class="form-input {{ $errors->has('clinic_address') ? 'is-invalid' : '' }}"
                                value="{{ old('clinic_address', $settings['clinic_address']) }}"
                                placeholder="Ex : 12 Rue Ibn Sina, Casablanca">
                            @error('clinic_address')<p class="input-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group full">
                            <label class="form-label" for="clinic_description">Description / Spécialité</label>
                            <textarea id="clinic_description" name="clinic_description"
                                class="form-textarea {{ $errors->has('clinic_description') ? 'is-invalid' : '' }}"
                                placeholder="Ex : Cabinet de médecine générale et pédiatrie">{{ old('clinic_description', $settings['clinic_description']) }}</textarea>
                            @error('clinic_description')<p class="input-error">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn-save">
                            <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Enregistrer
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- ══════════════════════════════════════════════════ --}}
    {{-- TAB 2 — Rendez-vous --}}
    {{-- ══════════════════════════════════════════════════ --}}
    <div class="tab-panel {{ $activeTab === 'appointments' ? 'active' : '' }}" id="tab-appointments">
        <form method="POST" action="{{ route('settings.update') }}">
            @csrf
            <input type="hidden" name="tab" value="appointments">

            <div class="settings-card">
                <div class="settings-card-header">
                    <div class="settings-card-icon">
                        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    </div>
                    <div>
                        <div class="settings-card-title">Paramètres des Rendez-vous</div>
                        <div class="settings-card-desc">Durée par défaut, horaires d'ouverture et jours de travail</div>
                    </div>
                </div>
                <div class="settings-card-body">
                    <div class="form-grid">

                        <div class="form-group">
                            <label class="form-label" for="default_appointment_duration">Durée par défaut (minutes) <span class="required">*</span></label>
                            <select id="default_appointment_duration" name="default_appointment_duration" class="form-select">
                                @foreach([10,15,20,30,45,60,90,120] as $dur)
                                    <option value="{{ $dur }}" {{ (old('default_appointment_duration', $settings['default_appointment_duration']) == $dur) ? 'selected' : '' }}>
                                        {{ $dur }} min
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            {{-- spacer --}}
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="opening_time">Heure d'ouverture <span class="required">*</span></label>
                            <input type="time" id="opening_time" name="opening_time"
                                class="form-input"
                                value="{{ old('opening_time', $settings['opening_time'] ?: '08:00') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="closing_time">Heure de fermeture <span class="required">*</span></label>
                            <input type="time" id="closing_time" name="closing_time"
                                class="form-input"
                                value="{{ old('closing_time', $settings['closing_time'] ?: '18:00') }}">
                        </div>

                        <div class="form-group full">
                            <label class="form-label">Jours de travail</label>
                            @php
                                $days = [
                                    'monday'    => 'Lundi',
                                    'tuesday'   => 'Mardi',
                                    'wednesday' => 'Mercredi',
                                    'thursday'  => 'Jeudi',
                                    'friday'    => 'Vendredi',
                                    'saturday'  => 'Samedi',
                                    'sunday'    => 'Dimanche',
                                ];
                            @endphp
                            <div class="days-grid">
                                @foreach($days as $value => $label)
                                    <div class="day-chip">
                                        <input
                                            type="checkbox"
                                            id="day_{{ $value }}"
                                            name="working_days[]"
                                            value="{{ $value }}"
                                            {{ in_array($value, $workingDays) ? 'checked' : '' }}>
                                        <label for="day_{{ $value }}">{{ $label }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn-save">
                            <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Enregistrer
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- ══════════════════════════════════════════════════ --}}
    {{-- TAB 3 — Notifications --}}
    {{-- ══════════════════════════════════════════════════ --}}
    <div class="tab-panel {{ $activeTab === 'notifications' ? 'active' : '' }}" id="tab-notifications">
        <form method="POST" action="{{ route('settings.update') }}">
            @csrf
            <input type="hidden" name="tab" value="notifications">

            <div class="settings-card">
                <div class="settings-card-header">
                    <div class="settings-card-icon">
                        <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
                    </div>
                    <div>
                        <div class="settings-card-title">Préférences de Notifications</div>
                        <div class="settings-card-desc">Configurez les rappels et alertes du système</div>
                    </div>
                </div>
                <div class="settings-card-body">

                    <div class="toggle-row">
                        <div class="toggle-info">
                            <h4>Activer les Rappels</h4>
                            <p>Envoyer des rappels automatiques avant les rendez-vous</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" id="notifications_enabled" name="notifications_enabled"
                                {{ ($settings['notifications_enabled'] ?? '1') === '1' ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div class="form-group" style="margin-top:1.25rem;">
                        <label class="form-label" for="reminder_hours_before">Rappel envoyé … heures avant le RDV</label>
                        <select id="reminder_hours_before" name="reminder_hours_before" class="form-select" style="max-width:220px;">
                            @foreach([1, 2, 6, 12, 24, 48] as $h)
                                <option value="{{ $h }}"
                                    {{ (old('reminder_hours_before', $settings['reminder_hours_before'] ?? 24) == $h) ? 'selected' : '' }}>
                                    {{ $h === 1 ? '1 heure' : "$h heures" }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn-save">
                            <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Enregistrer
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- ══════════════════════════════════════════════════ --}}
    {{-- TAB 4 — Sécurité --}}
    {{-- ══════════════════════════════════════════════════ --}}
    <div class="tab-panel {{ $activeTab === 'security' ? 'active' : '' }}" id="tab-security">
        <form method="POST" action="{{ route('settings.update') }}">
            @csrf
            <input type="hidden" name="tab" value="security">

            <div class="settings-card">
                <div class="settings-card-header">
                    <div class="settings-card-icon">
                        <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    </div>
                    <div>
                        <div class="settings-card-title">Sécurité du Compte</div>
                        <div class="settings-card-desc">Modifiez votre mot de passe de connexion</div>
                    </div>
                </div>
                <div class="settings-card-body">
                    <div class="form-grid">

                        <div class="form-group full">
                            <label class="form-label" for="current_password">Mot de passe actuel <span class="required">*</span></label>
                            <input type="password" id="current_password" name="current_password"
                                class="form-input {{ $errors->has('current_password') ? 'is-invalid' : '' }}"
                                placeholder="••••••••"
                                autocomplete="current-password">
                            @error('current_password')<p class="input-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="new_password">Nouveau mot de passe <span class="required">*</span></label>
                            <input type="password" id="new_password" name="new_password"
                                class="form-input {{ $errors->has('new_password') ? 'is-invalid' : '' }}"
                                placeholder="••••••••"
                                autocomplete="new-password">
                            <p class="input-hint">Minimum 8 caractères</p>
                            @error('new_password')<p class="input-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="new_password_confirmation">Confirmer le mot de passe <span class="required">*</span></label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                class="form-input"
                                placeholder="••••••••"
                                autocomplete="new-password">
                        </div>

                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn-save">
                            <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                            Changer le mot de passe
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    {{-- ══════════════════════════════════════════════════ --}}
    {{-- TAB 5 — Thème --}}
    {{-- ══════════════════════════════════════════════════ --}}
    <div class="tab-panel {{ $activeTab === 'theme' ? 'active' : '' }}" id="tab-theme">
        <div class="settings-card">
            <div class="settings-card-header">
                <div class="settings-card-icon">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                </div>
                <div>
                    <div class="settings-card-title">Apparence &amp; Thème</div>
                    <div class="settings-card-desc">Choisissez l'apparence de l'interface qui vous convient le mieux</div>
                </div>
            </div>
            <div class="settings-card-body">

                {{-- Theme Toggle --}}
                <div class="toggle-row">
                    <div class="toggle-info">
                        <h4>Mode Sombre</h4>
                        <p>Basculer entre le mode clair et le mode sombre</p>
                    </div>
                    <label class="toggle-switch" id="darkModeToggleLabel">
                        <input type="checkbox" id="darkModeToggle">
                        <span class="slider"></span>
                    </label>
                </div>

                {{-- Visual Theme Cards --}}
                <div style="margin-top: 1.5rem;">
                    <p class="form-label" style="margin-bottom: 1rem;">Aperçu du thème</p>
                    <div class="theme-cards-grid">

                        {{-- Light Card --}}
                        <div class="theme-card" id="themeCardLight">
                            <div class="theme-card-preview theme-preview-light">
                                <div class="tp-sidebar"></div>
                                <div class="tp-content">
                                    <div class="tp-bar"></div>
                                    <div class="tp-bar tp-bar-short"></div>
                                    <div class="tp-rect"></div>
                                </div>
                            </div>
                            <div class="theme-card-info">
                                <svg viewBox="0 0 24 24" width="16" height="16"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                                <span>Mode Clair</span>
                                <span class="theme-check" id="checkLight">
                                    <svg viewBox="0 0 24 24" width="14" height="14"><polyline points="20 6 9 17 4 12" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                                </span>
                            </div>
                        </div>

                        {{-- Dark Card --}}
                        <div class="theme-card" id="themeCardDark">
                            <div class="theme-card-preview theme-preview-dark">
                                <div class="tp-sidebar"></div>
                                <div class="tp-content">
                                    <div class="tp-bar"></div>
                                    <div class="tp-bar tp-bar-short"></div>
                                    <div class="tp-rect"></div>
                                </div>
                            </div>
                            <div class="theme-card-info">
                                <svg viewBox="0 0 24 24" width="16" height="16"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                                <span>Mode Sombre</span>
                                <span class="theme-check" id="checkDark">
                                    <svg viewBox="0 0 24 24" width="14" height="14"><polyline points="20 6 9 17 4 12" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
<style>
/* ─── Theme Picker Cards ─────────────────────────────────────── */
.theme-cards-grid {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}
.theme-card {
    border: 2px solid var(--border-color);
    border-radius: 14px;
    overflow: hidden;
    cursor: pointer;
    transition: all .22s cubic-bezier(.4,0,.2,1);
    flex: 1;
    min-width: 150px;
    max-width: 220px;
}
.theme-card:hover {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-light);
    transform: translateY(-2px);
}
.theme-card.selected {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-light);
}
.theme-card-preview {
    display: flex;
    height: 90px;
    border-radius: 10px 10px 0 0;
    overflow: hidden;
}
/* Light preview */
.theme-preview-light { background: #e8ede9; }
.theme-preview-light .tp-sidebar { width: 38px; background: #f4f7f5; border-right: 1px solid #dce8e1; }
.theme-preview-light .tp-content { flex:1; padding: 8px; display:flex; flex-direction:column; gap:5px; }
.theme-preview-light .tp-bar { height:6px; border-radius:4px; background:#c4ddd0; }
.theme-preview-light .tp-bar-short { width:60%; }
.theme-preview-light .tp-rect { flex:1; border-radius:6px; background:#ffffff; border:1px solid #dce8e1; margin-top:2px; }
/* Dark preview */
.theme-preview-dark { background: #0f1a14; }
.theme-preview-dark .tp-sidebar { width: 38px; background: #151e1a; border-right: 1px solid #2a3d32; }
.theme-preview-dark .tp-content { flex:1; padding: 8px; display:flex; flex-direction:column; gap:5px; }
.theme-preview-dark .tp-bar { height:6px; border-radius:4px; background:#233629; }
.theme-preview-dark .tp-bar-short { width:60%; }
.theme-preview-dark .tp-rect { flex:1; border-radius:6px; background:#1a2620; border:1px solid #2a3d32; margin-top:2px; }
/* Card info row */
.theme-card-info {
    display: flex;
    align-items: center;
    gap: .5rem;
    padding: .65rem 1rem;
    font-size: .84rem;
    font-weight: 500;
    color: var(--text-secondary);
    background: var(--sidebar-bg);
    border-top: 1px solid var(--border-color);
}
.theme-card-info svg { stroke: var(--accent); fill: none; flex-shrink:0; }
.theme-check {
    margin-left: auto;
    display: none;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: var(--accent);
    align-items: center;
    justify-content: center;
}
.theme-check svg { stroke: #fff; }
.theme-card.selected .theme-check { display: flex; }
</style>

<script>
(function () {
    /* ── Tab switching ───────────────────────────────── */
    const tabs = document.querySelectorAll('.tab-btn');
    const panels = document.querySelectorAll('.tab-panel');

    tabs.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.tab;

            tabs.forEach(t => t.classList.remove('active'));
            panels.forEach(p => p.classList.remove('active'));

            btn.classList.add('active');
            document.getElementById('tab-' + target).classList.add('active');
        });
    });

    /* ── Dark mode logic ─────────────────────────────── */
    const STORAGE_KEY = 'theme';
    const htmlEl      = document.documentElement;
    const toggle      = document.getElementById('darkModeToggle');
    const cardLight   = document.getElementById('themeCardLight');
    const cardDark    = document.getElementById('themeCardDark');

    function applyTheme(theme) {
        if (theme === 'dark') {
            htmlEl.setAttribute('data-theme', 'dark');
            if (toggle)  toggle.checked = true;
            if (cardDark)  cardDark.classList.add('selected');
            if (cardLight) cardLight.classList.remove('selected');
        } else {
            htmlEl.removeAttribute('data-theme');
            if (toggle)  toggle.checked = false;
            if (cardLight) cardLight.classList.add('selected');
            if (cardDark)  cardDark.classList.remove('selected');
        }
        localStorage.setItem(STORAGE_KEY, theme);
    }

    /* Initialise from stored preference */
    const stored = localStorage.getItem(STORAGE_KEY) || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
    applyTheme(stored);

    /* Toggle switch */
    if (toggle) {
        toggle.addEventListener('change', () => {
            applyTheme(toggle.checked ? 'dark' : 'light');
        });
    }

    /* Click on preview cards */
    if (cardLight) cardLight.addEventListener('click', () => applyTheme('light'));
    if (cardDark)  cardDark.addEventListener('click',  () => applyTheme('dark'));
})();
</script>
@endsection
