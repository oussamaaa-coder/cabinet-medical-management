<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            [
                'first_name' => 'Youssef',
                'last_name' => 'El Amrani',
                'specialty' => 'Cardiologie',
                'phone' => '0612345678',
                'email' => 'youssef.elamrani@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Salma',
                'last_name' => 'Bennani',
                'specialty' => 'Pédiatrie',
                'phone' => '0623456789',
                'email' => 'salma.bennani@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Omar',
                'last_name' => 'Zahir',
                'specialty' => 'Médecine générale',
                'phone' => '0634567890',
                'email' => 'omar.zahir@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Imane',
                'last_name' => 'El Fassi',
                'specialty' => 'Dermatologie',
                'phone' => '0645678901',
                'email' => 'imane.elfassi@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Khalid',
                'last_name' => 'Alaoui',
                'specialty' => 'Orthopédie',
                'phone' => '0656789012',
                'email' => 'khalid.alaoui@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($doctors as $doctor) {
            $user = \App\Models\User::firstOrCreate(
                ['email' => $doctor['email']],
                [
                    'name' => $doctor['first_name'] . ' ' . $doctor['last_name'],
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role' => 'doctor',
                    'phone' => $doctor['phone'],
                ]
            );

            $doctor['user_id'] = $user->id;
            $doctor['plain_password'] = 'password';
            DB::table('doctors')->updateOrInsert(['email' => $doctor['email']], $doctor);
        }
    }
}