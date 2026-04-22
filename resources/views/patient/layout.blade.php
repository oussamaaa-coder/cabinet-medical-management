<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portail Patient — Cabinet Médical">
    <title>MediCal — @yield('title', 'Mon Espace')</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('asset/img/logo.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/css/style_patient_portal.css') }}">

    <script>
        // Apply theme before paint to avoid flash
        const _t = localStorage.getItem('pt_theme');
        if (_t === 'dark') { document.documentElement.setAttribute('data-theme','dark'); }
        else               { document.documentElement.setAttribute('data-theme','light'); }
    </script>
    @stack('styles')
</head>
<body>

{{-- Mobile Nav --}}
<div class="pt-mobile-nav">
    <div style="display: flex; align-items: center; gap: 10px;">
        <div class="pt-logo-icon" style="width: 32px; height: 32px; border-radius: 8px;">
            <img src="{{ asset('asset/img/logo.svg') }}" alt="Logo" style="width:16px;height:16px;filter:brightness(0) invert(1);">
        </div>
        <span style="font-weight: 700; color: var(--pt-accent); font-family: 'Cormorant Garamond', serif; font-size: 1.1rem;">MediCal</span>
    </div>
    <button id="pt-sidebar-toggle" style="background: transparent; border: 1.5px solid var(--pt-sidebar-border); border-radius: 8px; padding: 6px; color: var(--pt-text-secondary); cursor: pointer;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
    </button>
</div>

<div id="pt-sidebar-overlay" class="pt-sidebar-overlay"></div>

{{-- ══════════════════════════════════════
     SIDEBAR
══════════════════════════════════════ --}}
<aside class="pt-sidebar">

    {{-- Logo --}}
    <div class="pt-logo" style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div class="pt-logo-icon">
                <img src="{{ asset('asset/img/logo.svg') }}" alt="Logo" style="width:24px;height:24px;filter:brightness(0) invert(1);">
            </div>
            <div>
                <div class="pt-logo-text">MediCal</div>
                <div class="pt-logo-sub">Espace Patient</div>
            </div>
        </div>
        <button id="pt-sidebar-close" class="pt-sidebar-close">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    {{-- Navigation --}}
    <nav class="pt-nav">
        <span class="pt-nav-section">Mon Espace</span>

        <a href="{{ route('patient.dashboard') }}"
           class="pt-nav-item {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}">
            <span class="pt-nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            </span>
            <span class="pt-nav-label">Tableau de bord</span>
        </a>

        <a href="{{ route('patient.appointments') }}"
           class="pt-nav-item {{ request()->routeIs('patient.appointments*') ? 'active' : '' }}">
            <span class="pt-nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            </span>
            <span class="pt-nav-label">Mes Rendez-vous</span>
        </a>

        <a href="{{ route('patient.appointments.book') }}"
           class="pt-nav-item {{ request()->routeIs('patient.appointments.book') ? 'active' : '' }}">
            <span class="pt-nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
            </span>
            <span class="pt-nav-label">Prendre un RDV</span>
        </a>

        <span class="pt-nav-section">Santé</span>

        <a href="{{ route('patient.prescriptions') }}"
           class="pt-nav-item {{ request()->routeIs('patient.prescriptions*') ? 'active' : '' }}">
            <span class="pt-nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
            </span>
            <span class="pt-nav-label">Mes Ordonnances</span>
        </a>

        <a href="{{ route('patient.dossier') }}"
           class="pt-nav-item {{ request()->routeIs('patient.dossier') ? 'active' : '' }}">
            <span class="pt-nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
            </span>
            <span class="pt-nav-label">Mon Dossier</span>
        </a>

        <span class="pt-nav-section">Options</span>

        <button id="pt-theme-toggle" class="pt-nav-item" style="width:100%;border:none;background:transparent;cursor:pointer;text-align:left;">
            <span class="pt-nav-icon" id="pt-theme-icon"></span>
            <span class="pt-nav-label" id="pt-theme-text">Mode Sombre</span>
        </button>

    </nav>

    {{-- User footer --}}
    <div class="pt-sidebar-user">
        <div class="pt-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
        <div style="flex:1;overflow:hidden;">
            <div class="pt-user-name">{{ auth()->user()->name }}</div>
            <div class="pt-user-role">Patient</div>
        </div>
        <button class="pt-logout-btn" title="Se déconnecter" onclick="document.getElementById('pt-logout-form').submit();">
            <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
        </button>
        <form id="pt-logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
    </div>

</aside>

{{-- ══════════════════════════════════════
     MAIN CONTENT
══════════════════════════════════════ --}}
<main class="pt-main">
    @yield('content')
</main>

<script>
    // Theme toggle
    const ptToggleBtn     = document.getElementById('pt-theme-toggle');
    const ptIcon          = document.getElementById('pt-theme-icon');
    const ptText          = document.getElementById('pt-theme-text');

    const sunSVG  = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>`;
    const moonSVG = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>`;

    function updateThemeUI() {
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        ptText.textContent = isDark ? 'Mode Clair' : 'Mode Sombre';
        ptIcon.innerHTML   = isDark ? sunSVG : moonSVG;
    }

    ptToggleBtn.addEventListener('click', () => {
        const cur  = document.documentElement.getAttribute('data-theme');
        const next = cur === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', next);
        localStorage.setItem('pt_theme', next);
        updateThemeUI();
    });

    updateThemeUI();

    // Mobile Sidebar Logic
    const ptSidebar       = document.querySelector('.pt-sidebar');
    const ptOverlay       = document.getElementById('pt-sidebar-overlay');
    const ptToggle        = document.getElementById('pt-sidebar-toggle');
    const ptClose         = document.getElementById('pt-sidebar-close');

    if (ptSidebar && ptOverlay) {
        const openPT = () => {
            ptSidebar.classList.add('active');
            ptOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        };
        const closePT = () => {
            ptSidebar.classList.remove('active');
            ptOverlay.classList.remove('active');
            document.body.style.overflow = '';
        };

        if (ptToggle) ptToggle.addEventListener('click', openPT);
        if (ptClose)  ptClose.addEventListener('click', closePT);
        ptOverlay.addEventListener('click', closePT);
    }
</script>
@stack('scripts')
</body>
</html>
