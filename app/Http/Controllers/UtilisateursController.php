<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UtilisateursController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::orderBy('name');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
            });
        }

        if ($role = $request->input('role')) {
            $query->where('role', $role);
        }

        $users = $query->paginate(10)->withQueryString();

        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalDoctors = User::where('role', 'doctor')->count();
        $totalNurses = User::where('role', 'nurse')->count();
        $totalSecretaries = User::where('role', 'secretary')->count();

        return view('dashbord_admin.index', compact(
            'users', 'totalUsers', 'totalAdmins', 'totalDoctors', 'totalNurses', 'totalSecretaries'
        ));
    }

    public function create(): View
    {
        $roles = ['admin', 'doctor', 'nurse', 'secretary'];
        $doctors = Doctor::all();

        return view('dashbord_admin.create', compact('roles', 'doctors'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,doctor,nurse,secretary'],
            'phone' => ['nullable', 'string', 'max:20'],
            'specialty' => ['required_if:role,doctor', 'nullable', 'string', 'max:255'],
            'doctor_id' => ['nullable', 'exists:doctors,id'],
        ]);

        $user = User::create($validated);

        if ($user->role === 'doctor') {
            $nameParts = explode(' ', $user->name, 2);
            Doctor::create([
                'user_id'    => $user->id,
                'first_name' => $nameParts[0],
                'last_name'  => $nameParts[1] ?? '',
                'specialty'  => $request->specialty,
                'phone'      => $request->phone ?? '',
                'email'      => $user->email,
            ]);
        }

        return redirect()->route('utilisateurs.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    public function show(User $utilisateur): View
    {
        if ($utilisateur->role === 'doctor') {
            $doctor = Doctor::where('email', $utilisateur->email)->first();
            $utilisateur->specialty = $doctor?->specialty;
        }
        return view('dashbord_admin.show', compact('utilisateur'));
    }

    public function edit(User $utilisateur): View
    {
        $roles = ['admin', 'doctor', 'nurse', 'secretary'];
        $doctors = Doctor::all();

        if ($utilisateur->role === 'doctor') {
            $doctor = Doctor::where('email', $utilisateur->email)->first();
            $utilisateur->specialty = $doctor?->specialty;
        }

        return view('dashbord_admin.edit', compact('utilisateur', 'roles', 'doctors'));
    }

    public function update(Request $request, User $utilisateur): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $utilisateur->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,doctor,nurse,secretary'],
            'phone' => ['nullable', 'string', 'max:20'],
            'specialty' => ['required_if:role,doctor', 'nullable', 'string', 'max:255'],
            'doctor_id' => ['nullable', 'exists:doctors,id'],
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $oldEmail = $utilisateur->email;
        $utilisateur->update($validated);

        if ($utilisateur->role === 'doctor') {
            $nameParts = explode(' ', $utilisateur->name, 2);
            Doctor::updateOrCreate(
                ['email' => $oldEmail],
                [
                    'user_id'    => $utilisateur->id,
                    'first_name' => $nameParts[0],
                    'last_name'  => $nameParts[1] ?? '',
                    'specialty'  => $request->specialty,
                    'phone'      => $utilisateur->phone ?? '',
                    'email'      => $utilisateur->email,
                ]
            );
        } else {
            // If role changed from doctor to something else, remove doctor record
            Doctor::where('email', $oldEmail)->delete();
        }

        return redirect()->route('utilisateurs.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(User $utilisateur): RedirectResponse
    {
        if ($utilisateur->id === auth()->id()) {
            return redirect()->route('utilisateurs.index')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        if ($utilisateur->role === 'doctor') {
            Doctor::where('email', $utilisateur->email)->delete();
        }

        $utilisateur->delete();

        return redirect()->route('utilisateurs.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
}