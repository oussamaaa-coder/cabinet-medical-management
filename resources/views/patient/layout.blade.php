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
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('styles')
    <style>[x-cloak] { display: none !important; }</style>
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
        <span class="pt-nav-section">Navigation</span>

        <a href="{{ url('/') }}" class="pt-nav-item">
            <span class="pt-nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            </span>
            <span class="pt-nav-label">Accueil Site</span>
        </a>

        <span class="pt-nav-section">Mon Espace</span>

        <a href="{{ route('patient.dashboard') }}"
           class="pt-nav-item {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}">
            <span class="pt-nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            </span>
            <span class="pt-nav-label">Tableau de bord</span>
        </a>

        <a href="{{ route('patient.appointments') }}"
           class="pt-nav-item {{ request()->routeIs('patient.appointments') ? 'active' : '' }}">
            <span class="pt-nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            </span>
            <span class="pt-nav-label">Mes Rendez-vous</span>
            @php $apptCount = optional(auth()->user()->patient)->appointments()->whereNotIn('status', ['completed', 'cancelled'])->count() ?? 0; @endphp
            @if($apptCount > 0)
                <span style="margin-left:auto; background:var(--pt-accent); color:#fff; font-size:10px; padding:2px 8px; border-radius:10px; font-weight:700;">{{ $apptCount }}</span>
            @endif
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

        <a href="{{ route('patient.archives') }}"
           class="pt-nav-item {{ request()->routeIs('patient.archives') ? 'active' : '' }}">
            <span class="pt-nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
            </span>
            <span class="pt-nav-label">Archives</span>
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
            <div class="pt-user-name">{{ ucwords(auth()->user()->name) }}</div>
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

<!-- AI Chatbot Assistant for Patient Portal -->
<div x-data="chatbot('{{ ucwords(auth()->user()->name) }}')" class="fixed bottom-6 right-6 z-[100] font-sans">

    <!-- Chat Launcher Button -->
    <button @click="toggleChat()" 
            class="w-14 h-14 md:w-16 md:h-16 bg-emerald-600 rounded-full shadow-2xl shadow-emerald-600/40 flex items-center justify-center text-white transition-all duration-300 hover:scale-110 active:scale-95 group relative overflow-hidden">
        <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
        <svg x-show="!chatOpen" x-transition class="w-7 h-7 md:w-8 md:h-8 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
        </svg>
        <svg x-show="chatOpen" x-transition class="w-7 h-7 md:w-8 md:h-8 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <!-- Chat Window -->
    <div x-show="chatOpen"
         x-transition:enter="transition ease-out duration-400"
         x-transition:enter-start="opacity-0 scale-95 translate-y-12"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-cloak
         class="absolute bottom-20 right-0 w-[420px] max-w-[calc(100vw-2rem)] h-[650px] bg-white rounded-[32px] shadow-[0_20px_60px_-15px_rgba(16,185,129,0.1)] border border-emerald-50 overflow-hidden flex flex-col"
         style="font-family: 'Outfit', sans-serif;">
        
        <!-- Header: Clean Light Green & White -->
        <div class="p-6 flex items-center justify-between relative overflow-hidden shrink-0 border-b border-emerald-50"
             style="background-color: white;">
            <div class="flex items-center gap-4 relative z-10">
                <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center border border-emerald-100 flex-shrink-0">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: block; width: 24px; height: 24px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-xl tracking-tight text-slate-800">Assistant MediCal</h3>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="w-2 h-2 rounded-full animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.5)]"
                              style="background-color: var(--pt-primary);"></span>
                        <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-widest">En ligne</span>
                    </div>
                </div>
            </div>
            <button @click="toggleChat()" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-400 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Chat Content -->
        <div class="flex-1 overflow-y-auto p-6 space-y-6 scrollbar-hide bg-white" id="chat-messages">
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div :class="msg.role === 'user' 
                        ? 'text-emerald-900 rounded-[22px] rounded-tr-none shadow-sm' 
                        : 'bg-slate-50 text-slate-700 rounded-[22px] rounded-tl-none border border-slate-100'" 
                        :style="msg.role === 'user' ? 'background-color: var(--pt-primary-soft, #ecfdf5); border: 1px solid var(--pt-primary); border-opacity: 0.2;' : ''"
                        class="max-w-[85%] px-5 py-3.5 text-[14px] leading-relaxed relative">
                        <div x-html="msg.content"></div>
                        <div class="text-[10px] mt-1.5 flex justify-end opacity-50 font-bold">
                            {{ now()->format('H:i') }}
                        </div>
                    </div>
                </div>
            </template>
            <div x-show="typing" class="flex justify-start">
                <div class="bg-slate-50 px-5 py-3 rounded-[22px] rounded-tl-none border border-slate-100 flex gap-1">
                    <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-bounce"></span>
                    <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-bounce [animation-delay:0.2s]"></span>
                    <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-bounce [animation-delay:0.4s]"></span>
                </div>
            </div>

            <!-- Quick Actions -->
            <div x-show="!typing && currentOptions.length > 0" class="flex flex-wrap gap-2 pt-2">
                <template x-for="opt in currentOptions">
                    <button @click="handleOption(opt)" 
                            class="px-4 py-2 bg-white border border-emerald-100 text-emerald-700 text-[13px] font-semibold rounded-full transition-all shadow-sm hover:bg-emerald-50 hover:shadow-md flex items-center gap-2">
                        <div x-html="opt.icon"></div>
                        <span x-text="opt.label"></span>
                    </button>
                </template>
            </div>
        </div>

        <!-- Chat Input -->
        <div class="p-6 bg-white border-t border-slate-100">
            <form @submit.prevent="sendMessage()" class="flex items-center gap-3">
                <button type="button" @click="toggleVoice()" 
                        :class="isListening ? 'bg-red-500 text-white shadow-red-200' : 'bg-slate-50 text-emerald-600 hover:bg-emerald-50'" 
                        class="w-12 h-12 rounded-2xl flex items-center justify-center transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                </button>
                <div class="relative flex-1">
                    <input type="text" x-model="userInput" placeholder="Besoin d'aide ?" 
                           class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:bg-white transition-all text-slate-700 placeholder:text-slate-400">
                </div>
                <button type="submit" 
                        class="w-12 h-12 text-white rounded-2xl flex items-center justify-center transition-all shadow-lg active:scale-95"
                        :style="`background-color: var(--pt-primary);`"
                        style="box-shadow: 0 8px 20px -4px rgba(16, 185, 129, 0.4);">
                    <svg class="w-6 h-6 rotate-45 -translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </form>
        </div>
    </div>
    </div>
