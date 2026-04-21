/**
 * Page Transitions - "Le Voile de Verre" (CORRIGÉ & ROBUSTE)
 * MediCal Application
 * 
 * Ce script gère les transitions fluides entre les pages Laravel.
 * Correction : Empêche le double déclenchement, les écouteurs redondants et les conflits de navigation.
 */

(function() {
    // 1. PROTECTION CONTRE LES INCLUSIONS MULTIPLES
    // Si le script est chargé deux fois, on ignore le second chargement.
    if (window.__TRANSITIONS_INITIALIZED__) return;
    window.__TRANSITIONS_INITIALIZED__ = true;

    // État de navigation global
    window.isNavigating = false;

    const initTransitions = () => {
        const overlay = document.querySelector('#page-transition-overlay');
        const logo = document.querySelector('.transition-logo');

        if (!overlay) return;

        /**
         * ANIMATION D'ENTRÉE (Quand la page a fini de charger)
         */
        const animateIn = () => {
            gsap.killTweensOf([overlay, logo]); // Arrête toute animation en cours
            
            const tl = gsap.timeline();
            tl.to(logo, {
                scale: 1.1,
                opacity: 1,
                duration: 0.4,
                ease: "power2.out"
            })
            .to(overlay, {
                opacity: 0,
                duration: 0.5,
                ease: "power2.inOut",
                onComplete: () => {
                    overlay.style.visibility = 'hidden';
                    document.body.classList.remove('is-transitioning');
                    window.isNavigating = false; // Libère le verrou
                }
            });
        };

        /**
         * ANIMATION DE SORTIE (Avant de changer de page)
         */
        const animateOut = (targetHref) => {
            if (window.isNavigating) return;
            window.isNavigating = true;

            document.body.classList.add('is-transitioning');
            overlay.style.visibility = 'visible';

            const tl = gsap.timeline({
                onComplete: () => {
                    window.location.href = targetHref;
                }
            });

            tl.to(overlay, {
                opacity: 1,
                duration: 0.4,
                ease: "power2.inOut"
            })
            .fromTo(logo, {
                scale: 0.8,
                opacity: 0
            }, {
                scale: 1,
                opacity: 1,
                duration: 0.3,
                ease: "back.out(1.7)"
            }, "-=0.1");
        };

        // Déclencher l'entrée immédiatement
        animateIn();

        /**
         * DÉLÉGATION D'ÉVÉNEMENTS (Un seul écouteur pour tout le document)
         * C'est la méthode la plus robuste pour éviter les double-clics et les conflits.
         */
        document.addEventListener('click', (e) => {
            // Trouve le lien <a> le plus proche (gestion du clic sur une icône dans un lien)
            const anchor = e.target.closest('a');

            // Conditions d'exclusion
            if (!anchor) return;
            if (window.isNavigating) {
                e.preventDefault();
                return;
            }

            const href = anchor.getAttribute('href');
            const target = anchor.getAttribute('target');

            // On ignore :
            // - Les clics droits ou avec touches (Ctrl, Shift, etc.)
            // - Les liens externes (target="_blank")
            // - Les ancres (#)
            // - Les protocoles spéciaux (mailto:, tel:, javascript:)
            // - Les clics déjà annulés
            if (
                e.button !== 0 || 
                e.ctrlKey || e.shiftKey || e.altKey || e.metaKey ||
                e.defaultPrevented ||
                (target && target === '_blank') ||
                !href || 
                href.startsWith('#') || 
                href.startsWith('mailto:') || 
                href.startsWith('tel:') || 
                href.startsWith('javascript:')
            ) return;

            // Vérification de même origine (pour éviter d'animer vers un autre site)
            const isSameOrigin = anchor.hostname === window.location.hostname || !href.includes('://');
            if (!isSameOrigin) return;

            // TOUT EST VALIDE : On lance la transition
            e.preventDefault();
            e.stopPropagation(); // Évite que d'autres scripts ne captent le clic
            animateOut(href);
        }, true); // Use capture phase for higher priority

        /**
         * GESTION DU BOUTON RETOUR (BFCache)
         */
        window.addEventListener('pageshow', (event) => {
            if (event.persisted) {
                window.isNavigating = false;
                animateIn();
            }
        });
    };

    // Initialisation robuste
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTransitions);
    } else {
        initTransitions();
    }
})();
