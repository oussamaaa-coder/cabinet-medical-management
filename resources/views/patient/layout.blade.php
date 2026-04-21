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

{{-- ══════════════════════════════════════
     SIDEBAR
══════════════════════════════════════ --}}
<aside class="pt-sidebar">

    {{-- Logo --}}
    <div class="pt-logo">
        <div class="pt-logo-icon">
            <svg viewBox="0 0 24 24"><rect x="7" y="2" width="4" height="14" rx="1.5" fill="white"/><rect x="2" y="7" width="14" height="4" rx="1.5" fill="white"/></svg>
        </div>
        <div>
            <div class="pt-logo-text">MediCal</div>
            <div class="pt-logo-sub">Espace Patient</div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="pt-nav">
        <span class="pt-nav-section">Mon Espace</span>

        <a href="{{ route('patient.dashboard') }}"
           class="pt-nav-item {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}">
            <span class="pt-nav-icon">
                <svg viewBox="0 0 24 24"><path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z"/><path d="M9 21V12h6v9"/></svg>
            </span>
            <span class="pt-nav-label">Tableau de bord</span>
        </a>

        <a href="{{ route('patient.appointments') }}"
           class="pt-nav-item {{ request()->routeIs('patient.appointments*') ? 'active' : '' }}">
            <span class="pt-nav-icon">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            </span>
            <span class="pt-nav-label">Mes Rendez-vous</span>
        </a>

        <a href="{{ route('patient.appointments.book') }}"
           class="pt-nav-item {{ request()->routeIs('patient.appointments.book') ? 'active' : '' }}">
            <span class="pt-nav-icon">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 8v8M8 12h8"/></svg>
            </span>
            <span class="pt-nav-label">Prendre un RDV</span>
        </a>

        <span class="pt-nav-section">Santé</span>

        <a href="{{ route('patient.prescriptions') }}"
           class="pt-nav-item {{ request()->routeIs('patient.prescriptions*') ? 'active' : '' }}">
            <span class="pt-nav-icon">
                <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><path d="M9 12h6M9 16h4"/></svg>
            </span>
            <span class="pt-nav-label">Mes Ordonnances</span>
        </a>

        <a href="{{ route('patient.dossier') }}"
           class="pt-nav-item {{ request()->routeIs('patient.dossier') ? 'active' : '' }}">
            <span class="pt-nav-icon">
                <svg viewBox="0 0 24 24"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
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
    const ptToggle = document.getElementById('pt-theme-toggle');
    const ptIcon   = document.getElementById('pt-theme-icon');
    const ptText   = document.getElementById('pt-theme-text');

    const sunSVG  = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>`;
    const moonSVG = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>`;

    function updateThemeUI() {
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        ptText.textContent = isDark ? 'Mode Clair' : 'Mode Sombre';
        ptIcon.innerHTML   = isDark ? sunSVG : moonSVG;
    }

    ptToggle.addEventListener('click', () => {
        const cur  = document.documentElement.getAttribute('data-theme');
        const next = cur === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', next);
        localStorage.setItem('pt_theme', next);
        updateThemeUI();
    });

    updateThemeUI();
</script>
@stack('scripts')
</body>
</html>
