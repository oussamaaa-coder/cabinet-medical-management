<div align="center">

# 🏥 MediCal

### Smart Medical Clinic Management System

Application web moderne de gestion de cabinet médical développée avec **Laravel 12**, **Tailwind CSS v4**, **Alpine.js** et des technologies avancées telles que **Three.js**, **GSAP** et **Gemini AI** afin d'offrir une expérience utilisateur premium.

<p>

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3-77C1D2?style=for-the-badge&logo=alpinedotjs&logoColor=white)

</p>

<p>

![Three.js](https://img.shields.io/badge/Three.js-000000?style=for-the-badge&logo=threedotjs&logoColor=white)
![GSAP](https://img.shields.io/badge/GSAP-88CE02?style=for-the-badge&logo=greensock&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white)
![Gemini AI](https://img.shields.io/badge/Gemini_AI-4285F4?style=for-the-badge&logo=google&logoColor=white)

</p>

</div>

---

# Overview

**MediCal** est une plateforme complète de gestion de cabinet médical conçue pour moderniser le suivi des patients, optimiser le travail du personnel médical et améliorer l'expérience des patients grâce à une interface moderne, des animations premium et une assistance intelligente basée sur l'IA.

L'application est développée avec une architecture MVC robuste sous Laravel et une interface utilisateur haut de gamme combinant animations, effets 3D et interactions fluides.

---

# Main Features

## Public Website

- Interactive landing page
- 3D animated heart powered by Three.js
- Glassmorphism UI
- Smooth scrolling
- GSAP animations
- Patient testimonials
- Contact form
- AI Medical Assistant
- Voice interaction
- French & Moroccan Darija support

---

## Patient Portal

- Secure authentication
- Medical profile
- Online appointment booking
- Appointment cancellation
- Medical records
- Prescription history
- Medication logs
- Vital signs
- Medical document archive

---

## Medical Staff Portal

### Doctor

- Dashboard
- Patient management
- Consultation management
- Prescription generator
- Nurse management
- Interactive calendar
- Internal messaging

### Nurse / Secretary

- Patient queue
- Appointment management
- Vital signs management
- Medical file preparation
- Collaboration with doctors

---

## Administration

- User management
- Doctor management
- Testimonials moderation
- Clinic configuration
- Statistics dashboard
- System settings

---

# AI Assistant

The platform integrates an intelligent medical assistant powered by **Google Gemini AI** capable of:

- Answering frequently asked questions
- Guiding patients through appointment booking
- Performing symptom pre-triage
- Voice recognition
- French language support
- Moroccan Darija support

---

# Technology Stack

## Backend

- Laravel 12
- PHP 8.2+
- Eloquent ORM
- MVC Architecture
- RESTful Routing

---

## Frontend

- Blade
- Tailwind CSS v4
- Alpine.js
- JavaScript ES6
- Vite

---

## Premium User Experience

- Three.js
- GSAP
- ScrollTrigger
- Lenis
- SplitType
- Glassmorphism
- Magnetic Buttons
- Responsive Design
- Dark Mode

---

## Database

- SQLite
- MySQL

---

## Development Tools

- Visual Studio Code
- Composer
- Node.js
- npm
- Git
- GitHub
- Postman

---

# Project Architecture

```text
medical-clinic

├── app
│   ├── Models
│   ├── Http
│   ├── Services
│   ├── Policies
│   └── Providers
│
├── database
│   ├── migrations
│   └── seeders
│
├── resources
│   ├── views
│   ├── css
│   └── js
│
├── routes
│
├── storage
│
└── public
```

---

# User Roles

| Role | Permissions |
|-------|-------------|
| Administrator | Full system management |
| Doctor | Medical consultations & prescriptions |
| Nurse / Secretary | Appointment & patient management |
| Patient | Personal medical space |

---

# Security

- Authentication
- Authorization
- Role-based Access Control
- CSRF Protection
- Input Validation
- Secure File Uploads

---

# Installation

## Clone the repository

```bash
git clone https://github.com/oussamaaa-coder/medical-clinic.git
```

## Install dependencies

```bash
composer install

npm install
```

## Environment

```bash
cp .env.example .env

php artisan key:generate
```

## Database

```bash
php artisan migrate

php artisan db:seed
```

## Run the project

```bash
php artisan serve

npm run dev
```

---

# Project Goals

- Modernize clinic management
- Improve patient experience
- Simplify medical workflows
- Digitalize medical records
- Enhance communication
- Integrate Artificial Intelligence
- Deliver a premium user experience

---

# Author

**Oussama El Hassar**

Full Stack Web Developer

GitHub: https://github.com/oussamaaa-coder

---

# License

This project was developed for educational and portfolio purposes.

© 2026 Oussama El Hassar
