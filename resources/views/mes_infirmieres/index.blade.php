@extends('layouts.sidebar')

@section('title', 'Mes Infirmières')

@section('content')
  <link rel="icon" type="image/svg+xml" href="{{ asset('asset/img/logo.svg') }}">
  <link rel="stylesheet" href="{{ asset('asset/css/style_dashboard_admin.css') }}">


  <div class="main-user-admin">
    <div class="app-topbar">
      <div class="app-breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </span>
        <span class="current">Ses Infirmières</span>
      </div>

      <a href="{{ route('mes-infirmieres.create') }}" class="app-btn app-btn-primary">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="12" y1="5" x2="12" y2="19"></line>
          <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
        Nouvelle infirmière
      </a>
    </div>

    <div class="content">
      @if(session('success'))
        <div class="alert alert-success" style="padding:1rem; background-color:var(--green-50); color:var(--green-700); border: 1px solid var(--green-100); border-radius:12px; margin-bottom:1.5rem; display: flex; align-items: center; gap: 10px;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
          {{ session('success') }}
        </div>
      @endif

      <div class="stats-row" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));">
        <div class="stat-card teal">
          <div class="stat-icon"></div>
          <div>
            <div class="stat-value">{{ $totalNurses }}</div>
            <div class="stat-label">Infirmière(s) assignée(s)</div>
          </div>
        </div>
      </div>

      <div class="app-card">
        <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border); padding: 24px;">
          <div class="header-left" style="display: flex; align-items: center; gap: 12px;">
            <h3 style="margin: 0; font-size: 1.1rem; font-weight: 700; color: var(--slate-900);">Liste de vos infirmières</h3>
            <span class="role-badge role-nurse" style="font-size: 11px;">{{ $totalNurses }} AU TOTAL</span>
          </div>
          
          <form method="GET" action="{{ route('mes-infirmieres.index') }}" class="app-search-bar">
            <div style="position: relative;">
              <svg style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; fill: none; stroke: var(--slate-400); stroke-width: 2;" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
              <input type="text" name="search" class="app-form-control" style="padding-left: 44px; width: 260px;" placeholder="Rechercher..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="app-btn app-btn-primary">Chercher</button>
          </form>
        </div>

        <div class="table-container">
          <table class="app-table">
            <thead>
              <tr>
                <th>Infirmière</th>
                <th>Coordonnées</th>
                <th>Date d'ajout</th>
                <th style="text-align: right;">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($nurses as $nurse)
                <tr>
                  <td>
                    <div style="display: flex; align-items: center; gap: 12px;">
                      <div style="width: 38px; height: 38px; border-radius: 10px; background: var(--green-50); color: var(--green-600); display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 700; border: 1px solid var(--green-100);">
                        {{ strtoupper(substr($nurse->name, 0, 1)) }}{{ str_contains($nurse->name, ' ') ? strtoupper(substr(explode(' ', $nurse->name)[1], 0, 1)) : '' }}
                      </div>
                      <div>
                        <div class="user-name-text">{{ $nurse->name }}</div>
                        <div class="role-badge role-nurse" style="font-size: 10px; padding: 1px 8px; margin-top: 2px;">Infirmière Qualifiée</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="user-email-text">{{ $nurse->email }}</div>
                    <div style="color: var(--slate-400); font-size: 12px; margin-top: 1px;">{{ $nurse->phone ?? '—' }}</div>
                  </td>
                  <td>
                    <span style="font-weight: 500; color: var(--slate-500);">{{ $nurse->created_at->format('d/m/Y') }}</span>
                  </td>
                  <td>
                    <div style="display: flex; justify-content: flex-end; gap: 8px;">
                      <a href="{{ route('mes-infirmieres.edit', $nurse) }}" class="action-btn" title="Modifier"></a>
                      <form action="{{ route('mes-infirmieres.destroy', $nurse) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir retirer cette infirmière ?');" style="margin:0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn danger" title="Supprimer"></button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4">
                    <div class="empty-state">
                      <div class="empty-icon"></div>
                      <h3 class="empty-title">Aucune infirmière</h3>
                      <p class="empty-text">Vous n'avez pas encore d'infirmière assignée dans votre équipe.</p>
                      <a href="{{ route('mes-infirmieres.create') }}" class="app-btn app-btn-outline" style="margin-top: 10px;">Ajouter maintenant</a>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        @if($nurses->hasPages())
          <div class="pagination-wrapper">
            <div class="pagination-info">Affichage des résultats</div>
            <div class="pagination-links">
              {{ $nurses->links() }}
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection
