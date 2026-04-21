<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class DossierController extends Controller
{
    /**
     * Display a listing of patient dossiers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $query = Patient::query();

        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role === 'doctor') {
            $doctorId = \App\Models\Doctor::where('user_id', \Illuminate\Support\Facades\Auth::id())->value('id');
            if ($doctorId) {
                $query->whereHas('appointments', function($q) use ($doctorId) {
                    $q->where('doctor_id', $doctorId);
                });
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Laravel handles this correctly despite some linter confusion
                $q->where('last_name', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('cin', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $patients = $query->latest('created_at')->paginate(10);

        return view('dossiers.index', compact('patients'));
    }
}
