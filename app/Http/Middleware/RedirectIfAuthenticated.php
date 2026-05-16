<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return Auth::user()->hasRole([User::ROLE_STAFF, User::ROLE_SUPER_ADMIN])
                    ? redirect()->route('admin.dashboard')
                    : redirect()->route('user.dashboard');
            }
        }

        return $next($request);
    }
}
