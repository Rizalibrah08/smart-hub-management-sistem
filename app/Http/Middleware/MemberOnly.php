<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MemberOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role !== 'member') {
            abort(403, 'Akses ditolak. Hanya Member yang diizinkan.');
        }

        return $next($request);
    }
}
