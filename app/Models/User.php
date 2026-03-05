<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
    ];

    // Relation avec Doctor
    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    // Relation avec Patient
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    // Relation avec Notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}