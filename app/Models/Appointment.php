<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',   // FK vers Doctor
        'patient_id',  // FK vers Patient
        'appointment_date',
        'appointment_time',
        'status',
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