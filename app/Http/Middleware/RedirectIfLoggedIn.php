<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfLoggedIn
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika sudah login, redirect langsung ke halaman product
        if (session()->has('account_id') || Auth::check()) {
            return redirect()->route('product.index');
        }

        return $next($request);
    }
}
