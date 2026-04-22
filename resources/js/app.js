import './bootstrap';
import Alpine from 'alpinejs';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from 'lenis';
import * as THREE from 'three';
import SplitType from 'split-type';

window.Alpine = Alpine;
Alpine.start();

gsap.registerPlugin(ScrollTrigger);

// 1. Smooth Scroll (Lenis)
const lenis = new Lenis({
    duration: 1.2,
    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
    smoothWheel: true
});

// Sync Lenis with ScrollTrigger
lenis.on('scroll', ScrollTrigger.update);

gsap.ticker.add((time) => {
    lenis.raf(time * 1000);
});

gsap.ticker.lagSmoothing(0);

// Scroll Progress Bar
const progressBar = document.querySelector('#scroll-progress');
lenis.on('scroll', ({ progress }) => {
    if (progressBar) {
        progressBar.style.width = `${progress * 100}%`;
    }
});


// Magnetic Buttons

document.querySelectorAll('.magnetic').forEach((btn) => {
    btn.addEventListener('mousemove', (e) => {
        const rect = btn.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width / 2;
        const y = e.clientY - rect.top - rect.height / 2;
        
        gsap.to(btn, {
            x: x * 0.3,
            y: y * 0.3,
            duration: 0.3,
            ease: 'power2.out'
        });
    });
    
    btn.addEventListener('mouseleave', () => {
        gsap.to(btn, {
            x: 0,
            y: 0,
            duration: 0.3,
            ease: 'elastic.out(1, 0.3)'
        });
    });
});

// 3. Three.js Organic Background
const initThree = () => {
    const container = document.querySelector('#hero-canvas');
    if (!container) return;

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
    
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    container.appendChild(renderer.domElement);

    // Geometry: Abstract Medical Shape (Heart)
    const heartShape = new THREE.Shape();
    heartShape.moveTo(0, 0.5);
    heartShape.bezierCurveTo(0, 0.5, 0.05, 1.2, 0.5, 1.2);
    heartShape.bezierCurveTo(1, 1.2, 1, 0.45, 1, 0.45);
    heartShape.bezierCurveTo(1, 0, 0.5, -0.4, 0, -1);
    heartShape.bezierCurveTo(-0.5, -0.4, -1, 0, -1, 0.45);
    heartShape.bezierCurveTo(-1, 0.45, -1, 1.2, -0.5, 1.2);
    heartShape.bezierCurveTo(-0.1, 1.2, 0, 0.5, 0, 0.5);

    const extrudeSettings = { depth: 0.4, bevelEnabled: true, bevelSegments: 3, steps: 2, bevelSize: 0.1, bevelThickness: 0.1 };
    const geometry = new THREE.ExtrudeGeometry(heartShape, extrudeSettings);
    geometry.center();
    
    // Responsive Scaling
    const isMobile = window.innerWidth < 768;
    const scale = isMobile ? 0.8 : 1.5;
    geometry.scale(scale, scale, scale);
    geometry.rotateZ(Math.PI);

    const material = new THREE.MeshPhongMaterial({ 
        color: 0x10b981, 
        wireframe: true,
        transparent: true,
        opacity: 0.2
    });
    const sphere = new THREE.LineSegments(new THREE.EdgesGeometry(geometry), new THREE.LineBasicMaterial({ color: 0x10b981, transparent: true, opacity: 0.3 }));
    scene.add(sphere);

    // Floating Particles
    const particlesGeometry = new THREE.BufferGeometry();
    const particlesCount = isMobile ? 800 : 2000;
    const posArray = new Float32Array(particlesCount * 3);
    for(let i=0; i < particlesCount * 3; i++) {
        posArray[i] = (Math.random() - 0.5) * (isMobile ? 10 : 15);
    }
    particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
    const particlesMaterial = new THREE.PointsMaterial({ size: 0.005, color: 0x10b981 });
    const particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
    scene.add(particlesMesh);

    const light = new THREE.PointLight(0xffffff, 1, 100);
    light.position.set(10, 10, 10);
    scene.add(light);
    scene.add(new THREE.AmbientLight(0xffffff, 0.5));

    camera.position.z = 4;

    const animate = () => {
        requestAnimationFrame(animate);
        sphere.rotation.x += 0.001;
        sphere.rotation.y += 0.002;
        particlesMesh.rotation.y += 0.001;
        
        // Parallax on mouse (Desktop only)
        if (!isMobile) {
            window.addEventListener('mousemove', (e) => {
                const x = (e.clientX / window.innerWidth - 0.5) * 0.3;
                const y = (e.clientY / window.innerHeight - 0.5) * 0.3;
                gsap.to(sphere.rotation, { x: y, y: x, duration: 1.5 });
            });
        }

        renderer.render(scene, camera);
    };

    window.addEventListener('resize', () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    });

    animate();
};

window.addEventListener('DOMContentLoaded', () => {
    initThree();
    
    // 4. GSAP Reveal Animations
    const splitTypes = document.querySelectorAll('[data-split]');
    splitTypes.forEach((char) => {
        const text = new SplitType(char, { types: 'words,chars' });
        
        gsap.from(text.chars, {
            opacity: 0,
            y: 50,
            rotateX: -90,
            duration: 1.5,
            stagger: 0.02,
            ease: 'expo.out',
            scrollTrigger: {
                trigger: char,
                start: 'top 85%',
                toggleActions: 'play none none reverse'
            }
        });
    });

    document.querySelectorAll('[data-gsap="reveal"]').forEach((el) => {
        gsap.from(el, {
            opacity: 0,
            y: 60,
            duration: 1.5,
            ease: 'power4.out',
            scrollTrigger: {
                trigger: el,
                start: 'top 90%'
            }
        });
    });

    // Navigation Color Shift
    ScrollTrigger.create({
        start: 'top -80',
        onEnter: () => gsap.to('nav .glass', { backgroundColor: 'rgba(255, 255, 255, 0.9)', duration: 0.3 }),
        onLeaveBack: () => gsap.to('nav .glass', { backgroundColor: 'rgba(255, 255, 255, 0.7)', duration: 0.3 })
    });

    // 5. Parallax Effects
    gsap.to('h1', {
        yPercent: 30,
        ease: 'none',
        scrollTrigger: {
            trigger: 'section.relative',
            start: 'top top',
            end: 'bottom top',
            scrub: true
        }
    });
});


