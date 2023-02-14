<?php

namespace App\Http\Controllers;

use App\Helpers\ViaCepHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CepController extends Controller
{

    private $header = array(
        'Content-Type' => 'application/json; charset=UTF-8',
        'charset' => 'utf-8'
    );

    function getInfoCep($cep){
        try{
           $response = (new ViaCepHelper())->getCepData($cep);

           return response()->json($response, 200, $this->header, JSON_UNESCAPED_UNICODE);
        }catch(\Exception $e){
           
            $message = "Error: {$e->getMessage()} , code: {$e->getCode()}, line: {$e->getLine()}";
            Log::error('Erro ao obter dados da api cep'. $message);

            return response()->json(['error' => true, 'success' => false, 'message' => __('Houve um Erro ao buscar cep, por favor tente novamente mais tarde')], 422);
        }
    }
}
