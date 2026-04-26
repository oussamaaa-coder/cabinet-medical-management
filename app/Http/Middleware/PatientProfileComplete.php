<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;

class PatientProfileComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'patient') {
            $patient = Patient::where('user_id', Auth::id())->first();
            
            if ($patient && !$patient->is_profile_completed) {
                // If the user is not already on the onboarding routes, redirect them
                if (!$request->routeIs('patient.onboarding') && !$request->routeIs('patient.onboarding.store')) {
                    return redirect()->route('patient.onboarding');
                }
            }
        }

        return $next($request);
    }
}
