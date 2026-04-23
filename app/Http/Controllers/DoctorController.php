<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DoctorController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\App\Http\Middleware\AdminOnly::class, except: ['index', 'show']),
        ];
    }

    public function index(Request $request)
    {
        $query = Doctor::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('specialty', 'like', "%{$search}%");
            });
        }

        $doctors = $query->latest()->paginate(50);

        return view('doctors.index', compact('doctors'));
    }

    public function show(string $id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('doctors.show', compact('doctor'));
    }

    public function create()
    {
        return view('doctors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'specialty'  => 'required|string|max:150',
            'phone'      => 'required|string|max:20',
            'email'      => 'required|email|max:150|unique:doctors,email|unique:users,email',
            'password'   => 'required|string|min:6',
        ]);

        $doctor = \Illuminate\Support\Facades\DB::transaction(function () use ($data) {
            // 1. Create the User account
            $user = \App\Models\User::create([
                'name'     => $data['first_name'] . ' ' . $data['last_name'],
                'email'    => $data['email'],
                'password' => $data['password'],
                'role'     => 'doctor',
                'phone'    => $data['phone'],
            ]);

            // 2. Create the Doctor profile, explicitly linking to the User
            $doctor = Doctor::create([
                'user_id'        => $user->id,   // ← critical link
                'first_name'     => $data['first_name'],
                'last_name'      => $data['last_name'],
                'specialty'      => $data['specialty'],
                'phone'          => $data['phone'],
                'email'          => $data['email'],
                'plain_password' => $data['password'],
            ]);

            return $doctor;
        });

        return redirect()->route('doctors.show', $doctor->id)
            ->with('success', 'Médecin ajouté avec succès.');
    }

    public function edit(string $id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, string $id)
    {
        $doctor = Doctor::findOrFail($id);

        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'specialty'  => 'required|string|max:150',
            'phone'      => 'required|string|max:20',
            'email'      => 'required|email|max:150|unique:doctors,email,' . $doctor->id . '|unique:users,email,' . $doctor->user_id,
            'password'   => 'nullable|string|min:6',
        ]);

        $updateData = $data;
        if (!empty($data['password'])) {
            $updateData['plain_password'] = $data['password'];
        }
        unset($updateData['password']);

        $doctor->update($updateData);

        if ($doctor->user_id) {
            $user = \App\Models\User::find($doctor->user_id);
            if ($user) {
                $userUpdate = [
                    'name' => $data['first_name'] . ' ' . $data['last_name'],
                    'email' => $data['email'],
                    'phone' => $data['phone']
                ];
                if (!empty($data['password'])) {
                    $userUpdate['password'] = $data['password'];
                }
                $user->update($userUpdate);
            }
        }

        return redirect()->route('doctors.show', $doctor->id)
            ->with('success', 'Médecin mis à jour avec succès.');
    }

    public function destroy(string $id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return redirect()->route('doctors.index')
            ->with('success', 'Médecin supprimé avec succès.');
    }
}

