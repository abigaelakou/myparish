<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MustChangePassword
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
        if (
            auth()->check()
            && auth()->user()->must_change_password
            && auth()->user()->id_type_utilisateur != 1 
            && !$request->is('password/change')
        ) {
            return redirect()->route('password.change');
        }
    
        return $next($request);
    }
}
