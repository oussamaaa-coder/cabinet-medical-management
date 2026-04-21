<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'birth_date',
        'gender',
        'nationality',
        'cin',
        'assurance',
        'num_assurance',
        'langue_parlee',
        'photo',
        'email',
        'address',
        'is_majeur',

        // Responsable légal
        'type_responsable',
        'cin_responsable',
        'nom_responsable',
        'prenom_responsable',
        'phone_responsable',
        'email_responsable',
        'profession_responsable',

        // Données médicales
        'groupe_sanguin',
        'fratrie',
        'voie_accouchement',
        'apgar',
        'allaitement',
        'developpement_psychomoteur',
        'antecedents_familiaux',
        'allergies',
        'maladies_chroniques',
        'medicaments_cours',
        'antecedents_personnels',
        'hospitalisations',
    ];

    protected $appends = ['name'];

    // Un patient appartient à un User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un patient peut avoir plusieurs rendez-vous
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
