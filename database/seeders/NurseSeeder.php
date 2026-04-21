<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class NurseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $firstNames = [
            'Laila',
            'Fatima',
            'Khadija',
            'Maryam',
            'Sanaa',
            'Soukaina',
            'Imane',
            'Salma',
            'Zineb',
            'Hajar',
            'Ghita',
            'Nora',
            'Malika',
            'Yasmina',
            'Kenza'
        ];

        $lastNames = [
            'Bennani',
            'El Amrani',
            'Mansouri',
            'Tazi',
            'Alami',
            'Berrada',
            'Chraibi',
            'Filali',
            'Guezour',
            'Haddad',
            'Idrissi',
            'Jebli',
            'Kabbaj',
            'Lahlou',
            'Mernissi'
        ];

        $doctors = Doctor::all();

        foreach ($doctors as $doctor) {
            // Create 1 or 2 nurses per doctor
            $numNurses = rand(1, 2);

            for ($i = 0; $i < $numNurses; $i++) {
                $firstName = $firstNames[array_rand($firstNames)];
                $lastName = $lastNames[array_rand($lastNames)];
                $fullName = $firstName . ' ' . $lastName;

                // Create a unique email based on name
                $email = strtolower($firstName . '.' . $lastName . '.' . Str::random(3) . '@medical.ma');

                User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $fullName,
                        'email' => $email,
                        'password' => Hash::needsRehash('password') ? Hash::make('password') : 'password',
                        'role' => 'nurse',
                        'phone' => '06' . rand(10000000, 99999999),
                        'doctor_id' => $doctor->id,
                    ]
                );
            }
        }
    }
}
