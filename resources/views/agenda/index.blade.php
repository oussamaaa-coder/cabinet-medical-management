@extends('layouts.sidebar')

@section('title', 'Agenda Médical')
<link rel="icon" type="image/svg+xml" href="{{ asset('asset/img/logo.svg') }}">

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'medical-blue': 'var(--accent)',
                        'accent-light': 'var(--accent-light)',
                        'accent-mid': 'var(--accent-mid)',
                        'bg-page': 'var(--bg-page)',
                        'bg-card': 'var(--bg-card)',
                        'bg-field': 'var(--bg-field)',
                        'border-custom': 'var(--border)',
                        'text-primary': 'var(--text-primary)',
                        'text-secondary': 'var(--text-secondary)',
                        'text-muted': 'var(--text-muted)',
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        
        /* Premium Scrollbar */
        .lg\:pr-2::-webkit-scrollbar { width: 5px; }
        .lg\:pr-2::-webkit-scrollbar-track { background: transparent; }
        .lg\:pr-2::-webkit-scrollbar-thumb { 
            background: var(--border); 
            border-radius: 10px; 
        }
        .lg\:pr-2::-webkit-scrollbar-thumb:hover { background: var(--accent-mid); }

        .calendar-container {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(120px, 1fr));
            gap: 8px;
        }

        @media (max-width: 1400px) {
            .calendar-grid { grid-template-columns: repeat(7, minmax(100px, 1fr)); }
        }

        @media (max-width: 768px) {
            .calendar-grid { 
                grid-template-columns: repeat(7, minmax(90px, 1fr));
                gap: 4px;
            }
        }

        /* Premium States */
        .day-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--border);
            background: var(--bg-card);
        }
        .day-card:hover {
            transform: translateY(-2px);
            border-color: var(--accent-mid);
            box-shadow: 0 10px 20px -5px rgba(0,0,0,0.05);
        }
        .day-card.selected {
            background: linear-gradient(135deg, var(--accent), #2d6349) !important;
            border-color: var(--accent) !important;
            box-shadow: 0 12px 24px -8px rgba(58, 125, 92, 0.4);
        }
        .day-card.today {
            border-color: var(--accent);
            background: var(--accent-light);
        }

        /* RDV Cards */
        .rdv-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }
        .rdv-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--accent);
            opacity: 0.6;
        }
        .rdv-card:hover {
            transform: translateX(4px);
            border-color: var(--accent-mid);
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        /* Layout */
        .agenda-flex-wrapper {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }
        @media (min-width: 1200px) {
            .agenda-flex-wrapper {
                flex-direction: row !important;
                flex-wrap: nowrap !important;
                align-items: flex-start !important;
            }
            .agenda-calendar-col {
                flex: 1 !important;
                min-width: 0 !important;
            }
            .agenda-planning-col {
                width: 420px !important;
                flex-shrink: 0 !important;
                position: sticky;
                top: 24px;
            }
        }

        /* Status Colors Overrides */
        .bg-medical-blue { background-color: var(--accent); }
        .text-medical-blue { color: var(--accent); }
    </style>

    <div class="p-6 bg-bg-page min-h-screen transition-colors duration-300" x-data="calendarApp()"
        x-init="init()" x-cloak>

        <!-- Toast Notification -->
        <div x-show="successMessage" x-transition.opacity.duration.300ms
             class="fixed top-8 right-8 z-[100] flex items-center gap-3 bg-medical-blue text-white px-6 py-4 rounded-xl shadow-2xl"
             style="display: none;">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="font-bold whitespace-nowrap" x-text="successMessage"></span>
        </div>

        <div class="agenda-flex-wrapper">

            <!-- Left Column: Calendar -->
            <div
                class="agenda-calendar-col w-full bg-bg-card rounded-3xl shadow-sm border border-border-custom p-8 transition-colors">
                <div class="flex items-center justify-between mb-10">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 tracking-tight"
                            x-text="monthNames[month] + ' ' + year"></h2>
                        <p class="text-text-secondary mt-1 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-accent animate-pulse"></span>
                            Gestion des consultations
                        </p>
                    </div>
                    <div class="flex gap-3 bg-bg-page p-1.5 rounded-2xl border border-border-custom">
                        <button @click="previousMonth()"
                            class="p-2.5 hover:bg-bg-card hover:shadow-sm rounded-xl transition-all text-text-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                        </button>
                        <button @click="nextMonth()"
                            class="p-2.5 hover:bg-bg-card hover:shadow-sm rounded-xl transition-all text-text-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="calendar-container">
                    <div class="calendar-grid mb-4">
                        <template x-for="day in daysOfWeek">
                            <div class="text-center text-[11px] font-bold text-text-muted uppercase tracking-widest py-2" x-text="day"></div>
                        </template>
                    </div>

                    <div class="calendar-grid">
                        <template x-for="blankday in blankdays">
                            <div class="h-28 md:h-36 opacity-20">
                                <div class="w-full h-full border border-dashed border-border-custom rounded-2xl"></div>
                            </div>
                        </template>
                        <template x-for="(date, dateIndex) in noofdays" :key="dateIndex">
                            <div @click="selectDate(date)"
                                class="day-card h-28 md:h-36 rounded-2xl p-4 cursor-pointer relative group overflow-hidden"
                                :class="{
                                    'selected text-white': isSelected(date),
                                    'today': isToday(date) && !isSelected(date)
                                }">
                                <div class="flex justify-between items-start">
                                    <span class="text-lg font-bold tracking-tight"
                                        :class="isSelected(date) ? 'text-white' : 'text-text-primary'"
                                        x-text="date"></span>
                                    <template x-if="isToday(date)">
                                        <div class="w-2 h-2 rounded-full bg-accent" :class="isSelected(date) ? 'bg-white' : ''"></div>
                                    </template>
                                </div>

                                <template x-if="isHoliday(date)">
                                    <p class="text-[9px] mt-1 font-bold uppercase tracking-wider opacity-60"
                                       :class="isSelected(date) ? 'text-white' : 'text-red-500'"
                                       x-text="holidays[year + '-' + String(month + 1).padStart(2, '0') + '-' + String(date).padStart(2, '0')]"></p>
                                </template>

                                <!-- Appointment Indicators -->
                                <div class="absolute bottom-4 left-4 right-4">
                                    <div class="flex gap-1">
                                        <template x-for="apt in getAppointmentsForDate(date).slice(0, 4)">
                                            <div class="w-1.5 h-1.5 rounded-full" 
                                                 :class="isSelected(date) ? 'bg-white/40' : getStatusColor(apt.status)"></div>
                                        </template>
                                        <template x-if="getAppointmentsForDate(date).length > 4">
                                            <div class="text-[9px] font-bold opacity-60"
                                                 :class="isSelected(date) ? 'text-white' : 'text-text-muted'">
                                                 +<span x-text="getAppointmentsForDate(date).length - 4"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Right Column: Daily Schedule -->
            <div class="agenda-planning-col w-full flex flex-col gap-6">
                <!-- Header with Actions -->
                <div class="bg-bg-card p-6 rounded-3xl border border-border-custom shadow-sm">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex flex-col">
                            <span class="text-xs text-accent font-bold uppercase tracking-wider mb-1">Planning du jour</span>
                            <span x-text="formatFullDate(selectedDate)"></span>
                        </h3>
                    </div>
                    
                    <button @click="showNewModal = true"
                        class="w-full bg-medical-blue text-white px-6 py-4 rounded-2xl font-bold flex items-center justify-center gap-3 hover:shadow-lg hover:shadow-green-100 transition-all group">
                        <div class="p-1 bg-white/20 rounded-lg group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        Nouveau Rendez-vous
                    </button>
                </div>

                <!-- Appointments List -->
                <div class="flex flex-col gap-4 overflow-y-auto max-h-[calc(100vh-320px)] lg:pr-2 px-1">
                    <template x-if="dailyAppointments.length === 0">
                        <div
                            class="bg-white dark:bg-[#1a2420] rounded-3xl border border-dashed border-border-custom p-10 text-center flex flex-col items-center">
                            <div
                                class="bg-bg-page w-20 h-20 rounded-full flex items-center justify-center mb-6 border border-border-custom">
                                <svg class="w-10 h-10 text-text-muted opacity-30" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <h4 class="text-text-primary font-bold text-lg mb-1">Journée calme</h4>
                            <p class="text-sm text-text-secondary">Aucun rendez-vous pour cette date</p>
                        </div>
                    </template>
                    
                    <template x-for="apt in dailyAppointments">
                        <div @click="viewDetails(apt)"
                            class="rdv-card rounded-2xl p-5 cursor-pointer"
                            :class="getStatusBorder(apt.status)">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-accent-light flex items-center justify-center text-accent font-bold text-lg"
                                        x-text="apt.patient.name.substring(0,2).toUpperCase()"></div>
                                    <div>
                                        <h4 class="font-bold text-text-primary leading-tight text-lg" x-text="apt.patient.name"></h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-[11px] font-bold text-accent uppercase tracking-wider" x-text="'Dr. ' + apt.doctor.last_name"></span>
                                            <span class="w-1 h-1 rounded-full bg-border-custom"></span>
                                            <span class="text-[11px] text-text-secondary font-medium" x-text="apt.type"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-widest border"
                                    :class="getStatusBadge(apt.status)">
                                    <span x-html="getStatusIcon(apt.status)"></span>
                                    <span x-text="translateStatus(apt.status)"></span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between pt-4 border-t border-border-custom/50 mt-2">
                                <div class="flex items-center gap-2 text-text-secondary">
                                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm font-bold tracking-tight"
                                        x-text="apt.start_time.substring(0,5) + ' - ' + apt.end_time.substring(0,5)"></span>
                                </div>
                                <div class="flex -space-x-2">
                                    <template x-if="apt.sms_reminder">
                                        <div class="w-6 h-6 rounded-full bg-bg-page border border-border-custom flex items-center justify-center" title="SMS Activé">
                                            <svg class="w-3 h-3 text-accent" fill="currentColor" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
                                        </div>
                                    </template>
                                    <template x-if="apt.email_reminder">
                                        <div class="w-6 h-6 rounded-full bg-bg-page border border-border-custom flex items-center justify-center" title="Email Activé">
                                            <svg class="w-3 h-3 text-accent" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Modals -->
        <!-- New Appointment Modal -->
        <div x-show="showNewModal"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
            x-transition.opacity>
            <div @click.away="showNewModal = false"
                class="bg-white dark:bg-[#1a2420] rounded-3xl shadow-2xl w-full max-w-xl overflow-hidden border border-gray-200 dark:border-gray-800">
                <div class="bg-medical-blue p-6 text-white flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold">Nouveau Rendez-vous</h3>
                        <p class="text-sm text-green-100" x-text="formatFullDate(selectedDate)"></p>
                    </div>
                    <button @click="showNewModal = false" class="p-2 hover:bg-white/10 rounded-full transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                <div x-show="errorMessage" x-transition 
                    class="mx-8 mt-4 p-4 bg-red-50 border border-red-100 rounded-2xl flex items-center gap-3 text-red-600">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span class="text-sm font-bold" x-text="errorMessage"></span>
                </div>

                <form @submit.prevent="createAppointment" class="p-8 space-y-6">
                    <!-- Patient & Doctor -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Patient</label>
                            <select x-model="newApt.patient_id" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-[#0f1714] text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-medical-blue outline-none transition-all">
                                <option value="">Sélectionner un patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Médecin</label>
                            @if(auth()->check() && auth()->user()->role === 'doctor')
                                {{-- Doctor: auto-assigned, read-only display --}}
                                @php $myDoctor = $doctors->first(); @endphp
                                <div class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-[#0f1714] text-gray-600 dark:text-gray-400">
                                    Dr. {{ $myDoctor ? $myDoctor->first_name . ' ' . $myDoctor->last_name : auth()->user()->name }}
                                </div>
                            @else
                                {{-- Admin: full doctor selector --}}
                                <select x-model="newApt.doctor_id" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-[#0f1714] text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-medical-blue outline-none transition-all">
                                    <option value="">Sélectionner un médecin</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Heure Début</label>
                            <input type="time" x-model="newApt.start_time" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-medical-blue focus:border-medical-blue outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Heure Fin</label>
                            <input type="time" x-model="newApt.end_time" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-medical-blue focus:border-medical-blue outline-none transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Type</label>
                            <select x-model="newApt.type" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-medical-blue focus:border-medical-blue outline-none transition-all">
                                <option value="Consultation">Consultation</option>
                                <option value="Contrôle">Contrôle</option>
                                <option value="Urgence">Urgence</option>
                                <option value="Examen">Examen</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Statut Initial</label>
                            <div class="flex gap-2">
                                <template x-for="status in ['planned', 'urgent']">
                                    <button type="button" @click="newApt.status = status"
                                        class="flex-1 flex items-center justify-center gap-2 px-4 py-3 rounded-xl border-2 transition-all font-semibold text-sm"
                                        :class="newApt.status === status ? getStatusActiveBorder(status) + ' ' + getStatusTextColor(status) + ' bg-white shadow-sm' : 'border-gray-100 text-gray-400 hover:border-gray-200'">
                                        <span x-html="getStatusIcon(status)"></span>
                                        <span x-text="translateStatus(status)"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Notes</label>
                        <textarea x-model="newApt.notes" rows="3"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-[#0f1714] text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-medical-blue outline-none transition-all"
                            placeholder="Ajouter des notes..."></textarea>
                    </div>

                    <div class="flex gap-6">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative w-10 h-6">
                                <input type="checkbox" x-model="newApt.sms_reminder" class="sr-only peer">
                                <div
                                    class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:bg-medical-blue transition-colors">
                                </div>
                                <div
                                    class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full peer-checked:translate-x-4 transition-transform">
                                </div>
                            </div>
                            <span class="text-sm font-medium text-gray-600 group-hover:text-medical-blue">Rappel SMS</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative w-10 h-6">
                                <input type="checkbox" x-model="newApt.email_reminder" class="sr-only peer">
                                <div
                                    class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:bg-medical-blue transition-colors">
                                </div>
                                <div
                                    class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full peer-checked:translate-x-4 transition-transform">
                                </div>
                            </div>
                            <span class="text-sm font-medium text-gray-600 group-hover:text-medical-blue">Rappel
                                Email</span>
                        </label>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" @click="showNewModal = false"
                            class="px-6 py-3 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition-all">Annuler</button>
                        <button type="submit"
                            class="px-8 py-3 bg-medical-blue text-white rounded-xl font-bold shadow-lg shadow-green-100 hover:bg-opacity-90 transition-all">Créer
                            le RDV</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Appointment Detail Modal -->
        <div x-show="showDetailModal"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
            x-transition.opacity>
            <div @click.away="showDetailModal = false"
                class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden" x-show="selectedApt">
                <template x-if="selectedApt">
                    <div>
                        <div class="p-8 pb-4 relative">
                            <button @click="showDetailModal = false"
                                class="absolute right-6 top-6 p-2 hover:bg-gray-100 rounded-full text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>

                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-16 h-16 rounded-2xl bg-medical-blue text-white flex items-center justify-center text-2xl font-bold"
                                    x-text="selectedApt.patient.name.substring(0,2).toUpperCase()"></div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800" x-text="selectedApt.patient.name"></h3>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold text-medical-blue bg-green-50 px-2 py-0.5 rounded-lg" x-text="'Dr. ' + selectedApt.doctor.first_name + ' ' + selectedApt.doctor.last_name"></span>
                                        <span class="text-gray-400 text-sm">•</span>
                                        <p class="text-gray-500 text-sm" x-text="selectedApt.type"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-8">
                                <div class="bg-gray-50 p-4 rounded-2xl">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Date</p>
                                    <p class="font-bold text-gray-700" x-text="formatFullDate(selectedApt.date)"></p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-2xl">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Horaire</p>
                                    <p class="font-bold text-gray-700"
                                        x-text="selectedApt.start_time.substring(0,5) + ' - ' + selectedApt.end_time.substring(0,5)">
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Modifier le Statut</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <template x-for="status in ['planned', 'urgent', 'completed', 'cancelled']">
                                            <button type="button" @click="selectedApt.status = status; updateStatus()"
                                                class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl border-2 transition-all font-semibold text-sm"
                                                :class="selectedApt.status === status ? getStatusActiveBorder(status) + ' ' + getStatusTextColor(status) + ' bg-white shadow-sm' : 'border-gray-100 text-gray-400 hover:border-gray-200'">
                                                <span x-html="getStatusIcon(status)"></span>
                                                <span x-text="translateStatus(status)"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>

                                <div x-show="selectedApt.status === 'completed'" x-transition.opacity>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Infirmier(e) en charge des soins</label>
                                    <select x-model="selectedApt.nurse_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-medical-blue outline-none text-gray-600 bg-white">
                                        <option value="">-- Pas d'infirmier(e) assigné(e) --</option>
                                        @foreach($nurses as $nurse)
                                            <option value="{{ $nurse->id }}">{{ $nurse->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Notes</label>
                                    <textarea x-model="selectedApt.notes" rows="3"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-medical-blue outline-none text-gray-600"
                                        placeholder="Pas de notes..."></textarea>
                                </div>

                                <div class="flex gap-4 p-4 rounded-2xl border border-gray-100 bg-gray-50/50">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full"
                                            :class="selectedApt.sms_reminder ? 'bg-medical-blue' : 'bg-gray-300'"></div>
                                        <span class="text-xs font-bold text-gray-500">SMS</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full"
                                            :class="selectedApt.email_reminder ? 'bg-medical-blue' : 'bg-gray-300'"></div>
                                        <span class="text-xs font-bold text-gray-500">Email</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-8 pt-0 flex gap-3">
                            <button @click="updateAppointment"
                                class="flex-1 bg-medical-blue text-white py-3 rounded-xl font-bold shadow-lg shadow-green-100 hover:bg-opacity-90">
                                Enregistrer
                            </button>
                            <button @click="cancelAppointment"
                                class="px-4 py-3 bg-red-50 text-red-500 rounded-xl hover:bg-red-100 transition-all"
                                title="Supprimer">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <script>
        function calendarApp() {
            return {
                month: '',
                year: '',
                noofdays: [],
                blankdays: [],
                daysOfWeek: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],

                selectedDate: '', // Format: YYYY-MM-DD
                dailyAppointments: [],
                monthlyAppointments: {}, // Cache by date
                holidays: {
                    '2026-01-01': "Jour de l'An",
                    '2026-01-11': "Manifeste de l'Indépendance",
                    '2026-03-20': "Aïd el-Fitr",
                    '2026-03-21': "Aïd el-Fitr",
                    '2026-05-01': "Fête du Travail",
                    '2026-05-27': "Aïd el-Adha",
                    '2026-05-28': "Aïd el-Adha",
                    '2026-06-17': "1er Moharram",
                    '2026-07-30': "Fête du Trône",
                    '2026-08-14': "Allégeance Oued Eddahab",
                    '2026-08-20': "Révolution du Roi et du Peuple",
                    '2026-08-21': "Fête de la Jeunesse",
                    '2026-08-26': "Aïd el-Mawlid",
                    '2026-08-27': "Aïd el-Mawlid",
                    '2026-11-06': "Marche Verte",
                    '2026-11-18': "Fête de l'Indépendance"
                },

                showNewModal: false,
                showDetailModal: false,
                errorMessage: '',
                successMessage: '',

                newApt: {
                    patient_id: '',
                    {{-- Pre-assign doctor_id for doctor users so no manual selection is needed --}}
                    doctor_id: '{{ auth()->check() && auth()->user()->role === "doctor" && ($doctors->first() ?? null) ? $doctors->first()->id : "" }}',
                    date: '',
                    start_time: '09:00',
                    end_time: '09:30',
                    type: 'Consultation',
                    status: 'planned',
                    notes: '',
                    sms_reminder: false,
                    email_reminder: false
                },

                selectedApt: null,

                init() {
                    let today = new Date();
                    this.month = today.getMonth();
                    this.year = today.getFullYear();
                    this.selectedDate = this.formatDate(today);
                    this.getNoOfDays();
                    this.fetchAppointments();
                },

                getNoOfDays() {
                    let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
                    let dayOfWeek = new Date(this.year, this.month).getDay();
                    let blankdaysArray = [];
                    for (var i = 1; i <= dayOfWeek; i++) {
                        blankdaysArray.push(i);
                    }
                    let daysArray = [];
                    for (var i = 1; i <= daysInMonth; i++) {
                        daysArray.push(i);
                    }
                    this.blankdays = blankdaysArray;
                    this.noofdays = daysArray;
                },

                nextMonth() {
                    if (this.month == 11) {
                        this.month = 0;
                        this.year++;
                    } else {
                        this.month++;
                    }
                    this.getNoOfDays();
                    this.fetchAppointments(); // Refresh calendar indicators
                },

                previousMonth() {
                    if (this.month == 0) {
                        this.month = 11;
                        this.year--;
                    } else {
                        this.month--;
                    }
                    this.getNoOfDays();
                    this.fetchAppointments();
                },

                formatDate(d) {
                    let month = '' + (d.getMonth() + 1);
                    let day = '' + d.getDate();
                    let year = d.getFullYear();
                    if (month.length < 2) month = '0' + month;
                    if (day.length < 2) day = '0' + day;
                    return [year, month, day].join('-');
                },

                formatFullDate(dateStr) {
                    if (!dateStr) return '';
                    const date = new Date(dateStr);
                    return date.toLocaleDateString('fr-FR', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
                },

                isToday(day) {
                    const today = new Date();
                    return day === today.getDate() &&
                        this.month === today.getMonth() &&
                        this.year === today.getFullYear();
                },

                isSelected(day) {
                    const dateStr = this.year + '-' + String(this.month + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0');
                    return this.selectedDate === dateStr;
                },

                selectDate(day) {
                    this.selectedDate = this.year + '-' + String(this.month + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0');
                    this.fetchDailyAppointments();
                },

                fetchAppointments() {
                    // Fetch monthly indicators
                    fetch(`/api/appointments/monthly-status?month=${this.month + 1}&year=${this.year}`)
                        .then(res => res.json())
                        .then(data => {
                            this.monthlyAppointments = data;
                            this.fetchDailyAppointments(); // Also load details for selected date
                        });
                },

                fetchDailyAppointments() {
                    fetch(`/api/appointments?date=${this.selectedDate}`)
                        .then(res => res.json())
                        .then(data => {
                            this.dailyAppointments = data;
                        });
                },

                getAppointmentsForDate(day) {
                    // Simplified: assuming we might have indicators in monthlyAppointments
                    // Logic based on dailyAppointments if it matches selectedDate, 
                    // but for calendar view we'd need more data.
                    // For now, let's say we only show dots if any exist for that day.
                    const dateStr = this.year + '-' + String(this.month + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0');
                    return this.monthlyAppointments[dateStr] ? [1] : []; // Dummy array for dots
                },

                isHoliday(day) {
                    const dateStr = this.year + '-' + String(this.month + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0');
                    return !!this.holidays[dateStr];
                },

                getHolidayNameForSelectedDate() {
                    return this.holidays[this.selectedDate] || null;
                },

                getStatusColor(status) {
                    switch (status) {
                        case 'planned': return 'bg-blue-500';
                        case 'completed': return 'bg-green-500';
                        case 'cancelled': return 'bg-red-500';
                        case 'urgent': return 'bg-orange-500';
                        default: return 'bg-gray-400';
                    }
                },

                getStatusBadge(status) {
                    switch (status) {
                        case 'planned': return 'bg-blue-50/50 text-blue-600 border-blue-100';
                        case 'completed': return 'bg-green-50 text-green-600 border-green-100';
                        case 'cancelled': return 'bg-red-50 text-red-600 border-red-100';
                        case 'urgent': return 'bg-orange-50 text-orange-600 border-orange-100';
                    }
                },

                getStatusBorder(status) {
                    switch (status) {
                        case 'planned': return 'border-l-blue-400';
                        case 'completed': return 'border-l-green-400';
                        case 'cancelled': return 'border-l-red-400';
                        case 'urgent': return 'border-l-orange-400';
                    }
                },

                getStatusTextColor(status) {
                    switch (status) {
                        case 'planned': return 'text-blue-600';
                        case 'completed': return 'text-green-600';
                        case 'cancelled': return 'text-red-500';
                        case 'urgent': return 'text-orange-500';
                    }
                },

                translateStatus(status) {
                    switch (status) {
                        case 'planned': return 'Planifié';
                        case 'completed': return 'Terminé';
                        case 'cancelled': return 'Annulé';
                        case 'urgent': return 'Urgent';
                    }
                },

                getStatusIcon(status) {
                    switch (status) {
                        case 'planned': return `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>`;
                        case 'urgent': return `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>`;
                        case 'completed': return `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
                        case 'cancelled': return `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
                        default: return '';
                    }
                },

                getStatusActiveBorder(status) {
                    switch (status) {
                        case 'planned': return 'border-blue-500 bg-blue-50/10';
                        case 'urgent': return 'border-orange-500 bg-orange-50/10';
                        case 'completed': return 'border-green-500 bg-green-50/10';
                        case 'cancelled': return 'border-red-500 bg-red-50/10';
                    }
                },

                createAppointment() {
                    this.newApt.date = this.selectedDate;
                    fetch('/appointments/store', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(this.newApt)
                    })
                        .then(async res => {
                            const data = await res.json();
                            if (!res.ok) {
                                let errMsg = data.message || 'Erreur lors de la création';
                                if (data.errors) {
                                    const firstKey = Object.keys(data.errors)[0];
                                    errMsg = data.errors[firstKey][0];
                                }
                                throw new Error(errMsg);
                            }
                            return data;
                        })
                        .then(data => {
                            if (data.success) {
                                this.showNewModal = false;
                                this.errorMessage = '';
                                this.successMessage = data.message || 'Rendez-vous créé avec succès.';
                                setTimeout(() => { this.successMessage = ''; }, 3000);
                                this.fetchDailyAppointments();
                                this.fetchAppointments();
                                this.resetNewApt();
                            } else {
                                this.errorMessage = data.message || 'Erreur lors de la création';
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            this.errorMessage = err.message || 'Erreur: Impossible de créer le rendez-vous.';
                        });
                },

                viewDetails(apt) {
                    this.selectedApt = JSON.parse(JSON.stringify(apt)); // Clone
                    this.showDetailModal = true;
                },

                updateAppointment() {
                    fetch(`/appointments/${this.selectedApt.id}/update`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            status: this.selectedApt.status,
                            notes: this.selectedApt.notes,
                            nurse_id: this.selectedApt.nurse_id
                        })
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                this.showDetailModal = false;
                                this.successMessage = data.message || 'Rendez-vous mis à jour.';
                                setTimeout(() => { this.successMessage = ''; }, 3000);
                                this.fetchDailyAppointments();
                                this.fetchAppointments();
                            }
                        });
                },

                cancelAppointment() {
                    if (confirm('Êtes-vous sûr de vouloir annuler ce rendez-vous ?')) {
                        fetch(`/appointments/${this.selectedApt.id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    this.showDetailModal = false;
                                    this.successMessage = data.message || 'Rendez-vous annulé.';
                                    setTimeout(() => { this.successMessage = ''; }, 3000);
                                    this.fetchDailyAppointments();
                                    this.fetchAppointments();
                                }
                            });
                    }
                },

                resetNewApt() {
                    this.newApt = {
                        patient_id: '',
                        doctor_id: '{{ auth()->check() && auth()->user()->role === "doctor" && ($doctors->first() ?? null) ? $doctors->first()->id : "" }}',
                        date: '',
                        start_time: '09:00',
                        end_time: '09:30',
                        type: 'Consultation',
                        status: 'planned',
                        notes: '',
                        sms_reminder: false,
                        email_reminder: false
                    };
                }
            }
        }
    </script>
@endsection