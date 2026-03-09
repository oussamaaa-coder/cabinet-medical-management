@extends('layouts.sidebar')

@section('title', 'Tableau de bord')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<link rel="stylesheet" href="{{ asset('asset/css/style_dashboard.css') }}">

<div class="content">
    <header class="topbar" style="background: linear-gradient(135deg, #2F6A4F 0%, #418968 100%); padding: 1.5rem 2rem; margin: -1.5rem -1.5rem 2rem -1.5rem; border-radius: 12px 12px 0 0;">
        <div class="topbar-left">
            <div class="topbar-title" style="color: white; font-size: 1.5rem; font-weight: 700;">Tableau de bord</div>
            <div class="breadcrumb" style="color: rgba(255,255,255,0.8); margin-top: 0.25rem;">
                <span style="color: white;">Bienvenue, <strong>{{ auth()->user()->name }}</strong></span>
                <span style="margin: 0 0.5rem; color: rgba(255,255,255,0.5);">•</span>
                <span style="color: rgba(255,255,255,0.8);">{{ \Carbon\Carbon::now()->locale('fr')->translatedFormat('l d F Y') }}</span>
            </div>
        </div>
    </header>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon patients">
                <svg viewbox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Total Patients</h3>
                <p class="value">{{ $totalPatients }}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon doctors">
                <svg viewbox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 4v5a3 3 0 0 0 3 3h0a3 3 0 0 0 3-3V4"/>
                    <path d="M12 12c0 3.5 2.5 6 5.5 6a2.5 2.5 0 0 0 0-5c-1.5 0-2.5 1-2.5 2.5"/>
                    <circle cx="9" cy="3" r="1"/>
                    <circle cx="6" cy="3" r="1"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Médecins</h3>
                <p class="value">{{ $totalDoctors }}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon appointments">
                <svg viewbox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <path d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Total RDV</h3>
                <p class="value">{{ $totalAppointments }}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon today">
                <svg viewbox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <path d="M16 2v4M8 2v4M3 10h18"/>
                    <path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>RDV Aujourd'hui</h3>
                <p class="value">{{ $todayAppointments }}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon week">
                <svg viewbox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 3v18h18"/>
                    <path d="M18 17V9"/>
                    <path d="M13 17V5"/>
                    <path d="M8 17v-3"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>RDV Cette Semaine</h3>
                <p class="value">{{ $weekAppointments }}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon month">
                <svg viewbox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <path d="M16 2v4M8 2v4M3 10h18"/>
                    <path d="M8 14h.01M12 14h.01M16 14h.01"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>RDV Ce Mois</h3>
                <p class="value">{{ $monthAppointments }}</p>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="charts-grid">
        <!-- Appointments Last 7 Days -->
        <div class="chart-card">
            <h3>
                <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 3v18h18"/>
                    <path d="M18 17V9"/>
                    <path d="M13 17V5"/>
                    <path d="M8 17v-3"/>
                </svg>
                RDV des 7 derniers jours
            </h3>
            <canvas id="appointmentsChart" height="300"></canvas>
        </div>
        
        <!-- Appointments by Status -->
        <div class="chart-card">
            <h3>
                <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21.21 15.89A10 10 0 1 1 8 2.83"/>
                    <path d="M22 12A10 10 0 0 0 12 2v10z"/>
                </svg>
                Répartition par statut
            </h3>
            <canvas id="statusChart" height="50"></canvas>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="charts-grid">
        <!-- User Distribution -->
        <div class="chart-card">
            <h3>
                <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Répartition des utilisateurs
            </h3>
            <canvas id="usersChart" height="120"></canvas>
        </div>
        
        <!-- Completion Rate -->
        <div class="chart-card" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
            <h3>
                <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                Taux de complétion ce mois
            </h3>
            <div style="position: relative; width: 120px; height: 120px; margin: 0.5rem 0;">
                <canvas id="completionChart"></canvas>
            </div>
            <div class="percentage-badge" style="font-size: 0.875rem; padding: 0.375rem 0.75rem;">
                <span>{{ $completionRate }}%</span>
            </div>
            <p style="color: #666; margin-top: 0.5rem; text-align: center; font-size: 0.75rem;">
                {{ $completedThisMonth }} / {{ $monthAppointments }}
            </p>
        </div>
    </div>

    <!-- Recent & Upcoming Appointments -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
        <!-- Upcoming Today -->
        <div class="recent-section">
            <h3>
                <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
                RDV à venir aujourd'hui
            </h3>
            @if($upcomingToday->count() > 0)
                @foreach($upcomingToday as $appointment)
                    <div class="appointment-item">
                        <div class="appointment-time">{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</div>
                        <div class="appointment-info">
                            <div class="appointment-patient">{{ $appointment->patient->name ?? 'Patient' }}</div>
                            <div class="appointment-type">{{ $appointment->type }}</div>
                        </div>
                        <span class="appointment-status status-{{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span>
                    </div>
                @endforeach
            @else
                <div class="empty-state">Aucun RDV à venir aujourd'hui</div>
            @endif
        </div>
        
        <!-- Recent Appointments -->
        <div class="recent-section">
            <h3>
                <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
                RDV récents
            </h3>
            @if($recentAppointments->count() > 0)
                @foreach($recentAppointments as $appointment)
                    <div class="appointment-item">
                        <div class="appointment-time">{{ \Carbon\Carbon::parse($appointment->date)->format('d/m') }}</div>
                        <div class="appointment-info">
                            <div class="appointment-patient">{{ $appointment->patient->name ?? 'Patient' }}</div>
                            <div class="appointment-type">{{ $appointment->type }} - {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</div>
                        </div>
                        <span class="appointment-status status-{{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span>
                    </div>
                @endforeach
            @else
                <div class="empty-state">Aucun RDV récent</div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="recent-section">
        <h3>
            <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
            </svg>
            Actions rapides
        </h3>
        <div class="quick-actions">
            <a href="{{ route('appointments.create') }}" class="quick-action-btn">
                <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="16"/>
                    <line x1="8" y1="12" x2="16" y2="12"/>
                </svg>
                Nouveau RDV
            </a>
            <a href="{{ route('patients.create') }}" class="quick-action-btn">
                <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="8.5" cy="7" r="4"/>
                    <line x1="20" y1="8" x2="20" y2="14"/>
                    <line x1="23" y1="11" x2="17" y2="11"/>
                </svg>
                Nouveau Patient
            </a>
            <a href="{{ route('agenda.index') }}" class="quick-action-btn">
                <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <path d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
                Voir l'Agenda
            </a>
            <a href="{{ route('patients.index') }}" class="quick-action-btn">
                <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Liste Patients
            </a>
            <a href="{{ route('prescriptions.create') }}" class="quick-action-btn">
                <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                    <rect x="9" y="3" width="6" height="4" rx="1"/>
                    <path d="M9 12h6M9 16h4"/>
                </svg>
                Nouvelle Ordonnance
            </a>
            <a href="{{ route('chat.index') }}" class="quick-action-btn">
                <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                Discussion
            </a>
        </div>
    </div>
</div>

<script>
    // Appointments Last 7 Days Chart
    const appointmentsCtx = document.getElementById('appointmentsChart').getContext('2d');
    new Chart(appointmentsCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($last7DaysAppointments, 'date')) !!},
            datasets: [{
                label: 'Rendez-vous',
                data: {!! json_encode(array_column($last7DaysAppointments, 'count')) !!},
                backgroundColor: 'rgba(25, 118, 210, 0.8)',
                borderColor: '#1976d2',
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Status Distribution Chart
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
                backgroundColor: [
                    '#1976d2',
                    '#388e3c',
                    '#c62828',
                    '#c2185b'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Users Distribution Chart
    const usersCtx = document.getElementById('usersChart').getContext('2d');
    new Chart(usersCtx, {
        type: 'pie',
        data: {
            labels: ['Administrateurs', 'Médecins', 'Infirmiers', 'Secrétaires'],
            datasets: [{
                data: [
                    {{ $usersByRole['admin'] ?? 0 }},
                    {{ $usersByRole['doctor'] ?? 0 }},
                    {{ $usersByRole['nurse'] ?? 0 }},
                    {{ $usersByRole['secretary'] ?? 0 }}
                ],
                backgroundColor: [
                    '#7b1fa2',
                    '#388e3c',
                    '#f57c00',
                    '#0097a7'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Completion Rate Chart
    const completionCtx = document.getElementById('completionChart').getContext('2d');
    new Chart(completionCtx, {
        type: 'doughnut',
        data: {
            labels: ['Complétés', 'Restants'],
            datasets: [{
                data: [{{ $completedThisMonth }}, {{ $monthAppointments - $completedThisMonth }}],
                backgroundColor: [
                    '#667eea',
                    '#e0e0e0'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            cutout: '70%',
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endsection

