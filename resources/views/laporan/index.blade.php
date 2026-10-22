<x-layout>
    <x-slot:title>
        Laporan & Analisis Laba Rugi
    </x-slot:title>

    <div class="space-y-6 pb-12">
        <!-- ======================================================== -->
        <!-- HEADER & ACTIONS                                         -->
        <!-- ======================================================== -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="20" x2="18" y2="10"/>
                            <line x1="12" y1="20" x2="12" y2="4"/>
                            <line x1="6" y1="20" x2="6" y2="14"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Laporan & Analisis Keuangan</h1>
                        <p class="text-xs text-slate-500 mt-0.5">Analisis pendapatan omzet, modal pokok (HPP), laba kotor, dan pengeluaran stok.</p>
                    </div>
                </div>
            </div>

            <!-- Export & Print Action Buttons -->
            <div class="flex flex-wrap items-center gap-2.5">
                <!-- Tombol Print -->
                <a 
                    href="{{ route('laporan.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}" 
                    target="_blank" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs sm:text-sm font-semibold shadow-xs hover:shadow-md transition cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    <span>Cetak Laporan</span>
                </a>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- FILTER PERIODE WAKTU                                     -->
        <!-- ======================================================== -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <!-- Preset Buttons -->
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider mr-1">Preset:</span>
                    <a href="{{ route('laporan.index', ['periode' => 'hari_ini']) }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold transition {{ $periode === 'hari_ini' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                        Hari Ini
                    </a>
                    <a href="{{ route('laporan.index', ['periode' => '7_hari']) }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold transition {{ $periode === '7_hari' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                        7 Hari Terakhir
                    </a>
                    <a href="{{ route('laporan.index', ['periode' => 'bulan_ini']) }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold transition {{ $periode === 'bulan_ini' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                        Bulan Ini
                    </a>
                    <a href="{{ route('laporan.index', ['periode' => 'bulan_lalu']) }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold transition {{ $periode === 'bulan_lalu' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                        Bulan Lalu
                    </a>
                    <a href="{{ route('laporan.index', ['periode' => 'tahun_ini']) }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold transition {{ $periode === 'tahun_ini' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                        Tahun Ini
                    </a>
                </div>

                <!-- Custom Date Range Form -->
                <form action="{{ route('laporan.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5">
                    <input type="hidden" name="periode" value="custom">
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-slate-500 font-medium">Dari:</span>
                        <input 
                            type="date" 
                            name="start_date" 
                            value="{{ $startDate }}" 
                            class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:ring-2 focus:ring-indigo-500/20"
                        >
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-slate-500 font-medium">Sampai:</span>
                        <input 
                            type="date" 
                            name="end_date" 
                            value="{{ $endDate }}" 
                            class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:ring-2 focus:ring-indigo-500/20"
                        >
                    </div>
                    <button type="submit" class="px-3.5 py-1.5 bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold rounded-xl transition cursor-pointer">
                        Terapkan
                    </button>
                </form>
            </div>

            <div class="text-xs text-slate-400 flex items-center gap-1.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Menampilkan data periode: <strong class="text-slate-700">{{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }}</strong> s/d <strong class="text-slate-700">{{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}</strong></span>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- 5 KARTU RINGKASAN FINANSIAL                              -->
        <!-- ======================================================== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- 1. Total Omzet Penjualan -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-5 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Omzet</span>
                    <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-black text-slate-900 mt-2">
                    Rp {{ number_format($totalOmzet, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-slate-400 mt-1">{{ number_format($totalTransaksi) }} transaksi kasir</p>
            </div>

            <!-- 2. Modal Pokok (HPP) -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-5 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Modal Pokok (HPP)</span>
                    <div class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-black text-slate-900 mt-2">
                    Rp {{ number_format($totalHpp, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-slate-400 mt-1">Biaya modal barang terjual</p>
            </div>

            <!-- 3. Laba Kotor & Margin -->
            <div class="bg-white rounded-2xl border border-indigo-100 shadow-xs p-5 hover:shadow-md transition bg-gradient-to-br from-white to-indigo-50/30">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-indigo-600 uppercase tracking-wider">Laba Kotor</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-700">
                        {{ number_format($marginLabaKotor, 1) }}% Margin
                    </span>
                </div>
                <h3 class="text-xl font-black text-indigo-900 mt-2">
                    Rp {{ number_format($labaKotor, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-indigo-500/80 mt-1">Omzet dikurangi HPP</p>
            </div>

            <!-- 4. Pengeluaran Pembelian Stok (Kulakan) -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-5 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Beli Stok Masuk</span>
                    <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-black text-slate-900 mt-2">
                    Rp {{ number_format($totalPembelian, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-slate-400 mt-1">Pengeluaran kulakan supplier</p>
            </div>

            <!-- 5. Estimasi Laba Bersih Operasional -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-5 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Laba Bersih Est.</span>
                    <div class="w-8 h-8 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-black {{ $labaBersihEstimasi >= 0 ? 'text-emerald-700' : 'text-rose-600' }} mt-2">
                    Rp {{ number_format($labaBersihEstimasi, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-slate-400 mt-1">Setelah loss opname Rp {{ number_format($totalKerugianOpname, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- TABEL RINCIAN BERBAGAI LAPORAN (TABS INTERAKTIF)         -->
        <!-- ======================================================== -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <!-- Tab Headers -->
            <div class="flex border-b border-slate-200/80 bg-slate-50/60 overflow-x-auto text-sm font-semibold">
                <button type="button" onclick="switchReportTab('tab-penjualan')" id="btn-tab-penjualan" class="tab-btn px-6 py-3.5 border-b-2 border-indigo-600 text-indigo-600 cursor-pointer transition whitespace-nowrap">
                    1. Rincian Penjualan ({{ $penjualanList->total() }})
                </button>
                <button type="button" onclick="switchReportTab('tab-produk')" id="btn-tab-produk" class="tab-btn px-6 py-3.5 border-b-2 border-transparent text-slate-500 hover:text-slate-800 cursor-pointer transition whitespace-nowrap">
                    2. Performa & Margin Produk ({{ count($produkPerforma) }})
                </button>
                <button type="button" onclick="switchReportTab('tab-pembelian')" id="btn-tab-pembelian" class="tab-btn px-6 py-3.5 border-b-2 border-transparent text-slate-500 hover:text-slate-800 cursor-pointer transition whitespace-nowrap">
                    3. Pengeluaran Pembelian Stok ({{ count($pembelianList) }})
                </button>
                <button type="button" onclick="switchReportTab('tab-penyesuaian')" id="btn-tab-penyesuaian" class="tab-btn px-6 py-3.5 border-b-2 border-transparent text-slate-500 hover:text-slate-800 cursor-pointer transition whitespace-nowrap">
                    4. Selisih Opname & Kerusakan ({{ count($penyesuaianList) }})
                </button>
            </div>

            <!-- ================= TAB 1: PENJUALAN & LABA ================= -->
            <div id="tab-penjualan" class="tab-content block">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-200/80 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                <th class="py-3.5 px-6">No Invoice & Waktu</th>
                                <th class="py-3.5 px-6">Kasir</th>
                                <th class="py-3.5 px-6">Rincian Item</th>
                                <th class="py-3.5 px-6 text-right">Omzet</th>
                                <th class="py-3.5 px-6 text-right">Modal HPP</th>
                                <th class="py-3.5 px-6 text-right">Laba Kotor</th>
                                <th class="py-3.5 px-6 text-center">Margin</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse ($penjualanList as $trx)
                                @php
                                    $omzet = (float) $trx->total_bayar;
                                    $hpp = $trx->details->sum(fn ($d) => $d->jumlah * ($d->harga_beli_saat_ini ?? 0));
                                    $laba = $omzet - $hpp;
                                    $margin = $omzet > 0 ? ($laba / $omzet) * 100 : 0;
                                @endphp
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-1.5">
                                            <span class="font-mono font-bold text-slate-900 block">{{ $trx->no_invoice }}</span>
                                            <a href="{{ route('kasir.print', $trx->id_penjualan) }}" target="_blank" class="p-1 rounded-md text-slate-400 hover:text-indigo-600 hover:bg-slate-100 transition" title="Cetak Struk Thermal">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                                </svg>
                                            </a>
                                        </div>
                                        <span class="text-xs text-slate-400">{{ $trx->tanggal_penjualan ? $trx->tanggal_penjualan->translatedFormat('d M Y, H:i') : '-' }}</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="font-medium text-slate-700">{{ $trx->account->nama_akun ?? 'Administrator' }}</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="text-xs text-slate-600 max-w-xs space-y-0.5">
                                            @foreach ($trx->details as $det)
                                                <div class="truncate">
                                                    • {{ $det->product->nama_produk ?? 'Item' }} <span class="font-semibold text-slate-800">({{ $det->jumlah }}x)</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-right font-semibold text-slate-900">
                                        Rp {{ number_format($omzet, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-6 text-right text-slate-600 font-medium">
                                        Rp {{ number_format($hpp, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-6 text-right font-bold text-emerald-600">
                                        +Rp {{ number_format($laba, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                            {{ number_format($margin, 1) }}%
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-slate-400">
                                        Tidak ada transaksi penjualan dalam periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($penjualanList->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $penjualanList->links() }}
                    </div>
                @endif
            </div>

            <!-- ================= TAB 2: MARGIN PER PRODUK ================= -->
            <div id="tab-produk" class="tab-content hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-200/80 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                <th class="py-3.5 px-6">Produk & Kategori</th>
                                <th class="py-3.5 px-6 text-center">Total Terjual</th>
                                <th class="py-3.5 px-6 text-right">Total Omzet</th>
                                <th class="py-3.5 px-6 text-right">Total Modal HPP</th>
                                <th class="py-3.5 px-6 text-right">Laba Bersih Produk</th>
                                <th class="py-3.5 px-6 text-center">Margin</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse ($produkPerforma as $prod)
                                @php
                                    $marginProd = $prod->total_omzet > 0 ? ($prod->total_laba / $prod->total_omzet) * 100 : 0;
                                @endphp
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="font-bold text-slate-900">{{ $prod->nama_produk }}</div>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="font-mono text-xs text-slate-400">{{ $prod->kode_produk }}</span>
                                            @if ($prod->nama_kategori)
                                                <span class="text-[10px] font-semibold bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full">
                                                    {{ $prod->nama_kategori }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-center font-bold text-slate-800">
                                        {{ number_format($prod->total_qty) }} unit
                                    </td>
                                    <td class="py-4 px-6 text-right font-medium text-slate-900">
                                        Rp {{ number_format($prod->total_omzet, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-6 text-right text-slate-500">
                                        Rp {{ number_format($prod->total_modal, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-6 text-right font-bold text-emerald-600">
                                        +Rp {{ number_format($prod->total_laba, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-bold {{ $marginProd >= 20 ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                            {{ number_format($marginProd, 1) }}%
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-slate-400">
                                        Belum ada penjualan produk pada periode yang dipilih.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ================= TAB 3: PEMBELIAN STOK ================= -->
            <div id="tab-pembelian" class="tab-content hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-200/80 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                <th class="py-3.5 px-6">ID & Tanggal Masuk</th>
                                <th class="py-3.5 px-6">Produk / Barang</th>
                                <th class="py-3.5 px-6 text-center">Jumlah Unit Masuk</th>
                                <th class="py-3.5 px-6 text-right">Harga Beli Satuan</th>
                                <th class="py-3.5 px-6 text-right">Total Biaya Kulakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse ($pembelianList as $beli)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-4 px-6">
                                        <span class="font-bold text-slate-800">#{{ $beli->id_pembelian }}</span>
                                        <span class="text-xs text-slate-400 block">{{ $beli->tanggal_masuk ? \Carbon\Carbon::parse($beli->tanggal_masuk)->translatedFormat('d M Y') : '-' }}</span>
                                    </td>
                                    <td class="py-4 px-6 font-semibold text-slate-900">
                                        {{ $beli->product->nama_produk ?? 'Produk Dihapus' }}
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700">
                                            +{{ number_format($beli->jumlah_barang_masuk) }} {{ $beli->product->satuan_terkecil ?? 'unit' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-right text-slate-600">
                                        Rp {{ number_format($beli->harga_beli_satuan, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-6 text-right font-bold text-slate-900">
                                        Rp {{ number_format($beli->total_harga_beli, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-400">
                                        Tidak ada pengeluaran pembelian stok dalam periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ================= TAB 4: PENYESUAIAN STOK ================= -->
            <div id="tab-penyesuaian" class="tab-content hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-200/80 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                <th class="py-3.5 px-6">Tanggal Pengecekan</th>
                                <th class="py-3.5 px-6">Produk / Barang</th>
                                <th class="py-3.5 px-6 text-center">Selisih Fisik</th>
                                <th class="py-3.5 px-6 text-right">Estimasi Nilai Rugi/Untung</th>
                                <th class="py-3.5 px-6">Keterangan / Alasan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse ($penyesuaianList as $adj)
                                @php
                                    $hargaBeli = $adj->product->harga_beli_terakhir ?? 0;
                                    $nilaiRp = $adj->jumlah_selisih * $hargaBeli;
                                @endphp
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-4 px-6 text-slate-700 font-medium">
                                        {{ $adj->tanggal_cek ? \Carbon\Carbon::parse($adj->tanggal_cek)->translatedFormat('d M Y') : '-' }}
                                    </td>
                                    <td class="py-4 px-6 font-semibold text-slate-900">
                                        {{ $adj->product->nama_produk ?? 'Produk Dihapus' }}
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $adj->jumlah_selisih >= 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                            {{ $adj->jumlah_selisih > 0 ? '+' : '' }}{{ $adj->jumlah_selisih }} unit
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-right font-bold {{ $nilaiRp >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $nilaiRp >= 0 ? '+' : '' }}Rp {{ number_format($nilaiRp, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-6 text-xs text-slate-600">
                                        {{ $adj->keterangan ?: '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-400">
                                        Tidak ada catatan penyesuaian stok dalam periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- SCRIPT TABS & CHART.JS                                   -->
    <!-- ======================================================== -->
    <script>
        // Tab Switcher
        function switchReportTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-indigo-600', 'text-indigo-600');
                btn.classList.add('border-transparent', 'text-slate-500');
            });

            document.getElementById(tabId).classList.remove('hidden');
            const activeBtn = document.getElementById('btn-' + tabId);
            activeBtn.classList.remove('border-transparent', 'text-slate-500');
            activeBtn.classList.add('border-indigo-600', 'text-indigo-600');
        }

    </script>
</x-layout>
