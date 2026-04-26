<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\Vital;
use App\Models\MedicalDocument;
use App\Models\MedicationLog;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use Carbon\Carbon;

class PatientFeaturesSeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::all();
        if ($patients->isEmpty()) return;

        foreach ($patients as $patient) {
            // 1. Seed Vitals (Weight, BP, Glucose)
        for ($i = 30; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            
            // Weight (slight variation)
            Vital::create([
                'patient_id' => $patient->id,
                'type' => 'weight',
                'value' => 70 + (rand(-10, 10) / 10),
                'unit' => 'kg',
                'measured_at' => $date
            ]);

            // BP
            Vital::create([
                'patient_id' => $patient->id,
                'type' => 'bp_systolic',
                'value' => 120 + rand(-5, 10),
                'unit' => 'mmHg',
                'measured_at' => $date
            ]);

            // Glucose
            Vital::create([
                'patient_id' => $patient->id,
                'type' => 'glucose',
                'value' => 0.9 + (rand(-2, 4) / 10),
                'unit' => 'g/L',
                'measured_at' => $date
            ]);
        }

        // 2. Seed Medical Documents with AI Summaries
        MedicalDocument::create([
            'patient_id' => $patient->id,
            'title' => 'Bilan Sanguin Complet',
            'file_path' => 'reports/blood_test_001.pdf',
            'type' => 'blood_test',
            'ai_summary' => "Votre bilan sanguin montre un taux de cholestérol légèrement élevé (LDL à 1.4g/L). La glycémie est normale. Je vous conseille de réduire les graisses saturées et de refaire un test dans 3 mois. Tout le reste est parfait !",
            'created_at' => Carbon::now()->subMonths(1)
        ]);

        MedicalDocument::create([
            'patient_id' => $patient->id,
            'title' => 'Radiographie Thoracique',
            'file_path' => 'reports/xray_chest.jpg',
            'type' => 'scan',
            'ai_summary' => "L'examen ne montre aucune anomalie pulmonaire ou cardiaque. Les champs pulmonaires sont clairs. Conclusion : Examen normal.",
            'created_at' => Carbon::now()->subWeeks(2)
        ]);

        // 3. Seed Queue Status for today
        $doctor = Doctor::first();
        $doctorId = $doctor ? $doctor->user_id : 1;

        $appointment = Appointment::where('patient_id', $patient->id)
            ->whereDate('date', Carbon::today())
            ->first();

        if (!$appointment) {
            $appointment = Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor ? $doctor->id : 1,
                'date' => Carbon::today(),
                'start_time' => '10:00:00',
                'end_time' => '10:30:00',
                'status' => 'planned',
                'type' => 'Consultation'
            ]);
        }

        $appointment->update([
            'queue_position' => 5,
            'current_queue_number' => 3
        ]);

        // 4. Seed Medication Reminders
        $prescription = Prescription::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctorId,
            'prescription_date' => Carbon::today(),
            'notes' => 'Traitement pour hypertension'
        ]);

        $med1 = PrescriptionItem::create([
            'prescription_id' => $prescription->id,
            'medicine_name' => 'Amlodipine',
            'dosage' => '5mg',
            'duration' => '30 jours'
        ]);

        $med2 = PrescriptionItem::create([
            'prescription_id' => $prescription->id,
            'medicine_name' => 'Doliprane',
            'dosage' => '1000mg',
            'duration' => '5 jours'
        ]);

        // Add some logs
        MedicationLog::create([
            'patient_id' => $patient->id,
            'prescription_item_id' => $med1->id,
            'medication_name' => 'Amlodipine',
            'dosage' => '5mg',
            'taken_at' => Carbon::now()->subHours(2)
        ]);
        }
    }
}
