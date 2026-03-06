@extends('layouts.sidebar')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<link rel="stylesheet" href="{{ asset('asset/css/style_dashboard_admin.css') }}">
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
        <span>🔍</span>
        <input type="text" name="search" placeholder="Rechercher un utilisateur..." value="{{ request('search') }}" id="searchInput">
      </form>
      <a href="{{ route('utilisateurs.create') }}" class="btn btn-primary">
        ➕ Nouvel Utilisateur
      </a>
    </div>
  </header>
  <div class="content">
    <!-- STATS -->
    <div class="stats-row">
      <div class="stat-card teal">
        <div class="stat-icon">👥</div>
        <div class="stat-value">{{ $totalUsers }}</div>
        <div class="stat-label">Total Utilisateurs</div>
      </div>
      <div class="stat-card purple">
        <div class="stat-icon">🔐</div>
        <div class="stat-value">{{ $totalAdmins }}</div>
        <div class="stat-label">Administrateurs</div>
      </div>
      <div class="stat-card blue">
        <div class="stat-icon">🩺</div>
        <div class="stat-value">{{ $totalDoctors }}</div>
        <div class="stat-label">Médecins</div>
      </div>
      <div class="stat-card amber">
        <div class="stat-icon">💉</div>
        <div class="stat-value">{{ $totalNurses }}</div>
        <div class="stat-label">Infirmiers</div>
      </div>
      <div class="stat-card rose">
        <div class="stat-icon">📋</div>
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
                    @case('admin') 🔐 Admin @break
                    @case('doctor') 🩺 Médecin @break
                    @case('nurse') 💉 Infirmier @break
                    @case('secretary') 📋 Secrétaire @break
                  @endswitch
                </span>
              </td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '—' }}</td>
              <td>
                <a href="{{ route('utilisateurs.show', $user) }}" class="action-btn" title="Voir détails">👁</a>
                <a href="{{ route('utilisateurs.edit', $user) }}" class="action-btn" title="Modifier">✏️</a>
                @if($user->id !== auth()->id())
                  <button class="action-btn danger" title="Supprimer" onclick="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}')">🗑</button>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @else
        <div class="empty-state">
          <div class="empty-icon">👤</div>
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
      <div class="modal-title">⚠️ Confirmer la suppression</div>
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
        <button type="submit" class="btn btn-danger">🗑 Supprimer</button>
      </form>
    </div>
  </div>
</div>

<!-- TOAST NOTIFICATIONS -->
<div class="toast success" id="successToast">✅ <span id="successMsg"></span></div>
<div class="toast error" id="errorToast">❌ <span id="errorMsg"></span></div>

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
