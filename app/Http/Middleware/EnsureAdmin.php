<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('admin')->check() || !Auth::guard('admin')->user()->is_admin) {
            abort(403, 'Anda tidak memiliki akses admin.');
        }

        return $next($request);
    }
}