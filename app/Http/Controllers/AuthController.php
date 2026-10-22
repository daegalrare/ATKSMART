<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'password.required' => 'Password is required.',
        ]);

        // 1. Cek di tabel account (custom app)
        $account = Account::where('email_akun', $credentials['email'])->first();
        if ($account && Hash::check($credentials['password'], $account->password_hashed)) {
            $role = strtolower($account->role ?? 'admin');

            session([
                'account_id' => $account->id_akun,
                'account_name' => $account->nama_akun,
                'account_email' => $account->email_akun,
                'account_role' => $role,
            ]);

            if ($role === 'kasir') {
                return redirect()->route('kasir.index')->with('success', 'Selamat bertugas, ' . $account->nama_akun . '!');
            }

            return redirect()->intended('/dashboard')->with('success', 'Welcome back, ' . $account->nama_akun . '!');
        }

        // 2. Cek di tabel users bawaan Laravel
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard')->with('success', 'Welcome back!');
        }

        return back()->withInput($request->only('email'))->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}
