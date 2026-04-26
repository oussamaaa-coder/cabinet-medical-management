<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vital extends Model
{
    protected $fillable = ['patient_id', 'type', 'value', 'unit', 'measured_at'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
