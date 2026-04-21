@extends('layouts.sidebar')
@section('title', 'Détails Utilisateur')
@section('content')
<link rel="icon" type="image/svg+xml" href="{{ asset('asset/img/logo.svg') }}">
<link rel="stylesheet" href="{{ asset('asset/css/style_dashboard_admin.css') }}">
<link rel="stylesheet" href="{{ asset('asset/css/style_show_user.css') }}">

{{-- ── SVG icon helpers (inline, reusable via <use>) ──────────────── --}}
<svg xmlns="http://www.w3.org/2000/svg" style="display:none">
  {{-- Edit / pencil --}}
  <symbol id="icon-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
  </symbol>
  {{-- Arrow left --}}
  <symbol id="icon-arrow-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <line x1="19" y1="12" x2="5" y2="12"/>
    <polyline points="12 19 5 12 12 5"/>
  </symbol>
  {{-- ID card --}}
  <symbol id="icon-id" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <rect x="2" y="5" width="20" height="14" rx="2"/>
    <path d="M16 10h2M16 14h2M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm0 0c-2 0-4 1-4 3"/>
  </symbol>
  {{-- Shield / role --}}
  <symbol id="icon-role" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
  </symbol>
  {{-- Calendar --}}
  <symbol id="icon-calendar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <rect x="3" y="4" width="18" height="18" rx="2"/>
    <line x1="16" y1="2" x2="16" y2="6"/>
    <line x1="8" y1="2" x2="8" y2="6"/>
    <line x1="3" y1="10" x2="21" y2="10"/>
  </symbol>
  {{-- Refresh --}}
  <symbol id="icon-refresh" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <polyline points="23 4 23 10 17 10"/>
    <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
  </symbol>
  {{-- Mail --}}
  <symbol id="icon-mail" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
    <polyline points="22,6 12,13 2,6"/>
  </symbol>
  {{-- Check circle (verified) --}}
  <symbol id="icon-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
    <polyline points="22 4 12 14.01 9 11.01"/>
  </symbol>
  {{-- Clock (unverified) --}}
  <symbol id="icon-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <circle cx="12" cy="12" r="10"/>
    <polyline points="12 6 12 12 16 14"/>
  </symbol>
  {{-- Role: admin (lock) --}}
  <symbol id="icon-admin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <rect x="3" y="11" width="18" height="11" rx="2"/>
    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
  </symbol>
  {{-- Role: doctor (stethoscope alt: activity) --}}
  <symbol id="icon-doctor" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
  </symbol>
  {{-- Role: nurse (cross / plus) --}}
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
      <div class="topbar-title">Profil Utilisateur</div>
      <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a><span>›</span>
        <a href="{{ route('utilisateurs.index') }}">Utilisateurs</a><span>›</span>
        <span>{{ $utilisateur->name }}</span>
      </div>
    </div>
    
  </header>

  <div class="content">
    <div class="profile-card">

      {{-- ── Hero ── --}}
      <div class="profile-hero">
        @if($utilisateur->profile_photo)
          <img
            src="{{ asset('profiles/' . $utilisateur->profile_photo) }}"
            alt="Photo de profil"
            class="profile-avatar avatar-{{ $utilisateur->role }}">
        @else
          <div class="profile-avatar avatar-{{ $utilisateur->role }}">
            {{ strtoupper(substr($utilisateur->name, 0, 2)) }}
          </div>
        @endif

        <div class="profile-name">{{ $utilisateur->name }}</div>
        <div class="profile-email">{{ $utilisateur->email }}</div>

        <span class="role-badge role-{{ $utilisateur->role }}">
          @switch($utilisateur->role)
            @case('admin')
              <svg width="14" height="14"><use href="#icon-admin"/></svg>
              Administrateur
              @break
            @case('doctor')
              <svg width="14" height="14"><use href="#icon-doctor"/></svg>
              Médecin
              @break
            @case('nurse')
              <svg width="14" height="14"><use href="#icon-nurse"/></svg>
              Infirmier
              @break
            @case('secretary')
              <svg width="14" height="14"><use href="#icon-secretary"/></svg>
              Secrétaire
              @break
          @endswitch
        </span>
      </div>

      {{-- ── Details ── --}}
      <div class="profile-details">
        <div class="detail-grid">

          <div class="detail-item">
            <div class="detail-label">
              <svg width="14" height="14"><use href="#icon-id"/></svg>
              Identifiant
            </div>
            <div class="detail-value">
              #U-{{ str_pad($utilisateur->id, 4, '0', STR_PAD_LEFT) }}
            </div>
          </div>

          <div class="detail-item">
            <div class="detail-label">
              <svg width="14" height="14"><use href="#icon-role"/></svg>
              Rôle système
            </div>
            <div class="detail-value">{{ ucfirst($utilisateur->role) }}</div>
          </div>

          <div class="detail-item">
            <div class="detail-label">
              <svg width="14" height="14"><use href="#icon-calendar"/></svg>
              Date de création
            </div>
            <div class="detail-value">
              {{ $utilisateur->created_at ? $utilisateur->created_at->format('d/m/Y à H:i') : '—' }}
            </div>
          </div>

          <div class="detail-item">
            <div class="detail-label">
              <svg width="14" height="14"><use href="#icon-refresh"/></svg>
              Dernière mise à jour
            </div>
            <div class="detail-value">
              {{ $utilisateur->updated_at ? $utilisateur->updated_at->format('d/m/Y à H:i') : '—' }}
            </div>
          </div>

          <div class="detail-item" style="grid-column: 1 / -1;">
            <div class="detail-label">
              <svg width="14" height="14"><use href="#icon-mail"/></svg>
              Email vérifié
            </div>
            <div class="detail-value">
              @if($utilisateur->email_verified_at)
                <svg width="14" height="14" class="verified"><use href="#icon-check"/></svg>
                Vérifié le {{ $utilisateur->email_verified_at->format('d/m/Y') }}
              @else
                <svg width="14" height="14" class="unverified"><use href="#icon-clock"/></svg>
                Non vérifié
              @endif
            </div>
          </div>

        </div>
      </div>

      {{-- ── Actions ── --}}
      <div class="profile-actions">
        <a href="{{ route('utilisateurs.index') }}" class="btn btn-outline">
          <svg width="14" height="14"><use href="#icon-arrow-left"/></svg>
          Retour à la liste
        </a>
        <a href="{{ route('utilisateurs.edit', $utilisateur) }}" class="btn-edit">
          <svg width="14" height="14"><use href="#icon-edit"/></svg>
          Modifier cet utilisateur
        </a>
      </div>

    </div>
  </div>
</div>
@endsection