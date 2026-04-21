<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PatientOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Veuillez vous connecter.');
        }

        if (auth()->user()->role !== 'patient') {
            abort(403, 'Accès réservé aux patients.');
        }

        return $next($request);
    }
}
