<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsLoggedIn
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah ada session account_id atau auth default Laravel
        if (!session()->has('account_id') && !Auth::check()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
