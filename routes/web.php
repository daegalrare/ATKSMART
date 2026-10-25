<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PembelianStokController;
use App\Http\Controllers\PenyesuaianStokController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Root redirect
Route::get('/', function () {
    if (session('account_role') === 'kasir') {
        return redirect()->route('kasir.index');
    }
    if (session()->has('account_id') || \Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// --- Guest only routes (redirect ke dashboard jika sudah login) ---
Route::middleware('guest.app')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/lupa-kata-sandi', [AuthController::class, 'showForgotPasswordForm'])->name('password.forgot');
    Route::post('/lupa-kata-sandi', [AuthController::class, 'forgotPassword'])->name('password.forgot.post');
});

// --- Protected routes (harus login dulu) ---
Route::middleware('auth.app')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::post('/account', [AccountController::class, 'store'])->name('account.store');
    Route::put('/account/{id}', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/account/{id}', [AccountController::class, 'destroy'])->name('account.destroy');

    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

    // Kategori
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
    Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    // Kasir / POS
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
    Route::get('/kasir/search', [KasirController::class, 'searchProduct'])->name('kasir.search');
    Route::post('/kasir/transaksi', [KasirController::class, 'store'])->name('kasir.store');
    Route::get('/kasir/riwayat', [KasirController::class, 'riwayat'])->name('kasir.riwayat');
    Route::get('/kasir/print/{id}', [KasirController::class, 'printStruk'])->name('kasir.print');

    // --- Fitur Khusus Admin / Owner (Kasir Dilarang Mengakses) ---
    Route::middleware('admin.only')->group(function () {
        // Pembelian Stok
        Route::get('/pembelian-stok', [PembelianStokController::class, 'index'])->name('pembelian.index');
        Route::post('/pembelian-stok', [PembelianStokController::class, 'store'])->name('pembelian.store');
        Route::put('/pembelian-stok/{id}', [PembelianStokController::class, 'update'])->name('pembelian.update');
        Route::delete('/pembelian-stok/{id}', [PembelianStokController::class, 'destroy'])->name('pembelian.destroy');

        // Penyesuaian Stok
        Route::get('/penyesuaian-stok', [PenyesuaianStokController::class, 'index'])->name('penyesuaian.index');
        Route::post('/penyesuaian-stok', [PenyesuaianStokController::class, 'store'])->name('penyesuaian.store');
        Route::put('/penyesuaian-stok/{id}', [PenyesuaianStokController::class, 'update'])->name('penyesuaian.update');
        Route::delete('/penyesuaian-stok/{id}', [PenyesuaianStokController::class, 'destroy'])->name('penyesuaian.destroy');

        // Laporan & Analisis Laba Rugi
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/print', [LaporanController::class, 'print'])->name('laporan.print');
        Route::get('/laporan/export-csv', [LaporanController::class, 'exportCsv'])->name('laporan.export');
    });
});
