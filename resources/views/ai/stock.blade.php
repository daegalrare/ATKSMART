<x-layout>
    <x-slot:title>AI Smart Stock Alert</x-slot:title>

    @push('styles')
    <style>
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(99,102,241,0.3); }
            50% { box-shadow: 0 0 0 8px rgba(99,102,241,0); }
        }
        .ai-pulse { animation: pulse-glow 2s infinite; }

        @keyframes ai-scan {
            0% { transform: translateY(0); opacity: 1; }
            100% { transform: translateY(24px); opacity: 0; }
        }
        .ai-scan-line {
            animation: ai-scan 1.5s ease-in-out infinite alternate;
        }

        @keyframes float-in {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .float-in { animation: float-in 0.4s ease both; }
        .float-in-delay-1 { animation-delay: 0.05s; }
        .float-in-delay-2 { animation-delay: 0.10s; }
        .float-in-delay-3 { animation-delay: 0.15s; }
        .float-in-delay-4 { animation-delay: 0.20s; }

        /* TAB FILTER BUTTONS (STATE ACTIVE & INACTIVE) */
        .tab-filter-btn {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            outline: none;
        }

        /* Inactive states */
        .tab-filter-btn[data-filter="all"].is-inactive {
            background-color: #ffffff;
            color: #475569;
            border-color: #cbd5e1;
        }
        .tab-filter-btn[data-filter="all"].is-inactive:hover {
            background-color: #f1f5f9;
            color: #0f172a;
            border-color: #94a3b8;
        }

        .tab-filter-btn[data-filter="out"].is-inactive {
            background-color: #ffffff;
            color: #dc2626;
            border-color: #fecaca;
        }
        .tab-filter-btn[data-filter="out"].is-inactive:hover {
            background-color: #fef2f2;
            color: #b91c1c;
            border-color: #f87171;
        }

        .tab-filter-btn[data-filter="critical"].is-inactive {
            background-color: #ffffff;
            color: #ea580c;
            border-color: #fed7aa;
        }
        .tab-filter-btn[data-filter="critical"].is-inactive:hover {
            background-color: #fff7ed;
            color: #c2410c;
            border-color: #fb923c;
        }

        .tab-filter-btn[data-filter="warning"].is-inactive {
            background-color: #ffffff;
            color: #d97706;
            border-color: #fde68a;
        }
        .tab-filter-btn[data-filter="warning"].is-inactive:hover {
            background-color: #fffbeb;
            color: #b45309;
            border-color: #f59e0b;
        }

        .tab-filter-btn[data-filter="safe"].is-inactive {
            background-color: #ffffff;
            color: #059669;
            border-color: #a7f3d0;
        }
        .tab-filter-btn[data-filter="safe"].is-inactive:hover {
            background-color: #ecfdf5;
            color: #047857;
            border-color: #34d399;
        }

        .tab-filter-btn[data-filter="fast"].is-inactive {
            background-color: #ffffff;
            color: #7c3aed;
            border-color: #ddd6fe;
        }
        .tab-filter-btn[data-filter="fast"].is-inactive:hover {
            background-color: #f5f3ff;
            color: #6d28d9;
            border-color: #a78bfa;
        }

        .tab-filter-btn[data-filter="slow"].is-inactive {
            background-color: #ffffff;
            color: #475569;
            border-color: #cbd5e1;
        }
        .tab-filter-btn[data-filter="slow"].is-inactive:hover {
            background-color: #f8fafc;
            color: #1e293b;
            border-color: #94a3b8;
        }

        /* Active states (Saat diklik/terpilih) - Jelas, Kontras Tinggi & Teks Tetap Terbaca Sangat Terang */
        .tab-filter-btn[data-filter="all"].is-active {
            background-color: #4f46e5 !important;
            color: #ffffff !important;
            border-color: #4338ca !important;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35);
        }
        .tab-filter-btn[data-filter="all"].is-active:hover {
            background-color: #4338ca !important;
            color: #ffffff !important;
        }

        .tab-filter-btn[data-filter="out"].is-active {
            background-color: #dc2626 !important;
            color: #ffffff !important;
            border-color: #b91c1c !important;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35);
        }
        .tab-filter-btn[data-filter="out"].is-active:hover {
            background-color: #b91c1c !important;
            color: #ffffff !important;
        }

        .tab-filter-btn[data-filter="critical"].is-active {
            background-color: #ea580c !important;
            color: #ffffff !important;
            border-color: #c2410c !important;
            box-shadow: 0 4px 12px rgba(234, 88, 12, 0.35);
        }
        .tab-filter-btn[data-filter="critical"].is-active:hover {
            background-color: #c2410c !important;
            color: #ffffff !important;
        }

        .tab-filter-btn[data-filter="warning"].is-active {
            background-color: #d97706 !important;
            color: #ffffff !important;
            border-color: #b45309 !important;
            box-shadow: 0 4px 12px rgba(217, 119, 6, 0.35);
        }
        .tab-filter-btn[data-filter="warning"].is-active:hover {
            background-color: #b45309 !important;
            color: #ffffff !important;
        }

        .tab-filter-btn[data-filter="safe"].is-active {
            background-color: #059669 !important;
            color: #ffffff !important;
            border-color: #047857 !important;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.35);
        }
        .tab-filter-btn[data-filter="safe"].is-active:hover {
            background-color: #047857 !important;
            color: #ffffff !important;
        }

        .tab-filter-btn[data-filter="fast"].is-active {
            background-color: #7c3aed !important;
            color: #ffffff !important;
            border-color: #6d28d9 !important;
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.35);
        }
        .tab-filter-btn[data-filter="fast"].is-active:hover {
            background-color: #6d28d9 !important;
            color: #ffffff !important;
        }

        .tab-filter-btn[data-filter="slow"].is-active {
            background-color: #334155 !important;
            color: #ffffff !important;
            border-color: #1e293b !important;
            box-shadow: 0 4px 12px rgba(51, 65, 85, 0.35);
        }
        .tab-filter-btn[data-filter="slow"].is-active:hover {
            background-color: #1e293b !important;
            color: #ffffff !important;
        }
    </style>
    @endpush

    <div class="space-y-6 pb-8">

        {{-- ========================================================= --}}
        {{-- HEADER HERO                                                --}}
        {{-- ========================================================= --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-violet-600 to-purple-700 rounded-2xl p-6 sm:p-8 text-white shadow-xl float-in">
            {{-- Background decoration --}}
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-64 h-64 rounded-full bg-white/20 -translate-y-1/2 translate-x-1/4 blur-2xl"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 rounded-full bg-indigo-300/30 translate-y-1/2 -translate-x-1/4 blur-2xl"></div>
            </div>

            <div class="relative flex flex-col sm:flex-row items-start sm:items-center gap-5">
                {{-- AI Icon --}}
                <div class="w-16 h-16 rounded-2xl bg-white/15 backdrop-blur-sm border border-white/20 flex items-center justify-center shrink-0 ai-pulse">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2a2 2 0 0 1 2 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 0 1 7 7h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1H2a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h1a7 7 0 0 1 7-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 0 1 2-2z"/>
                        <circle cx="7.5" cy="14.5" r="1.5" fill="currentColor" stroke="none"/>
                        <circle cx="16.5" cy="14.5" r="1.5" fill="currentColor" stroke="none"/>
                        <path d="M7 18h10"/>
                    </svg>
                </div>

                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 border border-white/30 text-xs font-bold uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                            AI Engine Aktif
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">AI Smart Stock Alert</h1>
                    <p class="mt-1 text-indigo-200 text-sm sm:text-base">
                        Sistem kecerdasan buatan menganalisis pola penjualan &amp; memprediksi kebutuhan stok secara otomatis.
                    </p>
                </div>

                {{-- Stats pill --}}
                <div class="flex flex-col items-end gap-2 shrink-0">
                    <div class="text-right">
                        <p class="text-xs text-indigo-200">Terakhir dianalisis</p>
                        <p class="text-sm font-bold">{{ now()->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="flex gap-2">
                        <span class="px-3 py-1 rounded-full bg-orange-500/80 border border-orange-400/50 text-xs font-bold">
                            {{ $summary['critical'] }} Kritis
                        </span>
                        <span class="px-3 py-1 rounded-full bg-red-500/80 border border-red-400/50 text-xs font-bold">
                            {{ $summary['out'] }} Habis
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- SUMMARY CARDS                                              --}}
        {{-- ========================================================= --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">

            <div class="float-in float-in-delay-1 bg-white rounded-2xl border border-slate-100 shadow-xs p-4 text-center hover:shadow-md transition-all">
                <p class="text-2xl font-extrabold text-slate-800">{{ $summary['total'] }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Total Produk</p>
                <div class="mt-2 w-8 h-1 bg-indigo-400 rounded-full mx-auto"></div>
            </div>

            <div class="float-in float-in-delay-1 bg-white rounded-2xl border border-red-100 shadow-xs p-4 text-center hover:shadow-md transition-all">
                <p class="text-2xl font-extrabold text-red-600">{{ $summary['out'] }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Stok Habis</p>
                <div class="mt-2 w-8 h-1 bg-red-500 rounded-full mx-auto"></div>
            </div>

            <div class="float-in float-in-delay-2 bg-white rounded-2xl border border-orange-100 shadow-xs p-4 text-center hover:shadow-md transition-all">
                <p class="text-2xl font-extrabold text-orange-600">{{ $summary['critical'] }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Kritis</p>
                <div class="mt-2 w-8 h-1 bg-orange-500 rounded-full mx-auto"></div>
            </div>

            <div class="float-in float-in-delay-2 bg-white rounded-2xl border border-amber-100 shadow-xs p-4 text-center hover:shadow-md transition-all">
                <p class="text-2xl font-extrabold text-amber-600">{{ $summary['warning'] }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Waspada</p>
                <div class="mt-2 w-8 h-1 bg-amber-400 rounded-full mx-auto"></div>
            </div>

            <div class="float-in float-in-delay-3 bg-white rounded-2xl border border-emerald-100 shadow-xs p-4 text-center hover:shadow-md transition-all">
                <p class="text-2xl font-extrabold text-emerald-600">{{ $summary['safe'] }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Stok Aman</p>
                <div class="mt-2 w-8 h-1 bg-emerald-400 rounded-full mx-auto"></div>
            </div>

            <div class="float-in float-in-delay-4 bg-white rounded-2xl border border-violet-100 shadow-xs p-4 text-center hover:shadow-md transition-all">
                <p class="text-2xl font-extrabold text-violet-600">{{ $summary['fast'] }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Fast Moving</p>
                <div class="mt-2 w-8 h-1 bg-violet-400 rounded-full mx-auto"></div>
            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- EMPTY STATE                                                --}}
        {{-- ========================================================= --}}
        @if($summary['total'] === 0)
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-12 text-center float-in">
            <div class="w-20 h-20 mx-auto mb-4 rounded-3xl bg-indigo-50 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-700">Belum Ada Produk</h3>
            <p class="text-slate-400 text-sm mt-1">Tambahkan produk terlebih dahulu agar AI dapat menganalisis stok Anda.</p>
            <a href="{{ route('product.index') }}" class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Produk Sekarang
            </a>
        </div>
        @else

        {{-- ========================================================= --}}
        {{-- FILTER & SEARCH BAR                                        --}}
        {{-- ========================================================= --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-2.5 sm:p-3 flex flex-col lg:flex-row gap-2.5 items-stretch lg:items-center float-in">
            {{-- Search di paling kiri --}}
            <div class="relative w-full lg:w-72 shrink-0">
                <input type="text" id="search-product" placeholder="Cari nama atau kode produk..." oninput="searchProduct(this.value)"
                    class="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50/60 focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            {{-- Tombol Filter di sebelah kanan (memenuhi seluruh sisa border) --}}
            <div class="flex flex-wrap sm:flex-nowrap items-center gap-1.5 w-full flex-1">
                <button type="button" onclick="filterRisk('all')" id="btn-all" data-filter="all" class="tab-filter-btn is-active flex-1 min-w-[65px] py-2 px-2 rounded-xl text-xs font-bold border text-center whitespace-nowrap">Semua</button>
                <button type="button" onclick="filterRisk('out')" id="btn-out" data-filter="out" class="tab-filter-btn is-inactive flex-1 min-w-[85px] py-2 px-2 rounded-xl text-xs font-bold border text-center whitespace-nowrap">Stok Habis</button>
                <button type="button" onclick="filterRisk('critical')" id="btn-critical" data-filter="critical" class="tab-filter-btn is-inactive flex-1 min-w-[65px] py-2 px-2 rounded-xl text-xs font-bold border text-center whitespace-nowrap">Kritis</button>
                <button type="button" onclick="filterRisk('warning')" id="btn-warning" data-filter="warning" class="tab-filter-btn is-inactive flex-1 min-w-[75px] py-2 px-2 rounded-xl text-xs font-bold border text-center whitespace-nowrap">Waspada</button>
                <button type="button" onclick="filterRisk('safe')" id="btn-safe" data-filter="safe" class="tab-filter-btn is-inactive flex-1 min-w-[65px] py-2 px-2 rounded-xl text-xs font-bold border text-center whitespace-nowrap">Aman</button>
                <button type="button" onclick="filterRisk('fast')" id="btn-fast" data-filter="fast" class="tab-filter-btn is-inactive flex-1 min-w-[100px] py-2 px-2 rounded-xl text-xs font-bold border text-center whitespace-nowrap">🚀 Fast Moving</button>
                <button type="button" onclick="filterRisk('slow')" id="btn-slow" data-filter="slow" class="tab-filter-btn is-inactive flex-1 min-w-[100px] py-2 px-2 rounded-xl text-xs font-bold border text-center whitespace-nowrap">📦 Slow Moving</button>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- AI RECOMMENDATION TABLE                                    --}}
        {{-- ========================================================= --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden float-in">

            {{-- Table wrapper (responsif, tanpa scroll di desktop) --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse" id="cards-container">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-extrabold text-slate-700 uppercase tracking-wider">
                            <th class="text-left py-3.5 px-3.5 w-[20%]">Produk</th>
                            <th class="text-center py-3.5 px-2 whitespace-nowrap">Status</th>
                            <th class="text-center py-3.5 px-2 whitespace-nowrap">Stok</th>
                            <th class="text-center py-3.5 px-2 whitespace-nowrap">Min.</th>
                            <th class="text-center py-3.5 px-2 whitespace-nowrap">Terjual</th>
                            <th class="text-center py-3.5 px-2 whitespace-nowrap">Sisa Hari</th>
                            <th class="text-center py-3.5 px-2 whitespace-nowrap">Kecepatan</th>
                            <th class="text-center py-3.5 px-2 whitespace-nowrap">Reorder</th>
                            <th class="text-left py-3.5 px-3 w-[28%]">Rekomendasi AI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($analyzed as $index => $item)
                        @php
                            $p       = $item['product'];
                            $risk    = $item['risk_level'];
                            $isFast  = $item['is_fast_mover'];
                            $isSlow  = $item['is_slow_mover'];

                            $rowBg = match($risk) {
                                'out'      => 'bg-red-50/60 hover:bg-red-50',
                                'critical' => 'bg-orange-50/50 hover:bg-orange-50',
                                'warning'  => 'bg-amber-50/40 hover:bg-amber-50',
                                default    => 'bg-white hover:bg-indigo-50/30',
                            };
                            $leftBorder = match($risk) {
                                'out'      => 'border-l-4 border-l-red-500',
                                'critical' => 'border-l-4 border-l-orange-500',
                                'warning'  => 'border-l-4 border-l-amber-500',
                                default    => 'border-l-4 border-l-emerald-500',
                            };
                            $badgeClass = match($risk) {
                                'out'      => 'bg-red-100 text-red-700 border-red-200',
                                'critical' => 'bg-orange-100 text-orange-700 border-orange-200',
                                'warning'  => 'bg-amber-100 text-amber-700 border-amber-200',
                                default    => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                            };
                            $badgeLabel = match($risk) {
                                'out'      => '⛔ Stok Habis',
                                'critical' => '🔴 Kritis',
                                'warning'  => '🟡 Waspada',
                                default    => '✅ Aman',
                            };
                            $stokColor = $p->stok_produk <= 0
                                ? 'text-red-600 font-black'
                                : ($p->stok_produk <= $p->stok_minimum
                                    ? 'text-orange-600 font-black'
                                    : 'text-slate-800 font-extrabold');
                            $hariColor = $item['days_until_stockout'] !== null
                                ? ($item['days_until_stockout'] <= 7
                                    ? 'text-red-600 font-black'
                                    : ($item['days_until_stockout'] <= 14
                                        ? 'text-amber-600 font-extrabold'
                                        : 'text-emerald-600 font-extrabold'))
                                : 'text-slate-300 font-extrabold';
                        @endphp
                        <tr class="ai-card transition-colors {{ $rowBg }} {{ $leftBorder }}"
                            data-risk="{{ $risk }}"
                            data-fast="{{ $isFast ? '1' : '0' }}"
                            data-slow="{{ $isSlow ? '1' : '0' }}"
                            data-name="{{ strtolower($p->nama_produk) }}"
                            data-code="{{ strtolower($p->kode_produk) }}">

                            {{-- PRODUK --}}
                            <td class="py-3 px-3.5">
                                <div class="flex items-center gap-2.5">
                                    @if($p->foto_produk && file_exists(public_path('storage/' . $p->foto_produk)))
                                        <button type="button" 
                                                onclick="openImageModal('{{ asset('storage/' . $p->foto_produk) }}', '{{ addslashes($p->nama_produk) }}')" 
                                                class="group relative w-10 h-10 rounded-xl overflow-hidden border border-slate-200 shadow-2xs hover:ring-2 hover:ring-indigo-500 hover:scale-105 transition-all shrink-0 cursor-pointer"
                                                title="Klik untuk memperbesar foto">
                                            <img src="{{ asset('storage/' . $p->foto_produk) }}"
                                                 alt="{{ $p->nama_produk }}"
                                                 class="w-full h-full object-cover">
                                            <span class="absolute inset-0 bg-slate-900/35 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white transition-opacity">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/>
                                                </svg>
                                            </span>
                                        </button>
                                    @else
                                        <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-300 shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7H4a2 2 0 00-2 2v6a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><circle cx="12" cy="12" r="2"/></svg>
                                        </div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <p class="font-extrabold text-slate-900 text-xs sm:text-[13px] leading-snug line-clamp-2">{{ $p->nama_produk }}</p>
                                        <div class="flex items-center gap-1.5 mt-0.5 flex-wrap">
                                            <span class="inline-flex items-center font-mono text-[10px] font-bold text-indigo-600 bg-indigo-50 border border-indigo-100 px-1 py-0.2 rounded">
                                                {{ $p->kode_produk }}
                                            </span>
                                            <span class="text-[11px] font-semibold text-slate-400 truncate max-w-[100px]">
                                                {{ $p->category->nama_kategori ?? 'Tanpa Kategori' }}
                                            </span>
                                        </div>
                                        @if($isFast)
                                            <span class="inline-flex mt-0.5 items-center px-1.5 py-0.2 rounded-full text-[8.5px] font-extrabold bg-violet-100 text-violet-700 border border-violet-200">🚀 Fast</span>
                                        @endif
                                        @if($isSlow)
                                            <span class="inline-flex mt-0.5 items-center px-1.5 py-0.2 rounded-full text-[8.5px] font-extrabold bg-slate-100 text-slate-600 border border-slate-200">📦 Slow</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- STATUS --}}
                            <td class="py-3 px-2 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-extrabold border {{ $badgeClass }} whitespace-nowrap shadow-2xs">
                                    {{ $badgeLabel }}
                                </span>
                            </td>

                            {{-- STOK SAAT INI --}}
                            <td class="py-3 px-2 text-center whitespace-nowrap">
                                <span class="text-base sm:text-lg {{ $stokColor }}">{{ $p->stok_produk }}</span>
                                <p class="text-[10px] font-bold text-slate-500 mt-0.5">{{ $p->satuan_terkecil ?? 'pcs' }}</p>
                            </td>

                            {{-- STOK MINIMUM --}}
                            <td class="py-3 px-2 text-center whitespace-nowrap">
                                <span class="text-xs sm:text-sm font-extrabold text-slate-600">{{ $p->stok_minimum }}</span>
                                <p class="text-[10px] font-bold text-slate-400 mt-0.5">{{ $p->satuan_terkecil ?? 'pcs' }}</p>
                            </td>

                            {{-- TERJUAL/30 HARI --}}
                            <td class="py-3 px-2 text-center whitespace-nowrap">
                                <span class="text-xs sm:text-sm font-extrabold text-indigo-600">{{ $item['sold_30'] }}</span>
                                <p class="text-[10px] font-bold text-slate-400 mt-0.5">unit</p>
                            </td>

                            {{-- HARI TERSISA --}}
                            <td class="py-3 px-2 text-center whitespace-nowrap">
                                @if($item['days_until_stockout'] !== null)
                                    <span class="text-base sm:text-lg {{ $hariColor }}">{{ $item['days_until_stockout'] }}</span>
                                    <p class="text-[10px] font-bold text-slate-400 mt-0.5">hari</p>
                                @else
                                    <span class="text-sm font-extrabold text-slate-300">—</span>
                                    <p class="text-[10px] font-bold text-slate-400 mt-0.5">hari</p>
                                @endif
                            </td>

                            {{-- KECEPATAN JUAL --}}
                            <td class="py-3 px-2 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-indigo-50 border border-indigo-200" title="Rata-rata penjualan per minggu">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                    <span class="text-[11px] font-extrabold text-indigo-700">{{ $item['velocity_weekly'] }}/mgg</span>
                                </div>
                            </td>

                            {{-- REORDER QTY --}}
                            <td class="py-3 px-2 text-center whitespace-nowrap">
                                @if($item['reorder_qty'] > 0)
                                    <div class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-violet-50 border border-violet-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        <span class="text-[11px] font-extrabold text-violet-700">{{ $item['reorder_qty'] }} {{ $p->satuan_terkecil ?? 'pcs' }}</span>
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-slate-100 text-slate-500 text-[10px] font-bold border border-slate-200/80" title="Stok saat ini masih aman dan mencukupi">
                                        0 {{ $p->satuan_terkecil ?? 'pcs' }} (Cukup)
                                    </span>
                                @endif
                            </td>

                            {{-- REKOMENDASI AI (Menggantikan Est. Biaya) --}}
                            <td class="py-3 px-3">
                                <div class="flex items-start gap-2">
                                    <div class="shrink-0 w-5 h-5 rounded-md bg-indigo-600 flex items-center justify-center mt-0.5 shadow-2xs">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a2 2 0 012 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 017 7h1a1 1 0 011 1v3a1 1 0 01-1 1h-1v1a2 2 0 01-2 2H5a2 2 0 01-2-2v-1H2a1 1 0 01-1-1v-3a1 1 0 011-1h1a7 7 0 017-7h1V5.73C10.4 5.39 10 4.74 10 4a2 2 0 012-2z"/></svg>
                                    </div>
                                    <div class="text-[11px] font-medium text-slate-700 leading-relaxed bg-indigo-50/70 border border-indigo-100 rounded-xl px-2.5 py-2 flex-1 shadow-2xs">
                                        {!! $item['ai_message'] !!}
                                    </div>
                                </div>
                            </td>

                        </tr>
                        @endforeach

                        {{-- No result row --}}
                        <tr id="no-result" class="hidden">
                            <td colspan="9" class="text-center py-16 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-3 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="font-semibold">Tidak ada produk dengan kategori ini.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

        @endif

    </div>

    {{-- ========================================================= --}}
    {{-- MODAL PREVIEW FOTO PRODUK (POPUP ZOOM)                    --}}
    {{-- ========================================================= --}}
    <div id="image-preview-modal" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-xs hidden transition-opacity" 
         onclick="closeImageModal(event)">
        <div class="relative bg-white rounded-3xl shadow-2xl p-5 max-w-lg w-full overflow-hidden border border-slate-100 transition-all scale-100" 
             onclick="event.stopPropagation()">
            
            {{-- Close Button --}}
            <button type="button" 
                    onclick="closeImageModal()" 
                    class="absolute top-4 right-4 w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-900 flex items-center justify-center transition cursor-pointer z-10" 
                    title="Tutup (Esc)">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            {{-- Title Info --}}
            <div class="mb-3.5 pr-12">
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-indigo-600 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded-md inline-block mb-1">Foto Produk</span>
                <h4 id="modal-image-title" class="font-black text-slate-900 text-base sm:text-lg truncate"></h4>
            </div>

            {{-- Image Box --}}
            <div class="w-full aspect-square bg-slate-50/80 rounded-2xl overflow-hidden flex items-center justify-center border border-slate-200/80 p-2">
                <img id="modal-image-preview" src="" alt="Foto Produk" class="max-w-full max-h-full object-contain rounded-xl drop-shadow-sm">
            </div>

            <p class="text-center text-xs text-slate-400 mt-3 font-medium">Klik di luar area atau tombol Esc untuk menutup</p>
        </div>
    </div>

    @push('scripts')
    <script>
        // ── Filter by risk ───────────────────────────────────────────
        let activeFilter = 'all';
        let searchQuery  = '';

        function filterRisk(risk) {
            activeFilter = risk;
            document.querySelectorAll('.tab-filter-btn').forEach(btn => {
                btn.classList.remove('is-active');
                btn.classList.add('is-inactive');
            });
            const btn = document.getElementById('btn-' + risk);
            if (btn) {
                btn.classList.remove('is-inactive');
                btn.classList.add('is-active');
            }
            applyFilters();
        }

        function searchProduct(q) {
            searchQuery = q.toLowerCase().trim();
            applyFilters();
        }

        function applyFilters() {
            const cards = document.querySelectorAll('.ai-card');
            let visible = 0;
            cards.forEach(card => {
                const risk = card.dataset.risk;
                const fast = card.dataset.fast === '1';
                const slow = card.dataset.slow === '1';
                const name = card.dataset.name;
                const code = card.dataset.code || '';

                let matchFilter = true;
                if (activeFilter === 'all')      matchFilter = true;
                else if (activeFilter === 'fast') matchFilter = fast;
                else if (activeFilter === 'slow') matchFilter = slow;
                else                             matchFilter = risk === activeFilter;

                const matchSearch = searchQuery === '' || name.includes(searchQuery) || code.includes(searchQuery);

                if (matchFilter && matchSearch) {
                    card.style.display = '';
                    visible++;
                } else {
                    card.style.display = 'none';
                }
            });
            const noResult = document.getElementById('no-result');
            if (noResult) noResult.classList.toggle('hidden', visible > 0);
        }

        // ── Modal Preview Foto Produk ────────────────────────────────
        function openImageModal(imgSrc, title) {
            const modal = document.getElementById('image-preview-modal');
            const img   = document.getElementById('modal-image-preview');
            const ttl   = document.getElementById('modal-image-title');
            if (modal && img) {
                img.src = imgSrc;
                if (ttl) ttl.textContent = title;
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        }

        function closeImageModal() {
            const modal = document.getElementById('image-preview-modal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
    @endpush
</x-layout>

