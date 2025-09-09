<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            if ($user->account_type == $role) {
                return $next($request);
            } else {
                if ($role == 'admin') {
                    return redirect()->route('admin.login');
                } else {
                    return redirect()->route('login');
                }
            }
        } else {
            if ($role == 'admin') {
                return redirect()->route('admin.login');
            } else {
                return redirect()->route('login');
            }
        }
    }
}
