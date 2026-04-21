@extends('layouts.sidebar')

@section('title', 'Nouvelle Ordonnance')

@section('content')
<link rel="stylesheet" href="{{ asset('asset/css/style_ajouterPatient.css') }}">
<style>
    .prescription-page { padding: 30px; max-width: 1000px; margin: 0 auto; }
    .dynamic-list { margin-top: 20px; }
    .medicine-row { 
        display: grid; 
        grid-template-columns: 2fr 1fr 1fr auto; 
        gap: 15px; 
        background: #f8fafc; 
        padding: 15px; 
        border-radius: 12px; 
        margin-bottom: 10px;
        align-items: end;
        border: 1px solid #e2e8f0;
    }
    .remove-row { 
        background: #fee2e2; 
        color: #ef4444; 
        border: none; 
        width: 38px; 
        height: 38px; 
        border-radius: 10px; 
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .remove-row:hover { background: #fecaca; }
    .add-medicine-btn {
        background: #e0f2fe;
        color: #0369a1;
        border: 1px dashed #0ea5e9;
        padding: 12px;
        border-radius: 12px;
        width: 100%;
        cursor: pointer;
        font-weight: 600;
        margin-top: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .add-medicine-btn:hover { background: #bae6fd; }
</style>

<div class="prescription-page">
    <div class="page-title">
        <div class="page-title-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                <rect x="9" y="3" width="6" height="4" rx="1"/>
            </svg>
        </div>
        <div>
            <h2>Générer une Ordonnance</h2>
            <span>Créer une nouvelle prescription médicale</span>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" style="background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('prescriptions.store') }}" method="POST">
        @csrf
        
        <div class="section-card">
            <div class="section-header">
                <h3>Informations Patient & Diagnostic</h3>
            </div>
            <div class="fields-grid">
                <div class="form-group">
                    <label>Patient <span class="required-star">*</span></label>
                    <select name="patient_id" class="form-control" required>
                        <option value="">Sélectionner un patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ $selectedPatientId == $patient->id ? 'selected' : '' }}>
                                {{ $patient->first_name }} {{ $patient->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Médecin <span class="required-star">*</span></label>
                    <select name="doctor_id" class="form-control" required {{ Auth::user()->role === 'doctor' ? 'readonly style=pointer-events:none;background:#f8fafc;' : '' }}>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}" {{ Auth::id() == $doc->id ? 'selected' : '' }}>
                                Dr. {{ $doc->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Date de l'ordonnance <span class="required-star">*</span></label>
                    <input type="date" name="prescription_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group full-width">
                    <label>Diagnostic / Motif</label>
                    <input type="text" name="diagnosis" class="form-control" placeholder="Ex: Grippe saisonnière, Angine, ...">
                </div>
            </div>
        </div>

        <div class="section-card">
            <div class="section-header">
                <h3>Médicaments & Posologie</h3>
            </div>
            
            <div id="medicine-list" class="dynamic-list">
                <!-- First medicine row is mandatory -->
                <div class="medicine-row">
                    <div class="form-group">
                        <label>Médicament</label>
                        <input type="text" name="medicines[0][name]" class="form-control" placeholder="Nom du médicament" required>
                    </div>
                    <div class="form-group">
                        <label>Posologie</label>
                        <input type="text" name="medicines[0][dosage]" class="form-control" placeholder="Ex: 1 comp 3x/jour" required>
                    </div>
                    <div class="form-group">
                        <label>Durée</label>
                        <input type="text" name="medicines[0][duration]" class="form-control" placeholder="Ex: 7 jours">
                    </div>
                    <div style="width: 38px;"></div>
                </div>
            </div>

            <button type="button" id="add-medicine" class="add-medicine-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width: 18px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Ajouter un médicament
            </button>
        </div>

        <div class="section-card">
            <div class="section-header">
                <h3>Notes additionnelles</h3>
            </div>
            <textarea name="notes" class="form-control" placeholder="Conseils, précautions, ..."></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Générer l'Ordonnance</button>
            <a href="{{ route('prescriptions.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

<script>
    let medicineCount = 1;
    const medicineList = document.getElementById('medicine-list');
    const addButton = document.getElementById('add-medicine');

    addButton.addEventListener('click', () => {
        const row = document.createElement('div');
        row.className = 'medicine-row';
        row.innerHTML = `
            <div class="form-group">
                <input type="text" name="medicines[${medicineCount}][name]" class="form-control" placeholder="Nom du médicament" required>
            </div>
            <div class="form-group">
                <input type="text" name="medicines[${medicineCount}][dosage]" class="form-control" placeholder="Ex: 1 comp 3x/jour" required>
            </div>
            <div class="form-group">
                <input type="text" name="medicines[${medicineCount}][duration]" class="form-control" placeholder="Ex: 7 jours">
            </div>
            <button type="button" class="remove-row">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
            </button>
        `;
        
        row.querySelector('.remove-row').addEventListener('click', () => {
            row.remove();
        });
        
        medicineList.appendChild(row);
        medicineCount++;
    });
</script>
@endsection
