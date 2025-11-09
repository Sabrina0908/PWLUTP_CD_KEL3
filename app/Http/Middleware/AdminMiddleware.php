<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            // Jika belum login, alihkan ke halaman login
            return redirect('login');
        }

        // Cek role user
        if (Auth::user()->role === 'admin') {
            // Jika admin, lanjutkan permintaan ke controller
            return $next($request);
        }

        // Jika user biasa, alihkan ke dashboard user
        return redirect('/dashboard')->with('error', 'Akses ditolak. Anda bukan Administrator.');
    }
}
