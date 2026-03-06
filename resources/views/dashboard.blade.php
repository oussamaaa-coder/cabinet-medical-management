@extends('layouts.sidebar')

@section('title', 'Tableau de bord')

@section('content')
<div class="content">
    <header class="topbar">
        <div class="topbar-left">
            <div class="topbar-title">Tableau de bord</div>
            <div class="breadcrumb">
                <span>Bienvenue, {{ auth()->user()->name }}</span>
            </div>
        </div>
    </header>

    <div class="card" style="margin-top: 2rem; padding: 2rem;">
        <h2>Bienvenue sur votre espace MediCal</h2>
        <p>Sélectionnez une option dans le menu pour commencer.</p>
    </div>
</div>
@endsection
