<?php

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

Route::prefix('paciente')->controller(PatientsController::class)->group(function () {
    Route::get('', 'index');
    Route::post('', 'store');
    Route::get('show', 'show');
    Route::delete('destroy', 'destroy');
});


