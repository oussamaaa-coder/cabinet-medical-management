<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'date',
        'start_time',
        'end_time',
        'type',
        'status',
        'notes',
        'sms_reminder',
        'email_reminder',
        'nurse_id',
    ];

    // Relation avec Doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // Relation avec Patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Relation avec Nurse (User de type nurse)
    public function nurse()
    {
        return $this->belongsTo(User::class, 'nurse_id');
    }
}