<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek apakah user sudah login dan apakah rolenya sesuai
        if (!$request->user() || $request->user()->role !== $role) {
            // Jika bukan admin, lempar ke dashboard biasa atau kasih error 403
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses admin.');
        }

        return $next($request);
    }
}