</div>


<script>
    function chatbot(userName) {
        return {
            chatOpen: false,
            typing: false,
            userInput: '',
            showHelpBubble: false,
            isListening: false,
            recognition: null,
            currentOptions: [
                { label: 'Mes RDV', icon: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>`, value: 'check appointments' },
                { label: 'Nouveau RDV', icon: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>`, value: 'book new appointment' },
                { label: 'Ordonnances', icon: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>`, value: 'my prescriptions' }
            ],
            messages: [
                { role: 'bot', content: `Bonjour **${userName}** ! Je suis votre assistant personnel. <br><br>Comment puis-je vous aider dans votre espace patient aujourd'hui ?` }
            ],
            init() {
                if ('webkitSpeechRecognition' in window) {
                    const SpeechRecognition = window.webkitSpeechRecognition;
                    this.recognition = new SpeechRecognition();
                    this.recognition.lang = 'fr-FR';
                    this.recognition.onresult = (event) => {
                        this.userInput = event.results[0][0].transcript;
                        this.sendMessage();
                    };
                    this.recognition.onend = () => { this.isListening = false; };
                }
            },
            toggleVoice() {
                if (!this.recognition) return alert("Micro non supporté");
                if (this.isListening) { this.recognition.stop(); } 
                else { this.recognition.start(); this.isListening = true; }
            },
            toggleChat() {
                this.chatOpen = !this.chatOpen;
                this.showHelpBubble = false;
                if(this.chatOpen) this.scrollToBottom();
            },
            handleOption(opt) {
                this.userInput = opt.label;
                this.sendMessage(opt.value);
            },
            async sendMessage(val = null) {
                const text = val || this.userInput.trim();
                if (!text) return;
                this.messages.push({ role: 'user', content: text });
                this.userInput = ''; this.typing = true; this.currentOptions = [];
                this.scrollToBottom();
                try {
                    const res = await fetch("{{ route('chatbot.ask') }}", {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ message: text })
                    });
                    const data = await res.json();
                    this.messages.push({ role: 'bot', content: data.reply });
                } catch (e) {
                    this.messages.push({ role: 'bot', content: "Erreur de connexion..." });
                } finally {
                    this.typing = false; this.scrollToBottom();
                    this.currentOptions = [
                        { label: '📅 Mes RDV', value: 'appointments' },
                        { label: '➕ Nouveau RDV', value: 'booking' }
                    ];
                }
            },
            scrollToBottom() {
                this.$nextTick(() => {
                    const el = document.getElementById('chat-messages');
                    if (el) el.scrollTop = el.scrollHeight;
                });
            }
        }
    }
