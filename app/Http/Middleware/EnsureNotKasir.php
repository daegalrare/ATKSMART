<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureNotKasir
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session('account_role') === 'kasir') {
            return redirect()->route('kasir.index')->with('error', 'Akses ditolak. Fitur ini hanya dapat diakses oleh Administrator / Owner.');
        }

        return $next($request);
    }
}
