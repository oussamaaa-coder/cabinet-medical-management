<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $appointments = [
            // ─── Rendez-vous passés (completed / cancelled) ───────────────────

            [
                'patient_id' => 1,  // Oussama El Hassar
                'doctor_id' => 1,
                'date' => now()->subDays(30)->toDateString(),
                'start_time' => '09:00:00',
                'end_time' => '09:30:00',
                'type' => 'Consultation',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => 1,  // Oussama El Hassar – suivi asthme
                'doctor_id' => 1,
                'date' => now()->subDays(10)->toDateString(),
                'start_time' => '10:00:00',
                'end_time' => '10:30:00',
                'type' => 'Contrôle',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'patient_id' => 2,  // Sara El Hassar (mineure)
                'doctor_id' => 2,
                'date' => now()->subDays(20)->toDateString(),
                'start_time' => '11:00:00',
                'end_time' => '11:30:00',
                'type' => 'Consultation',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'patient_id' => 3,  // Rachid Benkirane
                'doctor_id' => 1,
                'date' => now()->subDays(15)->toDateString(),
                'start_time' => '14:00:00',
                'end_time' => '14:30:00',
                'type' => 'Consultation',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'patient_id' => 4,  // Nadia Cherkaoui
                'doctor_id' => 2,
                'date' => now()->subDays(25)->toDateString(),
                'start_time' => '08:30:00',
                'end_time' => '09:00:00',
                'type' => 'Consultation',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => 4,  // Nadia Cherkaoui – annulé
                'doctor_id' => 2,
                'date' => now()->subDays(5)->toDateString(),
                'start_time' => '16:00:00',
                'end_time' => '16:30:00',
                'type' => 'Contrôle',
                'status' => 'cancelled',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'patient_id' => 5,  // Youssef Kadiri – suivi diabète
                'doctor_id' => 1,
                'date' => now()->subDays(45)->toDateString(),
                'start_time' => '10:30:00',
                'end_time' => '11:00:00',
                'type' => 'Contrôle',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => 5,  // Youssef Kadiri – suivi diabète
                'doctor_id' => 1,
                'date' => now()->subDays(7)->toDateString(),
                'start_time' => '09:30:00',
                'end_time' => '10:00:00',
                'type' => 'Contrôle',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'patient_id' => 6,  // Fatima Zouiten (mineure – épilepsie)
                'doctor_id' => 2,
                'date' => now()->subDays(60)->toDateString(),
                'start_time' => '09:00:00',
                'end_time' => '09:45:00',
                'type' => 'Consultation',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'patient_id' => 7,  // Hamid Ouali – suivi HTA
                'doctor_id' => 1,
                'date' => now()->subDays(35)->toDateString(),
                'start_time' => '15:00:00',
                'end_time' => '15:30:00',
                'type' => 'Contrôle',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'patient_id' => 8,  // Amina Belhaj
                'doctor_id' => 2,
                'date' => now()->subDays(12)->toDateString(),
                'start_time' => '13:00:00',
                'end_time' => '13:30:00',
                'type' => 'Consultation',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'patient_id' => 9,  // Karim Mansouri – hernie discale
                'doctor_id' => 1,
                'date' => now()->subDays(18)->toDateString(),
                'start_time' => '11:30:00',
                'end_time' => '12:00:00',
                'type' => 'Contrôle',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'patient_id' => 11, // Omar Filali – insuffisance rénale
                'doctor_id' => 1,
                'date' => now()->subDays(50)->toDateString(),
                'start_time' => '08:00:00',
                'end_time' => '08:45:00',
                'type' => 'Consultation',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'patient_id' => 14, // Leila Bensouda – ostéoporose
                'doctor_id' => 2,
                'date' => now()->subDays(40)->toDateString(),
                'start_time' => '10:00:00',
                'end_time' => '10:30:00',
                'type' => 'Contrôle',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ─── Rendez-vous aujourd'hui ──────────────────────────────────────

            [
                'patient_id' => 10, // Zineb Tahiri (mineure)
                'doctor_id' => 2,
                'date' => now()->toDateString(),
                'start_time' => '09:00:00',
                'end_time' => '09:30:00',
                'type' => 'Consultation',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => 12, // Houda Alaoui – lupus
                'doctor_id' => 1,
                'date' => now()->toDateString(),
                'start_time' => '10:30:00',
                'end_time' => '11:00:00',
                'type' => 'Contrôle',
                'status' => 'in_progress',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => 15, // Anas Berrada
                'doctor_id' => 2,
                'date' => now()->toDateString(),
                'start_time' => '14:00:00',
                'end_time' => '14:30:00',
                'type' => 'Consultation',
                'status' => 'planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => 7,  // Hamid Ouali – suivi HTA
                'doctor_id' => 1,
                'date' => now()->toDateString(),
                'start_time' => '15:30:00',
                'end_time' => '16:00:00',
                'type' => 'Contrôle',
                'status' => 'planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ─── Rendez-vous à venir ──────────────────────────────────────────

            [
                'patient_id' => 1,  // Oussama El Hassar
                'doctor_id' => 1,
                'date' => now()->addDays(3)->toDateString(),
                'start_time' => '09:00:00',
                'end_time' => '09:30:00',
                'type' => 'Contrôle',
                'status' => 'planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => 2,  // Sara El Hassar
                'doctor_id' => 2,
                'date' => now()->addDays(5)->toDateString(),
                'start_time' => '11:00:00',
                'end_time' => '11:30:00',
                'type' => 'Contrôle',
                'status' => 'planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => 3,  // Rachid Benkirane
                'doctor_id' => 1,
                'date' => now()->addDays(7)->toDateString(),
                'start_time' => '10:00:00',
                'end_time' => '10:30:00',
                'type' => 'Bilan',
                'status' => 'planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => 5,  // Youssef Kadiri – suivi diabète
                'doctor_id' => 1,
                'date' => now()->addDays(14)->toDateString(),
                'start_time' => '09:30:00',
                'end_time' => '10:00:00',
                'type' => 'Contrôle',
                'status' => 'planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => 6,  // Fatima Zouiten – épilepsie
                'doctor_id' => 2,
                'date' => now()->addDays(10)->toDateString(),
                'start_time' => '14:30:00',
                'end_time' => '15:15:00',
                'type' => 'Contrôle',
                'status' => 'planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => 8,  // Amina Belhaj – maladie cœliaque
                'doctor_id' => 2,
                'date' => now()->addDays(6)->toDateString(),
                'start_time' => '08:30:00',
                'end_time' => '09:00:00',
                'type' => 'Bilan',
                'status' => 'planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => 9,  // Karim Mansouri
                'doctor_id' => 1,
                'date' => now()->addDays(4)->toDateString(),
                'start_time' => '16:00:00',
                'end_time' => '16:30:00',
                'type' => 'Consultation',
                'status' => 'planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => 11, // Omar Filali – insuffisance rénale
                'doctor_id' => 1,
                'date' => now()->addDays(2)->toDateString(),
                'start_time' => '08:00:00',
                'end_time' => '08:45:00',
                'type' => 'Contrôle',
                'status' => 'planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => 12, // Houda Alaoui – lupus
                'doctor_id' => 1,
                'date' => now()->addDays(21)->toDateString(),
                'start_time' => '13:00:00',
                'end_time' => '13:30:00',
                'type' => 'Contrôle',
                'status' => 'planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => 13, // Tariq Moussaoui – asthme
                'doctor_id' => 2,
                'date' => now()->addDays(8)->toDateString(),
                'start_time' => '15:00:00',
                'end_time' => '15:30:00',
                'type' => 'Contrôle',
                'status' => 'planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => 14, // Leila Bensouda
                'doctor_id' => 2,
                'date' => now()->addDays(12)->toDateString(),
                'start_time' => '10:00:00',
                'end_time' => '10:30:00',
                'type' => 'Bilan',
                'status' => 'planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => 15, // Anas Berrada
                'doctor_id' => 1,
                'date' => now()->addDays(9)->toDateString(),
                'start_time' => '11:00:00',
                'end_time' => '11:30:00',
                'type' => 'Consultation',
                'status' => 'planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($appointments as $appointment) {
            DB::table('appointments')->updateOrInsert(
                [
                    'patient_id' => $appointment['patient_id'],
                    'doctor_id' => $appointment['doctor_id'],
                    'date' => $appointment['date'],
                    'start_time' => $appointment['start_time']
                ],
                $appointment
            );
        }
    }
}