<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('appointments')->insert([
            [
                'patient_id' => 1,
                'doctor_id' => 1,
                'date' => now()->toDateString(),
                'start_time' => '10:00:00',
                'end_time' => '10:30:00',
                'type' => 'Consultation',
                'status' => 'planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => 2,
                'doctor_id' => 1,
                'date' => now()->toDateString(),
                'start_time' => '14:30:00',
                'end_time' => '15:00:00',
                'type' => 'Contrôle',
                'status' => 'planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => 3,
                'doctor_id' => 2,
                'date' => now()->toDateString(),
                'start_time' => '09:00:00',
                'end_time' => '09:30:00',
                'type' => 'Consultation',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}