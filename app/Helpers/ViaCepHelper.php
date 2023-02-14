<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ViaCepHelper{


    /**
     * Busca cep inserido
     * @param $cep string 
     * @throws  \Exception
     * @return array
     */

    function getCepData(string $cep){
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