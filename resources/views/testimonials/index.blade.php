@extends('layouts.sidebar')

@section('content')
<div class="testimonials-page-wrapper">
    <!-- Unified Topbar -->
    <div class="app-topbar">
        <div class="app-breadcrumb">
            <a href="{{ route('testimonials.index') }}">Témoignages</a>
            <span class="sep">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </span>
            <span class="current">Liste des avis</span>
        </div>

        <a href="{{ route('testimonials.create') }}" class="app-btn app-btn-primary">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Nouveau Témoignage
        </a>
    </div>

    <!-- Main Content Card -->
    <div class="app-card">
        <div class="app-topbar" style="padding-top: 0; margin-bottom: 25px; border-bottom: 1px solid var(--border); padding-bottom: 20px;">
            <div class="header-left">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text-primary);">Gestion des Témoignages</h3>
                <span class="badge app-badge-pill" style="margin-left: 12px;">{{ $testimonials->total() }} au total</span>
            </div>
            
            <form action="{{ route('testimonials.index') }}" method="GET" class="app-search-bar">
                <div style="position: relative;">
                    <svg style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; fill: none; stroke: var(--text-muted); stroke-width: 2;" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" name="search" class="app-form-control app-search-input" style="padding-left: 44px;" placeholder="Rechercher un nom ou contenu..." value="{{ request('search') }}">
                </div>
                <button type="submit" class="app-btn app-btn-primary">Filtrer</button>
            </form>
        </div>

        @if(session('success'))
            <div style="margin-bottom: 20px; padding: 15px; background: #ecfdf5; color: #059669; border-radius: 12px; border: 1px solid #10b98133;">
                {{ session('success') }}
            </div>
        @endif

        <div class="app-table-wrapper">
            <table class="app-table">
                <thead>
                    <tr>
                        <th>Auteur</th>
                        <th>Message</th>
                        <th>Note</th>
                        <th>Statut</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $testimonial)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 45px; height: 45px; border-radius: 12px; overflow: hidden; background: var(--accent-light); flex-shrink: 0;">
                                    @if($testimonial->image)
                                        <img src="{{ asset($testimonial->image) }}" alt="{{ $testimonial->name }}" style="width: 100%; height: 100%; object-cover: cover;">
                                    @else
                                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--accent); font-weight: 700;">
                                            {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--text-primary);">{{ $testimonial->name }}</div>
                                    <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $testimonial->role ?? 'Patient' }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="max-width: 300px;">
                            <div style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $testimonial->content }}
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; color: #fbbf24; gap: 2px;">
                                @for($i = 0; $i < 5; $i++)
                                    <svg width="14" height="14" fill="{{ $i < $testimonial->rating ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                @endfor
                            </div>
                        </td>
                        <td>
                            @if($testimonial->is_active)
                                <span class="badge app-badge-pill" style="background: #ecfdf5; color: #059669; border: 1px solid #10b98133;">Actif</span>
                            @else
                                <span class="badge app-badge-pill" style="background: #fef2f2; color: #dc2626; border: 1px solid #ef444433;">Inactif</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <a href="{{ route('testimonials.edit', $testimonial->id) }}" class="app-btn-action" title="Modifier">
                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                <form action="{{ route('testimonials.destroy', $testimonial->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Supprimer ce témoignage ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="app-btn-action delete" title="Supprimer">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">Aucun témoignage trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="app-pagination">
            {{ $testimonials->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
