<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CashierMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || $request->user()->role !== 'cashier') {
            abort(403, 'Akses ditolak. Hanya kasir yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}