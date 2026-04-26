<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCal — Cabinet Médical du Futur</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                <a href="#reviews" class="hover:text-emerald-500 transition-colors">Témoignages</a>
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

    <!-- Testimonials Section -->
    <section id="reviews" class="py-24 md:py-32 bg-slate-50/50 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent"></div>
        
        <div class="container mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-16 md:mb-24">
                <h2 class="text-4xl md:text-6xl font-serif mb-6 text-slate-900" data-split>
                    La confiance de <span class="italic text-emerald-500">nos patients.</span>
                </h2>
                <p class="text-lg text-slate-600" data-gsap="reveal">
                    Découvrez les retours d'expérience de ceux qui nous font confiance pour leur santé au quotidien.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-10">
                @foreach($testimonials as $testimonial)
                <!-- Dynamic Review -->
                <div class="glass p-8 md:p-10 rounded-[2.5rem] flex flex-col justify-between hover:translate-y-[-10px] transition-all duration-500 group" data-gsap="reveal">
                    <div>
                        <div class="flex gap-1 text-emerald-500 mb-6">
                            @for($i=0; $i<5; $i++)
                                <svg class="w-5 h-5 {{ $i < $testimonial->rating ? 'fill-current' : 'text-slate-300 fill-none stroke-current' }} transition-transform group-hover:scale-110" style="transition-delay: {{ $i * 50 }}ms" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <p class="text-xl md:text-2xl font-serif text-slate-800 leading-relaxed mb-8 italic">
                            "{{ $testimonial->content }}"
                        </p>
                    </div>
                    <div class="flex items-center gap-4 pt-6 border-t border-slate-100">
                        <div class="w-14 h-14 rounded-full bg-emerald-100 overflow-hidden flex items-center justify-center border-2 border-white shadow-sm ring-4 ring-emerald-500/5 transition-transform group-hover:scale-110 duration-500">
                            @if($testimonial->image)
                                <img src="{{ asset($testimonial->image) }}" alt="{{ $testimonial->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-emerald-500 text-white font-bold text-xl">
                                    {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-lg leading-none mb-1">{{ $testimonial->name }}</h4>
                            <p class="text-slate-500 text-[10px] uppercase tracking-[0.2em] font-bold">{{ $testimonial->role ?? 'Patient' }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Review Submission Form -->
            <div class="mt-20 md:mt-32 max-w-2xl mx-auto" data-gsap="reveal">
                <div class="glass p-8 md:p-12 rounded-[2.5rem] relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-10">
                        <svg class="w-24 h-24 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z"/></svg>
                    </div>

                    @auth
                        <h3 class="text-2xl md:text-3xl font-serif mb-4 text-slate-900">Partagez votre <span class="italic text-emerald-500">expérience.</span></h3>
                        <p class="text-slate-600 mb-8">Votre avis nous aide à améliorer nos services au quotidien.</p>

                        @if(session('testimonial_success'))
                            <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3">
                                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="font-medium">{{ session('testimonial_success') }}</span>
                            </div>
                        @endif

                        <form action="{{ route('testimonials.submit') }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label class="block text-sm font-bold uppercase tracking-widest text-slate-500 mb-3">Quelle note nous donnez-vous ?</label>
                                <div class="flex gap-2" x-data="{ rating: 5, hover: 0 }">
                                    <input type="hidden" name="rating" :value="rating">
                                    <template x-for="i in 5">
                                        <button type="button" 
                                                @click="rating = i" 
                                                @mouseenter="hover = i" 
                                                @mouseleave="hover = 0"
                                                class="transition-all duration-300">
                                            <svg class="w-8 h-8" :class="(hover || rating) >= i ? 'text-emerald-500 fill-current' : 'text-slate-200 fill-none stroke-current'" viewBox="0 0 24 24" stroke-width="2">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                        </button>
                                    </template>
                                </div>
                            </div>

                            <div>
                                <label for="content" class="block text-sm font-bold uppercase tracking-widest text-slate-500 mb-3">Votre témoignage</label>
                                <textarea name="content" id="content" rows="4" required
                                          class="w-full bg-slate-50/50 border border-slate-200 rounded-3xl px-6 py-5 focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all resize-none placeholder:text-slate-400"
                                          placeholder="Racontez-nous votre expérience..."></textarea>
                            </div>

                            <button type="submit" class="w-full btn-premium bg-emerald-500 text-white shadow-xl shadow-emerald-500/20 group magnetic">
                                Publier mon avis
                                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        </form>
                    @else
                        <div class="text-center py-6">
                            <h3 class="text-2xl font-serif mb-4 text-slate-900">Vous souhaitez laisser <span class="italic text-emerald-500">un avis ?</span></h3>
                            <p class="text-slate-600 mb-8">Connectez-vous à votre espace patient pour partager votre expérience avec nous.</p>
                            <a href="{{ route('login') }}" class="inline-flex btn-premium bg-slate-900 text-white shadow-xl shadow-slate-900/20 magnetic">
                                Se connecter maintenant
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent"></div>
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
                    <h5 class="font-bold mb-6 text-slate-900">Contact</h5>
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

    <!-- AI Chatbot Assistant -->
    <div x-data="chatbot()" class="fixed bottom-6 right-6 z-[100] font-sans">
        <!-- Proactive Help Bubble -->
        <div x-show="!chatOpen && showHelpBubble" 
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 translate-y-4 scale-90"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             class="absolute bottom-20 right-0 w-64 bg-white p-4 rounded-2xl shadow-xl border border-emerald-100 mb-2">
            <p class="text-sm text-slate-700 font-medium">Besoin d'aide pour prendre rendez-vous ? 🏥</p>
            <p class="text-xs text-slate-500 mt-1">Je peux vous aider en Français ou en Darija.</p>
            <div class="absolute bottom-[-8px] right-6 w-4 h-4 bg-white border-r border-b border-emerald-100 rotate-45"></div>
        </div>

        <!-- Chat Launcher Button -->
        <button @click="toggleChat()" 
                class="w-14 h-14 md:w-16 md:h-16 bg-emerald-500 rounded-full shadow-2xl shadow-emerald-500/40 flex items-center justify-center text-white transition-all duration-300 hover:scale-110 active:scale-95 group relative overflow-hidden">
            <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
            <svg x-show="!chatOpen" x-transition class="w-7 h-7 md:w-8 md:h-8 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
            <svg x-show="chatOpen" x-transition class="w-7 h-7 md:w-8 md:h-8 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <div class="absolute inset-0 rounded-full bg-emerald-500 animate-ping opacity-20 -z-10"></div>
        </button>

        <!-- Chat Window -->
        <div x-show="chatOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90 translate-y-10"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-90 translate-y-10"
             x-cloak
             class="absolute bottom-20 right-0 w-[calc(100vw-3rem)] sm:w-96 h-[550px] bg-white rounded-3xl shadow-[0_20px_60px_-15px_rgba(0,0,0,0.1)] border border-slate-100 overflow-hidden flex flex-col backdrop-blur-xl">
            
            <!-- Chat Header -->
            <div class="p-6 bg-gradient-to-r from-emerald-500 to-teal-600 text-white flex items-center gap-4 shrink-0">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold tracking-tight text-lg">Assistant Médical</h3>
                    <div class="flex items-center gap-1.5 opacity-80">
                        <span class="w-2 h-2 bg-emerald-300 rounded-full animate-pulse"></span>
                        <span class="text-xs font-medium uppercase tracking-wider">Intelligence Artificielle</span>
                    </div>
                </div>
            </div>

            <!-- Chat Messages -->
            <div id="chat-messages" class="flex-1 overflow-y-auto p-5 space-y-4 scroll-smooth bg-slate-50/30">
                <template x-for="(msg, index) in messages" :key="index">
                    <div :class="msg.role === 'bot' ? 'flex justify-start' : 'flex justify-end'">
                        <div :class="msg.role === 'bot' 
                            ? 'bg-white text-slate-800 rounded-2xl rounded-tl-none px-4 py-3 max-w-[88%] text-sm shadow-sm border border-slate-100' 
                            : 'bg-emerald-500 text-white rounded-2xl rounded-tr-none px-4 py-3 max-w-[85%] text-sm shadow-md shadow-emerald-500/10'"
                             x-html="msg.content">
                        </div>
                    </div>
                </template>

                <!-- Quick Replies -->
                <div x-show="!typing && currentOptions.length > 0" class="flex flex-wrap gap-2 py-2">
                    <template x-for="opt in currentOptions">
                        <button @click="handleOption(opt)" 
                                class="px-4 py-2 bg-white border border-emerald-100 text-emerald-700 text-xs font-bold rounded-full hover:bg-emerald-50 hover:border-emerald-300 transition-all shadow-sm">
                            <span x-text="opt.label"></span>
                        </button>
                    </template>
                </div>

                <!-- Typing Indicator -->
                <div x-show="typing" class="flex justify-start">
                    <div class="bg-white rounded-2xl rounded-tl-none px-4 py-3 flex gap-1 shadow-sm border border-slate-100">
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-bounce"></span>
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
                    </div>
                </div>
            </div>

            <!-- Chat Input -->
            <div class="p-4 bg-white border-t border-slate-100 shrink-0">
                <form @submit.prevent="sendMessage()" class="flex items-center gap-2">
                    <button type="button" 
                            @click="toggleVoice()"
                            :class="isListening ? 'bg-red-500 text-white animate-pulse' : 'bg-slate-100 text-slate-500 hover:bg-emerald-50 hover:text-emerald-500'"
                            class="w-11 h-11 rounded-xl flex items-center justify-center transition-all">
                        <svg x-show="!isListening" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                        <svg x-show="isListening" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path></svg>
                    </button>
                    <input type="text" 
                           x-model="userInput" 
                           @focus="scrollToBottom()"
                           :placeholder="isListening ? 'Je vous écoute...' : 'Posez votre question...'" 
                           class="flex-1 bg-slate-50 border border-slate-200 rounded-2xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all placeholder:text-slate-400">
                    <button type="submit" 
                            class="w-11 h-11 bg-emerald-500 text-white rounded-xl flex items-center justify-center transition-transform hover:scale-105 active:scale-95 shadow-lg shadow-emerald-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

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
            <a @click="mobileMenu = false" href="#reviews" class="hover:text-emerald-500 transition-colors">Témoignages</a>
            <a @click="mobileMenu = false" href="#portals" class="hover:text-emerald-500 transition-colors">Portails</a>
            <a @click="mobileMenu = false" href="{{ route('contact') }}" class="hover:text-emerald-500 transition-colors">Contact</a>
        </div>

        <div class="flex flex-col gap-4 w-full mt-12">
            <a href="{{ route('login') }}" class="text-center py-4 rounded-full border border-emerald-500/30 text-emerald-500 font-semibold text-lg">Connexion</a>
            <a href="{{ route('patient.dashboard') }}" class="text-center py-4 rounded-full bg-emerald-500 text-white shadow-xl shadow-emerald-500/20 font-semibold text-lg">Espace Patient</a>
        </div>
    </div>

    <script>
        function chatbot() {
            return {
                chatOpen: false,
                typing: false,
                userInput: '',
                showHelpBubble: false,
                isListening: false,
                recognition: null,
                currentOptions: [
                    { label: ' Prendre RDV', value: 'booking' },
                    { label: ' Triage Symptômes', value: 'triage' },
                    { label: ' FAQ (Heures/Prix)', value: 'faq' }
                ],
                messages: [
                    { role: 'bot', content: 'Bonjour ! Je suis votre **Assistant Médical**. Labas ? <br><br>Je peux vous aider à prendre rendez-vous en quelques secondes. Que puis-je faire pour vous ?' }
                ],
                init() {
                    setTimeout(() => this.showHelpBubble = true, 5000);
                    
                    // Initialize Speech Recognition
                    if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
                        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                        this.recognition = new SpeechRecognition();
                        this.recognition.lang = 'fr-FR'; // Can be changed to ar-MA for better Darija support
                        this.recognition.continuous = false;
                        this.recognition.interimResults = false;

                        this.recognition.onresult = (event) => {
                            this.userInput = event.results[0][0].transcript;
                            this.isListening = false;
                            this.sendMessage();
                        };

                        this.recognition.onerror = () => {
                            this.isListening = false;
                        };

                        this.recognition.onend = () => {
                            this.isListening = false;
                        };
                    }
                },
                toggleVoice() {
                    if (!this.recognition) {
                        alert("La reconnaissance vocale n'est pas supportée par votre navigateur.");
                        return;
                    }
                    if (this.isListening) {
                        this.recognition.stop();
                        this.isListening = false;
                    } else {
                        this.recognition.start();
                        this.isListening = true;
                    }
                },
                toggleChat() {
                    this.chatOpen = !this.chatOpen;
                    this.showHelpBubble = false;
                    if(this.chatOpen) setTimeout(() => this.scrollToBottom(), 100);
                },
                handleOption(opt) {
                    this.userInput = opt.label;
                    this.sendMessage(opt.value);
                },
                async sendMessage(predefinedValue = null) {
                    const text = this.userInput.trim();
                    if (text === '' && !predefinedValue) return;

                    const displayMessage = predefinedValue ? (this.currentOptions.find(o => o.value === predefinedValue)?.label || text) : text;
                    this.messages.push({ role: 'user', content: displayMessage });
                    this.userInput = '';
                    this.typing = true;
                    this.currentOptions = [];

                    this.scrollToBottom();

                    try {
                        const response = await fetch("{{ route('chatbot.ask') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ message: predefinedValue || text })
                        });

                        const data = await response.json();
                        
                        this.messages.push({ role: 'bot', content: data.reply });
                        
                        // Keep core options available after AI response
                        this.currentOptions = [
                            { label: ' Prendre RDV', value: 'booking' },
                            { label: ' Triage Symptômes', value: 'triage' },
                            { label: ' Retour', value: 'start' }
                        ];

                    } catch (error) {
                        this.messages.push({ role: 'bot', content: "Désolé, je rencontre des difficultés de connexion. Veuillez réessayer." });
                    } finally {
                        this.typing = false;
                        this.scrollToBottom();
                    }
                },
                scrollToBottom() {
                    this.$nextTick(() => {
                        const chatMessages = document.getElementById('chat-messages');
                        if (chatMessages) chatMessages.scrollTop = chatMessages.scrollHeight;
                    });
                }
            }
        }
    </script>
</body>
</html>