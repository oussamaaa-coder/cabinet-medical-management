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