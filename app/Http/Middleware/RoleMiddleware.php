<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        // Cek login
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // Ubah string role jadi array, misalnya "admin|dokter" → ['admin', 'dokter']
        $allowedRoles = explode('|', $roles);

        // Jika role user tidak ada di dalam daftar yang diizinkan
        if (!in_array($user->role, $allowedRoles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
