<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // TAMBAHKAN BARIS INI

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles) 
{
    // Tanda ...$roles (titik tiga) sangat penting agar bisa baca banyak role
    if (!auth()->check()) {
        return redirect('login');
    }

    if (in_array($request->user()->role, $roles)) {
        return $next($request);
    }

    abort(403, 'Unauthorized');
    }
}