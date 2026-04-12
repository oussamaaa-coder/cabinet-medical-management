@extends('layouts.sidebar')

@section('title', 'Agenda Médical')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        darkMode: 'class',
    }
</script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
    [x-cloak] { display: none !important; }
    .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); }
    .bg-medical-blue { background-color: #3A7D5C; }
    .text-medical-blue { color: #3A7D5C; }
    .border-medical-blue { border-color: #3A7D5C; }
</style>

<div class="p-6 bg-gray-50 dark:bg-[#0f1714] min-h-screen transition-colors duration-300" x-data="calendarApp()" x-init="init()" x-cloak>
    <div class="flex flex-col md:flex-row gap-6">
        
        <!-- Left Column: Calendar -->
        <div class="w-full md:w-3/5 bg-white dark:bg-[#1a2420] rounded-2xl shadow-sm border border-gray-200 dark:border-gray-800 p-6 transition-colors">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100" x-text="monthNames[month] + ' ' + year"></h2>
                    <p class="text-gray-500 dark:text-gray-400">Gérez vos rendez-vous</p>
                </div>
                <div class="flex gap-2">
                    <button @click="previousMonth()" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors text-gray-600 dark:text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button @click="nextMonth()" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors text-gray-600 dark:text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>

            <div class="calendar-grid mb-2">
                <template x-for="day in daysOfWeek">
                    <div class="text-center text-xs font-bold text-gray-400 uppercase py-2" x-text="day"></div>
                </template>
            </div>

            <div class="calendar-grid gap-1">
                <template x-for="blankday in blankdays">
                    <div class="h-24 md:h-32"></div>
                </template>
                <template x-for="(date, dateIndex) in noofdays" :key="dateIndex">
                    <div 
                        @click="selectDate(date)"
                        class="h-24 md:h-32 border border-gray-100 dark:border-gray-800 rounded-xl p-2 cursor-pointer transition-all hover:border-medical-blue relative group"
                        :class="{
                            'bg-medical-blue text-white shadow-lg shadow-green-100 dark:shadow-green-900/20 border-medical-blue': isSelected(date),
                            'bg-green-50/50 dark:bg-green-900/10 border-green-200 dark:border-green-800/30': isToday(date) && !isSelected(date),
                            'bg-white dark:bg-[#1a2420]': !isSelected(date) && !isToday(date)
                        }"
                    >
                        <div class="flex justify-between items-start">
                            <span class="text-sm font-semibold" :class="isSelected(date) ? 'text-white' : 'text-gray-700 dark:text-gray-300'" x-text="date"></span>
                            <div class="flex flex-col items-end gap-1">
                                <template x-if="isToday(date)">
                                    <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-green-500 text-white font-bold uppercase tracking-wider">Aujourd'hui</span>
                                </template>
                                <template x-if="isHoliday(date)">
                                    <span class="text-[9px] px-1.5 py-0.5 rounded-full bg-red-100 text-red-600 font-bold uppercase tracking-wider">Férié</span>
                                </template>
                            </div>
                        </div>
                        
                        <!-- Appointment Indicators -->
                        <div class="mt-2 flex flex-wrap gap-1">
                            <template x-for="apt in getAppointmentsForDate(date).slice(0, 3)">
                                <div class="w-1.5 h-1.5 rounded-full" :class="getStatusColor(apt.status)"></div>
                            </template>
                            <template x-if="getAppointmentsForDate(date).length > 3">
                                <div class="text-[10px] text-gray-400 font-medium">+<span x-text="getAppointmentsForDate(date).length - 3"></span></div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Right Column: Daily Schedule -->
        <div class="w-full md:w-2/5 flex flex-col gap-6">
            <!-- Header with Actions -->
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">
                    Planning du <span x-text="formatFullDate(selectedDate)"></span>
                    <template x-if="getHolidayNameForSelectedDate()">
                        <span class="block text-sm text-red-500 font-semibold" x-text="getHolidayNameForSelectedDate()"></span>
                    </template>
                </h3>
                <button @click="showNewModal = true" class="bg-medical-blue text-white px-4 py-2 rounded-xl font-semibold flex items-center gap-2 hover:bg-opacity-90 transition-all shadow-md shadow-green-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Nouveau RDV
                </button>
            </div>

            <!-- Appointments List -->
            <div class="flex flex-col gap-4 overflow-y-auto max-h-[calc(100vh-200px)] lg:pr-2">
                <template x-if="dailyAppointments.length === 0">
                    <div class="bg-white dark:bg-[#1a2420] rounded-2xl border border-dashed border-gray-300 dark:border-gray-700 p-12 text-center transition-colors">
                        <div class="bg-gray-50 dark:bg-gray-800/50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100 dark:border-gray-700">
                            <svg class="w-8 h-8 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h4 class="text-gray-500 dark:text-gray-400 font-medium">Aucun rendez-vous</h4>
                        <p class="text-sm text-gray-400 dark:text-gray-500">Pour ce jour sélectionné</p>
                    </div>
                </template>

                <template x-for="apt in dailyAppointments" :key="apt.id">
                    <div @click="viewDetails(apt)" class="bg-white dark:bg-[#1a2420] border border-gray-200 dark:border-gray-800 rounded-2xl p-4 cursor-pointer hover:shadow-md transition-all border-l-4 group" :class="getStatusBorder(apt.status)">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-medical-blue font-bold" x-text="apt.patient.name.substring(0,2).toUpperCase()"></div>
                                <div>
                                    <h4 class="font-bold text-gray-800 dark:text-gray-200" x-text="apt.patient.name"></h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400" x-text="apt.type"></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider" :class="getStatusBadge(apt.status)">
                                <span x-html="getStatusIcon(apt.status)"></span>
                                <span x-text="translateStatus(apt.status)"></span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span x-text="apt.start_time.substring(0,5) + ' - ' + apt.end_time.substring(0,5)"></span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <!-- New Appointment Modal -->
    <div x-show="showNewModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" x-transition.opacity>
        <div @click.away="showNewModal = false" class="bg-white dark:bg-[#1a2420] rounded-3xl shadow-2xl w-full max-w-xl overflow-hidden border border-gray-200 dark:border-gray-800">
            <div class="bg-medical-blue p-6 text-white flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold">Nouveau Rendez-vous</h3>
                    <p class="text-sm text-green-100" x-text="formatFullDate(selectedDate)"></p>
                </div>
                <button @click="showNewModal = false" class="p-2 hover:bg-white/10 rounded-full transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form @submit.prevent="createAppointment" class="p-8 space-y-6">
                <!-- Patient & Doctor -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Patient</label>
                        <select x-model="newApt.patient_id" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-[#0f1714] text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-medical-blue outline-none transition-all">
                            <option value="">Sélectionner un patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Médecin</label>
                        <select x-model="newApt.doctor_id" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-[#0f1714] text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-medical-blue outline-none transition-all">
                            <option value="">Sélectionner un médecin</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Heure Début</label>
                        <input type="time" x-model="newApt.start_time" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-medical-blue focus:border-medical-blue outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Heure Fin</label>
                        <input type="time" x-model="newApt.end_time" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-medical-blue focus:border-medical-blue outline-none transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Type</label>
                        <select x-model="newApt.type" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-medical-blue focus:border-medical-blue outline-none transition-all">
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
                                <button 
                                    type="button"
                                    @click="newApt.status = status" 
                                    class="flex-1 flex items-center justify-center gap-2 px-4 py-3 rounded-xl border-2 transition-all font-semibold text-sm"
                                    :class="newApt.status === status ? getStatusActiveBorder(status) + ' ' + getStatusTextColor(status) + ' bg-white shadow-sm' : 'border-gray-100 text-gray-400 hover:border-gray-200'"
                                >
                                    <span x-html="getStatusIcon(status)"></span>
                                    <span x-text="translateStatus(status)"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Notes</label>
                    <textarea x-model="newApt.notes" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-[#0f1714] text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-medical-blue outline-none transition-all" placeholder="Ajouter des notes..."></textarea>
                </div>

                <div class="flex gap-6">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative w-10 h-6">
                            <input type="checkbox" x-model="newApt.sms_reminder" class="sr-only peer">
                            <div class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:bg-medical-blue transition-colors"></div>
                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full peer-checked:translate-x-4 transition-transform"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-600 group-hover:text-medical-blue">Rappel SMS</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative w-10 h-6">
                            <input type="checkbox" x-model="newApt.email_reminder" class="sr-only peer">
                            <div class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:bg-medical-blue transition-colors"></div>
                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full peer-checked:translate-x-4 transition-transform"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-600 group-hover:text-medical-blue">Rappel Email</span>
                    </label>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" @click="showNewModal = false" class="px-6 py-3 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition-all">Annuler</button>
                    <button type="submit" class="px-8 py-3 bg-medical-blue text-white rounded-xl font-bold shadow-lg shadow-green-100 hover:bg-opacity-90 transition-all">Créer le RDV</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Appointment Detail Modal -->
    <div x-show="showDetailModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-transition.opacity>
        <div @click.away="showDetailModal = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden" x-show="selectedApt">
            <template x-if="selectedApt">
                <div>
                    <div class="p-8 pb-4 relative">
                        <button @click="showDetailModal = false" class="absolute right-6 top-6 p-2 hover:bg-gray-100 rounded-full text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                        
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-16 h-16 rounded-2xl bg-medical-blue text-white flex items-center justify-center text-2xl font-bold" x-text="selectedApt.patient.name.substring(0,2).toUpperCase()"></div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800" x-text="selectedApt.patient.name"></h3>
                                <p class="text-gray-500" x-text="selectedApt.type"></p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div class="bg-gray-50 p-4 rounded-2xl">
                                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Date</p>
                                <p class="font-bold text-gray-700" x-text="formatFullDate(selectedApt.date)"></p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-2xl">
                                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Horaire</p>
                                <p class="font-bold text-gray-700" x-text="selectedApt.start_time.substring(0,5) + ' - ' + selectedApt.end_time.substring(0,5)"></p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Modifier le Statut</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <template x-for="status in ['planned', 'urgent', 'completed', 'cancelled']">
                                        <button 
                                            type="button"
                                            @click="selectedApt.status = status; updateStatus()" 
                                            class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl border-2 transition-all font-semibold text-sm"
                                            :class="selectedApt.status === status ? getStatusActiveBorder(status) + ' ' + getStatusTextColor(status) + ' bg-white shadow-sm' : 'border-gray-100 text-gray-400 hover:border-gray-200'"
                                        >
                                            <span x-html="getStatusIcon(status)"></span>
                                            <span x-text="translateStatus(status)"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Notes</label>
                                <textarea x-model="selectedApt.notes" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-medical-blue outline-none text-gray-600" placeholder="Pas de notes..."></textarea>
                            </div>

                            <div class="flex gap-4 p-4 rounded-2xl border border-gray-100 bg-gray-50/50">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full" :class="selectedApt.sms_reminder ? 'bg-medical-blue' : 'bg-gray-300'"></div>
                                    <span class="text-xs font-bold text-gray-500">SMS</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full" :class="selectedApt.email_reminder ? 'bg-medical-blue' : 'bg-gray-300'"></div>
                                    <span class="text-xs font-bold text-gray-500">Email</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-8 pt-0 flex gap-3">
                        <button @click="updateAppointment" class="flex-1 bg-medical-blue text-white py-3 rounded-xl font-bold shadow-lg shadow-green-100 hover:bg-opacity-90">
                            Enregistrer
                        </button>
                        <button @click="cancelAppointment" class="px-4 py-3 bg-red-50 text-red-500 rounded-xl hover:bg-red-100 transition-all" title="Supprimer">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
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
            
            newApt: {
                patient_id: '',
                doctor_id: '',
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
                switch(status) {
                    case 'planned': return 'bg-blue-500';
                    case 'completed': return 'bg-green-500';
                    case 'cancelled': return 'bg-red-500';
                    case 'urgent': return 'bg-orange-500';
                    default: return 'bg-gray-400';
                }
            },

            getStatusBadge(status) {
                switch(status) {
                    case 'planned': return 'bg-blue-50/50 text-blue-600';
                    case 'completed': return 'bg-green-50 text-green-600';
                    case 'cancelled': return 'bg-red-50 text-red-600';
                    case 'urgent': return 'bg-orange-50 text-orange-600';
                }
            },

            getStatusBorder(status) {
                switch(status) {
                    case 'planned': return 'border-l-blue-400';
                    case 'completed': return 'border-l-green-400';
                    case 'cancelled': return 'border-l-red-400';
                    case 'urgent': return 'border-l-orange-400';
                }
            },

            getStatusTextColor(status) {
                 switch(status) {
                    case 'planned': return 'text-blue-600';
                    case 'completed': return 'text-green-600';
                    case 'cancelled': return 'text-red-500';
                    case 'urgent': return 'text-orange-500';
                }
            },

            translateStatus(status) {
                switch(status) {
                    case 'planned': return 'Planifié';
                    case 'completed': return 'Terminé';
                    case 'cancelled': return 'Annulé';
                    case 'urgent': return 'Urgent';
                }
            },

            getStatusIcon(status) {
                switch(status) {
                    case 'planned': return `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>`;
                    case 'urgent': return `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>`;
                    case 'completed': return `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
                    case 'cancelled': return `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
                    default: return '';
                }
            },

            getStatusActiveBorder(status) {
                switch(status) {
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
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(this.newApt)
                })
                .then(async res => {
                    const data = await res.json();
                    if (!res.ok) {
                        throw new Error(data.message || 'Erreur lors de la création');
                    }
                    return data;
                })
                .then(data => {
                    if (data.success) {
                        this.showNewModal = false;
                        this.fetchDailyAppointments();
                        this.fetchAppointments();
                        this.resetNewApt();
                        alert('Rendez-vous créé avec succès !');
                    } else {
                        alert(data.message || 'Erreur lors de la création');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert(err.message || 'Erreur: Impossible de créer le rendez-vous. Vérifiez tous les champs.');
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
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status: this.selectedApt.status,
                        notes: this.selectedApt.notes
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.showDetailModal = false;
                        this.fetchDailyAppointments();
                    }
                });
            },

            cancelAppointment() {
                if (confirm('Êtes-vous sûr de vouloir annuler ce rendez-vous ?')) {
                    fetch(`/appointments/${this.selectedApt.id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.showDetailModal = false;
                            this.fetchDailyAppointments();
                            this.fetchAppointments();
                        }
                    });
                }
            },

            resetNewApt() {
                this.newApt = {
                    patient_id: '',
                    doctor_id: '',
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
