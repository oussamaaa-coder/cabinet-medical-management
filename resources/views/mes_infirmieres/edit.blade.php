@extends('layouts.sidebar')

@section('title', 'Modifier l\'Infirmière')

@section('content')
<link rel="stylesheet" href="{{ asset('asset/css/style_dashboard_admin.css') }}">
<link rel="icon" type="image/svg+xml" href="{{ asset('asset/img/logo.svg') }}">

<div class="main-user-admin">
    <div class="app-topbar">
        <div class="app-breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span class="sep">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </span>
            <a href="{{ route('mes-infirmieres.index') }}">Ses Infirmières</a>
            <span class="sep">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </span>
            <span class="current">Modifier</span>
        </div>
    </div>

    <div class="content">
        <div class="app-card" style="max-width: 800px; margin: 0 auto;">
            <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border); padding: 24px;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="width: 52px; height: 52px; border-radius: 14px; background: var(--green-50); color: var(--green-600); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem; border: 1px solid var(--green-100);">
                        {{ strtoupper(substr($mes_infirmiere->name, 0, 1)) }}{{ str_contains($mes_infirmiere->name, ' ') ? strtoupper(substr(explode(' ', $mes_infirmiere->name)[1], 0, 1)) : '' }}
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--slate-900);">{{ $mes_infirmiere->name }}</h3>
                        <p style="margin: 2px 0 0; font-size: 0.85rem; color: var(--slate-400);">Mise à jour des informations professionnelles</p>
                    </div>
                </div>
            </div>

            <div style="padding: 32px;">
                @if($errors->any())
                  <div class="alert alert-error" style="background: var(--rose-100); color: var(--rose-500); padding: 1rem; border-radius: 12px; margin-bottom: 2rem; border: 1px solid #fecaca;">
                    <ul style="margin: 0; padding-left: 1.5rem; font-size: 0.9rem; font-weight: 500;">
                      @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif

                <form method="POST" action="{{ route('mes-infirmieres.update', $mes_infirmiere) }}">
                    @csrf
                    @method('PUT')
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                        <div>
                            <label class="form-label" style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--slate-500); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em;">Nom Complet</label>
                            <input type="text" name="name" value="{{ old('name', $mes_infirmiere->name) }}" required class="app-form-control">
                        </div>

                        <div>
                            <label class="form-label" style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--slate-500); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em;">Adresse Email</label>
                            <input type="email" name="email" value="{{ old('email', $mes_infirmiere->email) }}" required class="app-form-control">
                        </div>
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label class="form-label" style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--slate-500); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em;">Numéro de téléphone</label>
                        <input type="text" name="phone" value="{{ old('phone', $mes_infirmiere->phone) }}" class="app-form-control">
                    </div>


                    <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border);">
                        <a href="{{ route('mes-infirmieres.index') }}" class="app-btn app-btn-outline">
                            Annuler
                        </a>
                        <button type="submit" class="app-btn app-btn-primary">
                            Mettre à jour le profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        </div>
    </div>
</div>
@endsection
