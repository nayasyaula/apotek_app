<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // kalau auth sudah mendeteksi ada riwayat login, maka dibolehkan akses route terkait
            return $next($request);
        } else {
            // kalau gada, diarahkan ke halamana login lagi
            return redirect()->route('login')->with('failed', 'Anda belum login');
        }
    }
}
