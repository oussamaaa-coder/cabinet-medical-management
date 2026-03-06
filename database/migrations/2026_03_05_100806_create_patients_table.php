<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id(); // PK
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('nationality')->nullable();
            $table->string('cin')->nullable();
            $table->string('assurance')->nullable();
            $table->string('num_assurance')->nullable();
            $table->string('langue_parlee')->nullable();
            $table->string('photo')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_majeur')->default(true);

            // Responsable légal (pour mineurs)
            $table->string('type_responsable')->nullable();
            $table->string('cin_responsable')->nullable();
            $table->string('nom_responsable')->nullable();
            $table->string('prenom_responsable')->nullable();
            $table->string('phone_responsable')->nullable();
            $table->string('email_responsable')->nullable();
            $table->string('profession_responsable')->nullable();

            // Données médicales
            $table->string('groupe_sanguin')->nullable();
            $table->string('fratrie')->nullable();
            $table->string('voie_accouchement')->nullable();
            $table->string('apgar')->nullable();
            $table->string('allaitement')->nullable();
            $table->text('developpement_psychomoteur')->nullable();
            $table->text('antecedents_familiaux')->nullable();
            $table->text('allergies')->nullable();
            $table->text('maladies_chroniques')->nullable();
            $table->text('medicaments_cours')->nullable();
            $table->text('antecedents_personnels')->nullable();
            $table->text('hospitalisations')->nullable();

                        $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
