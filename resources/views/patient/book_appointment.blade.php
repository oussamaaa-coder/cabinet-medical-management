@extends('patient.layout')

@section('title', 'Prendre un Rendez-vous')

@section('content')

<div class="pt-page-header">
    <h1>Prendre un <em>Rendez-vous</em></h1>
    <p class="pt-page-subtitle">Choisissez un médecin, une date et un créneau disponible.</p>
</div>

@if($errors->any())
<div class="pt-alert pt-alert-error">
    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
    <div>
        @foreach($errors->all() as $err)
            <div>{{ $err }}</div>
        @endforeach
    </div>
</div>
@endif

<div class="pt-booking-layout">

    {{-- Booking Form --}}
    <div class="pt-card">
        <div class="pt-section-title">Détails du rendez-vous</div>

        <form method="POST" action="{{ route('patient.appointments.store') }}">
            @csrf

            <div class="pt-form-grid" style="row-gap:20px;">

                {{-- Doctor --}}
                <div class="pt-field span2">
                    <label class="pt-label" for="doctor_id">Médecin</label>
                    <select id="doctor_id" name="doctor_id" class="pt-select" required>
                        <option value="">— Choisissez un médecin —</option>
                        @foreach($doctors as $doc)
                        <option value="{{ $doc->id }}" {{ old('doctor_id') == $doc->id ? 'selected' : '' }}>
                            Dr. {{ $doc->first_name }} {{ $doc->last_name }} — {{ $doc->specialty }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Type --}}
                <div class="pt-field span2">
                    <label class="pt-label" for="type">Type de consultation</label>
                    <select id="type" name="type" class="pt-select" required>
                        <option value="">— Sélectionnez —</option>
                        <option value="Consultation" {{ old('type') === 'Consultation' ? 'selected' : '' }}>Consultation</option>
                        <option value="Contrôle" {{ old('type') === 'Contrôle' ? 'selected' : '' }}>Contrôle</option>
                        <option value="Urgence" {{ old('type') === 'Urgence' ? 'selected' : '' }}>Urgence</option>
                        <option value="Bilan" {{ old('type') === 'Bilan' ? 'selected' : '' }}>Bilan</option>
                        <option value="Suivi" {{ old('type') === 'Suivi' ? 'selected' : '' }}>Suivi</option>
                    </select>
                </div>

                {{-- Date --}}
                <div class="pt-field">
                    <label class="pt-label" for="date">Date</label>
                    <input type="date" id="date" name="date" class="pt-input"
                        min="{{ date('Y-m-d') }}" value="{{ old('date') }}" required>
                </div>

                {{-- Time range --}}
                <div class="pt-field">
                    <label class="pt-label">Créneau horaire</label>
                    <div class="pt-time-range">
                        <input type="time" name="start_time" class="pt-input" value="{{ old('start_time', '09:00') }}" required>
                        <span class="pt-time-sep">→</span>
                        <input type="time" name="end_time" class="pt-input" value="{{ old('end_time', '09:30') }}" required>
                    </div>
                </div>

                {{-- Notes --}}
                <div class="pt-field span2">
                    <label class="pt-label" for="notes">Notes / Motif (facultatif)</label>
                    <textarea id="notes" name="notes" class="pt-textarea"
                        placeholder="Décrivez brièvement le motif de votre visite...">{{ old('notes') }}</textarea>
                </div>

            </div>

            <div class="pt-form-actions">
                <button type="submit" class="pt-btn pt-btn-primary">
                    <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                    Confirmer le rendez-vous
                </button>
                <a href="{{ route('patient.appointments') }}" class="pt-btn pt-btn-outline">Annuler</a>
            </div>
        </form>
    </div>

    {{-- Info Panel --}}
    <div>
        <div class="pt-card pt-card-sm" style="margin-bottom:16px;background:linear-gradient(135deg,var(--pt-accent),var(--pt-accent-2));color:#fff;">
            <div style="font-weight:700;margin-bottom:6px;font-size:14px;display:flex;align-items:center;gap:8px;">
                <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2.5;"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg>
                Comment ça marche ?
            </div>
            <ol style="padding-left:18px;font-size:13px;line-height:1.8;opacity:.9;">
                <li>Choisissez votre médecin</li>
                <li>Sélectionnez une date disponible</li>
                <li>Indiquez le créneau souhaité</li>
                <li>Confirmez votre demande</li>
            </ol>
        </div>

        <div class="pt-card pt-card-sm" style="margin-top:16px;">
            <div style="font-weight:600;font-size:13px;color:var(--pt-text-primary);margin-bottom:12px;display:flex;justify-content:space-between;align-items:center;">
                <span style="display:flex;align-items:center;gap:8px;">
                    <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2.5;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Calendrier & Jours Fériés
                </span>
                <div style="display:flex;gap:5px;">
                    <button type="button" onclick="prevMonth()" class="cal-btn">
                        <svg viewBox="0 0 24 24" style="width:12px;height:12px;fill:none;stroke:currentColor;stroke-width:3;"><polyline points="15 18 9 12 15 6"/></svg>
                    </button>
                    <button type="button" onclick="nextMonth()" class="cal-btn">
                        <svg viewBox="0 0 24 24" style="width:12px;height:12px;fill:none;stroke:currentColor;stroke-width:3;"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                </div>
            </div>
            
            <div id="cal-month-name" style="font-size:12px;font-weight:700;text-align:center;margin-bottom:8px;text-transform:capitalize;color:var(--pt-accent);"></div>
            
            <div class="mini-calendar" id="mini-calendar">
                <!-- JS populated -->
            </div>

            <div class="cal-legend">
                <div class="cal-legend-item"><span class="dot holiday"></span> Jour férié</div>
                <div class="cal-legend-item"><span class="dot weekend"></span> Week-end</div>
            </div>
        </div>

        <div class="pt-card pt-card-sm" style="margin-top:16px;">
            <div style="font-weight:600;font-size:13px;color:var(--pt-text-primary);margin-bottom:10px;display:flex;align-items:center;gap:8px;">
                <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2.5;"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                Médecins disponibles
            </div>
            @foreach($doctors as $doc)
            <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid var(--pt-sidebar-border);" class="reveal">
                <div style="width:34px;height:34px;border-radius:9px;background:var(--pt-accent-light);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;color:var(--pt-accent);">
                    {{ strtoupper(substr($doc->first_name, 0, 1)) }}{{ strtoupper(substr($doc->last_name, 0, 1)) }}
                </div>
                <div>
                    <div style="font-size:13px;font-weight:600;color:var(--pt-text-primary);">Dr. {{ $doc->first_name }} {{ $doc->last_name }}</div>
                    <div style="font-size:11px;color:var(--pt-text-muted);">{{ $doc->specialty }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

@push('styles')
<style>
    .cal-btn {
        width:22px; height:22px; border-radius:5px; border:1px solid var(--pt-sidebar-border);
        background:var(--pt-card-bg); cursor:pointer; display:flex; align-items:center; justify-content:center;
        font-size:14px; color:var(--pt-text-secondary); transition: all 0.2s;
    }
    .cal-btn:hover { background:var(--pt-accent-light); border-color:var(--pt-accent); color:var(--pt-accent); }
    
    .mini-calendar {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 4px;
        text-align: center;
    }
    .cal-day-head { font-size:9px; font-weight:700; color:var(--pt-text-muted); padding-bottom:5px; }
    .cal-day {
        font-size:11px; padding:6px 0; border-radius:6px;
        color:var(--pt-text-secondary);
    }
    .cal-day.today { background:var(--pt-accent-light); color:var(--pt-accent); font-weight:700; }
    .cal-day.weekend { color:var(--pt-text-muted); background:rgba(0,0,0,0.02); }
    .cal-day.holiday { background:rgba(192,89,58,0.1); color:#c0593a; font-weight:700; position:relative; }
    .cal-day.holiday::after {
        content: ''; position:absolute; bottom:3px; left:50%; transform:translateX(-50%);
        width:3px; height:3px; border-radius:50%; background:#c0593a;
    }
    
    .cal-legend { margin-top:12px; display:flex; gap:12px; border-top:1px solid var(--pt-sidebar-border); padding-top:10px; }
    .cal-legend-item { display:flex; align-items:center; gap:5px; font-size:10px; color:var(--pt-text-muted); }
    .dot { width:7px; height:7px; border-radius:50%; display:inline-block; }
    .dot.holiday { background:#c0593a; }
    .dot.weekend { background:rgba(0,0,0,0.1); }

    /* Responsive Booking Layout */
    .pt-booking-layout {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 24px;
        align-items: start;
    }

    .pt-time-range {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .pt-time-sep {
        color: var(--pt-text-muted);
        font-size: 13px;
        flex-shrink: 0;
    }

    .pt-form-actions {
        margin-top: 24px;
        display: flex;
        gap: 12px;
    }

    @media (max-width: 1100px) {
        .pt-booking-layout { grid-template-columns: 1fr; }
    }

    @media (max-width: 640px) {
        .pt-time-range {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }
        .pt-time-sep {
            text-align: center;
            transform: rotate(90deg);
            height: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .pt-form-actions {
            flex-direction: column;
        }
        .pt-form-actions .pt-btn {
            justify-content: center;
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    let currentData = new Date();
    
    // Jours fériés Marocains (Fixes + Estimations 2025/2026)
    const holidays = [
        "01-01", // Nouvel an
        "11-01", // Manifeste Indépendance
        "01-05", // Fête du travail
        "30-07", // Fête du Trône
        "14-08", // Oued Ed-Dahab
        "20-08", // Révolution du Roi et du Peuple
        "21-08", // Fête de la Jeunesse
        "06-11", // Marche Verte
        "18-11", // Fête de l'Indépendance
        // Mobiles 2026 (Estimations)
        "2026-03-20", "2026-03-21", // Aïd al-Fitr
        "2026-05-27", "2026-05-28", // Aïd al-Adha
        "2026-06-16", // 1er Moharram
        "2026-08-25", "2026-08-26", // Al Mawlid
    ];

    function renderCalendar() {
        const cal = document.getElementById('mini-calendar');
        const monthName = document.getElementById('cal-month-name');
        cal.innerHTML = '';
        
        const year = currentData.getFullYear();
        const month = currentData.getMonth();
        
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        
        const names = ['janv.','févr.','mars','avr.','mai','juin','juil.','août','sept.','oct.','nov.','déc.'];
        monthName.textContent = names[month] + ' ' + year;
        
        // Headers
        ['L','M','M','J','V','S','D'].forEach(d => {
            const div = document.createElement('div');
            div.className = 'cal-day-head';
            div.textContent = d;
            cal.appendChild(div);
        });
        
        // Empty slots (ajust for Monday start)
        let startingDay = firstDay === 0 ? 6 : firstDay - 1;
        for(let i=0; i<startingDay; i++) {
            cal.appendChild(document.createElement('div'));
        }
        
        const today = new Date();
        
        for(let d=1; d<=daysInMonth; d++) {
            const dateStr = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
            const shortStr = `${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
            const isHoliday = holidays.includes(dateStr) || holidays.includes(shortStr);
            
            const div = document.createElement('div');
            div.className = 'cal-day';
            div.textContent = d;
            
            const dayOfWeek = new Date(year, month, d).getDay(); // 0=Sun, 6=Sat
            if(dayOfWeek === 0 || dayOfWeek === 6) div.classList.add('weekend');
            if(isHoliday) div.classList.add('holiday');
            if(d === today.getDate() && month === today.getMonth() && year === today.getFullYear()) div.classList.add('today');
            
            cal.appendChild(div);
        }
    }

    function prevMonth() { currentData.setMonth(currentData.getMonth() - 1); renderCalendar(); }
    function nextMonth() { currentData.setMonth(currentData.getMonth() + 1); renderCalendar(); }

    document.addEventListener('DOMContentLoaded', renderCalendar);
</script>
@endpush

@endsection
