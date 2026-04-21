<?php

namespace Database\Seeders;

use App\Models\Prescription;
use App\Models\PrescriptionItem;
use Illuminate\Database\Seeder;

class PrescriptionSeeder extends Seeder
{
    public function run(): void
    {
        $prescriptions = [

            // ── Patient 1 : Oussama El Hassar (Asthme) ────────────────────────
            [
                'patient_id' => 1,
                'doctor_id' => 1,
                'prescription_date' => now()->subDays(10)->toDateString(),
                'notes' => 'Traitement de fond asthme persistant modéré. Éviter les efforts intenses en cas de pollution.',
                'items' => [
                    ['medicine_name' => 'Ventoline 100 µg (Salbutamol)', 'dosage' => '2 bouffées', 'duration' => '3 mois'],
                    ['medicine_name' => 'Symbicort 160/4.5 µg', 'dosage' => '1 bouffée', 'duration' => '3 mois'],
                    ['medicine_name' => 'Montelukast 10 mg', 'dosage' => '1 comprimé', 'duration' => '3 mois'],
                ],
            ],

            // ── Patient 2 : Sara El Hassar (Mineure, allergie lait) ───────────
            [
                'patient_id' => 2,
                'doctor_id' => 2,
                'prescription_date' => now()->subDays(20)->toDateString(),
                'notes' => "Allergie aux protéines de lait de vache confirmée. Régime d'éviction strict.",
                'items' => [
                    ['medicine_name' => 'Desloratadine 2.5 mg/5 ml sirop', 'dosage' => '5 ml', 'duration' => '1 mois'],
                    ['medicine_name' => 'Méthylprednisolone 4 mg', 'dosage' => '1 comprimé', 'duration' => '5 jours'],
                    ['medicine_name' => 'Adrénaline auto-injectable 0.15 mg (Epipen Jr)', 'dosage' => '1 injection', 'duration' => '12 mois'],
                ],
            ],

            // ── Patient 3 : Rachid Benkirane (Allergie pollen) ───────────────
            [
                'patient_id' => 3,
                'doctor_id' => 1,
                'prescription_date' => now()->subDays(15)->toDateString(),
                'notes' => 'Rhinite allergique saisonnière au pollen. Bilan allergologique recommandé.',
                'items' => [
                    ['medicine_name' => 'Cétirizine 10 mg', 'dosage' => '1 comprimé', 'duration' => '2 mois'],
                    ['medicine_name' => 'Fluticasone spray nasal 50 µg', 'dosage' => '2 pulvérisations par narine', 'duration' => '2 mois'],
                    ['medicine_name' => 'Larmes artificielles Hyabak', 'dosage' => '1-2 gouttes', 'duration' => '2 mois'],
                ],
            ],

            // ── Patient 4 : Nadia Cherkaoui (Migraine chronique) ─────────────
            [
                'patient_id' => 4,
                'doctor_id' => 2,
                'prescription_date' => now()->subDays(25)->toDateString(),
                'notes' => 'Migraine chronique avec aura. Tenir un journal des crises. Éviter le stress et le manque de sommeil.',
                'items' => [
                    ['medicine_name' => 'Sumatriptan 50 mg', 'dosage' => '1 comprimé', 'duration' => '3 mois'],
                    ['medicine_name' => 'Topiramate 25 mg', 'dosage' => '1 comprimé', 'duration' => '3 mois'],
                    ['medicine_name' => 'Ibuprofène 400 mg', 'dosage' => '1 comprimé', 'duration' => 'Ponctuel'],
                    ['medicine_name' => 'Magnésium B6 (Magne B6)', 'dosage' => '2 comprimés', 'duration' => '3 mois'],
                ],
            ],

            // ── Patient 5 : Youssef Kadiri (Diabète type 2) ──────────────────
            [
                'patient_id' => 5,
                'doctor_id' => 1,
                'prescription_date' => now()->subDays(7)->toDateString(),
                'notes' => 'Diabète type 2 – HbA1c à 7.8%. Objectif glycémique : HbA1c < 7%. Contrôle dans 3 mois. Régime pauvre en sucres rapides.',
                'items' => [
                    ['medicine_name' => 'Metformine 1000 mg', 'dosage' => '1 comprimé', 'duration' => '3 mois'],
                    ['medicine_name' => 'Gliclazide LP 30 mg', 'dosage' => '2 comprimés', 'duration' => '3 mois'],
                    ['medicine_name' => 'Atorvastatine 20 mg', 'dosage' => '1 comprimé', 'duration' => '3 mois'],
                    ['medicine_name' => 'Aspirine 100 mg', 'dosage' => '1 comprimé', 'duration' => '3 mois'],
                ],
            ],

            // ── Patient 6 : Fatima Zouiten (Mineure, Épilepsie) ──────────────
            [
                'patient_id' => 6,
                'doctor_id' => 2,
                'prescription_date' => now()->subDays(60)->toDateString(),
                'notes' => 'Épilepsie focale. Bonne tolérance au traitement. Renouvellement ordonné. EEG prévu dans 6 mois.',
                'items' => [
                    ['medicine_name' => 'Valproate de sodium (Dépakine) 200 mg/ml', 'dosage' => '10 ml', 'duration' => '6 mois'],
                    ['medicine_name' => 'Vitamine D3 1000 UI', 'dosage' => '1 ampoule', 'duration' => '3 mois'],
                    ['medicine_name' => 'Diazépam 5 mg rectal (Valium)', 'dosage' => '1 tube', 'duration' => '6 mois'],
                ],
            ],

            // ── Patient 7 : Hamid Ouali (HTA + Diabète + ATCD AVC) ───────────
            [
                'patient_id' => 7,
                'doctor_id' => 1,
                'prescription_date' => now()->subDays(35)->toDateString(),
                'notes' => 'HTA + diabète type 2 + ATCD AVC. Objectif tensionnel < 130/80 mmHg. Surveillance neurologique annuelle.',
                'items' => [
                    ['medicine_name' => 'Amlodipine 10 mg', 'dosage' => '1 comprimé', 'duration' => '3 mois'],
                    ['medicine_name' => 'Ramipril 5 mg', 'dosage' => '1 comprimé', 'duration' => '3 mois'],
                    ['medicine_name' => 'Metformine 850 mg', 'dosage' => '1 comprimé', 'duration' => '3 mois'],
                    ['medicine_name' => 'Clopidogrel 75 mg', 'dosage' => '1 comprimé', 'duration' => '3 mois'],
                    ['medicine_name' => 'Atorvastatine 40 mg', 'dosage' => '1 comprimé', 'duration' => '3 mois'],
                ],
            ],

            // ── Patient 8 : Amina Belhaj (Maladie cœliaque + Anémie) ─────────
            [
                'patient_id' => 8,
                'doctor_id' => 2,
                'prescription_date' => now()->subDays(12)->toDateString(),
                'notes' => 'Maladie cœliaque. Régime sans gluten strict et définitif. Anémie ferriprive en cours de correction.',
                'items' => [
                    ['medicine_name' => 'Fer + acide folique (Tardyferon B9)', 'dosage' => '1 comprimé', 'duration' => '3 mois'],
                    ['medicine_name' => 'Vitamine D3 100 000 UI', 'dosage' => '1 ampoule', 'duration' => '3 mois'],
                    ['medicine_name' => 'Calcium 500 mg', 'dosage' => '1 comprimé', 'duration' => '3 mois'],
                    ['medicine_name' => 'Vitamine B12 1000 µg', 'dosage' => '1 ampoule IM', 'duration' => '3 mois'],
                ],
            ],

            // ── Patient 9 : Karim Mansouri (Hernie discale) ──────────────────
            [
                'patient_id' => 9,
                'doctor_id' => 1,
                'prescription_date' => now()->subDays(18)->toDateString(),
                'notes' => 'Hernie discale L4-L5 post-opératoire. Rééducation en cours. Éviter le port de charges > 5 kg.',
                'items' => [
                    ['medicine_name' => 'Ibuprofène 400 mg', 'dosage' => '1 comprimé', 'duration' => '15 jours'],
                    ['medicine_name' => 'Thiocolchicoside 4 mg', 'dosage' => '1 comprimé', 'duration' => '7 jours'],
                    ['medicine_name' => 'Oméprazole 20 mg', 'dosage' => '1 gélule', 'duration' => '15 jours'],
                    ['medicine_name' => 'Prégabaline 75 mg', 'dosage' => '1 gélule', 'duration' => '1 mois'],
                ],
            ],

            // ── Patient 10 : Zineb Tahiri (Mineure, allergie lactose) ─────────
            [
                'patient_id' => 10,
                'doctor_id' => 2,
                'prescription_date' => now()->toDateString(),
                'notes' => "Intolérance au lactose confirmée. Régime d'éviction et supplémentation conseillée.",
                'items' => [
                    ['medicine_name' => 'Lactase 4500 FCC (Lactrase)', 'dosage' => '1 capsule', 'duration' => '3 mois'],
                    ['medicine_name' => 'Calcium 500 mg (pédiatrique)', 'dosage' => '1 sachet', 'duration' => '3 mois'],
                    ['medicine_name' => 'Vitamine D3 600 UI', 'dosage' => '1 goutte', 'duration' => '3 mois'],
                ],
            ],

            // ── Patient 11 : Omar Filali (Insuffisance rénale chronique) ──────
            [
                'patient_id' => 11,
                'doctor_id' => 1,
                'prescription_date' => now()->subDays(50)->toDateString(),
                'notes' => 'IRC stade 3b. Dialyse depuis 2023. Éviter AINS et néphrotoxiques. Régime hypoprotéique et pauvre en potassium.',
                'items' => [
                    ['medicine_name' => 'Furosémide 40 mg', 'dosage' => '1 comprimé', 'duration' => '3 mois'],
                    ['medicine_name' => 'Érythropoïétine (Eprex) 4000 UI', 'dosage' => '1 injection SC', 'duration' => '3 mois'],
                    ['medicine_name' => 'Calcium carbonate (Calcidia) 500 mg', 'dosage' => '2 comprimés', 'duration' => '3 mois'],
                    ['medicine_name' => 'Bicarbonate de sodium 1 g', 'dosage' => '2 comprimés', 'duration' => '3 mois'],
                    ['medicine_name' => 'Amlodipine 5 mg', 'dosage' => '1 comprimé', 'duration' => '3 mois'],
                ],
            ],

            // ── Patient 12 : Houda Alaoui (Lupus érythémateux systémique) ─────
            [
                'patient_id' => 12,
                'doctor_id' => 1,
                'prescription_date' => now()->toDateString(),
                'notes' => 'Lupus en rémission partielle. Photoprotection obligatoire (SPF 50+). Bilan rénal trimestriel.',
                'items' => [
                    ['medicine_name' => 'Hydroxychloroquine (Plaquenil) 200 mg', 'dosage' => '1 comprimé', 'duration' => '6 mois'],
                    ['medicine_name' => 'Prednisolone 5 mg', 'dosage' => '2 comprimés', 'duration' => '3 mois'],
                    ['medicine_name' => 'Oméprazole 20 mg', 'dosage' => '1 gélule', 'duration' => '3 mois'],
                    ['medicine_name' => 'Calcium + Vitamine D3 (Ostram)', 'dosage' => '1 sachet', 'duration' => '6 mois'],
                    ['medicine_name' => 'Mycophenolate mofetil 500 mg', 'dosage' => '2 comprimés', 'duration' => '6 mois'],
                ],
            ],

            // ── Patient 13 : Tariq Moussaoui (Mineure, Asthme allergique) ─────
            [
                'patient_id' => 13,
                'doctor_id' => 2,
                'prescription_date' => now()->subDays(8)->toDateString(),
                'notes' => 'Asthme allergique aux acariens, palier 3. Éviction des acariens recommandée (housses anti-acariens, aération quotidienne).',
                'items' => [
                    ['medicine_name' => 'Symbicort Turbuhaler 80/4.5 µg', 'dosage' => '1 bouffée', 'duration' => '3 mois'],
                    ['medicine_name' => 'Ventoline 100 µg', 'dosage' => '2 bouffées', 'duration' => '3 mois'],
                    ['medicine_name' => 'Montelukast 5 mg (pédiatrique)', 'dosage' => '1 comprimé à croquer', 'duration' => '3 mois'],
                    ['medicine_name' => 'Loratadine 10 mg', 'dosage' => '1 comprimé', 'duration' => '3 mois'],
                ],
            ],

            // ── Patient 14 : Leila Bensouda (HTA + Ostéoporose) ──────────────
            [
                'patient_id' => 14,
                'doctor_id' => 2,
                'prescription_date' => now()->subDays(40)->toDateString(),
                'notes' => 'HTA équilibrée. Ostéoporose post-ménopausique. Prothèse de hanche 2021 – kiné de maintien conseillée.',
                'items' => [
                    ['medicine_name' => 'Amlodipine 5 mg', 'dosage' => '1 comprimé', 'duration' => '3 mois'],
                    ['medicine_name' => 'Périndopril 5 mg', 'dosage' => '1 comprimé', 'duration' => '3 mois'],
                    ['medicine_name' => 'Alendronate 70 mg', 'dosage' => '1 comprimé', 'duration' => '6 mois'],
                    ['medicine_name' => 'Calcium 500 mg + Vitamine D3 400 UI', 'dosage' => '2 comprimés', 'duration' => '6 mois'],
                    ['medicine_name' => 'Paracétamol 1000 mg', 'dosage' => '1 comprimé', 'duration' => 'Ponctuel'],
                ],
            ],

            // ── Patient 15 : Anas Berrada (Allergie fruits de mer) ───────────
            [
                'patient_id' => 15,
                'doctor_id' => 1,
                'prescription_date' => now()->toDateString(),
                'notes' => 'Allergie confirmée aux crustacés. Entorse de cheville 2023 guérie. Bilan allergologique prévu.',
                'items' => [
                    ['medicine_name' => 'Adrénaline auto-injectable 0.3 mg (Epipen)', 'dosage' => '1 injection', 'duration' => '12 mois'],
                    ['medicine_name' => 'Cétirizine 10 mg', 'dosage' => '1 comprimé', 'duration' => '1 mois'],
                    ['medicine_name' => 'Prednisolone 20 mg', 'dosage' => '2 comprimés', 'duration' => '5 jours'],
                ],
            ],
        ];

        foreach ($prescriptions as $data) {
            $items = $data['items'];
            unset($data['items']);

            // Idempotent : crée ou retrouve la prescription par patient + date
            $prescription = Prescription::firstOrCreate(
                [
                    'patient_id' => $data['patient_id'],
                    'prescription_date' => $data['prescription_date'],
                ],
                array_merge($data, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );

            // Supprime les anciens items pour éviter les doublons lors d'un re-seed
            $prescription->items()->delete();

            foreach ($items as $item) {
                PrescriptionItem::create(array_merge($item, [
                    'prescription_id' => $prescription->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }
}