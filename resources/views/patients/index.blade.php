<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{ asset('asset/css/style_patient.css') }}">
        <link
            href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap"
            rel="stylesheet">
        <title>Dashboard Patients</title>
    </head>
    <body>
        @extends('layouts.sidebar') @section('content')
        <div class="topbar">
            <div class="breadcrumb">
                <a href="{{ route('patients.index') }}">Patients</a>
                <span class="sep">›</span>
            </div>

            <a href="{{ route('patients.create') }}" class="btn-new">
                <svg viewbox="0 0 24 24">
                    <path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <line x1="19" y1="8" x2="19" y2="14"/>
                    <line x1="16" y1="11" x2="22" y2="11"/>
                </svg>
                Nouvel utilisateur
            </a>
        </div>

        <h3>Filtres rapides</h3>

        <!-- 3 CARDS SÉPARÉES -->
        <div class="filters">

            <!-- Card 1 : Total Patients -->
            <div class="stat-card">
                <div class="card_icon">
                    <svg viewbox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                    </svg>
                </div>
                <a href="{{ route('patients.dashboardPatient.listAll') }}" class="card_info">
                    <div class="card_info">
                        <div class="card_value">{{ $totalPatients }}</div>
                        <div class="card_label">Total Patients</div>
                    </div>
                </a>


            </div>

            <!-- Card 2 : Planifiés aujourd'hui -->
            <div class="stat-card">
                <div class="card_icon">
                    <svg viewbox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                        <path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01"/>
                    </svg>
                </div>
                <div class="card_info">
                    <div class="card_value">{{ $patientsPlannedToday }}</div>
                    <div class="card_label">Planifiés aujourd'hui</div>
                </div>
            </div>

            <!-- Card 3 : Consultés aujourd'hui -->
            <div class="stat-card">
                <div class="card_icon">
                    <svg viewbox="0 0 24 24">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <div class="card_info">
                    <div class="card_value">{{ $patientsConsultedToday }}</div>
                    <div class="card_label">Consultés aujourd'hui</div>
                </div>
            </div>

        </div>

        @endsection
    </body>
</html>

