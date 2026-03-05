<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;

Route::get('/', function () {
    return view('welcome');
});

// Routes pour les doctors
Route::resource('doctors', DoctorController::class);

// Routes pour les patients
Route::resource('patients', PatientController::class);

// Routes pour les appointments
Route::resource('appointments', AppointmentController::class);
