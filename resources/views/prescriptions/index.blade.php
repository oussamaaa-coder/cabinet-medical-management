@extends('layouts.sidebar')

@section('title', 'Gestion des Ordonnances')

@section('content')
<link rel="stylesheet" href="{{ asset('asset/css/style_patient.css') }}">
    <style>
    :root {
        --text-primary: #111827;
        --text-secondary: #374151;
        --text-muted: #6b7280;
        --bg-card: #ffffff;
        --bg-page: #f9fafb;
        --border: #f3f4f6;
        --border-strong: #e5e7eb;
        --accent: #3A7D5C;
    }

    [data-theme="dark"] {
        --text-primary: #e2ede7;
        --text-secondary: #9fbfb0;
        --text-muted: #5a7d6e;
        --bg-card: #1a2620;
        --bg-page: #0f1a14;
        --border: rgba(255, 255, 255, 0.1);
        --border-strong: rgba(255, 255, 255, 0.15);
    }

    .list-container { padding: 20px; }
    .prescription-table { width: 100%; border-collapse: collapse; background: var(--bg-card); border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
    .prescription-table th, .prescription-table td { padding: 15px; text-align: left; border-bottom: 1px solid var(--border); }
    .prescription-table th { background: var(--bg-page); font-weight: 600; color: var(--text-secondary); }
    .action-btns { display: flex; gap: 8px; }
    .btn-icon { padding: 6px; border-radius: 6px; border: 1px solid var(--border-strong); background: var(--bg-card); cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none; }
    .section-title { font-size: 24px; font-weight: 700; color: var(--text-primary); }
    .patient-name { font-weight: 600; color: var(--text-primary); }
    </style>

<div class="list-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 class="section-title">Registre des Ordonnances</h2>
        <a href="{{ route('prescriptions.create') }}" class="btn-new" style="background: #3A7D5C; color: #fff; padding: 10px 20px; border-radius: 8px; text-decoration: none; display: flex; align-items: center; gap: 8px;">
             <span>Nouvelle Ordonnance</span>
        </a>
    </div>

    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 12px 18px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 500;">
            {{ session('success') }}
        </div>
    @endif

    <table class="prescription-table">
        <thead>
            <tr>
                <th>N°</th>
                <th>Patient</th>
                <th>Médecin</th>
                <th>Date</th>
                <th>Médicaments</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prescriptions as $prescription)
            <tr>
                <td>#ORD-{{ str_pad($prescription->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td>
                    <div class="patient-name">{{ $prescription->patient->first_name }} {{ $prescription->patient->last_name }}</div>
                </td>
                <td>Dr. {{ $prescription->doctor->name }}</td>
                <td>{{ \Carbon\Carbon::parse($prescription->prescription_date)->format('d/m/Y') }}</td>
                <td>{{ $prescription->items->count() }} article(s)</td>
                <td>
                    <div class="action-btns">
                        <a href="{{ route('prescriptions.show', $prescription->id) }}" class="btn-icon" style="color: #2563eb;" title="Voir">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </a>
                        <a href="{{ route('prescriptions.print', $prescription->id) }}" target="_blank" class="btn-icon" style="color: #16a34a;" title="Imprimer">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px;"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
