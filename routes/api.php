<?php

use App\Http\Controllers\CepController;
use App\Http\Controllers\PatientsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    //return $request->user();
});

Route::get('/', function(){
    return 'crud 1.0';
});

Route::prefix('paciente')->controller(PatientsController::class)->group(function () {
    Route::get('', 'index');
    Route::post('', 'store');
    Route::get('show', 'show');
    Route::get('edit/{id}', 'edit');
    Route::put('{id}', 'update');
    Route::delete('{id}', 'destroy');
    Route::post('activate/{id}', 'activate');
});

Route::prefix('cep')->controller(CepController::class)->group(function () {
    Route::get('{cep}', 'getInfoCep');
});


