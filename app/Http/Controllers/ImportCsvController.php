<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PatientCsv;
use App\Jobs\ImportCsvPatient;


class ImportCsvController extends Controller
{
    public function import(Request $request)
    {
      
        if ($request->hasFile('csv')) {
           $csv = $request->file('csv');
            $data = Excel::toArray(new PatientCsv, $csv);
            
           
            ImportCsvPatient::dispatch($data);

            return response()->json('Arquivo em processamento');
        }else{
            return response()->json('Arquivo não encontrado');
        }
        

        
    }
}
