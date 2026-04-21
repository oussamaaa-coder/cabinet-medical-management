@extends('layouts.sidebar')

@section('title', 'Modifier Utilisateur')

@section('content')
<link rel="icon" type="image/svg+xml" href="{{ asset('asset/img/logo.svg') }}">

<link rel="stylesheet" href="{{ asset('asset/css/style_dashboard_admin.css') }}">
<link rel="stylesheet" href="{{ asset('asset/css/style_edit_user.css') }}">

{{-- ── SVG sprite ──────────────────────────────────────────────────── --}}
<svg xmlns="http://www.w3.org/2000/svg" style="display:none">
  {{-- Edit / pencil --}}
  <symbol id="icon-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
  </symbol>
  {{-- Warning triangle --}}
  <symbol id="icon-warning" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
    <line x1="12" y1="9" x2="12" y2="13"/>
    <line x1="12" y1="17" x2="12.01" y2="17"/>
  </symbol>
  {{-- Lightbulb / hint --}}
  <symbol id="icon-hint" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <line x1="9" y1="18" x2="15" y2="18"/>
    <line x1="10" y1="22" x2="14" y2="22"/>
    <path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1 .23 2.23 1.5 3.5A4.61 4.61 0 0 1 8.91 14"/>
  </symbol>
  {{-- Save / floppy --}}
  <symbol id="icon-save" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
    <polyline points="17 21 17 13 7 13 7 21"/>
    <polyline points="7 3 7 8 15 8"/>
  </symbol>
  {{-- Arrow left --}}
  <symbol id="icon-arrow-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <line x1="19" y1="12" x2="5" y2="12"/>
    <polyline points="12 19 5 12 12 5"/>
  </symbol>
  {{-- Role: admin (lock) --}}
  <symbol id="icon-admin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <rect x="3" y="11" width="18" height="11" rx="2"/>
    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
  </symbol>
  {{-- Role: doctor (ECG line) --}}
  <symbol id="icon-doctor" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
  </symbol>
  {{-- Role: nurse (plus/cross) --}}
  <symbol id="icon-nurse" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <line x1="12" y1="5" x2="12" y2="19"/>
    <line x1="5" y1="12" x2="19" y2="12"/>
  </symbol>
  {{-- Role: secretary (clipboard) --}}
  <symbol id="icon-secretary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
    <rect x="8" y="2" width="8" height="4" rx="1"/>
    <line x1="8" y1="13" x2="16" y2="13"/>
    <line x1="8" y1="17" x2="12" y2="17"/>
  </symbol>
</svg>

