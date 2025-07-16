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
            // User is not logged in, redirect to login page
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Assuming role_id 1 is 'admin' and 2 is 'regular_user'
        $requiredRoleId = null;
        foreach ($roles as $role) {
            if ($role === 'admin') {
                $requiredRoleId = 1; // Assuming 'admin' maps to role_id 1
            } elseif ($role === 'user') { // Or any other role you define
                $requiredRoleId = 2; // Assuming 'user' maps to role_id 2
            }
            // Add more conditions for other roles if needed
        }

        if ($requiredRoleId !== null && $user->role_id === $requiredRoleId) {
            return $next($request);
        }

        // If the user does not have the required role, redirect or abort
        return redirect('/')->with('error', 'You do not have permission to access this page.');
        // Or you can abort with a 403 Forbidden error:
        // abort(403, 'Unauthorized action.');
    }
}
