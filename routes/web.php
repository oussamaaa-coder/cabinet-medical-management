<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\UtilisateursController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PrescriptionController;
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
    Route::post('/patients/store', [PatientController::class , 'store'])->name('patients.store');
    // Route personnalisée pour listAll
    Route::get('/patients/listAll', [PatientController::class, 'listAll'])
        ->name('patients.dashboardPatient.listAll');
    Route::resource('patients', PatientController::class);

    // Routes pour les appointments
    Route::resource('appointments', AppointmentController::class);

    // Profile Management
    Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class , 'update'])->name('profile.update');
    Route::delete('/profile-photo-delete', [ProfileController::class , 'destroyPhoto'])->name('profile.photo.delete_action');

    // Group Chat Routes
    Route::get('/chat', [ChatController::class , 'index'])->name('chat.index');
    Route::get('/chat/messages', [ChatController::class , 'fetchMessages'])->name('chat.messages');
    Route::post('/chat/messages', [ChatController::class , 'store'])->name('chat.store');

    // Prescription Routes
    Route::resource('prescriptions', PrescriptionController::class);
    Route::get('/prescriptions/{id}/print', [PrescriptionController::class , 'print'])->name('prescriptions.print');

    // Gestion des utilisateurs (admin only)
    Route::middleware([AdminOnly::class])->group(function () {
        Route::resource('utilisateurs', UtilisateursController::class);
    });
});
