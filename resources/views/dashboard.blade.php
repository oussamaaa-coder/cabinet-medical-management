@extends('layouts.sidebar')

@section('title', 'Tableau de bord')

@section('content')
<link rel="stylesheet" href="{{ asset('asset/css/style_dashboard.css') }}">

<div class="content">
    <header class="topbar">
        <div class="topbar-left">
            <div class="topbar-title">Tableau de bord</div>
            <div class="breadcrumb">
                <span>Bienvenue, <strong>{{ auth()->user()->name }}</strong></span>
                <span class="sep">•</span>
                <span>{{ \Carbon\Carbon::now()->locale('fr')->translatedFormat('l d F Y') }}</span>
            </div>
        </div>
    </header>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Total Patients</h3>
                <p class="value">{{ $totalPatients }}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 4v5a3 3 0 0 0 3 3h0a3 3 0 0 0 3-3V4"/>
                    <path d="M12 12c0 3.5 2.5 6 5.5 6a2.5 2.5 0 0 0 0-5c-1.5 0-2.5 1-2.5 2.5"/>
                    <circle cx="9" cy="3" r="1"/><circle cx="6" cy="3" r="1"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Médecins</h3>
                <p class="value">{{ $totalDoctors }}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Total RDV</h3>
                <p class="value">{{ $totalAppointments }}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                    <path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>RDV Aujourd'hui</h3>
                <p class="value">{{ $todayAppointments }}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>RDV Cette Semaine</h3>
                <p class="value">{{ $weekAppointments }}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                    <path d="M8 14h.01M12 14h.01M16 14h.01"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>RDV Ce Mois</h3>
                <p class="value">{{ $monthAppointments }}</p>
            </div>
        </div>
    </div>

    <!-- Main Activity Chart -->
    <div class="charts-grid">
        <div class="chart-card">
            <h3>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/>
                </svg>
                RDV des 7 derniers jours
            </h3>
            <div style="flex-grow: 1; min-height: 0;">
                <canvas id="appointmentsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Distribution Charts Row (Organigrammes) -->
    <div class="distribution-grid">
        <!-- Status -->
        <div class="chart-card">
            <h3>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/>
                </svg>
                Répartition par statut
            </h3>
            <div style="flex-grow: 1; display: flex; align-items: center; justify-content: center; min-height: 0;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Users -->
        <div class="chart-card">
            <h3>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                </svg>
                Répartition utilisateurs
            </h3>
            <div style="flex-grow: 1; display: flex; align-items: center; justify-content: center; min-height: 0;">
                <canvas id="usersChart"></canvas>
            </div>
        </div>
        
        <!-- Completion -->
        <div class="chart-card">
            <h3>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                Objectif mensuel
            </h3>
            <div style="flex-grow: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 0;">
                <div style="position: relative; width: 90px; height: 90px; margin-bottom: 0.25rem;">
                    <canvas id="completionChart"></canvas>
                    <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 800; color: var(--accent);">
                        {{ $completionRate }}%
                    </div>
                </div>
                <p style="color: var(--text-muted); font-size: 0.65rem; font-weight: 700; text-align: center;">
                    {{ $completedThisMonth }}/{{ $monthAppointments }}
                </p>
            </div>
        </div>
    </div>

    <!-- Appointments Lists -->
    <div class="appointments-activity-grid">
        <div class="recent-section">
            <h3>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
                RDV à venir aujourd'hui
            </h3>
            @forelse($upcomingToday as $appointment)
                <div class="appointment-item">
                    <div class="appointment-time">{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</div>
                    <div class="appointment-info">
                        <div class="appointment-patient">{{ $appointment->patient->name ?? 'Patient' }}</div>
                        <div class="appointment-type text-emerald-600">
                            {{ $appointment->type }} — 
                            <span style="font-weight: 500; font-size: 0.8rem; color: var(--text-secondary);">Dr. {{ $appointment->doctor->last_name ?? 'Expert' }}</span>
                        </div>
                    </div>
                    <span class="appointment-status status-{{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span>
                </div>
            @empty
                <div style="text-align: center; padding: 2rem; color: var(--text-light); font-style: italic;">Aucun RDV à venir aujourd'hui</div>
            @endforelse
        </div>
        
        <div class="recent-section">
            <h3>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
                RDV récents
            </h3>
            @forelse($recentAppointments as $appointment)
                <div class="appointment-item">
                    <div class="appointment-time">{{ \Carbon\Carbon::parse($appointment->date)->format('d/m') }}</div>
                    <div class="appointment-info">
                        <div class="appointment-patient">{{ $appointment->patient->name ?? 'Patient' }}</div>
                        <div class="appointment-type">
                            {{ $appointment->type }} - {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} — 
                            <span style="font-weight: 500; font-size: 0.8rem; color: var(--text-secondary);">Dr. {{ $appointment->doctor->last_name ?? 'Expert' }}</span>
                        </div>
                    </div>
                    <span class="appointment-status status-{{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span>
                </div>
            @empty
                <div style="text-align: center; padding: 2rem; color: var(--text-light); font-style: italic;">Aucun RDV récent</div>
            @endforelse
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="recent-section">
        <h3>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
            </svg>
            Actions rapides
        </h3>
        <div class="quick-actions">
            <a href="{{ route('appointments.create') }}" class="quick-action-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/>
                </svg>
                <span>Nouveau RDV</span>
            </a>
            <a href="{{ route('patients.create') }}" class="quick-action-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>
                </svg>
                <span>Nouveau Patient</span>
            </a>
            <a href="{{ route('agenda.index') }}" class="quick-action-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
                <span>Voir l'Agenda</span>
            </a>
            <a href="{{ route('patients.index') }}" class="quick-action-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                <span>Liste Patients</span>
            </a>
            <a href="{{ route('prescriptions.create') }}" class="quick-action-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><path d="M9 12h6M9 16h4"/>
                </svg>
                <span>Nouvelle Ordonnance</span>
            </a>
            <a href="{{ route('chat.index') }}" class="quick-action-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                <span>Discussion</span>
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.color = '#6b8c7d';
    
    const medOxGreen = '#3a7d5c';

    // Appointments Last 7 Days
    const appointmentsCtx = document.getElementById('appointmentsChart').getContext('2d');
    new Chart(appointmentsCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($last7DaysAppointments, 'date')) !!},
            datasets: [{
                label: 'Rendez-vous',
                data: {!! json_encode(array_column($last7DaysAppointments, 'count')) !!},
                backgroundColor: medOxGreen,
                borderRadius: 4,
                barThickness: 24
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f0f3f1' }, ticks: { font: { size: 10 } } },
                x: { ticks: { font: { size: 10 } } }
            }
        }
    });

    // Status Distribution
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Planifié', 'Complété', 'Annulé', 'Urgent'],
            datasets: [{
                data: [
                    {{ $appointmentsByStatus['planned'] ?? 0 }},
                    {{ $appointmentsByStatus['completed'] ?? 0 }},
                    {{ $appointmentsByStatus['cancelled'] ?? 0 }},
                    {{ $appointmentsByStatus['urgent'] ?? 0 }}
                ],
                backgroundColor: [ '#3b82f6', medOxGreen, '#cc2d2d', '#c2185b' ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'right', labels: { boxWidth: 8, font: { size: 9 } } } }
        }
    });

    // Users Distribution
    const usersCtx = document.getElementById('usersChart').getContext('2d');
    new Chart(usersCtx, {
        type: 'pie',
        data: {
            labels: ['Admin', 'Doc', 'Inf', 'Sec'],
            datasets: [{
                data: [
                    {{ $usersByRole['admin'] ?? 0 }},
                    {{ $usersByRole['doctor'] ?? 0 }},
                    {{ $usersByRole['nurse'] ?? 0 }},
                    {{ $usersByRole['secretary'] ?? 0 }}
                ],
                backgroundColor: [ '#7b1fa2', medOxGreen, '#f57c00', '#0097a7' ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'right', labels: { boxWidth: 8, font: { size: 9 } } } }
        }
    });

    // Completion Rate
    const completionCtx = document.getElementById('completionChart').getContext('2d');
    new Chart(completionCtx, {
        type: 'doughnut',
        data: {
            labels: ['Complétés', 'Restants'],
            datasets: [{
                data: [{{ $completedThisMonth }}, {{ max(0, $monthAppointments - $completedThisMonth) }}],
                backgroundColor: [ medOxGreen, '#e2e8f0' ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '80%',
            plugins: { legend: { display: false } }
        }
    });
</script>
@endsection
