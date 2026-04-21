<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'profile_photo',
        'doctor_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = Hash::needsRehash($value)
            ?Hash::make($value)
            : $value;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Relation avec Doctor (le User est un médecin)
    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    // Relation avec un Doctor (le User est assigné à un médecin, ex: infirmier)
    public function associatedDoctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
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

    // Relation avec Messages
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class , 'doctor_id');
    }
}