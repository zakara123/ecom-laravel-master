<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;

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
    return $request->user();
});


Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('get-appointment-list',[AppointmentController::class,'appointment_list']);
Route::middleware('auth:sanctum')->post('add-appointment-files',[AppointmentController::class,'add_appointment_files_api']);
Route::post('get-appointment-files',[AppointmentController::class,'appointment_files_list_api']);
Route::post('get-appointment-payment-list',[AppointmentController::class,'appointment_payment_list_api']);





Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);


