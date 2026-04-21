<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorNurseController extends Controller
{
    // Constructor to ensure only doctors can access
    public function __construct()
    {
        // Should only allow doctors, though routes might already be protected
    }

    private function getDoctor()
    {
        return Doctor::where('user_id', Auth::id())->firstOrFail();
    }

    public function index(Request $request)
    {
        if (Auth::user()->role !== 'doctor') {
            return redirect()->route('dashboard')->with('error', 'Accès non autorisé.');
        }

        $doctor = $this->getDoctor();
        $query = User::where('role', 'nurse')->where('doctor_id', $doctor->id)->orderBy('name');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $nurses = $query->paginate(10)->withQueryString();
        $totalNurses = User::where('role', 'nurse')->where('doctor_id', $doctor->id)->count();

        return view('mes_infirmieres.index', compact('nurses', 'totalNurses'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'doctor') {
            return redirect()->route('dashboard')->with('error', 'Accès non autorisé.');
        }
        return view('mes_infirmieres.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'doctor') {
            return redirect()->route('dashboard')->with('error', 'Accès non autorisé.');
        }

        $doctor = $this->getDoctor();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $validated['password'] = \Illuminate\Support\Str::random(16);

        $validated['role'] = 'nurse';
        $validated['doctor_id'] = $doctor->id;

        User::create($validated);

        return redirect()->route('mes-infirmieres.index')
            ->with('success', 'Infirmière ajoutée avec succès.');
    }

    public function show(User $mes_infirmiere)
    {
        // the parameter is generated as $mes_infirmiere based on the route 'mes-infirmieres'
        if (Auth::user()->role !== 'doctor' || $mes_infirmiere->doctor_id !== $this->getDoctor()->id) {
            return redirect()->route('mes-infirmieres.index')->with('error', 'Accès non associé à vos infirmières.');
        }

        return view('mes_infirmieres.show', compact('mes_infirmiere'));
    }

    public function edit(User $mes_infirmiere)
    {
        if (Auth::user()->role !== 'doctor' || $mes_infirmiere->doctor_id !== $this->getDoctor()->id) {
            return redirect()->route('mes-infirmieres.index')->with('error', 'Accès non autorisé.');
        }

        return view('mes_infirmieres.edit', compact('mes_infirmiere'));
    }

    public function update(Request $request, User $mes_infirmiere)
    {
        if (Auth::user()->role !== 'doctor' || $mes_infirmiere->doctor_id !== $this->getDoctor()->id) {
            return redirect()->route('mes-infirmieres.index')->with('error', 'Accès non autorisé.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $mes_infirmiere->id],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $mes_infirmiere->update($validated);

        return redirect()->route('mes-infirmieres.index')
            ->with('success', 'Informations mises à jour avec succès.');
    }

    public function destroy(User $mes_infirmiere)
    {
        if (Auth::user()->role !== 'doctor' || $mes_infirmiere->doctor_id !== $this->getDoctor()->id) {
            return redirect()->route('mes-infirmieres.index')->with('error', 'Accès non autorisé.');
        }

        $mes_infirmiere->delete();

        return redirect()->route('mes-infirmieres.index')
            ->with('success', 'Infirmière retirée avec succès.');
    }
}
