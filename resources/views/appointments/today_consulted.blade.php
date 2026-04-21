@extends('layouts.sidebar')

@section('content')
<div class="appointments-page-wrapper">
    <div class="app-topbar">
        <div class="app-breadcrumb">
            <a href="{{ route('patients.index') }}">Patients</a>
            <span class="sep">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </span>
            <span class="current">Consultés aujourd'hui</span>
        </div>
    </div>

    <div class="app-card">
        <div class="app-section-title">
            <h3>Patients consultés aujourd'hui</h3>
        </div>

        <div class="app-table-wrapper">
            <table class="app-table">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Médecin</th>
                        <th>Heure</th>
                        <th style="text-align: right;">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px; font-weight: 600; color: var(--text-primary);">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #e0f2fe; color: #0369a1; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700;">{{ strtoupper(substr($appointment->patient->first_name, 0, 1) . substr($appointment->patient->last_name, 0, 1)) }}</div>
                                    <span>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</span>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="font-size: 0.85rem; padding: 4px 10px; background: #fff5eb; color: #9a3412; border-radius: 6px; font-weight: 600;">Dr. {{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}</span>
                                </div>
                            </td>
                            <td><span style="font-weight: 600; color: var(--text-primary);">{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</span></td>
                            <td style="text-align: right;">
                                <span class="badge app-badge" style="background: #f0f9ff; color: #0284c7;">
                                    Consulté
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 48px; color: var(--text-muted); font-style: italic;">Aucun patient n'a été consulté aujourd'hui.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection