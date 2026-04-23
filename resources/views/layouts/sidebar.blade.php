<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{ asset('asset/css/style_sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('asset/css/style_global.css') }}">
        <link rel="stylesheet" href="{{ asset('asset/css/style_transitions.css') }}">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
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
        <script>
            // On page load, apply theme immediately from localStorage
            // Default to 'light' instead of checking browser preference
            const storedTheme = localStorage.getItem('theme');
            if (storedTheme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
                document.documentElement.classList.remove('dark');
            }
        </script>
        <title>MediCal — @yield('title', 'Tableau de bord')</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');
            @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
            
            body {
                font-family: 'Plus Jakarta Sans', 'Outfit', sans-serif;
            }
        </style>
        @stack('styles')
    </head>
    <body class="is-transitioning">
        {{-- Mobile Header --}}
        <div class="mobile-top-nav lg:hidden flex items-center justify-between px-4 py-3 bg-white border-b sticky top-0 z-[80] shadow-sm">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-emerald-500 flex items-center justify-center">
                    <img src="{{ asset('asset/img/logo.svg') }}" alt="Logo" style="width:16px;height:16px;filter:brightness(0) invert(1);">
                </div>
                <span class="font-bold text-emerald-600 font-serif">MediCal</span>
            </div>
            <button id="sidebar-toggle-btn" class="p-2 rounded-lg bg-slate-50 text-slate-600 border">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </div>

        <div id="sidebar-overlay" class="sidebar-overlay lg:hidden"></div>
        {{-- Overlay de transition --}}
        <div id="page-transition-overlay">
            <div class="transition-logo">
                <div class="logo-icon-svg">
                    <img src="{{ asset('asset/img/logo.svg') }}" alt="Logo" style="width:80px;height:80px;">
                </div>
                <div class="logo-text" style="color: #3A7D5C">MediCal</div>
            </div>
        </div>

        <aside class="sidebar">

            {{-- ── LOGO ── --}}
            <div class="sidebar-logo flex items-center justify-between">
                <div class="logo-mark flex items-center gap-3">
                    <div class="logo-icon">
                        <img src="{{ asset('asset/img/logo.svg') }}" alt="Logo" style="width:24px;height:24px;filter:brightness(0) invert(1);">
                    </div>
                    <div>
                        <div class="logo-text" style="color: #3A7D5C">MediCal</div>
                        <div class="logo-sub">Gestion de Rendez-vous</div>
                    </div>
                </div>
                {{-- Close button for mobile inside sidebar --}}
                <button id="sidebar-close-btn" class="lg:hidden p-2 text-slate-400 hover:text-emerald-500 transition-colors">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
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
                    @if($todayAppointmentsCount > 0)
                        <span class="nav-badge">{{ $todayAppointmentsCount }}</span>
                    @endif
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
                @if(auth()->check() && auth()->user()->role === 'admin')
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
                @endif

                @if(auth()->check() && auth()->user()->role === 'doctor')
                <a
                    href="{{ route('mes-infirmieres.index') }}"
                    class="nav-item {{ request()->is('mes-infirmieres*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"/>
                            <line x1="5" y1="12" x2="19" y2="12"/>
                            <circle cx="12" cy="12" r="10"/>
                        </svg>
                    </span>
                    <span class="nav-label">Mes infirmières</span>
                </a>
                @endif

                <span class="nav-section-label">Gestion</span>

                

                <a
                    href="{{ route('prescriptions.index') }}"
                    class="nav-item {{ request()->is('prescriptions*') ? 'active' : '' }}">
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
                    class="nav-item {{ request()->is('dossiers*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/>
                        </svg>
                    </span>
                    <span class="nav-label">Dossiers</span>
                </a>

                <a
                    href="{{ route('chat.index') }}"
                    class="nav-item {{ request()->is('chat*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
                        </svg>
                    </span>
                    <span class="nav-label">Discussion Groupe</span>
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
                    href="{{ route('settings.index') }}"
                    class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
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
                    href="{{ route('profile.edit') }}"
                    class="nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </span>
                    <span class="nav-label">Mon Profil</span>
                </a>

                <a
                    href="{{ route('help.index') }}"
                    class="nav-item {{ request()->routeIs('help.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3M12 17h.01"/>
                        </svg>
                    </span>
                    <span class="nav-label">Aide</span>
                </a>

                <button
                    id="theme-toggle"
                    class="nav-item"
                    style="width: 100%; border: none; background: transparent; cursor: pointer; text-align: left;">
                    <span class="nav-icon" id="theme-icon">
                        <!-- Sun/Moon icon will be set via JS -->
                    </span>
                    <span class="nav-label" id="theme-text">Mode Sombre</span>
                </button>

            </nav>

            {{-- ── UTILISATEUR ── --}}
            <div class="sidebar-user" onclick="window.location.href='{{ route('profile.edit') }}'" style="cursor: pointer;">
                @if(auth()->user()->profile_photo)
                    <img src="{{ asset('profiles/' . auth()->user()->profile_photo) }}" alt="Avatar" class="user-avatar" style="object-fit: cover;">
                @else
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                @endif
                <div class="user-info">
                    <div class="user-name" style="color: #3A7D5C">{{ auth()->user()->name }}</div>
                    <div class="user-role" style="color: #3A7D5C">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
                <div class="user-action" title="Se déconnecter" onclick="event.stopPropagation(); document.getElementById('logout-form').submit();">
                    <svg viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/>
                    </svg>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>

        </aside>

        <div class="main-content">
            @yield('content')
        </div>

        <script>
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeIcon = document.getElementById('theme-icon');
            const themeText = document.getElementById('theme-text');

            function updateToggleUI() {
                const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
                themeText.textContent = isDark ? 'Mode Clair' : 'Mode Sombre';
                themeIcon.innerHTML = isDark 
                    ? `<svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>`
                    : `<svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>`;
            }

            themeToggleBtn.addEventListener('click', () => {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                document.documentElement.setAttribute('data-theme', newTheme);
                if (newTheme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
                localStorage.setItem('theme', newTheme);
                updateToggleUI();
            });

            // Initial UI state
            updateToggleUI();

            // Mobile Sidebar Toggle
            const sidebarToggle = document.getElementById('sidebar-toggle-btn');
            const sidebarClose = document.getElementById('sidebar-close-btn');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const sidebar = document.querySelector('.sidebar');

            if (sidebar && sidebarOverlay) {
                const openSidebar = () => {
                    sidebar.classList.add('active');
                    sidebarOverlay.classList.add('active');
                    document.body.style.overflow = 'hidden';
                };

                const closeSidebar = () => {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                };

                if (sidebarToggle) sidebarToggle.addEventListener('click', openSidebar);
                if (sidebarClose) sidebarClose.addEventListener('click', closeSidebar);
                sidebarOverlay.addEventListener('click', closeSidebar);
            }
        </script>
        <script src="{{ asset('asset/js/transitions.js') }}"></script>
        @stack('scripts')
    </body>
</html>
