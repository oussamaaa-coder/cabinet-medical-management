@extends('layouts.sidebar')

@section('title', 'Liste des Patients')

@section('content')
<link rel="stylesheet" href="{{ asset('asset/css/style_patient.css') }}">
<style>
    .list-container { padding: 20px; }
    .patient-table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
    .patient-table th, .patient-table td { padding: 15px; text-align: left; border-bottom: 1px solid #f3f4f6; }
    .patient-table th { background: #f9fafb; font-weight: 600; color: #374151; }
    .status-badge { padding: 4px 8px; border-radius: 9999px; font-size: 12px; font-weight: 500; }
    .status-majeur { background: #dcfce7; color: #166534; }
    .status-mineur { background: #fef9c3; color: #854d0e; }
    .action-btns { display: flex; gap: 8px; }
    .btn-icon { padding: 6px; border-radius: 6px; border: 1px solid #e5e7eb; background: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none; }
    .btn-view { color: #2563eb; }
    .btn-edit { color: #d97706; }
</style>

<div class="list-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 style="font-size: 24px; font-weight: 700; color: #111827;">Registre des Patients</h2>
        <a href="{{ route('patients.create') }}" class="btn-new" style="background: #2563eb; color: #fff; padding: 10px 20px; border-radius: 8px; text-decoration: none; display: flex; align-items: center; gap: 8px;">
             <span>Nouveau Patient</span>
        </a>
    </div>

    <table class="patient-table">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Type</th>
                <th>Sexe</th>
                <th>Téléphone</th>
                <th>Date d'ajout</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: #f3f4f6; border-radius: 50%; overflow: hidden;">
                            @if($patient->photo)
                                <img src="{{ asset($patient->photo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #9ca3af;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px;"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <div style="font-weight: 600; color: #111827;">{{ $patient->first_name }} {{ $patient->last_name }}</div>
                            <div style="font-size: 13px; color: #6b7280;">{{ $patient->cin ?? 'N/A' }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="status-badge {{ $patient->is_majeur ? 'status-majeur' : 'status-mineur' }}">
                        {{ $patient->is_majeur ? 'Majeur' : 'Mineur' }}
                    </span>
                </td>
                <td>{{ $patient->gender == 'male' ? 'Masculin' : 'Féminin' }}</td>
                <td>{{ $patient->is_majeur ? $patient->phone : $patient->phone_responsable }}</td>
                <td>{{ $patient->created_at->format('d/m/Y') }}</td>
                <td>
                    <div class="action-btns">
                        <a href="{{ route('patients.show', $patient->id) }}" class="btn-icon btn-view" title="Voir details">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </a>
                        <a href="{{ route('patients.edit', $patient->id) }}" class="btn-icon btn-edit" title="Modifier">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px;"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </a>
                        <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" onsubmit="return confirm('Supprimer ce patient ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon" style="color: #ef4444;" title="Supprimer">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
