<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - ATK SMART</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-40 hidden md:hidden transition-opacity"></div>

    <div class="flex h-screen overflow-hidden">
        <!-- SIDEBAR -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white flex flex-col transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0 md:static md:inset-auto shrink-0 shadow-xl">
            <!-- Brand / Logo -->
            <div class="h-16 flex items-center justify-between px-6 border-b border-slate-800/80 bg-slate-950/40">
                <a href="{{ url('/') }}" class="flex items-center gap-3 font-bold text-lg tracking-wide text-white group">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-400 flex items-center justify-center text-white shadow-md shadow-indigo-500/25 group-hover:scale-105 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"/>
                            <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/>
                            <path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"/>
                            <path d="M2 7h20"/>
                        </svg>
                    </div>
                    <span class="bg-gradient-to-r from-white via-slate-100 to-slate-300 bg-clip-text text-transparent">ATK SMART</span>
                </a>

                <!-- Mobile Close Button -->
                <button id="close-sidebar-btn" type="button" class="p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 md:hidden transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Action Button (+ Transaksi Baru like reference 'Register patient +') -->
            <div class="px-4 pt-4 pb-1">
                <a href="{{ route('kasir.index') }}" class="w-full flex items-center justify-between py-2.5 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-600/30 hover:scale-[1.02] active:scale-95 transition-all">
                    <span>Kasir POS Baru</span>
                    <span class="text-base leading-none font-bold">+</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto px-4 py-4 space-y-5 scrollbar-thin scrollbar-thumb-slate-700">
                @if (session('account_role') !== 'kasir')
                    <!-- Group 1: Menu Utama (Admin Only) -->
                    <div>
                        <span class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400/80">Menu Utama</span>
                        <nav class="mt-2 space-y-1">
                            <!-- Dashboard -->
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('dashboard') || request()->is('/') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="7" height="9" x="3" y="3" rx="1"/>
                                    <rect width="7" height="5" x="14" y="3" rx="1"/>
                                    <rect width="7" height="9" x="14" y="12" rx="1"/>
                                    <rect width="7" height="5" x="3" y="16" rx="1"/>
                                </svg>
                                <span>Dashboard</span>
                            </a>

                            <!-- AI Smart Stock Alert -->
                            <a href="{{ route('ai.stock.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('ai-stock*') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 2a2 2 0 0 1 2 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 0 1 7 7h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1H2a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h1a7 7 0 0 1 7-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 0 1 2-2z"/>
                                    <circle cx="7.5" cy="14.5" r="1.5" fill="currentColor" stroke="none"/>
                                    <circle cx="16.5" cy="14.5" r="1.5" fill="currentColor" stroke="none"/>
                                    <path d="M7 18h10"/>
                                </svg>
                                <span>AI Stock Alert</span>
                                @php
                                    $aiCritical = \App\Models\Product::where('stok_produk', '<=', \Illuminate\Support\Facades\DB::raw('stok_minimum'))->count();
                                @endphp
                                @if($aiCritical > 0)
                                <span class="ml-auto inline-flex items-center justify-center w-5 h-5 rounded-full bg-red-500 text-white text-[10px] font-bold">{{ $aiCritical > 9 ? '9+' : $aiCritical }}</span>
                                @endif
                            </a>

                            <!-- Laporan & Analisis Keuangan -->
                            <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('laporan*') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="20" x2="18" y2="10"/>
                                    <line x1="12" y1="20" x2="12" y2="4"/>
                                    <line x1="6" y1="20" x2="6" y2="14"/>
                                </svg>
                                <span>Laporan & Analisis</span>
                            </a>

                            <!-- Kelola Akun -->
                            <a href="{{ route('account.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('account*') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                                <span>Kelola Akun</span>
                            </a>
                        </nav>
                    </div>

                    <!-- Group 2: Master Data (Admin Only) -->
                    <div>
                        <span class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400/80">Master Data</span>
                        <nav class="mt-2 space-y-1">
                            <!-- Produk / Barang -->
                            <a href="{{ route('product.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('product*') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                                <div class="flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m7.5 4.27 9 5.15"/>
                                        <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                                        <path d="m3.3 7 8.7 5 8.7-5"/>
                                        <path d="M12 22V12"/>
                                    </svg>
                                    <span>Data Produk</span>
                                </div>
                            </a>

                            <!-- Kategori -->
                            <a href="{{ route('category.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('category*') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 20h16"/>
                                    <path d="M4 14h16"/>
                                    <path d="M4 8h16"/>
                                    <path d="M4 4h16"/>
                                </svg>
                                <span>Kategori</span>
                            </a>
                        </nav>
                    </div>
                @endif

                @if (session('account_role') !== 'kasir')
                    <!-- Group 3: Stok (Admin Only) -->
                    <div>
                        <span class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400/80">Stok</span>
                        <nav class="mt-2 space-y-1">
                            <!-- Pembelian Stok -->
                            <a href="{{ route('pembelian.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('pembelian*') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 2v20"/>
                                    <path d="m17 5-5-3-5 3"/>
                                    <path d="m17 19-5 3-5-3"/>
                                    <path d="M2 12h20"/>
                                </svg>
                                <span>Pembelian Stok</span>
                            </a>

                            <!-- Penyesuaian Stok -->
                            <a href="{{ route('penyesuaian.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('penyesuaian*') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                                <span>Penyesuaian Stok</span>
                            </a>
                        </nav>
                    </div>
                @endif

                <!-- Group 4: Transaksi (Kasir & Admin) — urutan terakhir -->
                <div>
                    <span class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400/80">Transaksi</span>
                    <nav class="mt-2 space-y-1">
                        <!-- Penjualan / Kasir -->
                        <a href="{{ route('kasir.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('kasir.index') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="8" cy="21" r="1"/>
                                <circle cx="19" cy="21" r="1"/>
                                <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
                            </svg>
                            <span>Penjualan (Kasir)</span>
                        </a>

                        <!-- Riwayat Penjualan -->
                        <a href="{{ route('kasir.riwayat') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('kasir.riwayat') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Riwayat Penjualan</span>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- User Profile Card & Logout -->
            <div class="p-4 border-t border-slate-800/80 bg-slate-950/30 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-indigo-500 to-indigo-700 flex items-center justify-center font-bold text-xs text-white shadow-inner shrink-0">
                        {{ strtoupper(substr(session('account_name', 'Admin'), 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ session('account_name', 'Administrator') }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ session('account_email', 'admin@example.com') }}</p>
                        <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider {{ session('account_role') === 'kasir' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-indigo-500/20 text-indigo-300 border border-indigo-500/30' }}">
                            {{ session('account_role', 'Admin') }}
                        </span>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="shrink-0">
                    @csrf
                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-400 hover:bg-slate-800/80 rounded-xl transition cursor-pointer" title="Keluar / Logout">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-50">
            @php
                // Query real-time data untuk notifikasi sistem
                $notifStokMenipis = \App\Models\Product::whereRaw('stok_produk <= COALESCE(stok_minimum, 5)')
                    ->orderBy('stok_produk', 'asc')
                    ->limit(4)
                    ->get();

                $notifTransaksiTerbaru = \App\Models\Penjualan::orderBy('created_at', 'desc')
                    ->limit(4)
                    ->get();

                $totalNotif = $notifStokMenipis->count() + $notifTransaksiTerbaru->count();
            @endphp

            <!-- TOPBAR / HEADER -->
            <header class="relative z-40 h-16 bg-white border-b border-slate-200/80 px-4 sm:px-6 flex items-center justify-between shadow-xs shrink-0">
                <div class="flex items-center gap-3">
                    <!-- Toggle Mobile Sidebar -->
                    <button id="open-sidebar-btn" type="button" class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 md:hidden focus:outline-hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <!-- Judul Halaman Aktif -->
                    <h2 class="text-base sm:text-lg font-bold text-slate-800 tracking-tight">
                        {{ $title ?? 'Dashboard' }}
                    </h2>
                </div>

                <!-- Right Header Actions (Bell Notification & Profile) -->
                <div class="flex items-center gap-3 sm:gap-4">
                    
                    @if (session('account_role') !== 'kasir')
                    <!-- Notification Bell Dropdown Wrapper -->
                    <div class="relative" id="notif-wrapper">
                        <button id="btn-toggle-notif" type="button" class="relative p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition cursor-pointer" title="Lihat Notifikasi">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @if ($totalNotif > 0)
                                <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 rounded-full bg-rose-500 ring-2 ring-white animate-pulse"></span>
                            @endif
                        </button>

                        <!-- Notification Dropdown Panel -->
                        <div id="notif-dropdown" class="absolute right-0 mt-3 w-80 sm:w-96 bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden z-50 hidden transition-all">
                            <!-- Dropdown Header -->
                            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                                <div class="flex items-center gap-2">
                                    <h4 class="text-sm font-bold text-slate-900">Notifikasi Sistem</h4>
                                    @if ($totalNotif > 0)
                                        <span class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-700 font-extrabold text-[10px]">
                                            {{ $totalNotif }} Baru
                                        </span>
                                    @endif
                                </div>
                                <span class="text-[11px] text-slate-400 font-medium">Real-time</span>
                            </div>

                            <!-- Dropdown Body Scrollable -->
                            <div class="max-h-[380px] overflow-y-auto divide-y divide-slate-100">
                                
                                <!-- 1. Notifikasi Stok Menipis -->
                                <div class="p-3 bg-amber-50/30">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-amber-700 px-2 mb-1.5 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                        </svg>
                                        Stok Menipis (Perlu Restock)
                                    </p>
                                    @forelse ($notifStokMenipis as $ns)
                                        <a href="{{ route('product.index') }}" class="flex items-center justify-between p-2 rounded-xl hover:bg-white hover:shadow-xs transition text-xs group">
                                            <div class="min-w-0 pr-2">
                                                <p class="font-bold text-slate-800 truncate group-hover:text-indigo-600 transition">{{ $ns->nama_produk }}</p>
                                                <p class="text-[10px] text-slate-400">Kode: {{ $ns->kode_produk }}</p>
                                            </div>
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700 shrink-0">
                                                Sisa {{ $ns->stok_produk }} {{ $ns->satuan_terkecil ?? 'pcs' }}
                                            </span>
                                        </a>
                                    @empty
                                        <p class="text-[11px] text-slate-400 px-2 py-1 italic">Semua stok produk saat ini aman.</p>
                                    @endforelse
                                </div>

                                <!-- 2. Notifikasi Transaksi Baru -->
                                <div class="p-3">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 px-2 mb-1.5 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        Transaksi Penjualan Terbaru
                                    </p>
                                    @forelse ($notifTransaksiTerbaru as $nt)
                                        <a href="{{ route('kasir.riwayat') }}" class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 transition text-xs group">
                                            <div class="min-w-0 pr-2">
                                                <p class="font-bold text-slate-800 group-hover:text-indigo-600 transition font-mono">{{ $nt->no_invoice }}</p>
                                                <p class="text-[10px] text-slate-400">{{ $nt->created_at ? $nt->created_at->diffForHumans() : '-' }}</p>
                                            </div>
                                            <span class="font-extrabold text-slate-900 shrink-0">
                                                Rp {{ number_format($nt->total_bayar, 0, ',', '.') }}
                                            </span>
                                        </a>
                                    @empty
                                        <p class="text-[11px] text-slate-400 px-2 py-1 italic">Belum ada transaksi penjualan.</p>
                                    @endforelse
                                </div>

                            </div>

                            <!-- Dropdown Footer -->
                            <div class="p-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs font-semibold">
                                <a href="{{ route('kasir.riwayat') }}" class="text-indigo-600 hover:text-indigo-800 transition">
                                    Buka Riwayat Penjualan &rarr;
                                </a>
                                <button type="button" onclick="document.getElementById('notif-dropdown').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 transition cursor-pointer">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- User Profile (Tanpa panah ke bawah) -->
                    <div class="flex items-center gap-2.5 pl-2 border-l border-slate-200/80">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-purple-500 to-indigo-600 flex items-center justify-center font-bold text-xs text-white shadow-xs ring-2 ring-purple-100 shrink-0">
                            {{ strtoupper(substr(session('account_name', 'Admin'), 0, 2)) }}
                        </div>
                        <span class="text-xs font-bold text-slate-800 hidden sm:inline-block truncate max-w-[140px]">
                            {{ session('account_name', 'Administrator') }}
                        </span>
                    </div>

                </div>
            </header>

            <!-- MAIN BODY / CONTENT (Scrollable) -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>

            <!-- FOOTER -->
            <footer class="h-12 border-t border-slate-200/80 bg-white px-6 flex items-center justify-between text-xs text-slate-500 shrink-0">
                <span>&copy; {{ date('Y') }} ATK SMART. All rights reserved.</span>
                <span class="flex items-center gap-1.5 font-medium text-slate-500">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                    Sistem Kasir &amp; Inventaris Toko ATK
                </span>
            </footer>
        </div>
    </div>

    <!-- Interactive Scripts (Sidebar & Notification Dropdown) -->
    <script>
        (function() {
            // Sidebar Toggle
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const openSidebarBtn = document.getElementById('open-sidebar-btn');
            const closeSidebarBtn = document.getElementById('close-sidebar-btn');

            function toggleSidebar() {
                if (!sidebar || !overlay) return;
                const isClosed = sidebar.classList.contains('-translate-x-full');
                if (isClosed) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                }
            }

            if (openSidebarBtn) openSidebarBtn.addEventListener('click', toggleSidebar);
            if (closeSidebarBtn) closeSidebarBtn.addEventListener('click', toggleSidebar);
            if (overlay) overlay.addEventListener('click', toggleSidebar);

            // Notification Dropdown Toggle
            const btnToggleNotif = document.getElementById('btn-toggle-notif');
            const notifDropdown = document.getElementById('notif-dropdown');
            const notifWrapper = document.getElementById('notif-wrapper');

            if (btnToggleNotif && notifDropdown) {
                btnToggleNotif.addEventListener('click', (e) => {
                    e.stopPropagation();
                    notifDropdown.classList.toggle('hidden');
                });

                // Close on click outside
                document.addEventListener('click', (e) => {
                    if (notifWrapper && !notifWrapper.contains(e.target)) {
                        notifDropdown.classList.add('hidden');
                    }
                });

                // Close on Escape key
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && !notifDropdown.classList.contains('hidden')) {
                        notifDropdown.classList.add('hidden');
                    }
                });
            }
        })();
    </script>

    @stack('scripts')
</body>
</html>
