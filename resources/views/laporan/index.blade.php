<x-layout>
    <x-slot:title>Laporan &amp; Analisis Laba Rugi</x-slot:title>

    <style>
        .margin-bar { transition: width 0.6s cubic-bezier(0.4,0,0.2,1); }
        .item-list { max-height: 0; overflow: hidden; transition: max-height 0.35s ease; }
        .item-list.open { max-height: 600px; }
        @keyframes fadeIn { from{opacity:0;transform:translateY(6px)} to{opacity:1;transform:translateY(0)} }
        .tab-content { animation: fadeIn 0.25s ease; }
    </style>

    <div class="space-y-5 pb-12">

        {{-- HEADER --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center shadow-lg shadow-indigo-200">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-slate-900">Laporan &amp; Analisis Keuangan</h1>
                    <p class="text-xs text-slate-400 mt-0.5">Omzet, Modal HPP, Laba, dan Performa Toko</p>
                </div>
            </div>
            <a href="{{ route('laporan.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
               target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-semibold shadow-xs hover:shadow-md transition cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak Laporan
            </a>
        </div>

        {{-- FILTER --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-3">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Periode:</span>
                    <a href="{{ route('laporan.index', ['periode' => 'hari_ini']) }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold transition {{ $periode === 'hari_ini' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">Hari Ini</a>
                    <a href="{{ route('laporan.index', ['periode' => '7_hari']) }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold transition {{ $periode === '7_hari' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">7 Hari</a>
                    <a href="{{ route('laporan.index', ['periode' => 'bulan_ini']) }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold transition {{ $periode === 'bulan_ini' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">Bulan Ini</a>
                    <a href="{{ route('laporan.index', ['periode' => 'bulan_lalu']) }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold transition {{ $periode === 'bulan_lalu' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">Bulan Lalu</a>
                    <a href="{{ route('laporan.index', ['periode' => 'tahun_ini']) }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold transition {{ $periode === 'tahun_ini' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">Tahun Ini</a>
                </div>
                <form action="{{ route('laporan.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                    <input type="hidden" name="periode" value="custom">
                    <span class="text-xs text-slate-500">Dari:</span>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:ring-2 focus:ring-indigo-500/20 focus:outline-none">
                    <span class="text-xs text-slate-500">s/d</span>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:ring-2 focus:ring-indigo-500/20 focus:outline-none">
                    <button type="submit" class="px-3.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl transition cursor-pointer">Terapkan</button>
                </form>
            </div>
            <p class="text-xs text-slate-400 pt-1 border-t border-slate-100">
                Periode aktif: <strong class="text-slate-700">{{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }}</strong>
                — <strong class="text-slate-700">{{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}</strong>
            </p>
        </div>

        {{-- 5 SUMMARY CARDS --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-3">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-4 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Omzet</span>
                    <div class="w-7 h-7 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <p class="text-base font-black text-slate-900 leading-tight">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-400 mt-1">{{ number_format($totalTransaksi) }} transaksi</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-4 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Modal HPP</span>
                    <div class="w-7 h-7 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                </div>
                <p class="text-base font-black text-slate-900 leading-tight">Rp {{ number_format($totalHpp, 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-400 mt-1">Biaya modal barang</p>
            </div>
            <div class="bg-gradient-to-br from-indigo-50 to-violet-50 rounded-2xl border border-indigo-100 shadow-xs p-4 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-wider">Laba Kotor</span>
                    <span class="px-1.5 py-0.5 rounded-full text-[9px] font-black bg-indigo-100 text-indigo-700">{{ number_format($marginLabaKotor, 1) }}%</span>
                </div>
                <p class="text-base font-black text-indigo-900 leading-tight">Rp {{ number_format($labaKotor, 0, ',', '.') }}</p>
                <p class="text-[10px] text-indigo-400 mt-1">Omzet dikurangi HPP</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-4 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Beli Stok</span>
                    <div class="w-7 h-7 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                </div>
                <p class="text-base font-black text-slate-900 leading-tight">Rp {{ number_format($totalPembelian, 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-400 mt-1">Kulakan supplier</p>
            </div>
            <div class="bg-white rounded-2xl border {{ $labaBersihEstimasi >= 0 ? 'border-emerald-100' : 'border-rose-100' }} shadow-xs p-4 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] font-bold {{ $labaBersihEstimasi >= 0 ? 'text-emerald-600' : 'text-rose-500' }} uppercase tracking-wider">Laba Bersih</span>
                    <span class="px-1.5 py-0.5 rounded-full text-[9px] font-black {{ $labaBersihEstimasi >= 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">{{ $labaBersihEstimasi >= 0 ? 'Untung' : 'Rugi' }}</span>
                </div>
                <p class="text-base font-black {{ $labaBersihEstimasi >= 0 ? 'text-emerald-700' : 'text-rose-600' }} leading-tight">Rp {{ number_format(abs($labaBersihEstimasi), 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-400 mt-1">Setelah selisih opname</p>
            </div>
        </div>

        {{-- TABEL TABS --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">

            <div class="flex border-b border-slate-200/80 bg-slate-50/60 overflow-x-auto">
                <button type="button" onclick="switchReportTab('tab-penjualan')" id="btn-tab-penjualan"
                        class="tab-btn flex items-center gap-2 px-5 py-3.5 text-sm font-semibold whitespace-nowrap cursor-pointer text-indigo-600 border-b-2 border-indigo-600 transition">
                    <span id="badge-penjualan" class="w-5 h-5 rounded-full bg-indigo-100 text-indigo-700 text-[10px] font-black flex items-center justify-center">{{ $penjualanList->total() > 99 ? '99+' : $penjualanList->total() }}</span>
                    Rincian Penjualan
                </button>
                <button type="button" onclick="switchReportTab('tab-produk')" id="btn-tab-produk"
                        class="tab-btn flex items-center gap-2 px-5 py-3.5 text-sm font-semibold whitespace-nowrap cursor-pointer text-slate-500 hover:text-slate-800 border-b-2 border-transparent transition">
                    <span id="badge-produk" class="w-5 h-5 rounded-full bg-slate-200 text-slate-600 text-[10px] font-black flex items-center justify-center">{{ count($produkPerforma) }}</span>
                    Performa Produk
                </button>
                <button type="button" onclick="switchReportTab('tab-pembelian')" id="btn-tab-pembelian"
                        class="tab-btn flex items-center gap-2 px-5 py-3.5 text-sm font-semibold whitespace-nowrap cursor-pointer text-slate-500 hover:text-slate-800 border-b-2 border-transparent transition">
                    <span id="badge-pembelian" class="w-5 h-5 rounded-full bg-slate-200 text-slate-600 text-[10px] font-black flex items-center justify-center">{{ count($pembelianList) }}</span>
                    Beli Stok
                </button>
                <button type="button" onclick="switchReportTab('tab-penyesuaian')" id="btn-tab-penyesuaian"
                        class="tab-btn flex items-center gap-2 px-5 py-3.5 text-sm font-semibold whitespace-nowrap cursor-pointer text-slate-500 hover:text-slate-800 border-b-2 border-transparent transition">
                    <span id="badge-penyesuaian" class="w-5 h-5 rounded-full bg-slate-200 text-slate-600 text-[10px] font-black flex items-center justify-center">{{ count($penyesuaianList) }}</span>
                    Opname
                </button>
            </div>

            {{-- TAB 1: PENJUALAN --}}
            <div id="tab-penjualan" class="tab-content block">
                @php
                    $sumOmzet = 0; $sumHpp = 0; $sumLaba = 0;
                    foreach ($penjualanList as $t) {
                        $h = $t->details->sum(fn($d) => $d->jumlah * ($d->harga_beli_saat_ini ?? 0));
                        $sumOmzet += $t->total_bayar; $sumHpp += $h; $sumLaba += ($t->total_bayar - $h);
                    }
                    $sumMargin = $sumOmzet > 0 ? ($sumLaba / $sumOmzet) * 100 : 0;
                    $mc = $sumMargin >= 20 ? 'bg-emerald-100 text-emerald-700' : ($sumMargin >= 10 ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700');
                @endphp
                <div class="flex flex-wrap items-center gap-x-6 gap-y-1.5 px-6 py-3 bg-slate-50/80 border-b border-slate-100 text-xs">
                    <span class="text-slate-500">Halaman ini — Omzet: <strong class="text-slate-800">Rp {{ number_format($sumOmzet, 0, ',', '.') }}</strong></span>
                    <span class="text-slate-500">Laba: <strong class="text-emerald-600">+Rp {{ number_format($sumLaba, 0, ',', '.') }}</strong></span>
                    <span class="text-slate-500">Margin rata-rata: <span class="px-2 py-0.5 rounded-full font-black {{ $mc }}">{{ number_format($sumMargin, 1) }}%</span></span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-extrabold text-slate-700 uppercase tracking-wider">
                                <th class="py-3 px-5">Invoice &amp; Waktu</th>
                                <th class="py-3 px-5">Kasir</th>
                                <th class="py-3 px-5">Item Dibeli</th>
                                <th class="py-3 px-5 text-right">Omzet</th>
                                <th class="py-3 px-5 text-right">Modal HPP</th>
                                <th class="py-3 px-5 text-right">Laba</th>
                                <th class="py-3 px-5 text-center min-w-[130px]">Margin</th>
                                <th class="py-3 px-5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse ($penjualanList as $trx)
                                @php
                                    $omzet  = (float) $trx->total_bayar;
                                    $hpp    = $trx->details->sum(fn($d) => $d->jumlah * ($d->harga_beli_saat_ini ?? 0));
                                    $laba   = $omzet - $hpp;
                                    $margin = $omzet > 0 ? ($laba / $omzet) * 100 : 0;
                                    if ($margin >= 20) {
                                        $badgeClass  = 'bg-emerald-100 text-emerald-700 border-emerald-200';
                                        $barColor    = 'bg-emerald-500';
                                        $statusClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                        $statusText  = 'Untung';
                                    } elseif ($margin >= 10) {
                                        $badgeClass  = 'bg-amber-100 text-amber-700 border-amber-200';
                                        $barColor    = 'bg-amber-400';
                                        $statusClass = 'bg-amber-50 text-amber-700 border-amber-200';
                                        $statusText  = 'Tipis';
                                    } else {
                                        $badgeClass  = 'bg-rose-100 text-rose-700 border-rose-200';
                                        $barColor    = 'bg-rose-400';
                                        $statusClass = 'bg-rose-50 text-rose-700 border-rose-200';
                                        $statusText  = 'Rendah';
                                    }
                                @endphp
                                <tr class="hover:bg-slate-50/70 transition-colors group">
                                    <td class="py-3.5 px-5">
                                        <div class="flex items-center gap-1.5">
                                            <span class="font-mono font-bold text-slate-900 text-xs">{{ $trx->no_invoice }}</span>
                                            <a href="{{ route('kasir.print', $trx->id_penjualan) }}" target="_blank"
                                               class="p-1 rounded-lg text-slate-300 hover:text-indigo-500 hover:bg-indigo-50 transition opacity-0 group-hover:opacity-100" title="Cetak Struk">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                            </a>
                                        </div>
                                        <span class="text-[11px] text-slate-400">{{ $trx->tanggal_penjualan ? $trx->tanggal_penjualan->translatedFormat('d M Y, H:i') : '-' }}</span>
                                    </td>
                                    <td class="py-3.5 px-5">
                                        <span class="text-xs font-semibold text-slate-700 bg-slate-100 px-2 py-0.5 rounded-lg">{{ $trx->account->nama_akun ?? 'Admin' }}</span>
                                    </td>
                                    <td class="py-3.5 px-5">
                                        <button type="button" onclick="toggleItems(this)"
                                                class="flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-indigo-600 transition cursor-pointer">
                                            <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-black flex items-center justify-center">{{ $trx->details->count() }}</span>
                                            item
                                            <svg class="w-3 h-3 text-slate-400 toggle-icon transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                        </button>
                                        <div class="item-list mt-1.5 space-y-0.5">
                                            @foreach ($trx->details as $det)
                                                <div class="flex items-center gap-1.5 text-[11px] text-slate-600 bg-slate-50 rounded-lg px-2 py-1">
                                                    <span class="w-1 h-1 rounded-full bg-indigo-400 shrink-0"></span>
                                                    <span class="truncate max-w-[200px]">{{ $det->product->nama_produk ?? 'Item' }}</span>
                                                    <span class="font-black text-slate-800 shrink-0 ml-auto">x{{ $det->jumlah }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-5 text-right font-bold text-slate-900">Rp {{ number_format($omzet, 0, ',', '.') }}</td>
                                    <td class="py-3.5 px-5 text-right text-slate-500">Rp {{ number_format($hpp, 0, ',', '.') }}</td>
                                    <td class="py-3.5 px-5 text-right font-bold text-emerald-600">+Rp {{ number_format($laba, 0, ',', '.') }}</td>
                                    <td class="py-3.5 px-5">
                                        <div class="flex flex-col items-center gap-1 min-w-[110px]">
                                            <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-black border {{ $badgeClass }}">{{ number_format($margin, 1) }}%</span>
                                            <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                                <div class="margin-bar h-full {{ $barColor }} rounded-full" style="width: {{ min(100, max(0, $margin)) }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-5 text-center">
                                        <span class="inline-block px-2.5 py-1 rounded-xl text-[10px] font-black border {{ $statusClass }} whitespace-nowrap">{{ $statusText }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="py-16 text-center text-slate-400">Tidak ada transaksi dalam periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($penjualanList->hasPages())
                    <div class="p-4 border-t border-slate-100">{{ $penjualanList->links() }}</div>
                @endif
            </div>

            {{-- TAB 2: PERFORMA PRODUK --}}
            <div id="tab-produk" class="tab-content hidden">
                <div class="flex flex-wrap items-center gap-x-6 gap-y-1.5 px-6 py-3 bg-slate-50/80 border-b border-slate-100 text-xs">
                    <span class="text-slate-500">Produk terlacak: <strong class="text-slate-800">{{ count($produkPerforma) }}</strong></span>
                    <span class="text-slate-500">Total laba: <strong class="text-emerald-600">+Rp {{ number_format(collect($produkPerforma)->sum('total_laba'), 0, ',', '.') }}</strong></span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-extrabold text-slate-700 uppercase tracking-wider">
                                <th class="py-3 px-5">#</th>
                                <th class="py-3 px-5">Produk &amp; Kategori</th>
                                <th class="py-3 px-5 text-center">Terjual</th>
                                <th class="py-3 px-5 text-right">Omzet</th>
                                <th class="py-3 px-5 text-right">Modal HPP</th>
                                <th class="py-3 px-5 text-right">Laba</th>
                                <th class="py-3 px-5 text-center min-w-[130px]">Margin</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse ($produkPerforma as $idx => $prod)
                                @php
                                    $mp = $prod->total_omzet > 0 ? ($prod->total_laba / $prod->total_omzet) * 100 : 0;
                                    if ($mp >= 20) { $pc='bg-emerald-500'; $pb='bg-emerald-100 text-emerald-700 border-emerald-200'; }
                                    elseif ($mp >= 10) { $pc='bg-amber-400'; $pb='bg-amber-100 text-amber-700 border-amber-200'; }
                                    else { $pc='bg-rose-400'; $pb='bg-rose-100 text-rose-700 border-rose-200'; }
                                    $rankC = ['bg-amber-400 text-white','bg-slate-400 text-white','bg-orange-500 text-white'];
                                @endphp
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    <td class="py-3.5 px-5">
                                        @if ($idx < 3)
                                            <span class="w-6 h-6 rounded-full {{ $rankC[$idx] }} text-[10px] font-black flex items-center justify-center">{{ $idx+1 }}</span>
                                        @else
                                            <span class="text-xs text-slate-400 font-bold pl-1">{{ $idx+1 }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-5">
                                        <div class="font-bold text-slate-900">{{ $prod->nama_produk }}</div>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <span class="font-mono text-[10px] text-slate-400">{{ $prod->kode_produk }}</span>
                                            @if ($prod->nama_kategori)
                                                <span class="text-[10px] font-bold bg-indigo-50 text-indigo-600 px-1.5 py-0.5 rounded-md">{{ $prod->nama_kategori }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-5 text-center"><span class="font-black text-slate-800">{{ number_format($prod->total_qty) }}</span> <span class="text-slate-400 text-xs">unit</span></td>
                                    <td class="py-3.5 px-5 text-right font-semibold text-slate-900">Rp {{ number_format($prod->total_omzet, 0, ',', '.') }}</td>
                                    <td class="py-3.5 px-5 text-right text-slate-500">Rp {{ number_format($prod->total_modal, 0, ',', '.') }}</td>
                                    <td class="py-3.5 px-5 text-right font-bold text-emerald-600">+Rp {{ number_format($prod->total_laba, 0, ',', '.') }}</td>
                                    <td class="py-3.5 px-5">
                                        <div class="flex flex-col items-center gap-1 min-w-[110px]">
                                            <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-black border {{ $pb }}">{{ number_format($mp, 1) }}%</span>
                                            <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                                <div class="margin-bar h-full {{ $pc }} rounded-full" style="width: {{ min(100, max(0, $mp)) }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="py-16 text-center text-slate-400">Belum ada penjualan produk pada periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- TAB 3: BELI STOK --}}
            <div id="tab-pembelian" class="tab-content hidden">
                <div class="flex flex-wrap items-center gap-x-6 gap-y-1.5 px-6 py-3 bg-slate-50/80 border-b border-slate-100 text-xs">
                    <span class="text-slate-500">Transaksi: <strong class="text-slate-800">{{ count($pembelianList) }} kali</strong></span>
                    <span class="text-slate-500">Total pengeluaran: <strong class="text-rose-600">Rp {{ number_format(collect($pembelianList)->sum('total_harga_beli'), 0, ',', '.') }}</strong></span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-extrabold text-slate-700 uppercase tracking-wider">
                                <th class="py-3 px-5">ID &amp; Tanggal</th>
                                <th class="py-3 px-5">Produk</th>
                                <th class="py-3 px-5 text-center">Unit Masuk</th>
                                <th class="py-3 px-5 text-right">Harga Satuan</th>
                                <th class="py-3 px-5 text-right">Total Biaya</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse ($pembelianList as $beli)
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    <td class="py-3.5 px-5">
                                        <span class="font-mono font-bold text-slate-800 text-xs">#{{ $beli->id_pembelian }}</span>
                                        <span class="text-[11px] text-slate-400 block">{{ $beli->tanggal_masuk ? \Carbon\Carbon::parse($beli->tanggal_masuk)->translatedFormat('d M Y') : '-' }}</span>
                                    </td>
                                    <td class="py-3.5 px-5 font-semibold text-slate-900">{{ $beli->product->nama_produk ?? 'Produk Dihapus' }}</td>
                                    <td class="py-3.5 px-5 text-center">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-black bg-emerald-50 text-emerald-700 border border-emerald-100">+{{ number_format($beli->jumlah_barang_masuk) }} {{ $beli->product->satuan_terkecil ?? 'unit' }}</span>
                                    </td>
                                    <td class="py-3.5 px-5 text-right text-slate-500">Rp {{ number_format($beli->harga_beli_satuan, 0, ',', '.') }}</td>
                                    <td class="py-3.5 px-5 text-right font-bold text-slate-900">Rp {{ number_format($beli->total_harga_beli, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="py-16 text-center text-slate-400">Tidak ada pembelian stok dalam periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- TAB 4: OPNAME --}}
            <div id="tab-penyesuaian" class="tab-content hidden">
                @php
                    $totalDampak = collect($penyesuaianList)->sum(fn($a) => $a->jumlah_selisih * ($a->product->harga_beli_terakhir ?? 0));
                @endphp
                <div class="flex flex-wrap items-center gap-x-6 gap-y-1.5 px-6 py-3 bg-slate-50/80 border-b border-slate-100 text-xs">
                    <span class="text-slate-500">Catatan: <strong class="text-slate-800">{{ count($penyesuaianList) }} penyesuaian</strong></span>
                    <span class="text-slate-500">Dampak estimasi: <strong class="{{ $totalDampak >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">{{ $totalDampak >= 0 ? '+' : '' }}Rp {{ number_format($totalDampak, 0, ',', '.') }}</strong></span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-extrabold text-slate-700 uppercase tracking-wider">
                                <th class="py-3 px-5">Tanggal</th>
                                <th class="py-3 px-5">Produk</th>
                                <th class="py-3 px-5 text-center">Selisih</th>
                                <th class="py-3 px-5 text-right">Nilai Estimasi</th>
                                <th class="py-3 px-5">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse ($penyesuaianList as $adj)
                                @php $nilaiRp = $adj->jumlah_selisih * ($adj->product->harga_beli_terakhir ?? 0); @endphp
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    <td class="py-3.5 px-5 font-medium text-slate-700">{{ $adj->tanggal_cek ? \Carbon\Carbon::parse($adj->tanggal_cek)->translatedFormat('d M Y') : '-' }}</td>
                                    <td class="py-3.5 px-5 font-semibold text-slate-900">{{ $adj->product->nama_produk ?? 'Produk Dihapus' }}</td>
                                    <td class="py-3.5 px-5 text-center">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-black border {{ $adj->jumlah_selisih >= 0 ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                                            {{ $adj->jumlah_selisih > 0 ? '+' : '' }}{{ $adj->jumlah_selisih }} unit
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-5 text-right font-bold {{ $nilaiRp >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">{{ $nilaiRp >= 0 ? '+' : '' }}Rp {{ number_format($nilaiRp, 0, ',', '.') }}</td>
                                    <td class="py-3.5 px-5 text-xs text-slate-500 italic">{{ $adj->keterangan ?: '—' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="py-16 text-center text-slate-400">Tidak ada catatan penyesuaian stok dalam periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        const tabIds = ['penjualan','produk','pembelian','penyesuaian'];

        function switchReportTab(tabId) {
            tabIds.forEach(id => {
                document.getElementById('tab-' + id).classList.add('hidden');
                const btn = document.getElementById('btn-tab-' + id);
                btn.classList.remove('text-indigo-600','border-indigo-600');
                btn.classList.add('text-slate-500','border-transparent');
                const badge = document.getElementById('badge-' + id);
                if (badge) {
                    badge.className = badge.className.replace('bg-indigo-100','bg-slate-200').replace('text-indigo-700','text-slate-600');
                }
            });
            document.getElementById(tabId).classList.remove('hidden');
            const id = tabId.replace('tab-','');
            const btn = document.getElementById('btn-tab-' + id);
            btn.classList.add('text-indigo-600','border-indigo-600');
            btn.classList.remove('text-slate-500','border-transparent');
            const badge = document.getElementById('badge-' + id);
            if (badge) {
                badge.className = badge.className.replace('bg-slate-200','bg-indigo-100').replace('text-slate-600','text-indigo-700');
            }
        }

        function toggleItems(btn) {
            const row = btn.closest('tr');
            const list = row.querySelector('.item-list');
            const icon = btn.querySelector('.toggle-icon');
            list.classList.toggle('open');
            icon.style.transform = list.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
        }
    </script>
</x-layout>
