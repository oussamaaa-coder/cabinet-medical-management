<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{ asset('asset/css/style_sidebar.css') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link
            rel="preconnect"
            href="https://fonts.gstatic.com"
            crossorigin="crossorigin">
        <link
            href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
            <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <title>MediCal — @yield('title', 'Tableau de bord')</title>
    </head>
    <body>

        <aside class="sidebar">

            {{-- ── LOGO ── --}}
            <div class="sidebar-logo">
                <div class="logo-mark">
                    <div class="logo-icon">
                        <svg
                            width="18"
                            height="18"
                            viewbox="0 0 18 18"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect
                                x="7"
                                y="2"
                                width="4"
                                height="14"
                                rx="1.5"
                                fill="white"
                                fill-opacity="0.9"/>
                            <rect
                                x="2"
                                y="7"
                                width="14"
                                height="4"
                                rx="1.5"
                                fill="white"
                                fill-opacity="0.9"/>
                        </svg>
                    </div>
                    <div>
                        <div class="logo-text" style="color: #3A7D5C">MediCal</div>
                        <div class="logo-sub">Gestion de Rendez-vous</div>
                    </div>
                </div>
            </div>

            {{-- ── NAVIGATION ── --}}
            <nav class="sidebar-nav">

                <span class="nav-section-label">Principal</span>

                <a
                    href="{{ url('/dashboard') }}"
                    class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z"/>
                            <path d="M9 21V12h6v9"/>
                        </svg>
                    </span>
                    <span class="nav-label">Tableau de bord</span>
                </a>

                <a
                    href="{{ url('/agenda') }}"
                    class="nav-item {{ request()->is('agenda') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <path d="M16 2v4M8 2v4M3 10h18"/>
                        </svg>
                    </span>
                    <span class="nav-label">Agenda</span>
                    <span class="nav-badge">8</span>
                </a>

                <a
                    href="{{ url('/patients') }}"
                    class="nav-item {{ request()->is('patients') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                        </svg>
                    </span>
                    <span class="nav-label">Patients</span>
                </a>
                <a
                    href="{{ url('/doctors') }}"
                    class="nav-item {{ request()->is('doctors') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg
                            viewbox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.6"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M6 4v5a3 3 0 0 0 3 3h0a3 3 0 0 0 3-3V4"/>
                            <path d="M12 12c0 3.5 2.5 6 5.5 6a2.5 2.5 0 0 0 0-5c-1.5 0-2.5 1-2.5 2.5"/>
                            <circle cx="9" cy="3" r="1"/>
                            <circle cx="6" cy="3" r="1"/>
                            <circle cx="17.5" cy="15.5" r="1.5" fill="currentColor" opacity="0.2"/>
                        </svg>
                    </span>
                    <span class="nav-label">Médecins</span>
                </a>

                <span class="nav-section-label">Gestion</span>

                <a
                    href="{{ url('/appointments/create') }}"
                    class="nav-item {{ request()->is('appointments/create') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 8v8M8 12h8"/>
                        </svg>
                    </span>
                    <span class="nav-label">Nouveau RDV</span>
                </a>

                <a
                    href="{{ url('/ordonnances') }}"
                    class="nav-item {{ request()->is('ordonnances') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                            <rect x="9" y="3" width="6" height="4" rx="1"/>
                            <path d="M9 12h6M9 16h4"/>
                        </svg>
                    </span>
                    <span class="nav-label">Ordonnances</span>
                </a>

                <a
                    href="{{ url('/dossiers') }}"
                    class="nav-item {{ request()->is('dossiers') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/>
                        </svg>
                    </span>
                    <span class="nav-label">Dossiers</span>
                </a>

                <a
                    href="{{ url('/messages') }}"
                    class="nav-item {{ request()->is('messages') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
                        </svg>
                    </span>
                    <span class="nav-label">Messages</span>
                    <span class="nav-badge warn">3</span>
                </a>

                @if(auth()->check() && auth()->user()->role === 'admin')
                <span class="nav-section-label">Admin</span>

                <a
                    href="{{ route('utilisateurs.index') }}"
                    class="nav-item {{ request()->is('utilisateurs*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </span>
                    <span class="nav-label">Gestion des Utilisateurs</span>
                </a>
                @endif

                <span class="nav-section-label">Paramètres</span>

                <a
                    href="{{ url('/settings') }}"
                    class="nav-item {{ request()->is('settings') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="3"/>
                            <path
                                d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/>
                        </svg>
                    </span>
                    <span class="nav-label">Configuration</span>
                </a>

                <a
                    href="{{ url('/help') }}"
                    class="nav-item {{ request()->is('help') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3M12 17h.01"/>
                        </svg>
                    </span>
                    <span class="nav-label">Aide</span>
                </a>

            </nav>

            {{-- ── UTILISATEUR ── --}}
            <div class="sidebar-user">
                <div class="user-avatar">DR</div>
                <div class="user-info">
                    <div class="user-name" style="color: #3A7D5C">Dr. Rachida Alaoui</div>
                    <div class="user-role" style="color: #3A7D5C">Médecin Généraliste</div>
                </div>
                <div class="user-action" title="Se déconnecter">
                    <svg viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/>
                    </svg>
                </div>
            </div>

        </aside>

        <div class="main-content">
            @yield('content')
        </div>

    </body>
</html>