</script>
    {{-- ══════════════════════════════════════
         INTERACTIVE TUTORIAL (ONBOARDING)
    ══════════════════════════════════════ --}}
    <div x-data="onboarding()" 
         x-init="startTutorial()"
         x-show="show" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[1000] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        
        <div class="bg-white dark:bg-slate-800 w-full max-w-lg rounded-[32px] overflow-hidden shadow-2xl relative border border-white/10"
             @click.away="close()">
            
            {{-- Progress Bar --}}
            <div class="absolute top-0 left-0 w-full h-1.5 bg-slate-100 dark:bg-slate-700">
                <div class="h-full bg-emerald-500 transition-all duration-500" :style="`width: ${((step + 1) / steps.length) * 100}%`"></div>
            </div>

            <div class="p-8 pt-12">
                {{-- Slide Content --}}
                <div class="text-center">
                    <div class="w-20 h-20 bg-emerald-50 dark:bg-emerald-500/10 rounded-3xl flex items-center justify-center mx-auto mb-6 text-emerald-600 dark:text-emerald-400">
                        <template x-if="steps[step].icon === 'welcome'">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </template>
                        <template x-if="steps[step].icon === 'stats'">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </template>
                        <template x-if="steps[step].icon === 'ai'">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        </template>
                    </div>
                    
                    <h2 class="text-2xl font-extrabold text-slate-800 dark:text-white mb-3 tracking-tight" x-text="steps[step].title"></h2>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-8 text-sm" x-text="steps[step].description"></p>
                </div>

                {{-- Controls --}}
                <div class="flex items-center justify-between gap-4">
                    <button @click="close()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 font-bold text-sm transition-colors">
                        Passer
                    </button>
                    
                    <div class="flex gap-2">
                        <button x-show="step > 0" @click="step--" class="px-6 py-3 rounded-2xl bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-sm transition-all hover:bg-slate-200">
                            Précédent
                        </button>
                        <button @click="next()" class="px-8 py-3 rounded-2xl bg-emerald-600 text-white font-bold text-sm shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 transition-all hover:-translate-y-0.5">
                            <span x-text="step === steps.length - 1 ? 'C\'est parti !' : 'Suivant'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @stack('scripts')
    <script>
        function onboarding() {
            return {
                show: false,
                step: 0,
                steps: [
                    {
                        icon: 'welcome',
                        title: 'Bienvenue sur MediCal !',
                        description: 'Nous sommes ravis de vous accompagner. Ce court guide va vous montrer comment profiter de votre espace santé.'
                    },
                    {
                        icon: 'stats',
                        title: 'Votre santé en direct',
                        description: 'Suivez l\'évolution de vos constantes (Poids, Tension, Glycémie) et gérez vos rendez-vous depuis le tableau de bord.'
                    },
                    {
                        icon: 'ai',
                        title: 'Un assistant à votre écoute',
                        description: 'Utilisez la bulle de chat en bas à droite pour poser vos questions au Dr. AI ou gérer vos ordonnances rapidement.'
                    }
                ],
                startTutorial() {
                    if (!localStorage.getItem('pt_onboarding_seen')) {
                        setTimeout(() => { this.show = true; }, 1200);
                    }
                },
                next() {
                    if (this.step < this.steps.length - 1) {
                        this.step++;
                    } else {
                        this.close();
                    }
                },
                close() {
                    this.show = false;
                    localStorage.setItem('pt_onboarding_seen', 'true');
                }
            }
        }
    </script>
</body>
</html>
