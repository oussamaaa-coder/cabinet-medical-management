@extends('layouts.sidebar')

@section('title', 'Nouvelle Ordonnance')

@section('content')
<link rel="stylesheet" href="{{ asset('asset/css/style_ajouterPatient.css') }}">
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<style>
    .prescription-page { padding: 30px; max-width: 1000px; margin: 0 auto; }
    .dynamic-list { margin-top: 20px; }
    .medicine-row-card { 
        background: #f8fafc; 
        padding: 20px; 
        border-radius: 12px; 
        margin-bottom: 15px;
        border: 1px solid #e2e8f0;
        position: relative;
    }
    .medicine-row-grid {
        display: grid; 
        grid-template-columns: 1fr 2fr auto; 
        gap: 15px; 
        align-items: end;
        margin-bottom: 15px;
    }
    .posology-grid {
        grid-template-columns: 1fr 1fr 1fr auto;
        margin-bottom: 0;
        padding-top: 15px;
        border-top: 1px dashed #cbd5e1;
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

    /* Tom Select Custom Styling */
    .ts-control {
        border-radius: 10px !important;
        border: 1px solid #e2e8f0 !important;
        padding: 10px 15px !important;
        box-shadow: none !important;
        font-size: 14px;
        background-color: #fff !important;
    }
    .ts-control.focus {
        border-color: #0ea5e9 !important;
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15) !important;
    }
    .ts-dropdown {
        border-radius: 10px !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05) !important;
        margin-top: 4px;
        overflow: hidden;
    }
    .ts-dropdown .option {
        padding: 10px 15px !important;
        font-size: 14px;
    }
    .ts-dropdown .active {
        background-color: #f0f9ff !important;
        color: #0369a1 !important;
    }
    .ts-wrapper.single .ts-control:after {
        border-color: #94a3b8 transparent transparent transparent !important;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .prescription-page {
            padding: 15px;
        }
        .fields-grid {
            grid-template-columns: 1fr !important;
            gap: 15px !important;
        }
        .medicine-row-grid {
            grid-template-columns: 1fr !important;
            gap: 12px;
        }
        .medicine-row-grid .form-group {
            grid-column: span 1 !important;
        }
        .posology-grid {
            grid-template-columns: 1fr 1fr !important;
        }
        .remove-row {
            width: 100%;
            margin-top: 10px;
        }
        .posology-grid > .form-group:last-child {
            grid-column: span 2;
        }
    }
    
    @media (max-width: 480px) {
        .posology-grid {
            grid-template-columns: 1fr !important;
        }
        .posology-grid > .form-group:last-child {
            grid-column: span 1;
        }
    }
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
                    <select name="patient_id" id="patient-select" class="form-control" required>
                        <option value="">Sélectionner un patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ $selectedPatientId == $patient->id ? 'selected' : '' }}>
                                {{ $patient->first_name }} {{ $patient->last_name }} - {{ $patient->cin }}
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
                <div class="medicine-row-card" data-index="0">
                    <div class="medicine-row-grid">
                        <div class="form-group">
                            <label>Type</label>
                            <select class="form-control med-type" required>
                                <option value="">Choisir...</option>
                                <option value="Comprimés">Comprimés</option>
                                <option value="Gélules">Gélules</option>
                                <option value="Sirop">Sirop</option>
                                <option value="Injection">Injection</option>
                                <option value="Pommade">Pommade</option>
                                <option value="Crème">Crème</option>
                                <option value="Gel">Gel</option>
                                <option value="Collyre">Collyre</option>
                                <option value="Gouttes auriculaires">Gouttes auriculaires</option>
                                <option value="Spray nasal">Spray nasal</option>
                                <option value="Inhalateur">Inhalateur</option>
                                <option value="Pastilles">Pastilles</option>
                                <option value="Solution buvable">Solution buvable</option>
                                <option value="Patch">Patch</option>
                                <option value="Suppositoire">Suppositoire</option>
                                <option value="Ovule">Ovule</option>
                            </select>
                        </div>
                        <div class="form-group" style="grid-column: span 2;">
                            <label>Médicament</label>
                            <input type="text" name="medicines[0][name]" class="form-control" placeholder="Nom du médicament" required>
                        </div>
                    </div>
                    
                    <div class="medicine-row-grid posology-grid">
                        <div class="form-group med-quantity-group">
                            <label>Quantité</label>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <input type="number" class="form-control med-qty" placeholder="Ex: 1" min="1" step="0.5" style="width: 80px;">
                                <span class="med-unit text-muted" style="font-size:13px;">unité</span>
                            </div>
                        </div>
                        <div class="form-group med-frequency-group">
                            <label>Fréquence</label>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <input type="number" class="form-control med-freq" placeholder="Ex: 3" min="1" style="width: 80px;">
                                <span class="text-muted" style="font-size:13px;">x / jour</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Durée</label>
                            <input type="text" name="medicines[0][duration]" class="form-control" placeholder="Ex: 7 jours">
                        </div>
                        
                        <div class="form-group" style="display:flex; align-items:flex-end;">
                            <!-- Hidden actual dosage sent to backend -->
                            <input type="hidden" name="medicines[0][dosage]" class="med-hidden-dosage" required>
                        </div>
                    </div>
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

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    let medicineCount = 1;
    const medicineList = document.getElementById('medicine-list');
    const addButton = document.getElementById('add-medicine');

    const typeConfig = {
        'Comprimés': { unit: 'comprimé(s)', hasQty: true },
        'Gélules': { unit: 'gélule(s)', hasQty: true },
        'Sirop': { unit: 'ml', hasQty: true },
        'Injection': { unit: 'injection(s)', hasQty: true },
        'Pommade': { unit: '', action: 'Appliquer', hasQty: false },
        'Crème': { unit: '', action: 'Appliquer', hasQty: false },
        'Gel': { unit: '', action: 'Appliquer', hasQty: false },
        'Collyre': { unit: 'goutte(s)', hasQty: true },
        'Gouttes auriculaires': { unit: 'goutte(s)', hasQty: true },
        'Spray nasal': { unit: 'pulvérisation(s)', hasQty: true },
        'Inhalateur': { unit: 'bouffée(s)', hasQty: true },
        'Pastilles': { unit: 'pastille(s)', hasQty: true },
        'Solution buvable': { unit: 'ml', hasQty: true },
        'Patch': { unit: 'patch(s)', hasQty: true },
        'Suppositoire': { unit: 'suppositoire(s)', hasQty: true },
        'Ovule': { unit: 'ovule(s)', hasQty: true }
    };

    function updateDosage(card) {
        const type = card.querySelector('.med-type').value;
        const qty = card.querySelector('.med-qty').value;
        const freq = card.querySelector('.med-freq').value;
        const hidden = card.querySelector('.med-hidden-dosage');
        
        if (!type || !freq) {
            hidden.value = "";
            return;
        }

        const config = typeConfig[type];
        let dosageText = "";

        if (config.hasQty) {
            if (qty) {
                dosageText = `${qty} ${config.unit} ${freq}x/jour`;
            }
        } else {
            dosageText = `${config.action} ${freq}x/jour`;
        }

        hidden.value = dosageText;
    }

    function handleTypeChange(card) {
        const type = card.querySelector('.med-type').value;
        const qtyGroup = card.querySelector('.med-quantity-group');
        const unitLabel = card.querySelector('.med-unit');
        
        if (type && typeConfig[type]) {
            const config = typeConfig[type];
            if (config.hasQty) {
                qtyGroup.style.display = 'block';
                unitLabel.textContent = config.unit;
            } else {
                qtyGroup.style.display = 'none';
            }
        } else {
            qtyGroup.style.display = 'block';
            unitLabel.textContent = 'unité';
        }
        updateDosage(card);
    }

    function attachEvents(card) {
        card.querySelector('.med-type').addEventListener('change', () => handleTypeChange(card));
        card.querySelector('.med-qty').addEventListener('input', () => updateDosage(card));
        card.querySelector('.med-freq').addEventListener('input', () => updateDosage(card));
    }

    // Attach to first row
    attachEvents(document.querySelector('.medicine-row-card[data-index="0"]'));

    addButton.addEventListener('click', () => {
        const row = document.createElement('div');
        row.className = 'medicine-row-card';
        row.dataset.index = medicineCount;
        
        row.innerHTML = `
            <div class="medicine-row-grid">
                <div class="form-group">
                    <label>Type</label>
                    <select class="form-control med-type" required>
                        <option value="">Choisir...</option>
                        <option value="Comprimés">Comprimés</option>
                        <option value="Gélules">Gélules</option>
                        <option value="Sirop">Sirop</option>
                        <option value="Injection">Injection</option>
                        <option value="Pommade">Pommade</option>
                        <option value="Crème">Crème</option>
                        <option value="Gel">Gel</option>
                        <option value="Collyre">Collyre</option>
                        <option value="Gouttes auriculaires">Gouttes auriculaires</option>
                        <option value="Spray nasal">Spray nasal</option>
                        <option value="Inhalateur">Inhalateur</option>
                        <option value="Pastilles">Pastilles</option>
                        <option value="Solution buvable">Solution buvable</option>
                        <option value="Patch">Patch</option>
                        <option value="Suppositoire">Suppositoire</option>
                        <option value="Ovule">Ovule</option>
                    </select>
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label>Médicament</label>
                    <input type="text" name="medicines[${medicineCount}][name]" class="form-control" placeholder="Nom du médicament" required>
                </div>
                <div class="form-group" style="display:flex; justify-content:flex-end; align-items:flex-end;">
                    <button type="button" class="remove-row">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                    </button>
                </div>
            </div>
            
            <div class="medicine-row-grid posology-grid">
                <div class="form-group med-quantity-group">
                    <label>Quantité</label>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <input type="number" class="form-control med-qty" placeholder="Ex: 1" min="1" step="0.5" style="width: 80px;">
                        <span class="med-unit text-muted" style="font-size:13px;">unité</span>
                    </div>
                </div>
                <div class="form-group med-frequency-group">
                    <label>Fréquence</label>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <input type="number" class="form-control med-freq" placeholder="Ex: 3" min="1" style="width: 80px;">
                        <span class="text-muted" style="font-size:13px;">x / jour</span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Durée</label>
                    <input type="text" name="medicines[${medicineCount}][duration]" class="form-control" placeholder="Ex: 7 jours">
                </div>
                
                <div class="form-group">
                    <input type="hidden" name="medicines[${medicineCount}][dosage]" class="med-hidden-dosage" required>
                </div>
            </div>
        `;
        
        row.querySelector('.remove-row').addEventListener('click', () => {
            row.remove();
        });
        
        attachEvents(row);
        medicineList.appendChild(row);
        medicineCount++;
    });

    // Initialize Tom Select for searchable dropdown
    new TomSelect("#patient-select",{
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
</script>
@endsection
