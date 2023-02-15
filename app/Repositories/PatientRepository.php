<?php

namespace App\Repositories;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientRepository
{

    /**
     * Get all patients
     * 
     * @return object
     */
    public static function getPatients(Request $filters)
    {
        $patients = Patient::with('address');

        //filters here
        return $patients->get();
    }

}
