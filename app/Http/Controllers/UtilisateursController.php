<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        return view('dashbord_admin.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,doctor,nurse,secretary'],
        ]);

        User::create($validated);

        return redirect()->route('utilisateurs.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    public function show(User $utilisateur): View
    {
        return view('dashbord_admin.show', compact('utilisateur'));
    }

    public function edit(User $utilisateur): View
    {
        $roles = ['admin', 'doctor', 'nurse', 'secretary'];

        return view('dashbord_admin.edit', compact('utilisateur', 'roles'));
    }

    public function update(Request $request, User $utilisateur): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $utilisateur->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,doctor,nurse,secretary'],
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $utilisateur->update($validated);

        return redirect()->route('utilisateurs.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(User $utilisateur): RedirectResponse
    {
        if ($utilisateur->id === auth()->id()) {
            return redirect()->route('utilisateurs.index')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $utilisateur->delete();

        return redirect()->route('utilisateurs.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
}