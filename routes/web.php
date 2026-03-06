<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\UtilisateursController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminOnly;
use App\Models\User;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth
Route::get('/login', [AuthController::class , 'showLogin'])->name('login');
Route::post('/login', [AuthController::class , 'login'])->name('login.post');
Route::post('/logout', [AuthController::class , 'logout'])->name('logout');

// Routes protégées
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
            return view('dashboard');
        }
        )->name('dashboard');

        // Routes pour les doctors
        Route::resource('doctors', DoctorController::class);

        // Routes pour les patients
        Route::resource('patients', PatientController::class);

        // Routes pour les appointments
        Route::resource('appointments', AppointmentController::class);

        // Profile Management
        Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
        Route::post('/profile', [ProfileController::class , 'update'])->name('profile.update');

        // Gestion des utilisateurs (admin only)
        Route::middleware([AdminOnly::class])->group(function () {
            Route::resource('utilisateurs', UtilisateursController::class);
        }
        );
    });
