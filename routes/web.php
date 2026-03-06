<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\UtilisateursController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminOnly;
use App\Models\User;
// Auth
Route::get('/login', [AuthController::class , 'showLogin'])->name('login');
Route::post('/login', [AuthController::class , 'login'])->name('login.post');
Route::post('/logout', [AuthController::class , 'logout'])->name('logout');

// Routes protégées
Route::middleware(['auth'])->group(function () {

    // Dashboard
     Route::get('/dashboard', function () {

    $totalUsers = User::count();
    $totalAdmins = User::where('role','admin')->count();
    $totalDoctors = User::where('role','doctor')->count();
    $totalNurses = User::where('role','nurse')->count();
    $totalSecretaries = User::where('role','secretary')->count();

    // Add this: Fetch users, filtered by role if provided, with pagination
    $users = User::when(request('role'), function ($query) {
        return $query->where('role', request('role'));
    })->paginate(10);  // Change get() to paginate(10) for 10 items per page

    return view('dashbord_admin.index', compact(
        'totalUsers',
        'totalAdmins',
        'totalDoctors',
        'totalNurses',
        'totalSecretaries',
        'users'  // Add this
    ));

})->name('dashboard');

        // Routes pour les doctors
        Route::resource('doctors', DoctorController::class);

        // Routes pour les patients
        Route::resource('patients', PatientController::class);
        Route::post('/patients/store', [PatientController::class, 'store'])->name('patients.store');

        // Routes pour les appointments
        Route::resource('appointments', AppointmentController::class);

        Route::get('/patients/list', [PatientController::class, 'listAll'])
    ->name('patients.dashboardPatient.listAll');
        // Gestion des utilisateurs (admin only)
        Route::middleware([AdminOnly::class])->group(function () {
            Route::resource('utilisateurs', UtilisateursController::class);
        }

        );
    });
