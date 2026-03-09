<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'date',
        'start_time',
        'end_time',
        'type',
        'status',
        'notes',
        'sms_reminder',
        'email_reminder',
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
}