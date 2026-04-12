<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ordonnance #{{ $prescription->id }}</title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 21cm;
            margin: auto;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 50px;
            border-bottom: 2px solid #3A7D5C;
            padding-bottom: 20px;
        }
        .clinic-info h1 { font-size: 28px; color: #3A7D5C; margin: 0; }
        .clinic-info p { font-size: 14px; color: #64748b; margin: 3px 0; }
        .doctor-info { text-align: right; }
        .doctor-info h2 { font-size: 20px; margin: 0; }
        .patient-info {
            background: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 40px;
        }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .label { font-size: 13px; color: #64748b; text-transform: uppercase; }
        .value { font-weight: bold; }
        .title {
            text-align: center;
            font-size: 36px;
            letter-spacing: 5px;
            text-transform: uppercase;
            margin-bottom: 50px;
        }
        .med-item {
            margin-bottom: 30px;
            padding-left: 20px;
            border-left: 4px solid #3A7D5C;
        }
        .med-name { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
        .med-dosage { font-size: 16px; color: #475569; font-style: italic; }
        .footer {
            margin-top: 100px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .signature {
            text-align: center;
            width: 250px;
            border-top: 1px dashed #cbd5e1;
            padding-top: 10px;
        }
        @media print {
            .no-print { display: none; }
            body { background: white; }
            .container { box-shadow: none; border: none; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="clinic-info">
                <h1>MediCal Cabinet</h1>
                <p>123 Avenue des Oliviers, Casablanca</p>
                <p>Tél: +212 5 22 00 00 00</p>
                <p>contact@medical.ma</p>
            </div>
            <div class="doctor-info">
                <h2>Dr. {{ $prescription->doctor->name }}</h2>
                <p>Médecin Généraliste</p>
            </div>
        </div>

        <div class="patient-info">
            <div class="info-row">
                <div>
                    <span class="label">Patient:</span>
                    <span class="value">{{ $prescription->patient->first_name }} {{ $prescription->patient->last_name }}</span>
                </div>
                <div>
                    <span class="label">Fait à Casablanca, le:</span>
                    <span class="value">{{ \Carbon\Carbon::parse($prescription->prescription_date)->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        <div class="title">Ordonnance</div>

        <div class="content">
            @foreach($prescription->items as $item)
            <div class="med-item">
                <div class="med-name">{{ $item->medicine_name }}</div>
                <div class="med-dosage">Posologie: {{ $item->dosage }} @if($item->duration)| {{ $item->duration }}@endif</div>
            </div>
            @endforeach
        </div>

        @if($prescription->notes)
        <div style="margin-top: 40px; font-style: italic; font-size: 14px; color: #4b5563;">
            <strong>Observations:</strong> {{ $prescription->notes }}
        </div>
        @endif

        <div class="footer">
            <div style="font-size: 12px; color: #94a3b8;">
                Réf: #ORD-{{ str_pad($prescription->id, 5, '0', STR_PAD_LEFT) }}
            </div>
            <div class="signature" style="position: relative;">
                Cachet et Signature
                <div style="height: 100px; display: flex; align-items: center; justify-content: center; margin-top: 10px;">
                    <img src="{{ asset('asset/img/medical_stamp.png') }}" alt="Cachet" style="width: 110px; opacity: 0.85; transform: rotate(-15deg); filter: contrast(1.1) brightness(1.1);">
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
