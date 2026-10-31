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
                        <span class="px-3 py-1 rounded-full bg-red-500/80 border border-red-400/50 text-xs font-bold">
                            {{ $summary['out'] + $summary['critical'] }} Kritis
                        </span>
                        <span class="px-3 py-1 rounded-full bg-amber-500/80 border border-amber-400/50 text-xs font-bold">
                            {{ $summary['warning'] }} Waspada
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
                <p class="text-xs text-slate-400 mt-0.5">Perlu Perhatian</p>
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
                <button onclick="filterRisk('all')" id="btn-all" class="filter-btn active flex-1 min-w-[65px] py-2 px-2 rounded-xl text-xs font-semibold border transition-all text-center whitespace-nowrap bg-indigo-600 text-white border-indigo-600">Semua</button>
                <button onclick="filterRisk('out')" id="btn-out" class="filter-btn flex-1 min-w-[85px] py-2 px-2 rounded-xl text-xs font-semibold border transition-all text-center whitespace-nowrap border-red-200 text-red-600 bg-white hover:bg-red-50">Stok Habis</button>
                <button onclick="filterRisk('critical')" id="btn-critical" class="filter-btn flex-1 min-w-[65px] py-2 px-2 rounded-xl text-xs font-semibold border transition-all text-center whitespace-nowrap border-orange-200 text-orange-600 bg-white hover:bg-orange-50">Kritis</button>
                <button onclick="filterRisk('warning')" id="btn-warning" class="filter-btn flex-1 min-w-[75px] py-2 px-2 rounded-xl text-xs font-semibold border transition-all text-center whitespace-nowrap border-amber-200 text-amber-600 bg-white hover:bg-amber-50">Waspada</button>
                <button onclick="filterRisk('safe')" id="btn-safe" class="filter-btn flex-1 min-w-[65px] py-2 px-2 rounded-xl text-xs font-semibold border transition-all text-center whitespace-nowrap border-emerald-200 text-emerald-600 bg-white hover:bg-emerald-50">Aman</button>
                <button onclick="filterRisk('fast')" id="btn-fast" class="filter-btn flex-1 min-w-[100px] py-2 px-2 rounded-xl text-xs font-semibold border transition-all text-center whitespace-nowrap border-violet-200 text-violet-600 bg-white hover:bg-violet-50">🚀 Fast Moving</button>
                <button onclick="filterRisk('slow')" id="btn-slow" class="filter-btn flex-1 min-w-[100px] py-2 px-2 rounded-xl text-xs font-semibold border transition-all text-center whitespace-nowrap border-slate-200 text-slate-500 bg-white hover:bg-slate-50">📦 Slow Moving</button>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- AI RECOMMENDATION CARDS                                    --}}
        {{-- ========================================================= --}}
        <div id="cards-container" class="space-y-3">
            @foreach($analyzed as $index => $item)
            @php
                $p = $item['product'];
                $risk = $item['risk_level'];
                $borderClass = match($risk) {
                    'out'      => 'border-red-300 bg-red-50/40',
                    'critical' => 'border-orange-300 bg-orange-50/40',
                    'warning'  => 'border-amber-200 bg-amber-50/30',
                    default    => 'border-slate-100 bg-white',
                };
                $badgeClass = match($risk) {
                    'out'      => 'bg-red-100 text-red-700 border-red-200',
                    'critical' => 'bg-orange-100 text-orange-700 border-orange-200',
                    'warning'  => 'bg-amber-100 text-amber-700 border-amber-200',
                    default    => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                };
                $badgeLabel = match($risk) {
                    'out'      => '⛔ STOK HABIS',
                    'critical' => '🔴 KRITIS',
                    'warning'  => '🟡 WASPADA',
                    default    => '✅ AMAN',
                };
                $isFast = $item['is_fast_mover'];
                $isSlow = $item['is_slow_mover'];
            @endphp
            <div class="ai-card float-in border rounded-2xl shadow-xs p-4 sm:p-5 transition-all hover:shadow-md {{ $borderClass }}"
                 data-risk="{{ $risk }}"
                 data-fast="{{ $isFast ? '1' : '0' }}"
                 data-slow="{{ $isSlow ? '1' : '0' }}"
                 data-name="{{ strtolower($p->nama_produk) }}"
                 data-code="{{ strtolower($p->kode_produk) }}">

                <div class="flex flex-col sm:flex-row gap-4">

                    {{-- Foto produk --}}
                    <div class="shrink-0">
                        @if($p->foto_produk && file_exists(public_path('storage/' . $p->foto_produk)))
                            <img src="{{ asset('storage/' . $p->foto_produk) }}"
                                 alt="{{ $p->nama_produk }}"
                                 class="w-16 h-16 object-cover rounded-xl border border-slate-200 shadow-sm">
                        @else
                            <div class="w-16 h-16 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7H4a2 2 0 00-2 2v6a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><circle cx="12" cy="12" r="2"/></svg>
                            </div>
                        @endif
                    </div>

                    {{-- Info produk --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            {{-- Status badge --}}
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $badgeClass }}">
                                {{ $badgeLabel }}
                            </span>
                            {{-- Fast/Slow badge --}}
                            @if($isFast)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-violet-100 text-violet-700 border border-violet-200">🚀 Fast Moving</span>
                            @endif
                            @if($isSlow)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">📦 Slow Moving</span>
                            @endif
                            {{-- AI Badge --}}
                            <span class="ml-auto inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-700 border border-indigo-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a2 2 0 012 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 017 7h1a1 1 0 011 1v3a1 1 0 01-1 1h-1v1a2 2 0 01-2 2H5a2 2 0 01-2-2v-1H2a1 1 0 01-1-1v-3a1 1 0 011-1h1a7 7 0 017-7h1V5.73C10.4 5.39 10 4.74 10 4a2 2 0 012-2z"/></svg>
                                AI Analysis
                            </span>
                        </div>

                        <h3 class="font-bold text-slate-800 text-sm sm:text-base truncate">{{ $p->nama_produk }}</h3>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $p->kode_produk }} &bull; {{ $p->category->nama_kategori ?? 'Tanpa Kategori' }}</p>

                        {{-- Stats row --}}
                        <div class="mt-3 grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <div class="bg-white/70 rounded-xl p-2 border border-white text-center">
                                <p class="text-lg font-extrabold {{ $p->stok_produk <= 0 ? 'text-red-600' : ($p->stok_produk <= $p->stok_minimum ? 'text-orange-600' : 'text-slate-800') }}">{{ $p->stok_produk }}</p>
                                <p class="text-[10px] text-slate-400">Stok Saat Ini</p>
                            </div>
                            <div class="bg-white/70 rounded-xl p-2 border border-white text-center">
                                <p class="text-lg font-extrabold text-slate-600">{{ $p->stok_minimum }}</p>
                                <p class="text-[10px] text-slate-400">Stok Minimum</p>
                            </div>
                            <div class="bg-white/70 rounded-xl p-2 border border-white text-center">
                                <p class="text-lg font-extrabold text-slate-600">{{ $item['sold_30'] }}</p>
                                <p class="text-[10px] text-slate-400">Terjual/30 Hari</p>
                            </div>
                            <div class="bg-white/70 rounded-xl p-2 border border-white text-center">
                                @if($item['days_until_stockout'] !== null)
                                    <p class="text-lg font-extrabold {{ $item['days_until_stockout'] <= 7 ? 'text-red-600' : ($item['days_until_stockout'] <= 14 ? 'text-amber-600' : 'text-emerald-600') }}">
                                        {{ $item['days_until_stockout'] }}
                                    </p>
                                    <p class="text-[10px] text-slate-400">Hari Tersisa</p>
                                @else
                                    <p class="text-lg font-extrabold text-slate-300">—</p>
                                    <p class="text-[10px] text-slate-400">Hari Tersisa</p>
                                @endif
                            </div>
                        </div>

                        {{-- AI Message bubble --}}
                        <div class="mt-3 flex items-start gap-2.5">
                            <div class="shrink-0 w-7 h-7 rounded-xl bg-indigo-600 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a2 2 0 012 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 017 7h1a1 1 0 011 1v3a1 1 0 01-1 1h-1v1a2 2 0 01-2 2H5a2 2 0 01-2-2v-1H2a1 1 0 01-1-1v-3a1 1 0 011-1h1a7 7 0 017-7h1V5.73C10.4 5.39 10 4.74 10 4a2 2 0 012-2z"/></svg>
                            </div>
                            <div class="flex-1 bg-indigo-50 border border-indigo-100 rounded-xl rounded-tl-none px-3.5 py-2.5 text-xs text-slate-700 leading-relaxed">
                                {!! $item['ai_message'] !!}
                            </div>
                        </div>

                        {{-- Velocity + Reorder info --}}
                        <div class="mt-3 flex flex-wrap items-center gap-3 text-xs text-slate-500">
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                Kecepatan jual: <strong>{{ $item['velocity'] }}/hari</strong>
                            </span>
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Rekomendasi reorder: <strong>{{ $item['reorder_qty'] }} {{ $p->satuan_terkecil ?? 'pcs' }}</strong>
                            </span>
                            @if($p->harga_beli_terakhir > 0)
                            <span class="flex items-center gap-1 text-emerald-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Est. biaya reorder: <strong>Rp {{ number_format($item['reorder_qty'] * $p->harga_beli_terakhir, 0, ',', '.') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- No result after filter --}}
            <div id="no-result" class="hidden text-center py-12 text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-3 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="font-semibold">Tidak ada produk dengan kategori ini.</p>
            </div>
        </div>

        @endif

    </div>

    @push('scripts')
    <script>
        // ── Filter by risk ───────────────────────────────────────────
        let activeFilter = 'all';
        let searchQuery  = '';

        function filterRisk(risk) {
            activeFilter = risk;
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600');
                btn.classList.add('bg-white');
            });
            const btn = document.getElementById('btn-' + risk);
            if (btn) {
                btn.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600');
                btn.classList.remove('bg-white');
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
    </script>
    @endpush
</x-layout>

