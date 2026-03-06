@extends('layouts.sidebar')

@section('title', 'Nouvel Utilisateur')

@section('content')
<link rel="stylesheet" href="{{ asset('asset/css/style_dashboard_admin.css') }}">
<link rel="stylesheet" href="{{ asset('asset/css/style_create_user.css') }}">


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
        <div class="form-card-icon">👤</div>
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
            <div class="alert-errors-title">⚠️ Des erreurs ont été détectées</div>
            <ul>
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif

          <div class="form-group">
            <label class="form-label">Nom complet</label>
            <input type="text" name="name" class="form-input {{ $errors->has('name') ? 'error' : '' }}" placeholder="Ex: Dr. Mohamed Alaoui" value="{{ old('name') }}" required>
            @error('name') <div class="form-error">⚠ {{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label class="form-label">Adresse email</label>
            <input type="email" name="email" class="form-input {{ $errors->has('email') ? 'error' : '' }}" placeholder="exemple@medical.ma" value="{{ old('email') }}" required>
            @error('email') <div class="form-error">⚠ {{ $message }}</div> @enderror
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Mot de passe</label>
              <input type="password" name="password" class="form-input {{ $errors->has('password') ? 'error' : '' }}" placeholder="Minimum 8 caractères" required>
              @error('password') <div class="form-error">⚠ {{ $message }}</div> @enderror
            </div>
            <div class="form-group">
              <label class="form-label">Confirmation</label>
              <input type="password" name="password_confirmation" class="form-input" placeholder="Confirmer le mot de passe" required>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Rôle</label>
            <div class="role-options">
              <label class="role-option">
                <input type="radio" name="role" value="admin" {{ old('role') === 'admin' ? 'checked' : '' }}>
                <div class="role-option-card">
                  <span class="role-option-icon">🔐</span>
                  <div>
                    <div class="role-option-name">Administrateur</div>
                    <div class="role-option-desc">Accès complet</div>
                  </div>
                </div>
              </label>
              <label class="role-option">
                <input type="radio" name="role" value="doctor" {{ old('role', 'doctor') === 'doctor' ? 'checked' : '' }}>
                <div class="role-option-card">
                  <span class="role-option-icon">🩺</span>
                  <div>
                    <div class="role-option-name">Médecin</div>
                    <div class="role-option-desc">Gestion patients</div>
                  </div>
                </div>
              </label>
              <label class="role-option">
                <input type="radio" name="role" value="nurse" {{ old('role') === 'nurse' ? 'checked' : '' }}>
                <div class="role-option-card">
                  <span class="role-option-icon">💉</span>
                  <div>
                    <div class="role-option-name">Infirmier</div>
                    <div class="role-option-desc">Soins & suivi</div>
                  </div>
                </div>
              </label>
              <label class="role-option">
                <input type="radio" name="role" value="secretary" {{ old('role') === 'secretary' ? 'checked' : '' }}>
                <div class="role-option-card">
                  <span class="role-option-icon">📋</span>
                  <div>
                    <div class="role-option-name">Secrétaire</div>
                    <div class="role-option-desc">Rendez-vous</div>
                  </div>
                </div>
              </label>
            </div>
            @error('role') <div class="form-error">⚠ {{ $message }}</div> @enderror
          </div>
        </div>

        <div class="form-card-footer">
          <a href="{{ route('utilisateurs.index') }}" class="btn btn-outline">← Retour</a>
          <button type="submit" class="btn btn-primary">✅ Créer l'utilisateur</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
