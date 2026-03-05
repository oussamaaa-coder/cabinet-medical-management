<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',   // FK vers User
        'last_name',
        'specialty',
        'phone',
        'email',
    ];

    // Un doctor appartient à un User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un doctor peut avoir plusieurs rendez-vous
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}