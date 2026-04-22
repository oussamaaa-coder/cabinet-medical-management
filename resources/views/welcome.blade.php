<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCal — Cabinet Médical du Futur</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ mobileMenu: false, darkMode: false }" :class="{ 'dark': darkMode }" class="relative">

    <!-- Scroll Progress Bar -->
    <div id="scroll-progress" class="fixed top-0 left-0 h-1 bg-emerald-500 z-[100] transition-all duration-100"></div>


    <!-- 3D Hero Background -->
    <div id="hero-canvas"></div>

    <!-- Navigation -->
    <nav class="fixed top-6 left-1/2 -translate-x-1/2 w-[90%] max-w-7xl z-50 transition-all duration-500">
        <div class="glass px-6 py-4 rounded-full flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center text-white transition-transform group-hover:rotate-12">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                <span class="text-xl font-bold tracking-tight">Medi<span class="text-emerald-500">Cal</span></span>
            </a>

            <div class="hidden md:flex items-center gap-8 font-medium">
                <a href="#services" class="hover:text-emerald-500 transition-colors">Services</a>
                <a href="#how" class="hover:text-emerald-500 transition-colors">Processus</a>
                <a href="#portals" class="hover:text-emerald-500 transition-colors">Portails</a>
                <a href="{{ route('contact') }}" class="hover:text-emerald-500 transition-colors">Contact</a>
            </div>

            <div class="flex items-center gap-4">
                <button @click="darkMode = !darkMode" class="p-2 hover:bg-black/5 dark:hover:bg-white/10 rounded-full transition-colors">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </button>
                <a href="{{ route('login') }}" class="hidden sm:block px-6 py-2 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 rounded-full font-medium hover:bg-emerald-500/10 transition-all">Connexion</a>
                <a href="{{ route('patient.dashboard') }}" class="btn-premium bg-emerald-500 text-white shadow-lg shadow-emerald-500/20 magnetic">
                    Espace Patient
                </a>
                <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center pt-24 overflow-hidden">
        <div class="container mx-auto px-6 text-center z-10">
            <span class="inline-block px-4 py-1.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-full text-sm font-semibold mb-6" data-gsap="reveal">
                ✨ La médecine réinventée
            </span>
            <h1 class="text-6xl md:text-8xl font-serif mb-8 leading-[1.1]" data-split>
                Votre santé, <br> <span class="text-emerald-500 italic">notre priorité</span> absolue.
            </h1>
            <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 max-w-2xl mx-auto mb-12" data-gsap="reveal">
                Une expérience médicale premium alliant technologie de pointe et chaleur humaine. Prenez vos rendez-vous en quelques clics.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6" data-gsap="reveal">
                <a href="{{ route('register.patient') }}" class="btn-premium bg-emerald-500 text-white text-lg px-10 py-5 shadow-2xl shadow-emerald-500/30 group magnetic">
                    Commencer l'expérience
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="#how" class="text-lg font-semibold hover:text-emerald-500 transition-colors underline-offset-8 decoration-emerald-500/30 hover:underline">
                    Découvrir le processus
                </a>
            </div>

            <!-- Hero Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mt-24 max-w-4xl mx-auto" data-gsap="reveal">
                <div class="text-center">
                    <div class="text-4xl font-serif text-emerald-500 mb-1">500+</div>
                    <div class="text-sm uppercase tracking-widest text-slate-400">Patients</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-serif text-emerald-500 mb-1">10+</div>
                    <div class="text-sm uppercase tracking-widest text-slate-400">Experts</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-serif text-emerald-500 mb-1">99%</div>
                    <div class="text-sm uppercase tracking-widest text-slate-400">Satisfaction</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-serif text-emerald-500 mb-1">24h</div>
                    <div class="text-sm uppercase tracking-widest text-slate-400">Support</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-32 bg-white dark:bg-slate-900 transition-colors">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-20 gap-8">
                <div class="max-w-2xl">
                    <h2 class="text-4xl md:text-5xl font-serif mb-6" data-split>Une gamme complète de <span class="italic text-emerald-500">services numériques.</span></h2>
                    <p class="text-slate-600 dark:text-slate-400" data-gsap="reveal">Nous avons digitalisé l'intégralité du parcours patient pour vous offrir fluidité et sécurité.</p>
                </div>
                <a href="{{ route('register.patient') }}" class="text-emerald-500 font-bold flex items-center gap-2 group" data-gsap="reveal">
                    Tous nos services
                    <div class="w-8 h-8 rounded-full border border-emerald-500/30 flex items-center justify-center transition-transform group-hover:translate-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Service Card 1 -->
                <div class="group p-10 rounded-[2.5rem] bg-slate-50 dark:bg-slate-800/50 border border-transparent hover:border-emerald-500/20 transition-all duration-500" data-gsap="reveal">
                    <div class="w-16 h-16 bg-emerald-500 text-white rounded-2xl flex items-center justify-center mb-8 transform transition-transform group-hover:rotate-6 shadow-lg shadow-emerald-500/20">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-2xl font-serif mb-4">Rendez-vous 24/7</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-6">Réservez vos consultations en quelques secondes, sans attente téléphonique.</p>
                    <span class="text-xs font-bold uppercase tracking-widest text-emerald-500">Digital First</span>
                </div>
                
                <!-- Service Card 2 -->
                <div class="group p-10 rounded-[2.5rem] bg-slate-50 dark:bg-slate-800/50 border border-transparent hover:border-emerald-500/20 transition-all duration-500" data-gsap="reveal">
                    <div class="w-16 h-16 bg-medical-dark text-white rounded-2xl flex items-center justify-center mb-8 transform transition-transform group-hover:rotate-6 shadow-lg shadow-emerald-500/20">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="text-2xl font-serif mb-4">Ordonnances Cloud</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-6">Retrouvez toutes vos prescriptions instantanément sur votre smartphone.</p>
                    <span class="text-xs font-bold uppercase tracking-widest text-emerald-500">Zéro Papier</span>
                </div>

                <!-- Service Card 3 -->
                <div class="group p-10 rounded-[2.5rem] bg-slate-50 dark:bg-slate-800/50 border border-transparent hover:border-emerald-500/20 transition-all duration-500" data-gsap="reveal">
                    <div class="w-16 h-16 bg-emerald-500 text-white rounded-2xl flex items-center justify-center mb-8 transform transition-transform group-hover:rotate-6 shadow-lg shadow-emerald-500/20">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h3 class="text-2xl font-serif mb-4">Dossier Sécurisé</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-6">Vos données médicales sont cryptées et accessibles uniquement par vous.</p>
                    <span class="text-xs font-bold uppercase tracking-widest text-emerald-500">RGPD Compliant</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Portal Selection -->
    <section id="portals" class="py-32 relative overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Patient Portal -->
                <div class="relative group p-12 rounded-[3rem] bg-emerald-600 text-white overflow-hidden shadow-2xl shadow-emerald-500/40" data-gsap="reveal">
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/10 rounded-full blur-3xl transition-transform group-hover:scale-150"></div>
                    <span class="text-xs font-bold uppercase tracking-widest mb-4 block text-emerald-200">Patient Space</span>
                    <h3 class="text-4xl md:text-5xl font-serif mb-6 leading-tight">Gérez votre <span class="italic font-light">parcours santé.</span></h3>
                    <p class="text-emerald-100/80 mb-10 text-lg">Un accès direct à vos rendez-vous, ordonnances et documents médicaux.</p>
                    <a href="{{ route('register.patient') }}" class="btn-premium bg-white text-emerald-600 px-8 py-4 magnetic">Accéder au Portail</a>
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
    <footer class="bg-slate-50 dark:bg-slate-950 py-20 border-t border-slate-200 dark:border-slate-800 transition-colors">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-20">
                <div class="col-span-2">
                    <a href="#" class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </div>
                        <span class="text-2xl font-bold tracking-tight dark:text-white">Medi<span class="text-emerald-500">Cal</span></span>
                    </a>
                    <p class="text-slate-500 dark:text-slate-400 max-w-sm mb-8">
                        Le cabinet médical de demain, centré sur le patient et optimisé par la technologie.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full border border-slate-200 dark:border-slate-800 flex items-center justify-center hover:bg-emerald-500 hover:text-white transition-all"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                        <a href="#" class="w-10 h-10 rounded-full border border-slate-200 dark:border-slate-800 flex items-center justify-center hover:bg-emerald-500 hover:text-white transition-all"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                    </div>
                </div>
                <div>
                    <h5 class="font-bold mb-6 dark:text-white">Navigation</h5>
                    <ul class="space-y-4 text-slate-500 dark:text-slate-400">
                        <li><a href="#" class="hover:text-emerald-500 transition-colors">Accueil</a></li>
                        <li><a href="#services" class="hover:text-emerald-500 transition-colors">Services</a></li>
                        <li><a href="#portals" class="hover:text-emerald-500 transition-colors">Portails</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-emerald-500 transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold mb-6 dark:text-white">Légal</h5>
                    <ul class="space-y-4 text-slate-500 dark:text-slate-400">
                        <li><a href="#" class="hover:text-emerald-500 transition-colors">Mentions Légales</a></li>
                        <li><a href="#" class="hover:text-emerald-500 transition-colors">Confidentialité</a></li>
                        <li><a href="#" class="hover:text-emerald-500 transition-colors">RGPD</a></li>
                        <li><a href="#" class="hover:text-emerald-500 transition-colors">Cookies</a></li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 border-t border-slate-200 dark:border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-slate-500">
                <p>© {{ date('Y') }} MediCal. Tous droits réservés.</p>
                <div class="flex gap-6">
                    <span class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-emerald-500"></div> Sécurisé</span>
                    <span class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-emerald-500"></div> Certifié HDS</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Overlay -->
    <div x-show="mobileMenu" x-cloak class="fixed inset-0 z-[100] bg-white dark:bg-slate-900 p-8 flex flex-col items-center justify-center gap-8 text-2xl font-serif md:hidden">
        <button @click="mobileMenu = false" class="absolute top-8 right-8 p-2">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <a @click="mobileMenu = false" href="#services" class="hover:text-emerald-500">Services</a>
        <a @click="mobileMenu = false" href="#how" class="hover:text-emerald-500">Processus</a>
        <a @click="mobileMenu = false" href="#portals" class="hover:text-emerald-500">Portails</a>
        <a @click="mobileMenu = false" href="{{ route('contact') }}" class="hover:text-emerald-500">Contact</a>
        <div class="flex flex-col gap-4 w-full mt-8">
            <a href="{{ route('login') }}" class="text-center py-4 rounded-2xl border border-emerald-500/30 text-emerald-500">Connexion</a>
            <a href="{{ route('patient.dashboard') }}" class="text-center py-4 rounded-2xl bg-emerald-500 text-white shadow-xl shadow-emerald-500/20">Espace Patient</a>
        </div>
    </div>

</body>
</html>