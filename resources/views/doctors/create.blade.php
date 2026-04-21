@extends('layouts.sidebar')

@section('content')
<div class="doctors-page-wrapper">
    <!-- Topbar -->
    <div class="app-topbar">
        <div class="app-breadcrumb">
            <a href="{{ route('doctors.index') }}">Médecins</a>
            <span class="sep">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </span>
            <span class="current">Nouveau médecin</span>
        </div>
    </div>

    <div class="app-card" style="max-width: 680px; margin: 0 auto;">
        <div style="margin-bottom: 28px; border-bottom: 1px solid var(--border); padding-bottom: 20px;">
            <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text-primary);">Ajouter un médecin</h3>
            <p style="margin: 4px 0 0; font-size: 0.875rem; color: var(--text-muted);">Remplissez les informations du nouveau professionnel de santé.</p>
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

        <form action="{{ route('doctors.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label class="app-form-label">Prénom <span style="color:#ef4444">*</span></label>
                    <input type="text" name="first_name" class="app-form-control" value="{{ old('first_name') }}" placeholder="ex: Jean" required>
                </div>
                <div>
                    <label class="app-form-label">Nom <span style="color:#ef4444">*</span></label>
                    <input type="text" name="last_name" class="app-form-control" value="{{ old('last_name') }}" placeholder="ex: Dupont" required>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label class="app-form-label">Spécialité <span style="color:#ef4444">*</span></label>
                <input type="text" name="specialty" class="app-form-control" value="{{ old('specialty') }}" placeholder="ex: Cardiologie" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px;">
                <div>
                    <label class="app-form-label">Téléphone <span style="color:#ef4444">*</span></label>
                    <input type="text" name="phone" class="app-form-control" value="{{ old('phone') }}" placeholder="ex: 06 12 34 56 78" required>
                </div>
                <div>
                    <label class="app-form-label">Email <span style="color:#ef4444">*</span></label>
                    <input type="email" name="email" class="app-form-control" value="{{ old('email') }}" placeholder="ex: docteur@mail.com" required>
                </div>
            </div>

            <div style="margin-bottom: 28px;">
                <label class="app-form-label">Mot de passe <span style="color:#ef4444">*</span></label>
                <input type="text" name="password" class="app-form-control" placeholder="Mot de passe pour la connexion" required>
            </div>

            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <a href="{{ route('doctors.index') }}" class="app-btn app-btn-secondary">Annuler</a>
                <button type="submit" class="app-btn app-btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v14a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
