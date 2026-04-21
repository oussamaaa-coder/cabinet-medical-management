@extends('layouts.sidebar')

@section('title', 'Aide & FAQ')
<link rel="icon" type="image/svg+xml" href="{{ asset('asset/img/logo.svg') }}">

@push('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/style_help.css') }}">
@endpush

@section('content')
    <div class="help-container">

        {{-- ── Hero Section ── --}}
        <div class="help-hero">
            <h1>Comment pouvons-nous vous aider ?</h1>
            <p>Besoin de conseils ou d'une aide technique ? Trouvez rapidement des réponses ou contactez notre support.</p>

            <div class="search-box">
                <input type="text" id="helpSearch" placeholder="Rechercher une question, un tutoriel...">
                <svg viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
            </div>
        </div>

        {{-- ── Categories ── --}}
        <div class="help-grid">
            <a href="#" class="help-cat-card">
                <div class="cat-icon">
                    <svg viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                        <path d="M16 2v4M8 2v4M3 10h18" />
                    </svg>
                </div>
                <h3>Rendez-vous</h3>
                <p>Gestion de l'agenda, prises de rendez-vous et rappels patients.</p>
            </a>
            <a href="#" class="help-cat-card">
                <div class="cat-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                    </svg>
                </div>
                <h3>Patients</h3>
                <p>Suivi des dossiers médicaux, historiques et antécédents.</p>
            </a>
            <a href="#" class="help-cat-card">
                <div class="cat-icon">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="3" />
                        <path
                            d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z" />
                    </svg>
                </div>
                <h3>Configuration</h3>
                <p>Personnalisation de vos paramètres et sécurité du compte.</p>
            </a>
        </div>

        {{-- ── FAQ Section ── --}}
        <div class="faq-section">
            <h2 class="faq-title">Foire Aux Questions</h2>

            @foreach($faqs as $group)
                <div class="faq-group">
                    <span class="faq-cat-label">{{ $group['category'] }}</span>
                    @foreach($group['questions'] as $index => $item)
                        <div class="accordion-item" id="faq-{{ $loop->parent->index }}-{{ $index }}">
                            <button type="button" class="accordion-trigger">
                                <span>{{ $item['q'] }}</span>
                                <svg viewBox="0 0 24 24">
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </button>
                            <div class="accordion-content">
                                <p>{{ $item['a'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        {{-- ── Contact Banner ── --}}
        <div class="contact-banner">
            <div class="contact-text">
                <h4>Vous n'avez pas trouvé votre réponse ?</h4>
                <p>Notre équipe de support est disponible du Lundi au Vendredi pour vous aider.</p>
            </div>
            <a href="mailto:support@medical.ma" class="btn-contact">Contacter le Support</a>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Accordion Logic
            const triggers = document.querySelectorAll('.accordion-trigger');

            triggers.forEach(trigger => {
                trigger.addEventListener('click', () => {
                    const item = trigger.closest('.accordion-item');
                    const isActive = item.classList.contains('active');

                    // Close all others
                    document.querySelectorAll('.accordion-item').forEach(other => {
                        other.classList.remove('active');
                    });

                    // Toggle current
                    if (!isActive) {
                        item.classList.add('active');
                    }
                });
            });

            // Search Logic (Simple Filter)
            const searchInput = document.getElementById('helpSearch');
            const faqItems = document.querySelectorAll('.accordion-item');

            searchInput.addEventListener('input', (e) => {
                const term = e.target.value.toLowerCase().trim();

                faqItems.forEach(item => {
                    const text = item.innerText.toLowerCase();
                    if (text.includes(term)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection