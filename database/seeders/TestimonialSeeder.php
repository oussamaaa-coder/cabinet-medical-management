<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Testimonial::create([
            'name' => 'Sophie Martin',
            'role' => 'Patiente depuis 2 ans',
            'content' => 'Le système de prise de rendez-vous est révolutionnaire. Plus besoin d\'attendre au téléphone, tout est fluide et instantané.',
            'rating' => 5,
            'image' => 'assets/images/testimonials/sophie.png',
            'is_active' => true,
        ]);

        \App\Models\Testimonial::create([
            'name' => 'Jean Dupont',
            'role' => 'Père de famille',
            'content' => 'Les ordonnances numériques sont tellement pratiques. Plus de risque de les perdre, tout est centralisé sur mon espace patient.',
            'rating' => 5,
            'image' => 'assets/images/testimonials/jean.png',
            'is_active' => true,
        ]);

        \App\Models\Testimonial::create([
            'name' => 'Léa Bernard',
            'role' => 'Nouvelle patiente',
            'content' => 'Une approche moderne de la médecine qui ne sacrifie pas le côté humain. Je me sens écoutée et accompagnée.',
            'rating' => 5,
            'image' => 'assets/images/testimonials/lea.png',
            'is_active' => true,
        ]);
    }
}
