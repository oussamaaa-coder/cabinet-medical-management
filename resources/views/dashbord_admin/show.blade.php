@extends('layouts.sidebar')

@section('title', 'Détails Utilisateur')

@section('content')
<link rel="stylesheet" href="{{ asset('asset/css/style_dashboard_admin.css') }}">
<link rel="stylesheet" href="{{ asset('asset/css/style_show_user.css') }}">


<div class="main-user-admin">
  <header class="topbar">
    <div class="topbar-left">
      <div class="topbar-title">Profil Utilisateur</div>
      <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a><span>›</span>
        <a href="{{ route('utilisateurs.index') }}">Utilisateurs</a><span>›</span>
        <span>{{ $utilisateur->name }}</span>
      </div>
    </div>
    <div class="topbar-actions">
      <a href="{{ route('utilisateurs.edit', $utilisateur) }}" class="btn btn-primary">✏️ Modifier</a>
    </div>
  </header>

  <div class="content">
    <div class="profile-card">
      <!-- Hero -->
      <div class="profile-hero">
        <div class="profile-avatar avatar-{{ $utilisateur->role }}">
          {{ strtoupper(substr($utilisateur->name, 0, 2)) }}
        </div>
        <div class="profile-name">{{ $utilisateur->name }}</div>
        <div class="profile-email">{{ $utilisateur->email }}</div>
        <span class="role-badge role-{{ $utilisateur->role }}">
          @switch($utilisateur->role)
            @case('admin') 🔐 Administrateur @break
            @case('doctor') 🩺 Médecin @break
            @case('nurse') 💉 Infirmier @break
            @case('secretary') 📋 Secrétaire @break
          @endswitch
        </span>
      </div>

      <!-- Details -->
      <div class="profile-details">
        <div class="detail-grid">
          <div class="detail-item">
            <div class="detail-label">🆔 Identifiant</div>
            <div class="detail-value">#U-{{ str_pad($utilisateur->id, 4, '0', STR_PAD_LEFT) }}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">🔑 Rôle système</div>
            <div class="detail-value">{{ ucfirst($utilisateur->role) }}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">📅 Date de création</div>
            <div class="detail-value">{{ $utilisateur->created_at ? $utilisateur->created_at->format('d/m/Y à H:i') : '—' }}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">🔄 Dernière mise à jour</div>
            <div class="detail-value">{{ $utilisateur->updated_at ? $utilisateur->updated_at->format('d/m/Y à H:i') : '—' }}</div>
          </div>
          <div class="detail-item" style="grid-column: 1 / -1;">
            <div class="detail-label">📧 Email vérifié</div>
            <div class="detail-value">
              @if($utilisateur->email_verified_at)
                ✅ Vérifié le {{ $utilisateur->email_verified_at->format('d/m/Y') }}
              @else
                ⏳ Non vérifié
              @endif
            </div>
          </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="profile-actions">
        <a href="{{ route('utilisateurs.index') }}" class="btn btn-outline">← Retour à la liste</a>
        <a href="{{ route('utilisateurs.edit', $utilisateur) }}" class="btn btn-primary">✏️ Modifier cet utilisateur</a>
      </div>
    </div>
  </div>
</div>
@endsection
