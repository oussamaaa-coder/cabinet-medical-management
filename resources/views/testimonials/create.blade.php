@extends('layouts.sidebar')

@section('content')
<div class="testimonials-page-wrapper">
    <!-- Topbar -->
    <div class="app-topbar">
        <div class="app-breadcrumb">
            <a href="{{ route('testimonials.index') }}">Témoignages</a>
            <span class="sep">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </span>
            <span class="current">Nouveau témoignage</span>
        </div>
    </div>

    <div class="app-card" style="max-width: 680px; margin: 0 auto;">
        <div style="margin-bottom: 28px; border-bottom: 1px solid var(--border); padding-bottom: 20px;">
            <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text-primary);">Ajouter un témoignage</h3>
            <p style="margin: 4px 0 0; font-size: 0.875rem; color: var(--text-muted);">Publiez un nouvel avis patient sur le site.</p>
        </div>

        @if($errors->any())
            <div style="background: #fee2e2; border: 1px solid #fca5a5; border-radius: 10px; padding: 14px 18px; margin-bottom: 24px; color: #b91c1c; font-size: 0.875rem;">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label class="app-form-label">Nom complet <span style="color:#ef4444">*</span></label>
                    <input type="text" name="name" class="app-form-control" value="{{ old('name') }}" placeholder="ex: Sophie Martin" required>
                </div>
                <div>
                    <label class="app-form-label">Rôle / Titre</label>
                    <input type="text" name="role" class="app-form-control" value="{{ old('role') }}" placeholder="ex: Patiente depuis 2 ans">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label class="app-form-label">Note (Étoiles) <span style="color:#ef4444">*</span></label>
                <select name="rating" class="app-form-control" required>
                    <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>5 Étoiles</option>
                    <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4 Étoiles</option>
                    <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3 Étoiles</option>
                    <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>2 Étoiles</option>
                    <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>1 Étoile</option>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label class="app-form-label">Témoignage <span style="color:#ef4444">*</span></label>
                <textarea name="content" class="app-form-control" rows="5" placeholder="Saisissez l'avis du patient ici..." required style="resize: vertical;">{{ old('content') }}</textarea>
            </div>

            <div style="margin-bottom: 20px;">
                <label class="app-form-label">Photo de profil</label>
                <input type="file" name="image" class="app-form-control" accept="image/*">
                <p style="margin-top: 4px; font-size: 0.75rem; color: var(--text-muted);">Recommandé: Image carrée (ex: 200x200px).</p>
            </div>

            <div style="margin-bottom: 28px; display: flex; align-items: center; gap: 10px;">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;">
                <label for="is_active" style="font-size: 0.875rem; color: var(--text-primary); cursor: pointer; font-weight: 500;">Afficher sur le site immédiatement</label>
            </div>

            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <a href="{{ route('testimonials.index') }}" class="app-btn app-btn-secondary">Annuler</a>
                <button type="submit" class="app-btn app-btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v14a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
