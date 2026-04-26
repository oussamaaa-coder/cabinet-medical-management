<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalDocument extends Model
{
    protected $fillable = ['patient_id', 'title', 'file_path', 'type', 'ai_summary'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
