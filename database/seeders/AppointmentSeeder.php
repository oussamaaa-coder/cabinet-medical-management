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
                'date' => '2026-03-07',
                'start_time' => '10:00:00',
                'end_time' => '10:30:00',
                'type' => 'Consultation',
                'status' => 'planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => 2,
                'date' => '2026-03-07',
                'start_time' => '14:30:00',
                'end_time' => '15:00:00',
                'type' => 'Contrôle',
                'status' => 'urgent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}