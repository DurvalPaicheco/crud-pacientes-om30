<?php

namespace App\Jobs;

use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\PatientAddress;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ImportCsvPatient implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $csvData;

    public function __construct($csvData)
    {
        $this->csvData = $csvData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        foreach($this->csvData[0] as $key => $value){
            if($key > 0){

                try{
                    DB::beginTransaction();

                    $patient = Patient::create([
                        'name' => $value[0],
                        'mother_name' => $value[1],
                        'birthdate' => Carbon::createFromFormat('d/m/Y', $value[2])->format('Y-m-d'),
                        'cpf' => $value[3],
                        'cns' => $value[4],
                        'path_picture' => '',
                    ]);


                    $patientAddress = PatientAddress::create([
                        'zip_code' => $value[5],
                        'street' => $value[6],
                        'number' => $value[7],
                        'complement' => $value[8],
                        'neighborhood' => $value[9],
                        'city' => $value[10],
                        'state' => $value[11],
                        'patient_id' => $patient->id,
                    ]);


                    DB::commit();
                }catch(\Exception $e){
                    DB::rollBack();
                    $message = "Error: {$e->getMessage()} , code: {$e->getCode()}, line: {$e->getLine()}";
                    Log::error('Error ao carregar arquivo: ' . $message); 
                }
            }
        }

        
    }
}
