<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',   // FK vers User
        'last_name',
        'phone',
        'email',
        'birth_date',
        'gender',
        'adress',
    ];

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
}