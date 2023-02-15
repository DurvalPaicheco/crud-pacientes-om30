<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientCreateRequest;
use App\Http\Requests\PatientEditRequest;
use App\Models\Patient;
use App\Models\PatientAddress;
use App\Repositories\PatientRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PatientsController extends Controller
{
    private $header = [
        'Content-Type' => 'application/json; charset=UTF-8',
        'charset' => 'utf-8',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $patients = PatientRepository::getPatients($request);

        return response()->json($patients);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientCreateRequest $request)
    {
        try {
            //sav temp data to edit with nescessary
            $data = $request->all();

            //save picture
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');

                $path = $file->store('pictures', 'public');

                $data['path_picture'] = $path;
            }

            DB::beginTransaction();

            $patient = Patient::create([
                'name' => $data['name'],
                'mother_name' => $data['mother_name'],
                'birthdate' => Carbon::createFromFormat('d/m/Y', $data['birthdate'])->format('Y-m-d'),
                'cpf' => $data['cpf'],
                'cns' => $data['cns'],
                'path_picture' => $data['path_picture'],
            ]);

            $address = $data['address'];
            $patientAddress = PatientAddress::create([
                'zip_code' => $address['zip_code'],
                'street' => $address['street'],
                'number' => $address['number'],
                'complement' => $address['complement'],
                'neighborhood' => $address['neighborhood'],
                'city' => $address['city'],
                'state' => $address['state'],
                'patient_id' => $patient->id,
            ]);

            DB::commit();

            return response()->json(['error' => false, 'success' => true, 'message' => __('Paciente cadastrado com sucesso!')], 200, $this->header, JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            $oldPath = storage_path("app/{$data['path_picture']}");
            unset($oldPath);
            DB::rollBack();
            $message = "Error: {$e->getMessage()} , code: {$e->getCode()}, line: {$e->getLine()}";
            Log::error('Error ao cadastrar paciente : ' . $message);

            return response()->json(['error' => true, 'success' => false, 'message' => __('Houve um Erro ao cadastrar Paciente, por favor tente novamente mais tarde'), 'errors' => []], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = Patient::find($id);

        return response()->json($patient);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $patient = Patient::with('address')->find($id);

        /**
         * Convert to locate-BR , not use mutator
         */
        if ($patient->birthdate) {
            $patient->birthdate = Carbon::createFromFormat('Y-m-d', $patient->birthdate)->format('d/m/Y');
        }
        return response()->json($patient);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $patient = Patient::find($id);

            //sav temp data to edit with nescessary
            $data = $request->all();

            if ($request->hasFile('picture')) {
                $file = $request->file('picture');

                $url = $file->store('pictures', 'public');
                unset($patient['path_picture']);

                $data['path_picture'] = $url;
            }

            DB::beginTransaction();

            $patient->update([
                'name' => $data['name'],
                'mother_name' => $data['mother_name'],
                'birthdate' => Carbon::createFromFormat('d/m/Y', $data['birthdate'])->format('Y-m-d'),
                'cpf' => $data['cpf'],
                'cns' => $data['cns'],
                'path_picture' => $data['path_picture'],
            ]);

           
            $address = $data['address'];
            $patient->address()->update([
                'zip_code' => $address['zip_code'],
                'street' => $address['street'],
                'number' => $address['number'],
                'complement' => $address['complement'],
                'neighborhood' => $address['neighborhood'],
                'city' => $address['city'],
                'state' => $address['state'],
                'patient_id' => $patient->id,
            ]);
            DB::commit();

            return response()->json(['error' => false, 'success' => true, 'message' => __('Paciente editado com sucesso!')]);
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            $message = "Error: {$e->getMessage()} , code: {$e->getCode()}, line: {$e->getLine()}";
            Log::error('Error ao editar paciente : ' . $message);

            return response()->json(['error' => true, 'success' => false, 'message' => __('Houve um Erro ao editar Paciente, por favor tente novamente mais tarde')], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patient = Patient::find($id);

        try {
            DB::beginTransaction();
            $patient->update(['deleted' => true, 'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')]);
            DB::commit();

            return response()->json(['error' => false, 'success' => true, 'message' => __('Paciente deletado com sucesso!')]);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = "Error: {$e->getMessage()} , code: {$e->getCode()}, line: {$e->getLine()}";
            Log::error('Error ao deletar/inativar paciente : ' . $message);

            return response()->json(['error' => true, 'success' => false, 'message' => __('Houve um Erro ao deletar/inativar Paciente, por favor tente novamente mais tarde')], 422);
        }
    }
}
