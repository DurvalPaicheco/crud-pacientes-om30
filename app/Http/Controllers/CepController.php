<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CepController extends Controller
{

    function getInfoCep($cep){

        $expiration = 60;//minutes
        $key = $cep;

        return Cache::remember($key, $expiration, function() use($cep){
            $url = "viacep.com.br/ws/$cep/json/";
            $http = Http::timeout(60)
                    ->acceptJson()
                    ->get($url);
            if($http->successful()){
                return 
                    [
                        'success' => true,
                        'error' => false,
                        'message' => 'ok',
                        'data' => $http->json()
                    ];
            }else{
                throw new \Exception($http->getBody());
            } 
        });
    }
}
