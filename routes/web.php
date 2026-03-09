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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DossierController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ContactController;
use App\Http\Middleware\AdminOnly;
use App\Models\User;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth
Route::get('/login', [AuthController::class , 'showLogin'])->name('login');
Route::post('/login', [AuthController::class , 'login'])->name('login.post');
Route::post('/logout', [AuthController::class , 'logout'])->name('logout');

// Mot de passe oublié
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');

// Réinitialisation du mot de passe (lien reçu par e-mail)
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

// Contactez-nous
Route::get('/contact', [ContactController::class, 'showForm'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Routes protégées
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class , 'index'])->name('dashboard');

    // Routes pour les doctors
    Route::resource('doctors', DoctorController::class);

    // Routes pour les patients
    Route::post('/patients/store', [PatientController::class , 'store'])->name('patients.store');
    // Route personnalisée pour listAll
    Route::get('/patients/listAll', [PatientController::class , 'listAll'])
        ->name('patients.dashboardPatient.listAll');
    Route::resource('patients', PatientController::class);

    // Routes pour les appointments
    // Routes pour les appointments (Agenda)
    Route::get('/agenda', [AppointmentController::class , 'index'])->name('agenda.index');
    Route::get('/appointments/create', [AppointmentController::class , 'create'])->name('appointments.create');
    Route::get('/api/appointments', [AppointmentController::class , 'getAppointments'])->name('api.appointments');
    Route::get('/api/appointments/monthly-status', [AppointmentController::class , 'getMonthlyStatus'])->name('api.appointments.monthly-status');
    Route::post('/appointments/store', [AppointmentController::class , 'store'])->name('appointments.store');
    Route::post('/appointments/{appointment}/update', [AppointmentController::class , 'update'])->name('appointments.update');
    Route::delete('/appointments/{appointment}', [AppointmentController::class , 'destroy'])->name('appointments.destroy');

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

    // Dossiers Routes
    Route::get('/dossiers', [DossierController::class , 'index'])->name('dossiers.index');

    // Settings Routes
    Route::get('/settings', [SettingsController::class , 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class , 'update'])->name('settings.update');

    // Help Routes
    Route::get('/help', [HelpController::class , 'index'])->name('help.index');

    // Gestion des utilisateurs (admin only)
    Route::middleware([AdminOnly::class])->group(function () {
            Route::resource('utilisateurs', UtilisateursController::class);
        }
        );
    });
