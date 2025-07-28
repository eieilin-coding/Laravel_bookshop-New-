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
        $requiredRoleId = null;
        foreach ($roles as $role) {
            if ($role === 'admin') {
                $requiredRoleId = 1; 
            } elseif ($role === 'user') { 
                $requiredRoleId = 2; 
            }
            // Add more conditions for other roles if needed
        }

        if ($requiredRoleId !== null && $user->role_id === $requiredRoleId) {
            return $next($request);
        }

        return redirect('/')->with('error', 'You do not have permission to access this page.');
        
    }
}
