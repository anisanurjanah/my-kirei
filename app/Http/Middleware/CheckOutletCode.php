<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckOutletCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('customer')->check()) {
            $outlet_code = $request->route('outlet_code');
            $outlet = Outlet::where('code', $outlet_code)->first();

            if (!$outlet) {
                return redirect()->route('404');
            }
        }

        return $next($request);
    }
}
