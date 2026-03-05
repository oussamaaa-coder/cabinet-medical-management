<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // On appelle tous les seeders ici
        $this->call([
            UserSeeder::class ,
            DoctorSeeder::class ,
            PatientSeeder::class ,
            AppointmentSeeder::class ,
        ]);
    }
}