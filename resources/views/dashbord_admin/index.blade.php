@extends('layouts.sidebar')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="doctors-page-wrapper">
    <!-- Unified Topbar -->
    <div class="app-topbar">
        <div class="app-breadcrumb">
            <a href="{{ route('utilisateurs.index') }}">Gestion des Utilisateurs</a>
            <span class="sep">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </span>
            <span class="current">Aperçu global</span>
        </div>

        <a href="{{ route('utilisateurs.create') }}" class="app-btn app-btn-primary">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="16" y1="11" x2="22" y2="11"/>
            </svg>
            Nouvel Utilisateur
        </a>
    </div>

    <!-- Key Metrics Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px;">
        <div style="background: var(--bg-card); border-radius: 16px; padding: 20px; border: 1px solid var(--border); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 15px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(13, 148, 136, 0.1); color: #0d9488; display: flex; align-items: center; justify-content: center;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 800; color: var(--text-primary); line-height: 1;">{{ $totalUsers }}</div>
                <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-top: 4px;">Total</div>
            </div>
        </div>
        <div style="background: var(--bg-card); border-radius: 16px; padding: 20px; border: 1px solid var(--border); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 15px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(147, 51, 234, 0.1); color: #9333ea; display: flex; align-items: center; justify-content: center;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 800; color: var(--text-primary); line-height: 1;">{{ $totalAdmins }}</div>
                <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-top: 4px;">Admins</div>
            </div>
        </div>
        <div style="background: var(--bg-card); border-radius: 16px; padding: 20px; border: 1px solid var(--border); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 15px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(59, 130, 246, 0.1); color: #3b82f6; display: flex; align-items: center; justify-content: center;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            </div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 800; color: var(--text-primary); line-height: 1;">{{ $totalDoctors }}</div>
                <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-top: 4px;">Médecins</div>
            </div>
        </div>
        <div style="background: var(--bg-card); border-radius: 16px; padding: 20px; border: 1px solid var(--border); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 15px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(245, 158, 11, 0.1); color: #f59e0b; display: flex; align-items: center; justify-content: center;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 800; color: var(--text-primary); line-height: 1;">{{ $totalNurses }}</div>
                <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-top: 4px;">Infirmiers</div>
            </div>
        </div>
        <div style="background: var(--bg-card); border-radius: 16px; padding: 20px; border: 1px solid var(--border); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 15px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(244, 63, 94, 0.1); color: #f43f5e; display: flex; align-items: center; justify-content: center;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            </div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 800; color: var(--text-primary); line-height: 1;">{{ $totalSecretaries }}</div>
                <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-top: 4px;">Secrétaires</div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="app-card">
        <div class="app-topbar" style="padding-top: 0; margin-bottom: 25px; border-bottom: 1px solid var(--border); padding-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div class="header-left">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text-primary);">Comptes Utilisateurs</h3>
            </div>
            
            <div style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
                <div style="display: flex; background: var(--bg-field); border: 1px solid var(--border); border-radius: 8px; padding: 4px;">
                    <a href="{{ route('utilisateurs.index', request()->except('role')) }}" style="padding: 6px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; text-decoration: none; color: {{ !request('role') ? 'var(--accent)' : 'var(--text-secondary)' }}; background: {{ !request('role') ? 'var(--bg-card)' : 'transparent' }}; box-shadow: {{ !request('role') ? '0 1px 2px rgba(0,0,0,0.05)' : 'none' }}; transition: all 0.2s;">Tous</a>
                    <a href="{{ route('utilisateurs.index', array_merge(request()->except('role'), ['role' => 'admin'])) }}" style="padding: 6px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; text-decoration: none; color: {{ request('role') == 'admin' ? 'var(--accent)' : 'var(--text-secondary)' }}; background: {{ request('role') == 'admin' ? 'var(--bg-card)' : 'transparent' }}; box-shadow: {{ request('role') == 'admin' ? '0 1px 2px rgba(0,0,0,0.05)' : 'none' }}; transition: all 0.2s;">Admins</a>
                    <a href="{{ route('utilisateurs.index', array_merge(request()->except('role'), ['role' => 'doctor'])) }}" style="padding: 6px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; text-decoration: none; color: {{ request('role') == 'doctor' ? 'var(--accent)' : 'var(--text-secondary)' }}; background: {{ request('role') == 'doctor' ? 'var(--bg-card)' : 'transparent' }}; box-shadow: {{ request('role') == 'doctor' ? '0 1px 2px rgba(0,0,0,0.05)' : 'none' }}; transition: all 0.2s;">Médecins</a>
                    <a href="{{ route('utilisateurs.index', array_merge(request()->except('role'), ['role' => 'nurse'])) }}" style="padding: 6px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; text-decoration: none; color: {{ request('role') == 'nurse' ? 'var(--accent)' : 'var(--text-secondary)' }}; background: {{ request('role') == 'nurse' ? 'var(--bg-card)' : 'transparent' }}; box-shadow: {{ request('role') == 'nurse' ? '0 1px 2px rgba(0,0,0,0.05)' : 'none' }}; transition: all 0.2s;">Infirmiers</a>
                    <a href="{{ route('utilisateurs.index', array_merge(request()->except('role'), ['role' => 'secretary'])) }}" style="padding: 6px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; text-decoration: none; color: {{ request('role') == 'secretary' ? 'var(--accent)' : 'var(--text-secondary)' }}; background: {{ request('role') == 'secretary' ? 'var(--bg-card)' : 'transparent' }}; box-shadow: {{ request('role') == 'secretary' ? '0 1px 2px rgba(0,0,0,0.05)' : 'none' }}; transition: all 0.2s;">Secrétaires</a>
                </div>

                <form action="{{ route('utilisateurs.index') }}" method="GET" class="app-search-bar" id="searchForm" style="margin: 0;">
                    @if(request('role'))
                        <input type="hidden" name="role" value="{{ request('role') }}">
                    @endif
                    <div style="position: relative;">
                        <svg style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; fill: none; stroke: var(--text-muted); stroke-width: 2;" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" name="search" class="app-form-control app-search-input" style="padding-left: 44px; width: 250px;" placeholder="Rechercher..." value="{{ request('search') }}" id="searchInput">
                    </div>
                </form>
            </div>
        </div>

        <div class="app-table-wrapper">
            <table class="app-table">
                <thead>
                    <tr>
                        <th>Identité</th>
                        <th>Coordonnées</th>
                        <th>Rôle</th>
                        <th>Adhésion</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr style="transition: all 0.2s; border-bottom: 1px solid var(--border);">
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                @if($user->profile_photo)
                                    <img src="{{ asset('profiles/' . $user->profile_photo) }}" alt="Avatar" style="width: 40px; height: 40px; border-radius: 12px; object-fit: cover; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                @else
                                    <div style="width: 40px; height: 40px; border-radius: 12px; background: var(--accent-light); color: var(--accent); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <div style="font-weight: 600; color: var(--text-primary);">{{ $user->name }}</div>
                                    <div style="font-size: 0.75rem; color: var(--text-muted);">#USR-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; flex-direction: column; gap: 2px;">
                                <span style="font-size: 0.85rem; color: var(--text-secondary);">{{ $user->email }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge app-badge-pill" style="border: 1px solid var(--border); background: var(--bg-field); color: var(--text-secondary); display: inline-flex; align-items: center; gap: 6px;">
                                @switch($user->role)
                                    @case('admin') 
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color:#9333ea"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> 
                                        Admin 
                                    @break
                                    @case('doctor') 
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color:#3b82f6"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg> 
                                        Médecin 
                                    @break
                                    @case('nurse') 
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color:#f59e0b"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> 
                                        Infirmier 
                                    @break
                                    @case('secretary') 
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color:#f43f5e"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg> 
                                        Secrétaire 
                                    @break
                                @endswitch
                            </span>
                        </td>
                        <td>
                            <span style="font-size: 0.85rem; color: var(--text-secondary); font-weight: 500;">
                                {{ $user->created_at ? $user->created_at->format('d M Y') : '—' }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <a href="{{ route('utilisateurs.show', $user) }}" class="app-btn-action" title="Consulter">
                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                                <a href="{{ route('utilisateurs.edit', $user) }}" class="app-btn-action" title="Modifier">
                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('utilisateurs.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Confirmer la suppression de cet utilisateur ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="app-btn-action delete" title="Supprimer">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-light);"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                <span>Aucun utilisateur trouvé.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="app-pagination" style="margin-top: 20px;">
            {{ $users->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<script>
  let searchTimeout;
  document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
      document.getElementById('searchForm').submit();
    }, 500);
  });
</script>
@endsection