<div class="main-user-admin">
  <header class="topbar">
    <div class="topbar-left">
      <div class="topbar-title">Modifier Utilisateur</div>
      <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a><span>›</span>
        <a href="{{ route('utilisateurs.index') }}">Utilisateurs</a><span>›</span>
        <span>{{ $utilisateur->name }}</span><span>›</span>
        <span>Modifier</span>
      </div>
    </div>
  </header>

  <div class="content">
    <div class="form-card">

      {{-- ── Card header ── --}}
      <div class="form-card-header">
        <div class="form-card-icon">
          <svg><use href="#icon-edit"/></svg>
        </div>
        <div>
          <div class="form-card-title">Modifier l'utilisateur</div>
          <div class="form-card-subtitle">Mettez à jour les informations de cet utilisateur</div>
        </div>
      </div>

      <form method="POST" action="{{ route('utilisateurs.update', $utilisateur) }}">
        @csrf
        @method('PUT')

        <div class="form-card-body">

          {{-- ── User banner ── --}}
          <div class="user-edit-banner">
            <div class="user-edit-avatar avatar-{{ $utilisateur->role }}">
              {{ strtoupper(substr($utilisateur->name, 0, 2)) }}
            </div>
            <div>
              <div class="user-edit-name">{{ $utilisateur->name }}</div>
              <div class="user-edit-email">{{ $utilisateur->email }}</div>
              <div class="user-edit-id">
                #U-{{ str_pad($utilisateur->id, 4, '0', STR_PAD_LEFT) }}
                · Créé le {{ $utilisateur->created_at ? $utilisateur->created_at->format('d/m/Y') : '—' }}
              </div>
            </div>
          </div>

          {{-- ── Validation errors ── --}}
          @if($errors->any())
          <div class="alert-errors">
            <div class="alert-errors-title">
              <svg><use href="#icon-warning"/></svg>
              Des erreurs ont été détectées
            </div>
            <ul>
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif

          {{-- ── Name ── --}}
          <div class="form-group">
            <label class="form-label">Nom complet</label>
            <input
              type="text"
              name="name"
              class="form-input {{ $errors->has('name') ? 'error' : '' }}"
              value="{{ old('name', $utilisateur->name) }}"
              required>
            @error('name')
              <div class="form-error">
                <svg><use href="#icon-warning"/></svg>
                {{ $message }}
              </div>
            @enderror
          </div>

          {{-- ── Email ── --}}
          <div class="form-group">
            <label class="form-label">Adresse email</label>
            <input
              type="email"
              name="email"
              class="form-input {{ $errors->has('email') ? 'error' : '' }}"
              value="{{ old('email', $utilisateur->email) }}"
              required>
            @error('email')
              <div class="form-error">
                <svg><use href="#icon-warning"/></svg>
                {{ $message }}
              </div>
            @enderror
          </div>

          {{-- ── Password row ── --}}
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Nouveau mot de passe</label>
              <input
                type="password"
                name="password"
                class="form-input {{ $errors->has('password') ? 'error' : '' }}"
                placeholder="Laisser vide pour ne pas changer">
              @error('password')
                <div class="form-error">
                  <svg><use href="#icon-warning"/></svg>
                  {{ $message }}
                </div>
              @enderror
              <div class="form-hint">
                <svg><use href="#icon-hint"/></svg>
                Laisser vide pour conserver le mot de passe actuel
              </div>
            </div>
            <div class="form-group">
              <label class="form-label">Confirmation</label>
              <input
                type="password"
                name="password_confirmation"
                class="form-input"
                placeholder="Confirmer le mot de passe">
            </div>
          </div>

          {{-- ── Phone ── --}}
          <div class="form-group" id="phone-group">
            <label class="form-label">Téléphone</label>
            <input
              type="text"
              name="phone"
              id="phone"
              class="form-input {{ $errors->has('phone') ? 'error' : '' }}"
              value="{{ old('phone', $utilisateur->phone) }}">
            @error('phone')
              <div class="form-error">
                <svg><use href="#icon-warning"/></svg>
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="form-group" id="specialty-group" style="display: none;">
            <label class="form-label">Spécialité</label>
            <input
              type="text"
              name="specialty"
              id="specialty"
              class="form-input {{ $errors->has('specialty') ? 'error' : '' }}"
              value="{{ old('specialty', $utilisateur->specialty) }}">
            @error('specialty')
              <div class="form-error">
                <svg><use href="#icon-warning"/></svg>
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="form-group" id="doctor-assign-group" style="display: none;">
            <label class="form-label">Médecin Assigné (Optionnel)</label>
            <select name="doctor_id" id="doctor_id" class="form-input {{ $errors->has('doctor_id') ? 'error' : '' }}">
              <option value="">-- Aucun médecin assigné spécifiquement --</option>
              @foreach($doctors as $doc)
                  <option value="{{ $doc->id }}" {{ old('doctor_id', $utilisateur->doctor_id) == $doc->id ? 'selected' : '' }}>
                      Dr. {{ $doc->first_name }} {{ $doc->last_name }}
                  </option>
              @endforeach
            </select>
            <div class="form-help" style="font-size: 0.8rem; color: #6b7280; margin-top: 4px;">Permet d'associer cet utilisateur exclusivement à un médecin.</div>
            @error('doctor_id')
              <div class="form-error"><svg><use href="#icon-warning"/></svg>{{ $message }}</div>
            @enderror
          </div>

          {{-- ── Role selector ── --}}
          <div class="form-group">
            <label class="form-label">Rôle</label>
            <div class="role-options">

              <label class="role-option">
                <input type="radio" name="role" value="admin"
                  {{ old('role', $utilisateur->role) === 'admin' ? 'checked' : '' }}
                  onchange="toggleDoctorFields()">
                <div class="role-option-card">
                  <span class="role-option-icon">
                    <svg><use href="#icon-admin"/></svg>
                  </span>
                  <div>
                    <div class="role-option-name">Admin</div>
                    <div class="role-option-desc">Accès complet</div>
                  </div>
                </div>
              </label>

              <label class="role-option">
                <input type="radio" name="role" value="doctor"
                  {{ old('role', $utilisateur->role) === 'doctor' ? 'checked' : '' }}
                  onchange="toggleDoctorFields()">
                <div class="role-option-card">
                  <span class="role-option-icon">
                    <svg><use href="#icon-doctor"/></svg>
                  </span>
                  <div>
                    <div class="role-option-name">Médecin</div>
                    <div class="role-option-desc">Gestion patients</div>
                  </div>
                </div>
              </label>

              <label class="role-option">
                <input type="radio" name="role" value="nurse"
                  {{ old('role', $utilisateur->role) === 'nurse' ? 'checked' : '' }}
                  onchange="toggleDoctorFields()">
                <div class="role-option-card">
                  <span class="role-option-icon">
                    <svg><use href="#icon-nurse"/></svg>
                  </span>
                  <div>
                    <div class="role-option-name">Infirmier</div>
                    <div class="role-option-desc">Soins &amp; suivi</div>
                  </div>
                </div>
              </label>

              <label class="role-option">
                <input type="radio" name="role" value="secretary"
                  {{ old('role', $utilisateur->role) === 'secretary' ? 'checked' : '' }}
                  onchange="toggleDoctorFields()">
                <div class="role-option-card">
                  <span class="role-option-icon">
                    <svg><use href="#icon-secretary"/></svg>
                  </span>
                  <div>
                    <div class="role-option-name">Secrétaire</div>
                    <div class="role-option-desc">Rendez-vous</div>
                  </div>
                </div>
              </label>

            </div>
            @error('role')
              <div class="form-error">
                <svg><use href="#icon-warning"/></svg>
                {{ $message }}
              </div>
            @enderror
          </div>

        </div><!-- /.form-card-body -->

        <script>
          function toggleDoctorFields() {
            const role = document.querySelector('input[name="role"]:checked').value;
            document.getElementById('specialty-group').style.display =
              (role === 'doctor') ? 'block' : 'none';
            document.getElementById('doctor-assign-group').style.display =
              (role === 'nurse' || role === 'secretary') ? 'block' : 'none';
          }
          document.addEventListener('DOMContentLoaded', toggleDoctorFields);
        </script>

        {{-- ── Footer actions ── --}}
        <div class="form-card-footer">
          <a href="{{ route('utilisateurs.index') }}" class="btn btn-outline">
            <svg width="14" height="14"><use href="#icon-arrow-left"/></svg>
            Retour
          </a>
          <button type="submit" class="btn-ok">
            <svg width="14" height="14"><use href="#icon-save"/></svg>
            Enregistrer les modifications
          </button>
        </div>

      </form>
    </div><!-- /.form-card -->
  </div><!-- /.content -->
</div><!-- /.main-user-admin -->

@endsection