<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
           
            return redirect()->route('login');
        }

        $user = Auth::user();        

        if ($user->role_id !== null && (int) $user->role_id === 2 || $user->role_id === 1 || $user->role_id === 3 ) {
            return $next($request);
        }

        return redirect('/')->with('error', 'You do not have permission to access this page.');
        
    }
}
