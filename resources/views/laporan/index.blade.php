<x-layout>
    <x-slot:title>Laporan &amp; Analisis Keuangan</x-slot:title>

    @push('styles')
    <style>
        @keyframes fadeSlideIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeSlideIn 0.35s ease both; }
        .fade-in-1 { animation-delay: 0.05s; }
        .fade-in-2 { animation-delay: 0.10s; }
        .fade-in-3 { animation-delay: 0.15s; }
        .fade-in-4 { animation-delay: 0.20s; }
        .fade-in-5 { animation-delay: 0.25s; }

        .margin-bar { transition: width 0.8s cubic-bezier(0.4,0,0.2,1); }
        .item-list  { max-height: 0; overflow: hidden; transition: max-height 0.35s ease; }
        .item-list.open { max-height: 500px; }

        .tab-btn-active {
            background: white;
            color: #4f46e5;
            font-weight: 700;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }
        .tab-btn-inactive {
            color: #94a3b8;
            font-weight: 500;
        }
        .tab-btn-inactive:hover { color: #475569; background: rgba(255,255,255,0.5); }

        .tab-content { animation: fadeSlideIn 0.25s ease; }

        /* scrollbar tipis */
        .thin-scroll::-webkit-scrollbar { height: 4px; }
        .thin-scroll::-webkit-scrollbar-track { background: #f1f5f9; }
        .thin-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
    </style>
    @endpush

    <div class="space-y-5 pb-12">

        {{-- ============================================================ --}}
        {{-- HERO HEADER                                                   --}}
        {{-- ============================================================ --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-indigo-700 to-violet-700 rounded-2xl p-5 sm:p-7 text-white shadow-xl fade-in">
            {{-- Dekorasi latar --}}
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute -top-10 -right-10 w-60 h-60 rounded-full bg-white/5 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 rounded-full bg-violet-400/10 blur-2xl"></div>
            </div>

            <div class="relative flex flex-col md:flex-row md:items-start justify-between gap-5">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-white/15 border border-white/25 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-extrabold leading-tight">Laporan &amp; Analisis Keuangan</h1>
                        <p class="text-indigo-200 text-sm mt-0.5">Omzet, modal HPP, laba kotor, pembelian stok &amp; opname</p>
                        <p class="text-indigo-300 text-xs mt-1.5 font-medium">
                            Periode:
                            <span class="text-white font-bold">{{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }}</span>
                            &mdash;
                            <span class="text-white font-bold">{{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}</span>
                        </p>
                    </div>
                </div>

                {{-- Tombol Cetak & Export --}}
                <div class="flex flex-wrap items-center gap-2 shrink-0">
                    <a href="{{ route('laporan.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/15 hover:bg-white/25 border border-white/25 text-xs font-semibold transition">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export CSV
                    </a>
                    <a href="{{ route('laporan.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-indigo-700 hover:bg-indigo-50 text-xs font-bold shadow-md transition">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Cetak Laporan
                    </a>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- FILTER PERIODE                                                --}}
        {{-- ============================================================ --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-4 fade-in fade-in-1">
            <div class="flex flex-col lg:flex-row lg:items-center gap-3">
                {{-- Preset Periode --}}
                <div class="flex flex-wrap items-center gap-1.5">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mr-1">Periode:</span>
                    @foreach ([
                        'hari_ini'   => 'Hari Ini',
                        '7_hari'     => '7 Hari',
                        'bulan_ini'  => 'Bulan Ini',
                        'bulan_lalu' => 'Bulan Lalu',
                        'tahun_ini'  => 'Tahun Ini',
                    ] as $key => $label)
                    <a href="{{ route('laporan.index', ['periode' => $key]) }}"
                       class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition
                              {{ $periode === $key
                                  ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-200'
                                  : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
                        {{ $label }}
                    </a>
                    @endforeach
                </div>

                {{-- Divider --}}
                <div class="hidden lg:block w-px h-8 bg-slate-200 mx-1"></div>

                {{-- Custom Range --}}
                <form action="{{ route('laporan.index') }}" method="GET" class="flex flex-wrap items-center gap-2 flex-1">
                    <input type="hidden" name="periode" value="custom">
                    <span class="text-xs text-slate-500 font-medium">Dari</span>
                    <input type="date" name="start_date" value="{{ $startDate }}"
                           class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:ring-2 focus:ring-indigo-400/30 focus:border-indigo-400 focus:outline-none transition">
                    <span class="text-xs text-slate-400">s/d</span>
                    <input type="date" name="end_date" value="{{ $endDate }}"
                           class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:ring-2 focus:ring-indigo-400/30 focus:border-indigo-400 focus:outline-none transition">
                    <button type="submit" class="px-4 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition shadow-xs cursor-pointer">
                        Terapkan
                    </button>
                </form>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- 5 KARTU RINGKASAN KEUANGAN                                    --}}
        {{-- ============================================================ --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-4">

            {{-- 1. Total Omzet --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-4 sm:p-5 hover:shadow-md hover:border-emerald-200 transition fade-in fade-in-1">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-[9px] font-bold uppercase tracking-widest text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full">Pemasukan</span>
                </div>
                <p class="text-lg sm:text-xl font-extrabold text-slate-900 leading-tight">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</p>
                <p class="text-[10px] font-semibold text-slate-400 mt-1">Total Omzet</p>
                <p class="text-[10px] text-emerald-500 mt-0.5 font-medium">{{ number_format($totalTransaksi) }} transaksi</p>
            </div>

            {{-- 2. Modal HPP --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-4 sm:p-5 hover:shadow-md hover:border-sky-200 transition fade-in fade-in-2">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                        <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <span class="text-[9px] font-bold uppercase tracking-widest text-sky-500 bg-sky-50 px-2 py-0.5 rounded-full">Modal</span>
                </div>
                <p class="text-lg sm:text-xl font-extrabold text-slate-900 leading-tight">Rp {{ number_format($totalHpp, 0, ',', '.') }}</p>
                <p class="text-[10px] font-semibold text-slate-400 mt-1">Modal HPP</p>
                <p class="text-[10px] text-sky-500 mt-0.5 font-medium">Biaya pokok penjualan</p>
            </div>

            {{-- 3. Laba Kotor (highlighted) --}}
            <div class="bg-gradient-to-br from-indigo-600 to-violet-600 rounded-2xl shadow-lg shadow-indigo-200 p-4 sm:p-5 text-white fade-in fade-in-3">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl bg-white/20 border border-white/25 flex items-center justify-center">
                        <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-white/20 border border-white/25">
                        {{ number_format($marginLabaKotor, 1) }}% margin
                    </span>
                </div>
                <p class="text-lg sm:text-xl font-extrabold leading-tight">Rp {{ number_format($labaKotor, 0, ',', '.') }}</p>
                <p class="text-[10px] font-semibold text-indigo-200 mt-1">Laba Kotor</p>
                <p class="text-[10px] text-indigo-300 mt-0.5">Omzet dikurangi HPP</p>
            </div>

            {{-- 4. Beli Stok --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-4 sm:p-5 hover:shadow-md hover:border-amber-200 transition fade-in fade-in-4">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <span class="text-[9px] font-bold uppercase tracking-widest text-amber-500 bg-amber-50 px-2 py-0.5 rounded-full">Pengeluaran</span>
                </div>
                <p class="text-lg sm:text-xl font-extrabold text-slate-900 leading-tight">Rp {{ number_format($totalPembelian, 0, ',', '.') }}</p>
                <p class="text-[10px] font-semibold text-slate-400 mt-1">Beli Stok</p>
                <p class="text-[10px] text-amber-500 mt-0.5 font-medium">Kulakan dari supplier</p>
            </div>

            {{-- 5. Laba Bersih --}}
            <div class="bg-white rounded-2xl border {{ $labaBersihEstimasi >= 0 ? 'border-emerald-200 hover:border-emerald-300' : 'border-rose-200 hover:border-rose-300' }} shadow-xs p-4 sm:p-5 hover:shadow-md transition fade-in fade-in-5">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl {{ $labaBersihEstimasi >= 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} flex items-center justify-center">
                        <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            @if($labaBersihEstimasi >= 0)
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            @else
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            @endif
                        </svg>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold {{ $labaBersihEstimasi >= 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                        {{ $labaBersihEstimasi >= 0 ? '✓ Untung' : '✗ Rugi' }}
                    </span>
                </div>
                <p class="text-lg sm:text-xl font-extrabold {{ $labaBersihEstimasi >= 0 ? 'text-emerald-700' : 'text-rose-600' }} leading-tight">
                    {{ $labaBersihEstimasi >= 0 ? '' : '-' }}Rp {{ number_format(abs($labaBersihEstimasi), 0, ',', '.') }}
                </p>
                <p class="text-[10px] font-semibold text-slate-400 mt-1">Laba Bersih Est.</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Setelah selisih opname</p>
            </div>

        </div>

        {{-- ============================================================ --}}
        {{-- TABS: RINCIAN DATA                                            --}}
        {{-- ============================================================ --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden fade-in fade-in-3">

            {{-- Tab Navigation --}}
            <div class="bg-slate-50/80 border-b border-slate-100 p-1.5">
                <div class="flex gap-1 overflow-x-auto thin-scroll">
                    @php
                        $tabs = [
                            ['id' => 'penjualan',   'label' => 'Rincian Penjualan', 'count' => $penjualanList->total(),   'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>'],
                            ['id' => 'produk',      'label' => 'Performa Produk',   'count' => count($produkPerforma),     'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>'],
                            ['id' => 'pembelian',   'label' => 'Beli Stok',         'count' => count($pembelianList),      'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>'],
                            ['id' => 'penyesuaian', 'label' => 'Opname Stok',       'count' => count($penyesuaianList),    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>'],
                        ];
                    @endphp
                    @foreach($tabs as $idx => $tab)
                    <button type="button" onclick="switchReportTab('tab-{{ $tab['id'] }}')" id="btn-tab-{{ $tab['id'] }}"
                            class="tab-btn flex items-center gap-2 px-4 py-2 rounded-xl text-xs whitespace-nowrap transition-all cursor-pointer shrink-0
                                   {{ $idx === 0 ? 'tab-btn-active' : 'tab-btn-inactive' }}">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">{!! $tab['icon'] !!}</svg>
                        <span>{{ $tab['label'] }}</span>
                        <span id="badge-{{ $tab['id'] }}"
                              class="inline-flex items-center justify-center min-w-[20px] h-5 px-1 rounded-full text-[10px] font-black
                                     {{ $idx === 0 ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-200 text-slate-600' }}">
                            {{ $tab['count'] > 99 ? '99+' : $tab['count'] }}
                        </span>
                    </button>
                    @endforeach
                </div>
            </div>

            {{-- ── TAB 1: RINCIAN PENJUALAN ──────────────────────────────── --}}
            <div id="tab-penjualan" class="tab-content block">
                @php
                    $sumOmzet = 0; $sumHpp = 0; $sumLaba = 0;
                    foreach ($penjualanList as $t) {
                        $h = $t->details->sum(fn($d) => $d->jumlah * ($d->harga_beli_saat_ini ?? 0));
                        $sumOmzet += $t->total_bayar; $sumHpp += $h; $sumLaba += ($t->total_bayar - $h);
                    }
                    $sumMargin = $sumOmzet > 0 ? ($sumLaba / $sumOmzet) * 100 : 0;
                @endphp

                {{-- Ringkasan Bar --}}
                <div class="flex flex-wrap items-center gap-4 px-5 py-3.5 bg-gradient-to-r from-slate-50 to-white border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-6 rounded-full bg-indigo-500"></div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-medium">Omzet Halaman Ini</p>
                            <p class="text-sm font-extrabold text-slate-800">Rp {{ number_format($sumOmzet, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-6 rounded-full bg-emerald-500"></div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-medium">Laba</p>
                            <p class="text-sm font-extrabold text-emerald-600">+Rp {{ number_format($sumLaba, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-6 rounded-full bg-violet-500"></div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-medium">Margin Rata-rata</p>
                            @php $mc = $sumMargin >= 20 ? 'text-emerald-600 bg-emerald-50' : ($sumMargin >= 10 ? 'text-amber-600 bg-amber-50' : 'text-rose-600 bg-rose-50'); @endphp
                            <span class="text-sm font-extrabold px-2 py-0.5 rounded-lg {{ $mc }}">{{ number_format($sumMargin, 1) }}%</span>
                        </div>
                    </div>
                </div>

                {{-- Tabel Penjualan --}}
                <div class="overflow-x-auto thin-scroll">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                                <th class="py-3 px-5">Invoice &amp; Waktu</th>
                                <th class="py-3 px-5">Kasir</th>
                                <th class="py-3 px-5">Item</th>
                                <th class="py-3 px-5 text-right">Omzet</th>
                                <th class="py-3 px-5 text-right">Modal HPP</th>
                                <th class="py-3 px-5 text-right">Laba</th>
                                <th class="py-3 px-5 text-center min-w-[120px]">Margin</th>
                                <th class="py-3 px-5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                        @forelse ($penjualanList as $trx)
                            @php
                                $omzet  = (float) $trx->total_bayar;
                                $hpp    = $trx->details->sum(fn($d) => $d->jumlah * ($d->harga_beli_saat_ini ?? 0));
                                $laba   = $omzet - $hpp;
                                $margin = $omzet > 0 ? ($laba / $omzet) * 100 : 0;
                                if ($margin >= 20)      { $barC='bg-emerald-500'; $bdgC='bg-emerald-100 text-emerald-700'; $stC='bg-emerald-50 text-emerald-700 border border-emerald-200'; $stT='Untung'; }
                                elseif ($margin >= 10)  { $barC='bg-amber-400';   $bdgC='bg-amber-100 text-amber-700';   $stC='bg-amber-50 text-amber-700 border border-amber-200';   $stT='Tipis'; }
                                else                    { $barC='bg-rose-400';    $bdgC='bg-rose-100 text-rose-700';     $stC='bg-rose-50 text-rose-700 border border-rose-200';       $stT='Rendah'; }
                            @endphp
                            <tr class="hover:bg-slate-50/60 transition-colors group">
                                <td class="py-3.5 px-5">
                                    <div class="flex items-center gap-1.5">
                                        <span class="font-mono font-bold text-slate-800 text-xs">{{ $trx->no_invoice }}</span>
                                        <a href="{{ route('kasir.print', $trx->id_penjualan) }}" target="_blank"
                                           class="p-1 rounded-lg text-slate-300 hover:text-indigo-500 hover:bg-indigo-50 transition opacity-0 group-hover:opacity-100" title="Cetak Struk">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                            </svg>
                                        </a>
                                    </div>
                                    <span class="text-[11px] text-slate-400">{{ $trx->tanggal_penjualan ? $trx->tanggal_penjualan->translatedFormat('d M Y, H:i') : '-' }}</span>
                                </td>
                                <td class="py-3.5 px-5">
                                    <span class="text-xs font-semibold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-lg">{{ $trx->account->nama_akun ?? 'Admin' }}</span>
                                </td>
                                <td class="py-3.5 px-5">
                                    <button type="button" onclick="toggleItems(this)"
                                            class="flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-indigo-600 transition cursor-pointer">
                                        <span class="w-5 h-5 rounded-full bg-indigo-50 text-indigo-600 text-[10px] font-black flex items-center justify-center">{{ $trx->details->count() }}</span>
                                        item
                                        <svg class="w-3 h-3 text-slate-400 toggle-icon transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <div class="item-list mt-2 space-y-1">
                                        @foreach ($trx->details as $det)
                                        <div class="flex items-center gap-1.5 text-[11px] text-slate-600 bg-slate-50 border border-slate-100 rounded-lg px-2.5 py-1.5">
                                            <span class="w-1 h-1 rounded-full bg-indigo-400 shrink-0"></span>
                                            <span class="truncate max-w-[180px]">{{ $det->product->nama_produk ?? 'Item' }}</span>
                                            <span class="font-black text-slate-800 shrink-0 ml-auto">×{{ $det->jumlah }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-3.5 px-5 text-right font-bold text-slate-900 text-sm">Rp {{ number_format($omzet, 0, ',', '.') }}</td>
                                <td class="py-3.5 px-5 text-right text-slate-500 text-sm">Rp {{ number_format($hpp, 0, ',', '.') }}</td>
                                <td class="py-3.5 px-5 text-right font-bold text-emerald-600 text-sm">+Rp {{ number_format($laba, 0, ',', '.') }}</td>
                                <td class="py-3.5 px-5">
                                    <div class="flex flex-col items-center gap-1.5">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-black {{ $bdgC }}">{{ number_format($margin, 1) }}%</span>
                                        <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                            <div class="margin-bar h-full {{ $barC }} rounded-full" style="width: {{ min(100, max(0, $margin)) }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-5 text-center">
                                    <span class="inline-block px-2.5 py-1 rounded-xl text-[10px] font-black {{ $stC }} whitespace-nowrap">{{ $stT }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-16 text-center">
                                    <div class="flex flex-col items-center gap-2 text-slate-300">
                                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        <p class="text-sm font-semibold text-slate-400">Tidak ada transaksi pada periode ini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($penjualanList->hasPages())
                <div class="p-4 border-t border-slate-100">{{ $penjualanList->links() }}</div>
                @endif
            </div>

            {{-- ── TAB 2: PERFORMA PRODUK ────────────────────────────────── --}}
            <div id="tab-produk" class="tab-content hidden">
                <div class="flex flex-wrap items-center gap-4 px-5 py-3.5 bg-gradient-to-r from-slate-50 to-white border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-6 rounded-full bg-violet-500"></div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-medium">Produk Terlacak</p>
                            <p class="text-sm font-extrabold text-slate-800">{{ count($produkPerforma) }} produk</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-6 rounded-full bg-emerald-500"></div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-medium">Total Laba Produk</p>
                            <p class="text-sm font-extrabold text-emerald-600">+Rp {{ number_format(collect($produkPerforma)->sum('total_laba'), 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto thin-scroll">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                                <th class="py-3 px-5 w-12">#</th>
                                <th class="py-3 px-5">Produk &amp; Kategori</th>
                                <th class="py-3 px-5 text-center">Terjual</th>
                                <th class="py-3 px-5 text-right">Omzet</th>
                                <th class="py-3 px-5 text-right">Modal HPP</th>
                                <th class="py-3 px-5 text-right">Laba</th>
                                <th class="py-3 px-5 text-center min-w-[120px]">Margin</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                        @forelse ($produkPerforma as $idx => $prod)
                            @php
                                $mp = $prod->total_omzet > 0 ? ($prod->total_laba / $prod->total_omzet) * 100 : 0;
                                if ($mp >= 20)     { $pc='bg-emerald-500'; $pb='bg-emerald-100 text-emerald-700'; }
                                elseif ($mp >= 10) { $pc='bg-amber-400';   $pb='bg-amber-100 text-amber-700'; }
                                else               { $pc='bg-rose-400';    $pb='bg-rose-100 text-rose-700'; }
                                $rankColors = ['from-amber-400 to-yellow-300','from-slate-400 to-slate-300','from-orange-500 to-amber-400'];
                            @endphp
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3.5 px-5">
                                    @if($idx < 3)
                                        <div class="w-7 h-7 rounded-full bg-gradient-to-br {{ $rankColors[$idx] }} text-white text-[10px] font-black flex items-center justify-center shadow-sm">{{ $idx+1 }}</div>
                                    @else
                                        <span class="text-xs text-slate-400 font-bold pl-1.5">{{ $idx+1 }}</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-5">
                                    <p class="font-bold text-slate-900 text-sm">{{ $prod->nama_produk }}</p>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <span class="font-mono text-[10px] text-slate-400">{{ $prod->kode_produk }}</span>
                                        @if($prod->nama_kategori)
                                        <span class="text-[10px] font-bold bg-indigo-50 text-indigo-600 px-1.5 py-0.5 rounded-md">{{ $prod->nama_kategori }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3.5 px-5 text-center">
                                    <span class="font-black text-slate-800">{{ number_format($prod->total_qty) }}</span>
                                    <span class="text-slate-400 text-xs ml-0.5">unit</span>
                                </td>
                                <td class="py-3.5 px-5 text-right font-semibold text-slate-900">Rp {{ number_format($prod->total_omzet, 0, ',', '.') }}</td>
                                <td class="py-3.5 px-5 text-right text-slate-400">Rp {{ number_format($prod->total_modal, 0, ',', '.') }}</td>
                                <td class="py-3.5 px-5 text-right font-bold text-emerald-600">+Rp {{ number_format($prod->total_laba, 0, ',', '.') }}</td>
                                <td class="py-3.5 px-5">
                                    <div class="flex flex-col items-center gap-1.5">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-black {{ $pb }}">{{ number_format($mp, 1) }}%</span>
                                        <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                            <div class="margin-bar h-full {{ $pc }} rounded-full" style="width: {{ min(100, max(0, $mp)) }}%"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-16 text-center">
                                    <div class="flex flex-col items-center gap-2 text-slate-300">
                                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        <p class="text-sm font-semibold text-slate-400">Belum ada penjualan produk pada periode ini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ── TAB 3: BELI STOK ─────────────────────────────────────── --}}
            <div id="tab-pembelian" class="tab-content hidden">
                <div class="flex flex-wrap items-center gap-4 px-5 py-3.5 bg-gradient-to-r from-slate-50 to-white border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-6 rounded-full bg-amber-500"></div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-medium">Transaksi Pembelian</p>
                            <p class="text-sm font-extrabold text-slate-800">{{ count($pembelianList) }} kali</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-6 rounded-full bg-rose-500"></div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-medium">Total Pengeluaran</p>
                            <p class="text-sm font-extrabold text-rose-600">Rp {{ number_format(collect($pembelianList)->sum('total_harga_beli'), 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto thin-scroll">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                                <th class="py-3 px-5">ID &amp; Tanggal</th>
                                <th class="py-3 px-5">Produk</th>
                                <th class="py-3 px-5 text-center">Unit Masuk</th>
                                <th class="py-3 px-5 text-right">Harga Satuan</th>
                                <th class="py-3 px-5 text-right">Total Biaya</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                        @forelse ($pembelianList as $beli)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3.5 px-5">
                                    <span class="font-mono font-bold text-slate-800 text-xs">#{{ $beli->id_pembelian }}</span>
                                    <p class="text-[11px] text-slate-400 mt-0.5">{{ $beli->tanggal_masuk ? \Carbon\Carbon::parse($beli->tanggal_masuk)->translatedFormat('d M Y') : '-' }}</p>
                                </td>
                                <td class="py-3.5 px-5">
                                    <p class="font-semibold text-slate-900">{{ $beli->product->nama_produk ?? 'Produk Dihapus' }}</p>
                                    @if($beli->product)
                                    <p class="text-[10px] text-slate-400 font-mono mt-0.5">{{ $beli->product->kode_produk }}</p>
                                    @endif
                                </td>
                                <td class="py-3.5 px-5 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-black bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        +{{ number_format($beli->jumlah_barang_masuk) }} {{ $beli->product->satuan_terkecil ?? 'unit' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-5 text-right text-slate-500">Rp {{ number_format($beli->harga_beli_satuan, 0, ',', '.') }}</td>
                                <td class="py-3.5 px-5 text-right font-bold text-slate-900">Rp {{ number_format($beli->total_harga_beli, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-16 text-center">
                                    <div class="flex flex-col items-center gap-2 text-slate-300">
                                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        <p class="text-sm font-semibold text-slate-400">Tidak ada pembelian stok pada periode ini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ── TAB 4: OPNAME STOK ───────────────────────────────────── --}}
            <div id="tab-penyesuaian" class="tab-content hidden">
                @php
                    $totalDampak = collect($penyesuaianList)->sum(fn($a) => $a->jumlah_selisih * ($a->product->harga_beli_terakhir ?? 0));
                @endphp
                <div class="flex flex-wrap items-center gap-4 px-5 py-3.5 bg-gradient-to-r from-slate-50 to-white border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-6 rounded-full bg-slate-400"></div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-medium">Catatan Opname</p>
                            <p class="text-sm font-extrabold text-slate-800">{{ count($penyesuaianList) }} penyesuaian</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-6 rounded-full {{ $totalDampak >= 0 ? 'bg-emerald-500' : 'bg-rose-500' }}"></div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-medium">Dampak Estimasi Nilai</p>
                            <p class="text-sm font-extrabold {{ $totalDampak >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $totalDampak >= 0 ? '+' : '' }}Rp {{ number_format($totalDampak, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto thin-scroll">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                                <th class="py-3 px-5">Tanggal</th>
                                <th class="py-3 px-5">Produk</th>
                                <th class="py-3 px-5 text-center">Selisih Stok</th>
                                <th class="py-3 px-5 text-right">Nilai Estimasi</th>
                                <th class="py-3 px-5">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                        @forelse ($penyesuaianList as $adj)
                            @php $nilaiRp = $adj->jumlah_selisih * ($adj->product->harga_beli_terakhir ?? 0); @endphp
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3.5 px-5 text-xs font-semibold text-slate-600">{{ $adj->tanggal_cek ? \Carbon\Carbon::parse($adj->tanggal_cek)->translatedFormat('d M Y') : '-' }}</td>
                                <td class="py-3.5 px-5 font-semibold text-slate-900">{{ $adj->product->nama_produk ?? 'Produk Dihapus' }}</td>
                                <td class="py-3.5 px-5 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-black border
                                                 {{ $adj->jumlah_selisih >= 0 ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                                        {{ $adj->jumlah_selisih > 0 ? '+' : '' }}{{ $adj->jumlah_selisih }} unit
                                    </span>
                                </td>
                                <td class="py-3.5 px-5 text-right font-bold {{ $nilaiRp >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ $nilaiRp >= 0 ? '+' : '' }}Rp {{ number_format($nilaiRp, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-5 text-xs text-slate-400 italic">{{ $adj->keterangan ?: '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-16 text-center">
                                    <div class="flex flex-col items-center gap-2 text-slate-300">
                                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                        <p class="text-sm font-semibold text-slate-400">Tidak ada catatan opname pada periode ini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

    @push('scripts')
    <script>
        // ── Tabs ──────────────────────────────────────────────────────
        const tabIds = ['penjualan','produk','pembelian','penyesuaian'];

        function switchReportTab(tabId) {
            tabIds.forEach(id => {
                document.getElementById('tab-' + id).classList.add('hidden');
                const btn   = document.getElementById('btn-tab-' + id);
                const badge = document.getElementById('badge-' + id);
                btn.classList.remove('tab-btn-active');
                btn.classList.add('tab-btn-inactive');
                if (badge) {
                    badge.classList.remove('bg-indigo-100','text-indigo-700');
                    badge.classList.add('bg-slate-200','text-slate-600');
                }
            });
            const active = tabId.replace('tab-','');
            document.getElementById(tabId).classList.remove('hidden');
            const btn   = document.getElementById('btn-tab-' + active);
            const badge = document.getElementById('badge-' + active);
            btn.classList.add('tab-btn-active');
            btn.classList.remove('tab-btn-inactive');
            if (badge) {
                badge.classList.add('bg-indigo-100','text-indigo-700');
                badge.classList.remove('bg-slate-200','text-slate-600');
            }
        }

        // ── Toggle Items ──────────────────────────────────────────────
        function toggleItems(btn) {
            const list = btn.closest('tr').querySelector('.item-list');
            const icon = btn.querySelector('.toggle-icon');
            list.classList.toggle('open');
            icon.style.transform = list.classList.contains('open') ? 'rotate(180deg)' : '';
        }
    </script>
    @endpush
</x-layout>
