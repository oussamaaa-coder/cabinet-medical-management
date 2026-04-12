@extends('layouts.sidebar')

@section('title', 'Gestion des Utilisateurs')

@push('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/style_dashboard_admin.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">
@endpush

@section('content')
<!-- MAIN CONTENT -->
<div class="main-user-admin">
  <header class="topbar">
    <div class="topbar-left">
      <div class="topbar-title">Gestion des Utilisateurs</div>
      <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span>›</span>
        <span>Utilisateurs</span>
      </div>
    </div>
    <div class="topbar-actions">
      <form method="GET" action="{{ route('utilisateurs.index') }}" class="search-input-wrapper" id="searchForm">
        <input type="text" name="search" placeholder="Rechercher un utilisateur..." value="{{ request('search') }}" id="searchInput">
      </form>
      <a href="{{ route('utilisateurs.create') }}" class="btn btn-primary">
        Nouvel Utilisateur
      </a>
    </div>
  </header>
  <div class="content">
    <!-- STATS -->
    <div class="stats-row">
      <div class="stat-card teal">
        <div class="stat-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div class="stat-value">{{ $totalUsers }}</div>
        <div class="stat-label">Total Utilisateurs</div>
      </div>
      <div class="stat-card purple">
        <div class="stat-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        </div>
        <div class="stat-value">{{ $totalAdmins }}</div>
        <div class="stat-label">Administrateurs</div>
      </div>
      <div class="stat-card blue">
        <div class="stat-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
        </div>
        <div class="stat-value">{{ $totalDoctors }}</div>
        <div class="stat-label">Médecins</div>
      </div>
      <div class="stat-card amber">
        <div class="stat-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </div>
        <div class="stat-value">{{ $totalNurses }}</div>
        <div class="stat-label">Infirmiers</div>
      </div>
      <div class="stat-card rose">
        <div class="stat-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        </div>
        <div class="stat-value">{{ $totalSecretaries }}</div>
        <div class="stat-label">Secrétaires</div>
      </div>
    </div>

    <!-- USER TABLE -->
    <div class="card">
      <div class="card-header">
        <div class="card-title">Liste des Utilisateurs</div>
        <div class="card-actions">
          <div class="filter-tabs">
            <a href="{{ route('utilisateurs.index', request()->except('role')) }}" class="filter-tab {{ !request('role') ? 'active' : '' }}">Tous</a>
            <a href="{{ route('utilisateurs.index', array_merge(request()->except('role'), ['role' => 'admin'])) }}" class="filter-tab {{ request('role') === 'admin' ? 'active' : '' }}">Admins</a>
            <a href="{{ route('utilisateurs.index', array_merge(request()->except('role'), ['role' => 'doctor'])) }}" class="filter-tab {{ request('role') === 'doctor' ? 'active' : '' }}">Médecins</a>
            <a href="{{ route('utilisateurs.index', array_merge(request()->except('role'), ['role' => 'nurse'])) }}" class="filter-tab {{ request('role') === 'nurse' ? 'active' : '' }}">Infirmiers</a>
            <a href="{{ route('utilisateurs.index', array_merge(request()->except('role'), ['role' => 'secretary'])) }}" class="filter-tab {{ request('role') === 'secretary' ? 'active' : '' }}">Secrétaires</a>
          </div>
        </div>
      </div>
      <div class="table-container">
        @if($users->count() > 0)
        <table>
          <thead>
            <tr>
              <th style="width: 60px;">Photo</th>
              <th>Nom</th>
              <th>Email</th>
              <th>Rôle</th>
              <th>Créé le</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
            <tr>
              <td>
                @if($user->profile_photo)
                  <img src="{{ asset('profiles/' . $user->profile_photo) }}" alt="Avatar" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover; border: 1px solid #dce8e1;">
                @else
                  <div style="width: 40px; height: 40px; border-radius: 8px; background: #eaf3ee; color: #3a7d5c; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; border: 1px solid #dce8e1;">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                  </div>
                @endif
              </td>
              <td>
                <div class="user-name-text">{{ $user->name }}</div>
                <div class="user-email-text">#U-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
              </td>
              <td>{{ $user->email }}</td>
              <td>
                <span class="role-badge role-{{ $user->role }}">
                  @switch($user->role)
                    @case('admin') <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> Admin @break
                    @case('doctor') <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg> Médecin @break
                    @case('nurse') <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> Infirmier @break
                    @case('secretary') <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg> Secrétaire @break
                  @endswitch
                </span>
              </td>
              <td>{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '—' }}</td>
              <td>
                <a href="{{ route('utilisateurs.show', $user) }}" class="action-btn" title="Voir détails">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </a>
                <a href="{{ route('utilisateurs.edit', $user) }}" class="action-btn" title="Modifier">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2-2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </a>
                @if($user->id !== auth()->id())
                  <button class="action-btn danger" title="Supprimer" onclick="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                  </button>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @else
        <div class="empty-state">
          <div class="empty-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </div>
          <div class="empty-title">Aucun utilisateur trouvé</div>
          <div class="empty-text">
            @if(request('search') || request('role'))
              Essayez de modifier vos critères de recherche.
            @else
              Commencez par ajouter un nouvel utilisateur.
            @endif
          </div>
        </div>
        @endif
      </div>

      @if($users->hasPages())
      <div class="pagination-wrapper">
        <div class="pagination-info">
          Affichage de {{ $users->firstItem() }} à {{ $users->lastItem() }} sur {{ $users->total() }} utilisateurs
        </div>
        <div class="pagination-links">
          @if($users->onFirstPage())
            <span class="disabled">‹ Préc.</span>
          @else
            <a href="{{ $users->previousPageUrl() }}">‹ Préc.</a>
          @endif

          @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
            @if($page == $users->currentPage())
              <span class="current">{{ $page }}</span>
            @else
              <a href="{{ $url }}">{{ $page }}</a>
            @endif
          @endforeach

          @if($users->hasMorePages())
            <a href="{{ $users->nextPageUrl() }}">Suiv. ›</a>
          @else
            <span class="disabled">Suiv. ›</span>
          @endif
        </div>
      </div>
      @endif
    </div>
  </div>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<div class="modal-overlay" id="deleteModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px; color:#b91c1c;"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        Confirmer la suppression
      </div>
      <button class="modal-close" onclick="closeDeleteModal()">✕</button>
    </div>
    <div class="modal-body">
      <p>Êtes-vous sûr de vouloir supprimer l'utilisateur <span class="user-delete-name" id="deleteUserName"></span> ? Cette action est irréversible.</p>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeDeleteModal()">Annuler</button>
      <form id="deleteForm" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:5px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
          Supprimer
        </button>
      </form>
    </div>
  </div>
</div>

<!-- TOAST NOTIFICATIONS -->
<div class="toast success" id="successToast">
  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;"><polyline points="20 6 9 17 4 12"/></svg>
  <span id="successMsg"></span>
</div>
<div class="toast error" id="errorToast">
  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
  <span id="errorMsg"></span>
</div>

<script>
  // Delete confirmation
  function confirmDelete(userId, userName) {
    document.getElementById('deleteUserName').textContent = userName;
    document.getElementById('deleteForm').action = '/utilisateurs/' + userId;
    document.getElementById('deleteModal').classList.add('open');
  }

  function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('open');
  }

  document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
  });

  // Toast notifications
  @if(session('success'))
    showToast('success', @json(session('success')));
  @endif

  @if(session('error'))
    showToast('error', @json(session('error')));
  @endif

  function showToast(type, message) {
    const toast = document.getElementById(type + 'Toast');
    document.getElementById(type + 'Msg').textContent = message;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 4000);
  }

  // Search debounce
  let searchTimeout;
  document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
      document.getElementById('searchForm').submit();
    }, 500);
  });
</script>
@endsection
