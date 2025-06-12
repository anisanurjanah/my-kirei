<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        if (Auth::guard('customer')->check()) {
            $outlet_code = $request->route('outlet_code');

            return redirect(secure_url("/{$outlet_code}/menu-page"));
        }

        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                $outlet_code = $request->route('outlet_code');

                if ($user->username === 'administrator') {
                    return redirect(secure_url("/dashboard"));
                }

                if (in_array($user->role, ['kasir', 'produksi']) && $outlet_code) {
                    return redirect(secure_url("/{$outlet_code}/dashboard"));
                }

                return redirect(secure_url("/login"));
            }
        }

        return $next($request);
    }
}
