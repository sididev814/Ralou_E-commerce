<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Gère l'accès en fonction du rôle de l'utilisateur
     */
    public function handle($request, Closure $next, $role)
    {
        // Si l'utilisateur n'est pas connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à cette page.');
        }

        // Si le rôle de l'utilisateur ne correspond pas
        if (Auth::user()->role !== $role) {
            return redirect('/')->with('error', 'Accès réservé aux utilisateurs avec le rôle : ' . $role);
        }

        return $next($request);
    }
}
