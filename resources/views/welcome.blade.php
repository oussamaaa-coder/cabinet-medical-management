<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCal — Cabinet Médical du Futur</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative bg-white text-slate-900 overflow-x-hidden" x-data="{ mobileMenu: false }">

    <!-- Scroll Progress Bar -->
    <div id="scroll-progress" class="fixed top-0 left-0 h-1 bg-emerald-500 z-[100] transition-all duration-100"></div>


    <!-- 3D Hero Background -->
    <div id="hero-canvas" class="fixed inset-0 -z-10 opacity-60"></div>

    <!-- Navigation -->
    <nav class="fixed top-0 md:top-6 left-0 md:left-1/2 md:-translate-x-1/2 w-full md:w-[90%] max-w-7xl z-50 transition-all duration-500">
        <div class="glass px-4 md:px-6 py-3 md:py-4 rounded-none md:rounded-full flex items-center justify-between shadow-xl shadow-slate-200/50 border-x-0 md:border-x">
            <a href="{{ route('home') }}" class="flex items-center gap-2 md:gap-3 group shrink-0">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-emerald-500 rounded-full flex items-center justify-center text-white transition-transform group-hover:rotate-12">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                <span class="text-lg md:text-xl font-bold tracking-tight">Medi<span class="text-emerald-500">Cal</span></span>
            </a>

            <div class="hidden lg:flex items-center gap-8 font-semibold text-slate-800">
                <a href="#services" class="hover:text-emerald-500 transition-colors">Services</a>
                <a href="#portals" class="hover:text-emerald-500 transition-colors">Portails</a>
                <a href="{{ route('contact') }}" class="hover:text-emerald-500 transition-colors">Contact</a>
            </div>

            <div class="flex items-center gap-2 md:gap-4">
                <a href="{{ route('login') }}" class="hidden sm:block px-4 md:px-6 py-2 border border-emerald-500/30 text-emerald-600 rounded-full font-medium hover:bg-emerald-500/5 transition-all text-sm md:text-base">Connexion</a>
                <a href="{{ route('patient.dashboard') }}" class="hidden md:block btn-premium bg-emerald-500 text-white shadow-lg shadow-emerald-500/20 magnetic text-sm md:text-base">
                    Espace Patient
                </a>
                <button @click="mobileMenu = !mobileMenu" class="lg:hidden p-2 text-slate-900 hover:bg-slate-100 rounded-full transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center pt-24 overflow-hidden">
        <div class="container mx-auto px-6 text-center z-10">
            <h1 class="text-4xl sm:text-6xl md:text-8xl font-serif mb-6 md:mb-8 leading-[1.2] md:leading-[1.1] text-slate-900" data-split>
                Votre santé, <br class="hidden md:block"> <span class="text-emerald-500 italic">notre priorité</span> absolue.
            </h1>
            <p class="text-lg md:text-xl text-slate-600 max-w-2xl mx-auto mb-12 leading-relaxed" data-gsap="reveal">
                Une expérience médicale premium alliant technologie de pointe et chaleur humaine. Prenez vos rendez-vous en quelques clics.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 md:gap-6" data-gsap="reveal">
                <a href="{{ route('register.patient') }}" class="w-full sm:w-auto btn-premium bg-emerald-500 text-white text-base md:text-lg px-8 md:px-10 py-4 md:py-5 shadow-2xl shadow-emerald-500/30 group magnetic">
                    Commencer l'expérience
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="#services" class="text-base md:text-lg font-semibold text-slate-800 hover:text-emerald-500 transition-colors underline-offset-8 decoration-emerald-500/30 hover:underline">
                    Découvrir nos services
                </a>
            </div>

            <!-- Hero Stats -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8 mt-16 md:mt-24 max-w-4xl mx-auto px-4 sm:px-0" data-gsap="reveal">
                <div class="text-center p-4 md:p-6 bg-white/50 backdrop-blur-sm rounded-2xl md:rounded-3xl border border-slate-100 shadow-sm">
                    <div class="text-2xl md:text-4xl font-serif text-emerald-500 mb-1">500+</div>
                    <div class="text-[10px] md:text-xs uppercase tracking-widest text-slate-500 font-bold">Patients</div>
                </div>
                <div class="text-center p-4 md:p-6 bg-white/50 backdrop-blur-sm rounded-2xl md:rounded-3xl border border-slate-100 shadow-sm">
                    <div class="text-2xl md:text-4xl font-serif text-emerald-500 mb-1">10+</div>
                    <div class="text-[10px] md:text-xs uppercase tracking-widest text-slate-500 font-bold">Experts</div>
                </div>
                <div class="text-center p-4 md:p-6 bg-white/50 backdrop-blur-sm rounded-2xl md:rounded-3xl border border-slate-100 shadow-sm">
                    <div class="text-2xl md:text-4xl font-serif text-emerald-500 mb-1">99%</div>
                    <div class="text-[10px] md:text-xs uppercase tracking-widest text-slate-500 font-bold">Satisfaction</div>
                </div>
                <div class="text-center p-4 md:p-6 bg-white/50 backdrop-blur-sm rounded-2xl md:rounded-3xl border border-slate-100 shadow-sm">
                    <div class="text-2xl md:text-4xl font-serif text-emerald-500 mb-1">24h</div>
                    <div class="text-[10px] md:text-xs uppercase tracking-widest text-slate-500 font-bold">Support</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 md:py-32 bg-slate-50/50 border-y border-slate-100">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 md:mb-20 gap-8 text-center md:text-left">
                <div class="max-w-2xl">
                    <h2 class="text-3xl md:text-5xl font-serif mb-4 md:mb-6 text-slate-900" data-split>Une gamme complète de <span class="italic text-emerald-500">services numériques.</span></h2>
                    <p class="text-slate-600 text-sm md:text-base" data-gsap="reveal">Nous avons digitalisé l'intégralité du parcours patient pour vous offrir fluidité et sécurité.</p>
                </div>
                <a href="{{ route('register.patient') }}" class="text-emerald-500 font-bold flex items-center justify-center md:justify-start gap-2 group" data-gsap="reveal">
                    Tous nos services
                    <div class="w-8 h-8 rounded-full border border-emerald-500/30 flex items-center justify-center transition-transform group-hover:translate-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Service Card 1 -->
                <div class="group p-10 rounded-[2.5rem] bg-white border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-emerald-500/5 transition-all duration-500" data-gsap="reveal">
                    <div class="w-16 h-16 bg-emerald-500 text-white rounded-2xl flex items-center justify-center mb-8 transform transition-transform group-hover:rotate-6 shadow-lg shadow-emerald-500/20">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-2xl font-serif mb-4 text-slate-900">Rendez-vous 24/7</h3>
                    <p class="text-slate-600 leading-relaxed mb-6">Réservez vos consultations en quelques secondes, sans attente téléphonique.</p>
                    <span class="text-xs font-bold uppercase tracking-widest text-emerald-500">Digital First</span>
                </div>
                
                <!-- Service Card 2 -->
                <div class="group p-10 rounded-[2.5rem] bg-white border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-emerald-500/5 transition-all duration-500" data-gsap="reveal">
                    <div class="w-16 h-16 bg-medical-dark text-white rounded-2xl flex items-center justify-center mb-8 transform transition-transform group-hover:rotate-6 shadow-lg shadow-emerald-500/20">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="text-2xl font-serif mb-4 text-slate-900">Ordonnances Cloud</h3>
                    <p class="text-slate-600 leading-relaxed mb-6">Retrouvez toutes vos prescriptions instantanément sur votre smartphone.</p>
                    <span class="text-xs font-bold uppercase tracking-widest text-emerald-500">Zéro Papier</span>
                </div>

                <!-- Service Card 3 -->
                <div class="group p-10 rounded-[2.5rem] bg-white border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-emerald-500/5 transition-all duration-500" data-gsap="reveal">
                    <div class="w-16 h-16 bg-emerald-500 text-white rounded-2xl flex items-center justify-center mb-8 transform transition-transform group-hover:rotate-6 shadow-lg shadow-emerald-500/20">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h3 class="text-2xl font-serif mb-4 text-slate-900">Dossier Sécurisé</h3>
                    <p class="text-slate-600 leading-relaxed mb-6">Vos données médicales sont cryptées et accessibles uniquement par vous.</p>
                    <span class="text-xs font-bold uppercase tracking-widest text-emerald-500">RGPD Compliant</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Portal Selection -->
    <section id="portals" class="py-20 md:py-32 relative overflow-hidden bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                <!-- Patient Portal -->
                <div class="relative group p-8 md:p-12 rounded-[2rem] md:rounded-[3rem] bg-emerald-600 text-white overflow-hidden shadow-2xl shadow-emerald-500/40" data-gsap="reveal">
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/10 rounded-full blur-3xl transition-transform group-hover:scale-150"></div>
                    <span class="text-xs font-bold uppercase tracking-widest mb-4 block text-emerald-200">Patient Space</span>
                    <h3 class="text-3xl md:text-5xl font-serif mb-6 leading-tight">Gérez votre <span class="italic font-light">parcours santé.</span></h3>
                    <p class="text-emerald-100/80 mb-8 md:mb-10 text-base md:text-lg">Un accès direct à vos rendez-vous, ordonnances et documents médicaux.</p>
                    <a href="{{ route('register.patient') }}" class="w-full sm:w-auto btn-premium bg-white text-emerald-600 px-8 py-4 magnetic text-center justify-center">Accéder au Portail</a>
                </div>

                <!-- Staff Portal -->
                <div class="relative group p-12 rounded-[3rem] bg-slate-900 text-white overflow-hidden shadow-2xl" data-gsap="reveal">
                    <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl transition-transform group-hover:scale-150"></div>
                    <span class="text-xs font-bold uppercase tracking-widest mb-4 block text-slate-500">Medical Team</span>
                    <h3 class="text-4xl md:text-5xl font-serif mb-6 leading-tight">Outils de <span class="italic font-light text-emerald-500">gestion avancés.</span></h3>
                    <p class="text-slate-400 mb-10 text-lg">Optimisez votre cabinet avec nos outils de planification et de suivi patient.</p>
                    <a href="{{ route('login') }}" class="btn-premium bg-emerald-500 text-white px-8 py-4 magnetic">Connexion Équipe</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-50 py-20 border-t border-slate-200">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-20">
                <div class="col-span-2">
                    <a href="#" class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </div>
                        <span class="text-2xl font-bold tracking-tight text-slate-900">Medi<span class="text-emerald-500">Cal</span></span>
                    </a>
                    <p class="text-slate-500 max-w-sm mb-8">
                        Le cabinet médical de demain, centré sur le patient et optimisé par la technologie.
                    </p>
                </div>
                <div>
                    <h5 class="font-bold mb-6 text-slate-900">Navigation</h5>
                    <ul class="space-y-4 text-slate-500">
                        <li><a href="#" class="hover:text-emerald-500 transition-colors">Accueil</a></li>
                        <li><a href="#services" class="hover:text-emerald-500 transition-colors">Services</a></li>
                        <li><a href="#portals" class="hover:text-emerald-500 transition-colors">Portails</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-emerald-500 transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold mb-6 text-slate-900 text-slate-900">Contact</h5>
                    <ul class="space-y-4 text-slate-500">
                        <li>01 23 45 67 89</li>
                        <li>contact@medical.com</li>
                        <li>Paris, France</li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 border-t border-slate-200 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-slate-500">
                <p>© {{ date('Y') }} MediCal. Tous droits réservés.</p>
                <div class="flex gap-6">
                    <span class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-emerald-500"></div> Sécurisé</span>
                    <span class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-emerald-500"></div> Certifié HDS</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Overlay -->
    <div x-show="mobileMenu" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-x-full"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 translate-x-full"
         x-cloak 
         class="fixed inset-0 z-[100] bg-white/95 backdrop-blur-lg p-8 flex flex-col items-center justify-center gap-8 text-2xl font-serif md:hidden">
        
        <div class="absolute top-8 left-8 flex items-center gap-2">
            <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
            <span class="text-xl font-bold tracking-tight">Medi<span class="text-emerald-500">Cal</span></span>
        </div>

        <button @click="mobileMenu = false" class="absolute top-8 right-8 p-2 text-slate-400 hover:text-emerald-500 transition-colors">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        
        <div class="flex flex-col items-center gap-8 mt-12">
            <a @click="mobileMenu = false" href="#services" class="hover:text-emerald-500 transition-colors">Services</a>
            <a @click="mobileMenu = false" href="#portals" class="hover:text-emerald-500 transition-colors">Portails</a>
            <a @click="mobileMenu = false" href="{{ route('contact') }}" class="hover:text-emerald-500 transition-colors">Contact</a>
        </div>

        <div class="flex flex-col gap-4 w-full mt-12">
            <a href="{{ route('login') }}" class="text-center py-4 rounded-full border border-emerald-500/30 text-emerald-500 font-semibold text-lg">Connexion</a>
            <a href="{{ route('patient.dashboard') }}" class="text-center py-4 rounded-full bg-emerald-500 text-white shadow-xl shadow-emerald-500/20 font-semibold text-lg">Espace Patient</a>
        </div>
    </div>
</body>
</html>