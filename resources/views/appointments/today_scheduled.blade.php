@extends('layouts.sidebar')

@section('content')
<div class="topbar">
    <div class="breadcrumb">
        <a href="{{ route('patients.index') }}">Patients</a>
        <span class="sep">›</span>
        <span>Planifiés aujourd'hui</span>
    </div>
</div>

<div class="appointments-container">
    <div class="table-header">
        <h3>Rendez-vous planifiés pour aujourd'hui</h3>
    </div>
    
    <div style="overflow-x: auto;">
        <table class="appointments-table">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Médecin</th>
                    <th>Heure</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                <tr>
                    <td class="font-medium text-primary">{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</td>
                    <td>Dr. {{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</td>
                    <td>
                        <span class="status-badge {{ $appointment->status }}">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="empty-message">Aucun rendez-vous planifié pour aujourd'hui.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    :root {
      --accent:         #3a7d5c;
      --accent-light:   #eaf3ee;
      --accent-mid:     #c4ddd0;
      --accent-glow:    rgba(58,125,92,.15);
      --accent-dark:    #2a6048;
      --text-primary:   #1a2b22;
      --text-secondary: #4a6358;
      --text-muted:     #8aad9c;
      --border:         #dce8e1;
      --bg-field:       #f4f7f5;
      --bg-card:        #ffffff;
      --ease:           cubic-bezier(.4,0,.2,1);
    }

    [data-theme="dark"] {
      --text-primary:   #e2ede7;
      --text-secondary: #9fbfb0;
      --text-muted:     #5a7d6e;
      --border:         rgba(255, 255, 255, 0.1);
      --bg-field:       #151e1a;
      --bg-card:        #1a2620;
      --accent-light:   #1a2d23;
    }

    .appointments-container {
        margin-top: 30px;
        background: var(--bg-card);
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        border: 1px solid var(--border);
    }

    .table-header h3 {
        margin: 0 0 20px 0;
        color: var(--text-primary);
        font-size: 1.25rem;
    }

    .appointments-table {
        width: 100%;
        text-align: left;
        border-collapse: collapse;
        min-width: 600px;
    }

    .appointments-table th {
        background-color: var(--bg-field);
        color: var(--text-muted);
        font-weight: 600;
        padding: 14px 16px;
        border-bottom: 1px solid var(--border);
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.05em;
    }

    .appointments-table td {
        padding: 16px;
        border-bottom: 1px solid var(--border);
        color: var(--text-secondary);
        vertical-align: middle;
    }

    .font-medium { font-weight: 500; }
    .text-primary { color: var(--text-primary); }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .status-badge.planned { background: var(--accent-light); color: var(--accent); }
    .status-badge.urgent { background: #fee2e2; color: #ef4444; }

    .empty-message {
        text-align: center;
        color: var(--text-muted);
        padding: 40px !important;
    }

    .topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .breadcrumb a {
        color: var(--accent);
        text-decoration: none;
    }

    .breadcrumb .sep {
        color: var(--border);
    }
</style>
@endsection
