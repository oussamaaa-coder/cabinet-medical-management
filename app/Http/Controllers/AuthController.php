<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirect admin to user management dashboard
            if (auth()->user()->role === 'admin') {
                return redirect()->route('utilisateurs.index');
            }

            // Redirect patient to patient portal
            if (auth()->user()->role === 'patient') {
                return redirect()->route('patient.dashboard');
            }

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->onlyInput('email');
    }

    public function showRegisterPatient(): View
    {
        return view('auth.register_patient');
    }

    public function registerPatient(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'unique:users,email'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
            'phone'      => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date'],
            'gender'     => ['nullable', 'string'],
        ]);

        // Create user account
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'patient',
            'phone'    => $validated['phone'] ?? null,
        ]);

        // Parse first/last name
        $nameParts  = explode(' ', $validated['name'], 2);
        $firstName  = $nameParts[0];
        $lastName   = $nameParts[1] ?? '';

        // Create linked patient record
        Patient::create([
            'user_id'    => $user->id,
            'first_name' => $firstName,
            'last_name'  => $lastName,
            'email'      => $validated['email'],
            'phone'      => $validated['phone'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'gender'     => $validated['gender'] ?? null,
        ]);

        Auth::login($user);

        return redirect()->route('patient.dashboard')
            ->with('success', 'Bienvenue ! Votre compte patient a été créé.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Vous avez été déconnecté.');
    }
}