<?php

use App\Http\Controllers\AllergyController;
use App\Http\Controllers\MedicalConditionController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\NextOfKinController;
use App\Http\Controllers\PatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'patients'], function () {
    Route::get('/list', [PatientController::class, 'patientList'])->name('patients.list');
    Route::get('/select/{id}', [PatientController::class, 'getPatientData']);
    Route::get('/destroy', [PatientController::class, 'destroy']);
    Route::get('/update', [PatientController::class, 'update']);
    Route::get('/store', [PatientController::class, 'store']);
});


Route::prefix('/allergies')->group(function () {
    Route::get('/destroy', [AllergyController::class, 'destroy']);
    Route::get('/update', [AllergyController::class, 'update']);
    Route::get('/store', [AllergyController::class, 'store']);
});

Route::prefix('/medicalCondition')->group(function () {
    Route::get('/destroy', [MedicalConditionController::class, 'destroy']);
    Route::get('/update', [MedicalConditionController::class, 'update']);
    Route::get('/store', [MedicalConditionController::class, 'store']);
});

Route::prefix('/medication')->group(function () {
    Route::get('/destroy', [MedicationController::class, 'destroy']);
    Route::get('/update', [MedicationController::class, 'update']);
    Route::get('/store', [MedicationController::class, 'store']);
});

Route::prefix('/nextOfKin')->group(function () {
    Route::get('/destroy', [NextOfKinController::class, 'destroy']);
    Route::get('/update', [NextOfKinController::class, 'update']);
    Route::get('/store', [NextOfKinController::class, 'store']);
});
