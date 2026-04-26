<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicationLog extends Model
{
    protected $fillable = ['patient_id', 'prescription_item_id', 'medication_name', 'dosage', 'taken_at'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function prescriptionItem()
    {
        return $this->belongsTo(PrescriptionItem::class);
    }
}
