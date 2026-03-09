@extends('layouts.sidebar')

@section('title', 'Nouvel Utilisateur')

@section('content')
<link rel="stylesheet" href="{{ asset('asset/css/style_dashboard_admin.css') }}">
<link rel="stylesheet" href="{{ asset('asset/css/style_create_user.css') }}">

{{-- ── SVG sprite ──────────────────────────────────────────────────── --}}
<svg xmlns="http://www.w3.org/2000/svg" style="display:none">
  <symbol id="icon-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
    <circle cx="12" cy="7" r="4"/>
  </symbol>
  <symbol id="icon-warning" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
    <line x1="12" y1="9" x2="12" y2="13"/>
    <line x1="12" y1="17" x2="12.01" y2="17"/>
  </symbol>
  <symbol id="icon-arrow-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <line x1="19" y1="12" x2="5" y2="12"/>
    <polyline points="12 19 5 12 12 5"/>
  </symbol>
  <symbol id="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <circle cx="12" cy="12" r="10"/>
    <line x1="12" y1="8" x2="12" y2="16"/>
    <line x1="8" y1="12" x2="16" y2="12"/>
  </symbol>
  <symbol id="icon-admin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <rect x="3" y="11" width="18" height="11" rx="2"/>
    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
  </symbol>
  <symbol id="icon-doctor" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
  </symbol>
  <symbol id="icon-nurse" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <line x1="12" y1="5" x2="12" y2="19"/>
    <line x1="5" y1="12" x2="19" y2="12"/>
  </symbol>
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
      <div class="topbar-title">Nouvel Utilisateur</div>
      <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a><span>›</span>
        <a href="{{ route('utilisateurs.index') }}">Utilisateurs</a><span>›</span>
        <span>Créer</span>
      </div>
    </div>
  </header>

  <div class="content">
    <div class="form-card">

      <div class="form-card-header">
        <div class="form-card-icon">
          <svg><use href="#icon-user"/></svg>
        </div>
        <div>
          <div class="form-card-title">Créer un utilisateur</div>
          <div class="form-card-subtitle">Remplissez les informations pour ajouter un nouvel utilisateur au système</div>
        </div>
      </div>

      <form method="POST" action="{{ route('utilisateurs.store') }}">
        @csrf

        <div class="form-card-body">

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

          <div class="form-group">
            <label class="form-label">Nom complet</label>
            <input type="text" name="name"
              class="form-input {{ $errors->has('name') ? 'error' : '' }}"
              placeholder="Ex: Dr. Mohamed Alaoui"
              value="{{ old('name') }}" required>
            @error('name')
              <div class="form-error"><svg><use href="#icon-warning"/></svg>{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label">Adresse email</label>
            <input type="email" name="email"
              class="form-input {{ $errors->has('email') ? 'error' : '' }}"
              placeholder="exemple@medical.ma"
              value="{{ old('email') }}" required>
            @error('email')
              <div class="form-error"><svg><use href="#icon-warning"/></svg>{{ $message }}</div>
            @enderror
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Mot de passe</label>
              <input type="password" name="password"
                class="form-input {{ $errors->has('password') ? 'error' : '' }}"
                placeholder="Minimum 8 caractères" required>
              @error('password')
                <div class="form-error"><svg><use href="#icon-warning"/></svg>{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group">
              <label class="form-label">Confirmation</label>
              <input type="password" name="password_confirmation"
                class="form-input" placeholder="Confirmer le mot de passe" required>
            </div>
          </div>

          <div class="form-group" id="phone-group">
            <label class="form-label">Téléphone</label>
            <input type="text" name="phone" id="phone"
              class="form-input {{ $errors->has('phone') ? 'error' : '' }}"
              placeholder="Ex: 0612345678"
              value="{{ old('phone') }}">
            @error('phone')
              <div class="form-error"><svg><use href="#icon-warning"/></svg>{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group" id="specialty-group" style="display: none;">
            <label class="form-label">Spécialité</label>
            <input type="text" name="specialty" id="specialty"
              class="form-input {{ $errors->has('specialty') ? 'error' : '' }}"
              placeholder="Ex: Cardiologue"
              value="{{ old('specialty') }}">
            @error('specialty')
              <div class="form-error"><svg><use href="#icon-warning"/></svg>{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label">Rôle</label>
            <div class="role-options">

              <label class="role-option">
                <input type="radio" name="role" value="admin"
                  {{ old('role') === 'admin' ? 'checked' : '' }}
                  onchange="toggleDoctorFields()">
                <div class="role-option-card">
                  <span class="role-option-icon"><svg><use href="#icon-admin"/></svg></span>
                  <div>
                    <div class="role-option-name">Admin</div>
                    <div class="role-option-desc">Accès complet</div>
                  </div>
                </div>
              </label>

              <label class="role-option">
                <input type="radio" name="role" value="doctor"
                  {{ old('role', 'doctor') === 'doctor' ? 'checked' : '' }}
                  onchange="toggleDoctorFields()">
                <div class="role-option-card">
                  <span class="role-option-icon"><svg><use href="#icon-doctor"/></svg></span>
                  <div>
                    <div class="role-option-name">Médecin</div>
                    <div class="role-option-desc">Gestion patients</div>
                  </div>
                </div>
              </label>

              <label class="role-option">
                <input type="radio" name="role" value="nurse"
                  {{ old('role') === 'nurse' ? 'checked' : '' }}
                  onchange="toggleDoctorFields()">
                <div class="role-option-card">
                  <span class="role-option-icon"><svg><use href="#icon-nurse"/></svg></span>
                  <div>
                    <div class="role-option-name">Infirmier</div>
                    <div class="role-option-desc">Soins &amp; suivi</div>
                  </div>
                </div>
              </label>

              <label class="role-option">
                <input type="radio" name="role" value="secretary"
                  {{ old('role') === 'secretary' ? 'checked' : '' }}
                  onchange="toggleDoctorFields()">
                <div class="role-option-card">
                  <span class="role-option-icon"><svg><use href="#icon-secretary"/></svg></span>
                  <div>
                    <div class="role-option-name">Secrétaire</div>
                    <div class="role-option-desc">Rendez-vous</div>
                  </div>
                </div>
              </label>

            </div>
            @error('role')
              <div class="form-error"><svg><use href="#icon-warning"/></svg>{{ $message }}</div>
            @enderror
          </div>

        </div>

        <script>
          function toggleDoctorFields() {
            const role = document.querySelector('input[name="role"]:checked').value;
            document.getElementById('specialty-group').style.display =
              (role === 'doctor') ? 'block' : 'none';
          }
          document.addEventListener('DOMContentLoaded', toggleDoctorFields);
        </script>

        <div class="form-card-footer">
          <a href="{{ route('utilisateurs.index') }}" class="btn btn-outline">
            <svg width="14" height="14"><use href="#icon-arrow-left"/></svg>
            Retour
          </a>
          <button type="submit" class="btn-add">
            <svg width="14" height="14"><use href="#icon-plus"/></svg>
            Créer l'utilisateur
          </button>
        </div>

      </form>
    </div>
  </div>
</div>

@endsection