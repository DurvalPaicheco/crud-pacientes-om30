<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'zip_code',
        'patient_id',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
