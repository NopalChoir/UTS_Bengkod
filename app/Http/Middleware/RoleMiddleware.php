<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  // Parameter role yang dilewatkan dari route
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah pengguna sudah login
        if (!Auth::check()) {
            // Jika belum login, arahkan ke halaman login
            return redirect('/login');
        }

        // 2. Ambil user yang sedang login
        $user = Auth::user();

        // 3. Cek Role
        // Membandingkan role user dengan role yang diizinkan ($role)
        if ($user->role !== $role) {
            // Jika role tidak sesuai, tolak akses dan kembalikan response 403 (Unauthorized)
            // Sesuai dengan modul, response yang diberikan adalah Unauthorized
            abort(403, 'Unauthorized');
        }

        // 4. Lanjutkan Request
        // Jika role sesuai, lanjutkan proses ke controller
        return $next($request);
    }
}
