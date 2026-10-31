<x-layout>
    <x-slot:title>Overview Dashboard</x-slot:title>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="space-y-6 pb-8">

        <!-- ======================================================== -->
        <!-- ROW 1: 4 TOP STAT CARDS (Sesuai Referensi H-care)        -->
        <!-- ======================================================== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">

            <!-- Card 1: Total Penjualan -->
            <div onclick="openModalCard('penjualan')" class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-xs p-5 flex items-center justify-between hover:shadow-md hover:border-purple-200 transition-all cursor-pointer group" title="Klik untuk melihat rincian penjualan">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 group-hover:bg-purple-100 flex items-center justify-center shrink-0 transition-colors">
                        <!-- Shopping Bag Icon -->
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ number_format($statPenjualan) }}</h3>
                        <p class="text-xs font-medium text-slate-400 mt-0.5">Total Penjualan</p>
                    </div>
                </div>
                <button type="button" class="text-slate-300 group-hover:text-purple-600 group-hover:bg-purple-50 rounded-xl transition p-1.5" title="Lihat Riwayat Penjualan">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><circle cx="5" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="19" cy="12" r="2"/></svg>
                </button>
            </div>

            <!-- Card 2: Produk Aktif -->
            <div onclick="openModalCard('produk')" class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-xs p-5 flex items-center justify-between hover:shadow-md hover:border-sky-200 transition-all cursor-pointer group" title="Klik untuk melihat daftar produk aktif">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-500 group-hover:bg-sky-100 flex items-center justify-center shrink-0 transition-colors">
                        <!-- Staff / Products Icon -->
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ number_format($statProduk) }}</h3>
                        <p class="text-xs font-medium text-slate-400 mt-0.5">Produk Aktif</p>
                    </div>
                </div>
                <button type="button" class="text-slate-300 group-hover:text-sky-600 group-hover:bg-sky-50 rounded-xl transition p-1.5" title="Lihat Daftar Produk Aktif">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><circle cx="5" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="19" cy="12" r="2"/></svg>
                </button>
            </div>

            <!-- Card 3: Rata-rata Transaksi -->
            <div onclick="openModalCard('analisis')" class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-xs p-5 flex items-center justify-between hover:shadow-md hover:border-amber-200 transition-all cursor-pointer group" title="Klik untuk melihat analisis transaksi">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 group-hover:bg-amber-100 flex items-center justify-center shrink-0 transition-colors">
                        <!-- Wallet / Cash Icon -->
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H4.5a1.5 1.5 0 01-1.5-1.5v-8.25M21 11.25V7.5a1.5 1.5 0 00-1.5-1.5H4.5A1.5 1.5 0 003 7.5v3.75m18 0H3m12 4.5h3" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                            @if ($statAvgBayar >= 1000000)
                                Rp {{ number_format($statAvgBayar / 1000000, 1, ',', '.') }} jt
                            @else
                                Rp {{ number_format($statAvgBayar, 0, ',', '.') }}
                            @endif
                        </h3>
                        <p class="text-xs font-medium text-slate-400 mt-0.5">Rata-rata Transaksi</p>
                    </div>
                </div>
                <button type="button" class="text-slate-300 group-hover:text-amber-600 group-hover:bg-amber-50 rounded-xl transition p-1.5" title="Lihat Analisis Transaksi">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><circle cx="5" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="19" cy="12" r="2"/></svg>
                </button>
            </div>

            <!-- Card 4: Available Cars / Stok Menipis -->
            <div onclick="openModalCard('stok')" class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-xs p-5 flex items-center justify-between hover:shadow-md hover:border-rose-200 transition-all cursor-pointer group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 group-hover:bg-rose-100 flex items-center justify-center shrink-0 transition-colors">
                        <!-- Alert / Car Icon -->
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ number_format($statMenipis) }}</h3>
                        <p class="text-xs font-medium text-slate-400 mt-0.5">Stok Perlu Restock</p>
                    </div>
                </div>
                <button type="button" class="text-slate-300 group-hover:text-rose-600 group-hover:bg-rose-50 rounded-xl transition p-1.5" title="Lihat Produk Perlu Restock">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><circle cx="5" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="19" cy="12" r="2"/></svg>
                </button>
            </div>

        </div>

        <!-- ======================================================== -->
        <!-- AI SMART STOCK ALERT WIDGET                              -->
        <!-- ======================================================== -->
        @php
            $aiStokKritis = \App\Models\Product::whereRaw('stok_produk <= COALESCE(stok_minimum, 5)')->orderBy('stok_produk','asc')->take(4)->get();
            $aiStokHabis  = \App\Models\Product::where('stok_produk', '<=', 0)->count();
        @endphp
        @if($aiStokKritis->count() > 0)
        <div class="bg-gradient-to-br from-indigo-600 via-violet-600 to-purple-700 rounded-2xl sm:rounded-3xl p-5 sm:p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 border border-white/30 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2a2 2 0 0 1 2 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 0 1 7 7h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1H2a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h1a7 7 0 0 1 7-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 0 1 2-2z"/>
                            <circle cx="7.5" cy="14.5" r="1.5" fill="currentColor" stroke="none"/>
                            <circle cx="16.5" cy="14.5" r="1.5" fill="currentColor" stroke="none"/>
                            <path d="M7 18h10"/>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-sm sm:text-base">AI Smart Stock Alert</h3>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-white/20 border border-white/30 text-[10px] font-bold uppercase">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                                Live
                            </span>
                        </div>
                        <p class="text-indigo-200 text-xs">{{ $aiStokKritis->count() }} produk membutuhkan perhatian segera</p>
                    </div>
                </div>
                <a href="{{ route('ai.stock.index') }}" class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white/20 hover:bg-white/30 border border-white/30 text-xs font-semibold transition">
                    Lihat Semua
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                @foreach($aiStokKritis as $kritis)
                <div class="bg-white/10 border border-white/20 rounded-xl p-3.5 hover:bg-white/20 transition">
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <p class="text-xs font-semibold leading-tight line-clamp-2">{{ $kritis->nama_produk }}</p>
                        @if($kritis->stok_produk <= 0)
                            <span class="shrink-0 px-1.5 py-0.5 rounded-md bg-red-500/80 text-[9px] font-bold uppercase">Habis</span>
                        @else
                            <span class="shrink-0 px-1.5 py-0.5 rounded-md bg-orange-500/80 text-[9px] font-bold uppercase">Kritis</span>
                        @endif
                    </div>
                    <div class="flex items-end justify-between">
                        <div>
                            <p class="text-2xl font-extrabold leading-none {{ $kritis->stok_produk <= 0 ? 'text-red-300' : 'text-amber-300' }}">{{ $kritis->stok_produk }}</p>
                            <p class="text-[10px] text-indigo-200 mt-0.5">Min. {{ $kritis->stok_minimum ?? 5 }} {{ $kritis->satuan_terkecil ?? 'pcs' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-indigo-200">AI saran reorder</p>
                            <p class="text-xs font-bold text-white">{{ max(($kritis->stok_minimum ?? 5) * 3, 10) }} {{ $kritis->satuan_terkecil ?? 'pcs' }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- ======================================================== -->
        <!-- ROW 2: BAR CHART (Outpatients vs Inpatients) & GENDER    -->
        <!-- ======================================================== -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

            <!-- KIRI (8 COLS): Outpatients vs. Inpatients Trend -->
            <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-100 shadow-xs p-6 flex flex-col justify-between">
                <!-- Header -->
                <div class="flex items-center justify-between pb-4">
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Tren Penjualan & Pendapatan</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Perbandingan performa transaksi berkala</p>
                    </div>
                    <div class="relative inline-block text-left" id="trend-filter-wrapper">
                        <button id="trend-filter-btn" type="button" class="flex items-center gap-1.5 text-xs text-slate-600 bg-slate-50 border border-slate-200/80 px-3 py-1.5 rounded-xl font-medium cursor-pointer hover:bg-slate-100 transition shadow-2xs">
                            <span id="trend-filter-label">6 Bulan Terakhir</span>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="trend-filter-menu" class="absolute right-0 mt-1 w-44 bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 hidden z-30 text-xs">
                            <button type="button" onclick="switchTrendMode('today')" class="w-full text-left px-3.5 py-2 hover:bg-slate-50 font-medium text-slate-700 cursor-pointer flex items-center justify-between">
                                <span>Hari Ini</span>
                            </button>
                            <button type="button" onclick="switchTrendMode('week')" class="w-full text-left px-3.5 py-2 hover:bg-slate-50 font-medium text-slate-700 cursor-pointer flex items-center justify-between">
                                <span>Seminggu Terakhir</span>
                            </button>
                            <button type="button" onclick="switchTrendMode('month')" class="w-full text-left px-3.5 py-2 hover:bg-slate-50 font-medium text-slate-700 cursor-pointer flex items-center justify-between">
                                <span>1 Bulan Terakhir</span>
                            </button>
                            <button type="button" onclick="switchTrendMode('months_6')" class="w-full text-left px-3.5 py-2 hover:bg-slate-50 font-medium text-slate-700 cursor-pointer flex items-center justify-between">
                                <span>6 Bulan Terakhir</span>
                            </button>
                            <button type="button" onclick="switchTrendMode('year')" class="w-full text-left px-3.5 py-2 hover:bg-slate-50 font-medium text-slate-700 cursor-pointer flex items-center justify-between">
                                <span>1 Tahun Terakhir</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Chart Grid: Bar Chart + Radial Progress -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center pt-2">
                    
                    <!-- Dual Bar Chart -->
                    <div class="md:col-span-8 flex flex-col justify-between">
                        <div class="h-56 relative w-full">
                            <canvas id="trendBarChart"></canvas>
                        </div>
                        <!-- Legend bawah bar -->
                        <div class="flex items-center justify-center gap-6 pt-4 pb-1 text-xs">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-purple-600 inline-block shadow-2xs"></span>
                                <span class="text-slate-600 font-medium">Pendapatan</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block shadow-2xs"></span>
                                <span class="text-slate-600 font-medium">Transaksi</span>
                            </div>
                        </div>
                    </div>

                    <!-- Circular Progress Gauge (28% Donut di kanan bar) -->
                    <div class="md:col-span-4 flex flex-col items-center justify-center p-3 border-t md:border-t-0 md:border-l border-slate-100">
                        <div class="relative w-36 h-36 flex items-center justify-center">
                            <canvas id="circularGaugeChart"></canvas>
                            <!-- Center Icon & badge -->
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                <div class="w-8 h-8 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                            <!-- Black floating badge dynamic % -->
                            <span class="absolute top-2 left-1 bg-slate-900 text-white text-[11px] font-bold px-2 py-0.5 rounded-md shadow-sm">
                                {{ $targetPercentage }}%
                            </span>
                        </div>
                        <p class="text-xs font-semibold text-slate-700 mt-2">Target Penjualan</p>
                        <p class="text-[11px] text-slate-400">Tercapai bulan ini ({{ $bulanIniTotal }}/{{ $targetTransaksi }})</p>
                    </div>

                </div>
            </div>

            <!-- KANAN (4 COLS): Patients by Gender / Distribusi Kategori -->
            <div class="lg:col-span-4 bg-white rounded-3xl border border-slate-100 shadow-xs p-6 flex flex-col justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Distribusi Kategori</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Proporsi penjualan per kategori</p>
                </div>

                <!-- Donut Chart -->
                <div class="relative w-44 h-44 mx-auto my-3 flex items-center justify-center">
                    <canvas id="genderDonutChart"></canvas>
                    <!-- Center Icon -->
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="w-10 h-10 rounded-full bg-slate-50 border border-slate-100 text-slate-500 flex items-center justify-center shadow-xs">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Legend below donut -->
                <div class="flex flex-wrap items-center justify-center gap-4 pt-2 text-xs">
                    @php
                        $catColors = ['bg-amber-500', 'bg-purple-600', 'bg-cyan-500', 'bg-emerald-500', 'bg-pink-500'];
                    @endphp
                    @foreach ($kategoriLabels as $idx => $cLabel)
                        <div class="flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full {{ $catColors[$idx % count($catColors)] }} inline-block"></span>
                            <span class="text-slate-600 font-medium">{{ $cLabel }} ({{ $kategoriSeries[$idx] ?? 0 }}%)</span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- ======================================================== -->
        <!-- ROW 3: TIME ADMITTED, PATIENTS BY DIVISION, PURPLE CARD  -->
        <!-- ======================================================== -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

            <!-- KIRI (5 COLS): Time Admitted / Waktu Transaksi -->
            <div class="lg:col-span-5 bg-white rounded-3xl border border-slate-100 shadow-xs p-6 flex flex-col justify-between">
                <!-- Header -->
                <div class="flex items-center justify-between pb-3">
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Waktu Transaksi</h3>
                        <p id="time-filter-desc" class="text-xs text-slate-400 mt-0.5">Frekuensi transaksi 6 bulan terakhir</p>
                    </div>
                    <!-- Dropdown Filter Waktu Transaksi -->
                    <div class="relative inline-block text-left" id="time-filter-wrapper">
                        <button id="time-filter-btn" type="button" class="flex items-center gap-1.5 text-xs text-slate-600 bg-slate-50 border border-slate-200/80 px-3 py-1.5 rounded-xl font-medium cursor-pointer hover:bg-slate-100 transition shadow-2xs">
                            <span id="time-filter-label">6 Bulan Terakhir</span>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="time-filter-menu" class="absolute right-0 mt-1 w-44 bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 hidden z-30 text-xs">
                            <button type="button" onclick="switchTimeMode('today')" class="w-full text-left px-3.5 py-2 hover:bg-slate-50 font-medium text-slate-700 cursor-pointer flex items-center justify-between">
                                <span>Hari Ini</span>
                            </button>
                            <button type="button" onclick="switchTimeMode('week')" class="w-full text-left px-3.5 py-2 hover:bg-slate-50 font-medium text-slate-700 cursor-pointer flex items-center justify-between">
                                <span>Seminggu Terakhir</span>
                            </button>
                            <button type="button" onclick="switchTimeMode('month')" class="w-full text-left px-3.5 py-2 hover:bg-slate-50 font-medium text-slate-700 cursor-pointer flex items-center justify-between">
                                <span>1 Bulan Terakhir</span>
                            </button>
                            <button type="button" onclick="switchTimeMode('months_6')" class="w-full text-left px-3.5 py-2 hover:bg-slate-50 font-medium text-slate-700 cursor-pointer flex items-center justify-between">
                                <span>6 Bulan Terakhir</span>
                            </button>
                            <button type="button" onclick="switchTimeMode('year')" class="w-full text-left px-3.5 py-2 hover:bg-slate-50 font-medium text-slate-700 cursor-pointer flex items-center justify-between">
                                <span>1 Tahun Terakhir</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Orange Spline Wave Chart -->
                <div class="h-44 relative mt-2">
                    <canvas id="timeAdmittedChart"></canvas>
                </div>
            </div>

            <!-- TENGAH (4 COLS): Patients By Division / Kategori Populer -->
            <div class="lg:col-span-4 bg-white rounded-3xl border border-slate-100 shadow-xs p-6 flex flex-col justify-between">
                <!-- Header -->
                <div class="flex items-center justify-between pb-3">
                    <h3 class="text-base font-bold text-slate-800">Kategori Populer</h3>
                    <svg class="w-4 h-4 text-slate-400 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>

                <!-- Sub-header -->
                <div class="flex items-center justify-between text-[11px] font-semibold text-slate-400 uppercase tracking-wider pb-2 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>KATEGORI</span>
                    </div>
                    <span>TERJUAL</span>
                </div>

                <!-- List Rows -->
                <div class="divide-y divide-slate-100 text-xs">
                    @forelse ($kategoriPopuler as $idx => $kp)
                        <div class="py-3 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <x-category-icon :name="$kp->nama_kategori" class="w-8 h-8 rounded-xl" icon-class="w-4 h-4" />
                                <span class="font-medium text-slate-700">{{ $kp->nama_kategori }}</span>
                            </div>
                            <span class="font-bold text-slate-900">{{ number_format($kp->terjual) }}</span>
                        </div>
                    @empty
                        <p class="py-4 text-center text-xs text-slate-400 italic">Belum ada data penjualan kategori</p>
                    @endforelse
                </div>
            </div>

            <!-- KANAN (3 COLS): Glowing Purple Card (3,240 Transaksi) -->
            <div class="lg:col-span-3 bg-gradient-to-br from-indigo-700 via-purple-700 to-violet-800 rounded-3xl p-6 text-white shadow-xl shadow-purple-600/20 relative overflow-hidden flex flex-col justify-between">
                <!-- Top Stat -->
                <div class="relative z-10">
                    <h2 id="purple-card-count" class="text-4xl font-extrabold tracking-tight">{{ number_format($purpleData['months_6']['total'] ?? $bulanIniTotal) }}</h2>
                    <p id="purple-card-desc" class="text-xs text-purple-200 mt-1 font-medium">{{ $purpleData['months_6']['desc'] ?? 'Transaksi 6 bulan terakhir' }}</p>
                </div>

                <!-- Sparkline Wave in White -->
                <div class="h-28 relative my-2 z-10">
                    <canvas id="purpleSparklineChart"></canvas>
                </div>

                <!-- Bottom X-axis Dates -->
                <div id="purple-card-labels" class="flex items-center justify-between text-[11px] font-semibold text-purple-200/80 px-1 relative z-10">
                    @foreach (($purpleData['months_6']['labels'] ?? $sparklineLabels) as $sLabel)
                        <span>{{ $sLabel }}</span>
                    @endforeach
                </div>

                <!-- Background Subtle Glow Effect -->
                <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-purple-500/30 rounded-full blur-2xl pointer-events-none"></div>
            </div>

        </div>

    </div>

    <!-- ======================================================== -->
    <!-- 4 POP-OUT DIALOG BOXES UNTUK KARTU ATAS (...)            -->
    <!-- ======================================================== -->

    <!-- 1. POP-OUT MODAL: DETAIL PENJUALAN -->
    <div id="modal-card-penjualan" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeModalCard('penjualan')"></div>
        <div class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all z-10 flex flex-col max-h-[85vh]">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-slate-100 bg-slate-50/50 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Rincian Transaksi Penjualan</h3>
                        <p class="text-xs text-slate-500">Total <span class="font-semibold text-purple-600">{{ number_format($statPenjualan) }}</span> transaksi tercatat</p>
                    </div>
                </div>
                <button type="button" onclick="closeModalCard('penjualan')" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Body List -->
            <div class="overflow-y-auto p-6 space-y-3">
                @forelse ($daftarPenjualan as $p)
                    <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:border-purple-200 hover:shadow-xs transition flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="font-mono font-bold text-xs text-purple-600">{{ $p->no_invoice }}</span>
                                <span class="text-[10px] text-slate-400">• {{ $p->created_at ? $p->created_at->format('d M Y, H:i') : '-' }}</span>
                            </div>
                            <div class="text-xs text-slate-600">
                                Kasir: <span class="font-semibold text-slate-800">{{ $p->account?->nama_akun ?? 'Kasir' }}</span>
                                <span class="mx-1 text-slate-300">|</span>
                                Item: <span class="font-medium text-slate-700">
                                    @if($p->details->count() > 0)
                                        {{ $p->details->map(fn($d) => ($d->product?->nama_produk ?? 'Item') . ' (' . $d->jumlah . 'x)')->join(', ') }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="text-sm font-extrabold text-slate-900">Rp {{ number_format($p->total_bayar, 0, ',', '.') }}</p>
                            <p class="text-[10px] text-emerald-600 font-semibold">Lunas</p>
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center text-slate-400 text-xs">
                        <p class="font-semibold text-slate-600">Belum ada transaksi penjualan riil</p>
                        <p class="text-[11px] mt-1">Gunakan Kasir POS untuk mulai melayani penjualan customer.</p>
                    </div>
                @endforelse
            </div>

            <!-- Footer -->
            <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-2 shrink-0">
                <a href="{{ route('kasir.riwayat') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-purple-600 hover:text-purple-800 transition">
                    <span>Lihat Halaman Riwayat Lengkap</span>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
                <div class="flex items-center gap-2">
                    <a href="{{ route('kasir.index') }}" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-xs font-semibold shadow-xs transition">
                        Buka Kasir POS
                    </a>
                    <button type="button" onclick="closeModalCard('penjualan')" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 rounded-xl text-xs font-semibold transition cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. POP-OUT MODAL: DAFTAR PRODUK AKTIF -->
    <div id="modal-card-produk" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeModalCard('produk')"></div>
        <div class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all z-10 flex flex-col max-h-[85vh]">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-slate-100 bg-slate-50/50 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-sky-50 text-sky-500 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 8-7-4-7 4v8l7 4 7-4zM12 22V12m9-4-9 4-9-4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Daftar Produk Aktif</h3>
                        <p class="text-xs text-slate-500">Total <span class="font-semibold text-sky-600">{{ number_format($statProduk) }}</span> produk tersedia</p>
                    </div>
                </div>
                <button type="button" onclick="closeModalCard('produk')" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Body List -->
            <div class="overflow-y-auto p-6 divide-y divide-slate-100">
                @forelse ($daftarProdukAktif as $prod)
                    <div class="py-3 flex items-center justify-between gap-3 first:pt-0 last:pb-0">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 font-bold text-xs flex items-center justify-center shrink-0">
                                {{ strtoupper(substr($prod->nama_produk, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-800 truncate">{{ $prod->nama_produk }}</p>
                                <p class="text-[10px] text-slate-400 font-mono">{{ $prod->kode_produk }} • {{ $prod->category?->nama_kategori ?? 'Umum' }}</p>
                            </div>
                        </div>
                        <div class="text-right shrink-0 flex items-center gap-3">
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700">
                                {{ $prod->stok_produk }} {{ $prod->satuan_terkecil ?? 'pcs' }}
                            </span>
                            <span class="text-xs font-extrabold text-slate-900">
                                Rp {{ number_format($prod->harga_jual, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center text-slate-400 text-xs">
                        <p class="font-semibold text-slate-600">Belum ada produk aktif</p>
                        <p class="text-[11px] mt-1">Tambahkan produk baru di menu Data Produk.</p>
                    </div>
                @endforelse
            </div>

            <!-- Footer -->
            <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-2 shrink-0">
                <a href="{{ route('product.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-sky-600 hover:text-sky-800 transition">
                    <span>Kelola Semua Produk</span>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
                <button type="button" onclick="closeModalCard('produk')" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 rounded-xl text-xs font-semibold transition cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- 3. POP-OUT MODAL: ANALISIS RATA-RATA TRANSAKSI -->
    <div id="modal-card-analisis" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeModalCard('analisis')"></div>
        <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all z-10 flex flex-col max-h-[85vh]">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-slate-100 bg-slate-50/50 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Analisis Nilai Transaksi</h3>
                        <p class="text-xs text-slate-500">Statistik performa penjualan dan rata-rata pembelian</p>
                    </div>
                </div>
                <button type="button" onclick="closeModalCard('analisis')" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Body Stats Grid -->
            <div class="overflow-y-auto p-6 space-y-4">
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-amber-50/60 rounded-2xl p-4 border border-amber-100">
                        <p class="text-[11px] font-semibold text-amber-700">Rata-rata Transaksi</p>
                        <h4 class="text-lg font-extrabold text-slate-900 mt-1">Rp {{ number_format($statAvgBayar, 0, ',', '.') }}</h4>
                        <p class="text-[10px] text-slate-400 mt-0.5">Per struk belanja</p>
                    </div>
                    <div class="bg-indigo-50/60 rounded-2xl p-4 border border-indigo-100">
                        <p class="text-[11px] font-semibold text-indigo-700">Total Pendapatan</p>
                        <h4 class="text-lg font-extrabold text-slate-900 mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
                        <p class="text-[10px] text-slate-400 mt-0.5">Akumulasi penjualan</p>
                    </div>
                    <div class="bg-emerald-50/60 rounded-2xl p-4 border border-emerald-100">
                        <p class="text-[11px] font-semibold text-emerald-700">Transaksi Tertinggi</p>
                        <h4 class="text-lg font-extrabold text-slate-900 mt-1">Rp {{ number_format($transaksiTertinggi, 0, ',', '.') }}</h4>
                        <p class="text-[10px] text-slate-400 mt-0.5">Nilai belanja terbesar</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200">
                        <p class="text-[11px] font-semibold text-slate-600">Transaksi Terendah</p>
                        <h4 class="text-lg font-extrabold text-slate-900 mt-1">Rp {{ number_format($transaksiTerendah, 0, ',', '.') }}</h4>
                        <p class="text-[10px] text-slate-400 mt-0.5">Nilai belanja terkecil</p>
                    </div>
                </div>

                <div class="pt-2">
                    <h5 class="text-xs font-bold text-slate-800 mb-2">5 Transaksi Terakhir</h5>
                    <div class="divide-y divide-slate-100 text-xs">
                        @forelse ($daftarPenjualan->take(5) as $pj)
                            <div class="py-2.5 flex items-center justify-between">
                                <span class="font-mono font-semibold text-slate-700">{{ $pj->no_invoice }}</span>
                                <span class="font-bold text-slate-900">Rp {{ number_format($pj->total_bayar, 0, ',', '.') }}</span>
                            </div>
                        @empty
                            <p class="text-center py-4 text-slate-400 text-xs">Belum ada transaksi</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-2 shrink-0">
                <a href="{{ route('kasir.riwayat') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-600 hover:text-amber-800 transition">
                    <span>Lihat Riwayat Transaksi</span>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
                <button type="button" onclick="closeModalCard('analisis')" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 rounded-xl text-xs font-semibold transition cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- 4. POP-OUT MODAL: PRODUK PERLU RESTOCK -->
    <div id="modal-card-stok" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeModalCard('stok')"></div>
        <div class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all z-10 flex flex-col max-h-[85vh]">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-slate-100 bg-slate-50/50 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Produk Perlu Restock</h3>
                        <p class="text-xs text-slate-500"><span class="font-semibold text-rose-600">{{ $daftarStokMenipis->count() }}</span> produk mencapai atau di bawah stok minimum</p>
                    </div>
                </div>
                <button type="button" onclick="closeModalCard('stok')" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Body List -->
            <div class="overflow-y-auto p-6 space-y-3">
                @forelse ($daftarStokMenipis as $m)
                    <a 
                        href="{{ route('product.index', ['search' => $m->kode_produk, 'edit' => $m->id_produk]) }}"
                        class="group p-4 rounded-2xl border border-rose-200/80 bg-rose-50/40 hover:bg-white hover:border-indigo-300 hover:shadow-md transition-all duration-200 flex items-center justify-between gap-3 cursor-pointer block"
                        title="Klik untuk membuka kelola & restock {{ $m->nama_produk }}"
                    >
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <p class="text-xs font-bold text-slate-900 group-hover:text-indigo-600 transition">{{ $m->nama_produk }}</p>
                                <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-indigo-600 bg-indigo-50 group-hover:bg-indigo-100 px-2 py-0.5 rounded-md transition shrink-0">
                                    Kelola Produk
                                    <svg class="w-3 h-3 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                    </svg>
                                </span>
                            </div>
                            <p class="text-[10px] text-slate-500 font-mono">{{ $m->kode_produk }} • Kategori: {{ $m->category?->nama_kategori ?? 'Umum' }} • Lokasi: {{ $m->lokasi_produk ?? '-' }}</p>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700 group-hover:bg-rose-200 transition">
                                Sisa {{ $m->stok_produk }} {{ $m->satuan_terkecil ?? 'pcs' }}
                            </span>
                            <p class="text-[10px] text-slate-400 mt-1">Min. {{ $m->stok_minimum ?? 5 }} {{ $m->satuan_terkecil ?? 'pcs' }}</p>
                        </div>
                    </a>
                @empty
                    <div class="py-10 text-center text-slate-400 text-xs">
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-2">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <p class="font-bold text-slate-700">Semua Stok Aman!</p>
                        <p class="text-[11px] mt-1 text-slate-400">Tidak ada produk yang berada di bawah batas minimum stok.</p>
                    </div>
                @endforelse
            </div>

            <!-- Footer -->
            <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-2 shrink-0">
                <a href="{{ route('product.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-rose-600 hover:text-rose-800 transition">
                    <span>Buka Manajemen Produk & Stok</span>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
                <button type="button" onclick="closeModalCard('stok')" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 rounded-xl text-xs font-semibold transition cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    <script>
        // Modal Pop-Out Handlers untuk 4 Kartu Metrik
        function openModalCard(type) {
            const modal = document.getElementById('modal-card-' + type);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        }

        function closeModalCard(type) {
            const modal = document.getElementById('modal-card-' + type);
            if (modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                ['penjualan', 'produk', 'analisis', 'stok'].forEach(function(type) {
                    closeModalCard(type);
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Palette warna modern H-care
            const PURPLE  = '#7c3aed';
            const EMERALD = '#00d284';
            const ORANGE  = '#f97316';
            const CYAN    = '#06b6d4';

            // ==========================================
            // 1. TREN BAR CHART (Dual Bars: Transaksi & Pendapatan)
            // ==========================================
            const trendDatasets = @json($trendData);
            const purpleDatasets = @json($purpleData);
            const currentTrendMode = 'months_6';
            const initialTrend = trendDatasets[currentTrendMode] || trendDatasets['months_6'];

            const ctxBar = document.getElementById('trendBarChart').getContext('2d');
            const trendBarChart = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: initialTrend.labels,
                    datasets: [
                        {
                            label: 'Transaksi',
                            data: initialTrend.penjualan,
                            backgroundColor: EMERALD,
                            borderRadius: 6,
                            barPercentage: 0.35,
                            categoryPercentage: 0.65,
                            yAxisID: 'y',
                        },
                        {
                            label: 'Pendapatan',
                            data: initialTrend.pendapatan,
                            backgroundColor: PURPLE,
                            borderRadius: 6,
                            barPercentage: 0.35,
                            categoryPercentage: 0.65,
                            yAxisID: 'y1',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 10,
                            cornerRadius: 10,
                            callbacks: {
                                label: function(context) {
                                    if (context.dataset.yAxisID === 'y1') {
                                        return ' Pendapatan: Rp ' + Number(context.raw).toLocaleString('id-ID');
                                    }
                                    return ' Transaksi: ' + context.raw + ' transaksi';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10 }, color: '#94a3b8' }
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            beginAtZero: true,
                            border: { dash: [4, 4] },
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                font: { size: 10 },
                                color: '#94a3b8',
                                precision: 0,
                                callback: val => val.toLocaleString('id-ID')
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            beginAtZero: true,
                            grid: { display: false },
                            ticks: {
                                font: { size: 10 },
                                color: '#94a3b8',
                                callback: val => {
                                    if (val >= 1000000) return 'Rp ' + (val/1000000).toFixed(1) + 'M';
                                    if (val >= 1000) return 'Rp ' + (val/1000).toLocaleString('id-ID') + 'k';
                                    return 'Rp ' + val.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });

            // Toggle filter dropdown for trend chart
            const trendFilterBtn = document.getElementById('trend-filter-btn');
            const trendFilterMenu = document.getElementById('trend-filter-menu');
            const trendFilterLabel = document.getElementById('trend-filter-label');

            if (trendFilterBtn && trendFilterMenu) {
                trendFilterBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    trendFilterMenu.classList.toggle('hidden');
                    const timeMenu = document.getElementById('time-filter-menu');
                    if (timeMenu) timeMenu.classList.add('hidden');
                });
            }

            window.switchDashboardPeriod = function(mode) {
                // 1. Update Tren Penjualan & Pendapatan
                const trendSelected = trendDatasets[mode];
                if (trendSelected) {
                    trendBarChart.data.labels = trendSelected.labels;
                    trendBarChart.data.datasets[0].data = trendSelected.penjualan;
                    trendBarChart.data.datasets[1].data = trendSelected.pendapatan;
                    trendBarChart.update();
                    if (trendFilterLabel) trendFilterLabel.textContent = trendSelected.label;
                }

                // 2. Update Waktu Transaksi
                const timeSelected = timeDatasets[mode];
                if (timeSelected) {
                    const dataArr = timeSelected.penjualan;
                    const maxVal = Math.max(...dataArr);
                    const peakIndex = maxVal > 0 ? dataArr.indexOf(maxVal) : -1;
                    const pointRadii = dataArr.map((v, i) => i === peakIndex ? 5 : 0);

                    timeAdmittedChart.data.labels = timeSelected.labels;
                    timeAdmittedChart.data.datasets[0].data = dataArr;
                    timeAdmittedChart.data.datasets[0].pointRadius = pointRadii;
                    timeAdmittedChart.options.scales.x.ticks.font = (ctx) => ({
                        weight: (peakIndex !== -1 && ctx.index === peakIndex) ? 'bold' : 'normal',
                        size: 10
                    });
                    timeAdmittedChart.options.scales.x.ticks.color = (ctx) => (peakIndex !== -1 && ctx.index === peakIndex) ? ORANGE : '#94a3b8';
                    timeAdmittedChart.options.scales.y.suggestedMax = Math.max(3, maxVal + 1);
                    timeAdmittedChart.options.scales.y.ticks.stepSize = maxVal > 4 ? Math.ceil(maxVal / 4) : 1;
                    timeAdmittedChart.update();

                    const timeFilterLabelEl = document.getElementById('time-filter-label');
                    const timeFilterDescEl = document.getElementById('time-filter-desc');
                    if (timeFilterLabelEl) timeFilterLabelEl.textContent = timeSelected.label;
                    if (timeFilterDescEl && timeSelected.desc) timeFilterDescEl.textContent = timeSelected.desc;
                }

                // 3. Update Kartu Transaksi Kanan Bawah (Ungu)
                const purpleSelected = purpleDatasets[mode];
                if (purpleSelected) {
                    const purpleCountEl = document.getElementById('purple-card-count');
                    const purpleDescEl = document.getElementById('purple-card-desc');
                    const purpleLabelsEl = document.getElementById('purple-card-labels');

                    if (purpleCountEl) purpleCountEl.textContent = Number(purpleSelected.total).toLocaleString('id-ID');
                    if (purpleDescEl) purpleDescEl.textContent = purpleSelected.desc;

                    const pData = purpleSelected.series;
                    const maxP = Math.max(...pData);
                    const peakP = maxP > 0 ? pData.lastIndexOf(maxP) : -1;
                    const radiiP = pData.map((v, i) => i === peakP ? 4 : 0);

                    purpleChart.data.labels = purpleSelected.labels;
                    purpleChart.data.datasets[0].data = pData;
                    purpleChart.data.datasets[0].pointRadius = radiiP;
                    purpleChart.update();

                    if (purpleLabelsEl && purpleSelected.labels) {
                        purpleLabelsEl.innerHTML = purpleSelected.labels.map(l => `<span>${l}</span>`).join('');
                    }
                }

                // Tutup semua menu
                if (trendFilterMenu) trendFilterMenu.classList.add('hidden');
                const timeMenu = document.getElementById('time-filter-menu');
                if (timeMenu) timeMenu.classList.add('hidden');
            };

            // Sambungkan kedua tombol filter ke fungsi yang sama
            window.switchTrendMode = window.switchDashboardPeriod;
            window.switchTimeMode = window.switchDashboardPeriod;

            // ==========================================
            // 2. CIRCULAR GAUGE (Target Penjualan Donut)
            // ==========================================
            const ctxGauge = document.getElementById('circularGaugeChart').getContext('2d');
            const targetPct = {{ $targetPercentage }};
            new Chart(ctxGauge, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [targetPct, Math.max(0, 100 - targetPct)],
                        backgroundColor: [EMERALD, '#f1f5f9'],
                        borderWidth: 0,
                        cutout: '76%',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false }, tooltip: { enabled: false } },
                    animation: { animateRotate: true }
                }
            });

            // ==========================================
            // 3. GENDER / KATEGORI DONUT
            // ==========================================
            const ctxDonut = document.getElementById('genderDonutChart').getContext('2d');
            const catColors = [ORANGE, PURPLE, CYAN, EMERALD, '#ec4899'];
            new Chart(ctxDonut, {
                type: 'doughnut',
                data: {
                    labels: @json($kategoriLabels),
                    datasets: [{
                        data: @json($kategoriSeries),
                        backgroundColor: catColors.slice(0, @json(count($kategoriLabels))),
                        borderWidth: 0,
                        cutout: '72%',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 8,
                            cornerRadius: 8,
                            callbacks: {
                                label: item => ` ${item.label}: ${item.raw}%`
                            }
                        }
                    }
                }
            });

            // ==========================================
            // 4. TIME ADMITTED / WAKTU TRANSAKSI
            // ==========================================
            const timeDatasets = @json($timeData);
            const currentTimeMode = 'months_6';
            const initialTime = timeDatasets[currentTimeMode] || timeDatasets['months_6'];

            const ctxTime = document.getElementById('timeAdmittedChart').getContext('2d');
            const gradientOrange = ctxTime.createLinearGradient(0, 0, 0, 160);
            gradientOrange.addColorStop(0, 'rgba(249, 115, 22, 0.25)');
            gradientOrange.addColorStop(1, 'rgba(249, 115, 22, 0.0)');

            const initialTimeData = initialTime.penjualan;
            const initialMaxVal = Math.max(...initialTimeData);
            const initialPeakIndex = initialMaxVal > 0 ? initialTimeData.indexOf(initialMaxVal) : -1;
            const initialPointRadii = initialTimeData.map((v, i) => i === initialPeakIndex ? 5 : 0);

            const timeAdmittedChart = new Chart(ctxTime, {
                type: 'line',
                data: {
                    labels: initialTime.labels,
                    datasets: [{
                        data: initialTimeData,
                        borderColor: ORANGE,
                        borderWidth: 2.5,
                        backgroundColor: gradientOrange,
                        fill: true,
                        tension: 0.45,
                        pointRadius: initialPointRadii,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: ORANGE,
                        pointBorderWidth: 3,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleColor: '#94a3b8',
                            bodyColor: '#ffffff',
                            cornerRadius: 8,
                            padding: 8,
                            displayColors: false,
                            callbacks: {
                                label: ctx => ` ${ctx.raw} Transaksi`
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: (ctx) => ({
                                    weight: (initialPeakIndex !== -1 && ctx.index === initialPeakIndex) ? 'bold' : 'normal',
                                    size: 10
                                }),
                                color: (ctx) => (initialPeakIndex !== -1 && ctx.index === initialPeakIndex) ? ORANGE : '#94a3b8'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            border: { dash: [4, 4] },
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                font: { size: 9 },
                                color: '#94a3b8',
                                precision: 0,
                                stepSize: initialMaxVal > 4 ? Math.ceil(initialMaxVal / 4) : 1
                            },
                            suggestedMax: Math.max(3, initialMaxVal + 1)
                        }
                    }
                }
            });

            // Dropdown listener untuk Waktu Transaksi
            const timeFilterBtn = document.getElementById('time-filter-btn');
            const timeFilterMenuEl = document.getElementById('time-filter-menu');

            if (timeFilterBtn && timeFilterMenuEl) {
                timeFilterBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    timeFilterMenuEl.classList.toggle('hidden');
                    if (trendFilterMenu) trendFilterMenu.classList.add('hidden');
                });
            }

            window.switchTimeMode = window.switchDashboardPeriod;

            // Global listener untuk menutup semua menu saat klik di luar
            document.addEventListener('click', (e) => {
                if (trendFilterBtn && trendFilterMenu && !trendFilterBtn.contains(e.target) && !trendFilterMenu.contains(e.target)) {
                    trendFilterMenu.classList.add('hidden');
                }
                if (timeFilterBtn && timeFilterMenuEl && !timeFilterBtn.contains(e.target) && !timeFilterMenuEl.contains(e.target)) {
                    timeFilterMenuEl.classList.add('hidden');
                }
            });

            // ==========================================
            // 5. PURPLE CARD SPARKLINE (Default: 6 Bulan Terakhir)
            // ==========================================
            const ctxSpark = document.getElementById('purpleSparklineChart').getContext('2d');
            const initialSparkData = purpleDatasets['months_6'].series;
            const initialSparkLabels = purpleDatasets['months_6'].labels;
            const maxSpark = Math.max(...initialSparkData);
            const peakSparkIndex = maxSpark > 0 ? initialSparkData.lastIndexOf(maxSpark) : -1;
            const sparkRadii = initialSparkData.map((v, i) => i === peakSparkIndex ? 4 : 0);

            const purpleChart = new Chart(ctxSpark, {
                type: 'line',
                data: {
                    labels: initialSparkLabels,
                    datasets: [{
                        data: initialSparkData,
                        borderColor: '#ffffff',
                        borderWidth: 2.2,
                        tension: 0.45,
                        pointRadius: sparkRadii,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#7c3aed',
                        pointBorderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#ffffff',
                            bodyColor: '#7c3aed',
                            titleColor: '#64748b',
                            displayColors: false,
                            cornerRadius: 8,
                            padding: 6,
                            bodyFont: { weight: 'bold' },
                            callbacks: {
                                label: ctx => ` ${ctx.raw} Transaksi`
                            }
                        }
                    },
                    scales: {
                        x: { display: false },
                        y: { display: false, beginAtZero: true }
                    }
                }
            });
        });
    </script>
</x-layout>
