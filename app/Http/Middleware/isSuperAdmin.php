<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'utilisateur connecté est un Super Admin
        if (Auth::check() && Auth::user()->id_type_utilisateur == 1) {
            return $next($request);
        }

        // Rediriger ou renvoyer une erreur si ce n'est pas un Super Admin
        return redirect()->route('home')->with('error', 'Vous n\'avez pas l\'autorisation d\'effectuer cette action.');
    }
}