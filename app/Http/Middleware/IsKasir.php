<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsKasir
{
    /**
     * Handle an incoming request.
     *
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role == "cashier" || "admin") {
            return $next($request);
        } else {
            return redirect('/dashboard')->with('failed', 'Anda bukan kasir dan tidak diperbolehkan mengakses halaman');
        }
    }
}
