<x-layout>
    <x-slot:title>Kasir / Point of Sale</x-slot:title>

    <div class="flex flex-col lg:flex-row gap-5 h-full">

        <!-- ============================================ -->
        <!-- KIRI: DAFTAR PRODUK (KATALOG)               -->
        <!-- ============================================ -->
        <div class="flex-1 flex flex-col gap-4 min-w-0">

            <!-- Baris Kontrol Kasir (Cari Produk + Filter Kategori + Riwayat Transaksi dalam 1 Baris) -->
            <div class="flex items-center gap-2.5 sm:gap-3">
                <!-- 1. Cari Nama atau Kode Produk -->
                <div class="relative flex-1 min-w-0">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input
                        type="text"
                        id="product-search"
                        placeholder="Cari nama atau kode produk..."
                        class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-xs sm:text-sm shadow-xs focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 transition"
                        autocomplete="off"
                        autofocus
                    >
                </div>

                <!-- 2. Dropdown Filter Kategori (Model Dropdown Pill seperti 6 Bulan Terakhir) -->
                <div class="relative inline-block text-left shrink-0" id="kasir-category-wrapper">
                    <button id="kasir-category-btn" type="button" class="flex items-center gap-2 text-xs sm:text-sm text-slate-700 bg-white border border-slate-200 px-3.5 sm:px-4 py-2.5 rounded-2xl font-medium cursor-pointer hover:bg-slate-50 hover:border-indigo-300 transition shadow-xs whitespace-nowrap">
                        <span id="kasir-category-label">Semua Kategori</span>
                        <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200" id="kasir-category-chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="kasir-category-menu" class="absolute right-0 mt-1.5 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 hidden z-30 text-xs max-h-72 overflow-y-auto">
                        <button type="button" onclick="selectCategory('all', 'Semua Kategori')" class="kasir-cat-item w-full text-left px-4 py-2.5 hover:bg-indigo-50/50 font-bold text-indigo-600 cursor-pointer flex items-center justify-between" data-cat="all">
                            <span>Semua Kategori</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] bg-indigo-100 text-indigo-700 font-mono">{{ $products->count() }}</span>
                        </button>
                        @foreach ($categories as $cat)
                        <button type="button" onclick="selectCategory('{{ $cat->id_kategori }}', '{{ addslashes($cat->nama_kategori) }}')" class="kasir-cat-item w-full text-left px-4 py-2.5 hover:bg-slate-50 font-medium text-slate-700 cursor-pointer flex items-center justify-between" data-cat="{{ $cat->id_kategori }}">
                            <span class="truncate">{{ $cat->nama_kategori }}</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] bg-slate-100 text-slate-500 font-mono">{{ $cat->products_count }}</span>
                        </button>
                        @endforeach
                        @if (isset($uncategorizedCount) && $uncategorizedCount > 0)
                        <button type="button" onclick="selectCategory('uncategorized', 'Tanpa Kategori')" class="kasir-cat-item w-full text-left px-4 py-2.5 hover:bg-slate-50 font-medium text-slate-700 cursor-pointer flex items-center justify-between" data-cat="uncategorized">
                            <span>Tanpa Kategori</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] bg-slate-100 text-slate-500 font-mono">{{ $uncategorizedCount }}</span>
                        </button>
                        @endif
                    </div>
                </div>

                <!-- 3. Riwayat Transaksi -->
                <a href="{{ route('kasir.riwayat') }}" class="inline-flex items-center gap-1.5 sm:gap-2 px-3.5 sm:px-4 py-2.5 bg-white border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/50 text-slate-700 hover:text-indigo-600 rounded-2xl text-xs sm:text-sm font-semibold shadow-xs transition shrink-0 cursor-pointer whitespace-nowrap">
                    <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="hidden sm:inline">Riwayat Transaksi</span>
                    <span class="sm:hidden">Riwayat</span>
                </a>
            </div>

            <!-- Produk Grid -->
            <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-3 overflow-y-auto" style="max-height: calc(100vh - 220px);">
                @forelse ($products as $p)
                    <button
                        type="button"
                        class="product-card bg-white rounded-2xl border border-slate-200 text-left hover:border-indigo-300 hover:shadow-md hover:-translate-y-0.5 active:scale-95 transition-all cursor-pointer flex flex-col group overflow-hidden"
                        data-id="{{ $p->id_produk }}"
                        data-nama="{{ $p->nama_produk }}"
                        data-kode="{{ $p->kode_produk }}"
                        data-kategori="{{ $p->id_kategori ?? 'uncategorized' }}"
                        data-kategori-nama="{{ $p->category?->nama_kategori ?? 'Tanpa Kategori' }}"
                        data-harga="{{ $p->harga_jual }}"
                        data-harga-beli="{{ $p->harga_beli_terakhir ?? 0 }}"
                        data-stok="{{ $p->stok_produk }}"
                        data-satuan="{{ $p->satuan_terkecil ?? 'pcs' }}"
                    >
                        <!-- Foto Produk -->
                        <div class="w-full h-24 bg-slate-100 overflow-hidden shrink-0 flex items-center justify-center relative">
                            @if($p->foto_produk)
                                <img
                                    src="{{ Storage::url($p->foto_produk) }}"
                                    alt="{{ $p->nama_produk }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                >
                            @else
                                <div class="w-full h-full bg-indigo-50 flex items-center justify-center group-hover:bg-indigo-100 transition">
                                    <svg class="w-8 h-8 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 8-7-4-7 4v8l7 4 7-4zM12 22V12m9-4-9 4-9-4"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Info Produk -->
                        <div class="p-3 flex flex-col gap-1 flex-1">
                            <!-- Kategori -->
                            @if ($p->category)
                                <span class="text-[10px] font-semibold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md self-start truncate max-w-full" title="{{ $p->category->nama_kategori }}">
                                    {{ $p->category->nama_kategori }}
                                </span>
                            @endif

                            <!-- Nama & Kode -->
                            <p class="text-xs font-bold text-slate-800 leading-snug line-clamp-2">{{ $p->nama_produk }}</p>
                            <p class="text-[10px] font-mono text-indigo-500 font-semibold">{{ $p->kode_produk }}</p>

                            <!-- Harga & Stok -->
                            <div class="mt-auto pt-1.5 border-t border-slate-100 flex items-end justify-between gap-1">
                                <p class="text-sm font-extrabold text-slate-900">Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</p>
                                <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded-full {{ $p->stok_produk <= ($p->stok_minimum ?? 0) ? 'bg-rose-50 text-rose-600' : 'bg-emerald-50 text-emerald-600' }} shrink-0">
                                    {{ $p->stok_produk }} {{ $p->satuan_terkecil ?? 'pcs' }}
                                </span>
                            </div>
                        </div>
                    </button>
                @empty
                    <div class="col-span-full py-12 text-center text-slate-400 text-sm">
                        <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m21 8-7-4-7 4v8l7 4 7-4zM12 22V12m9-4-9 4-9-4"/></svg>
                        </div>
                        <p class="font-semibold text-slate-600">Belum ada produk dengan stok tersedia</p>
                        <p class="text-xs mt-1">Tambahkan produk terlebih dahulu melalui menu Data Produk.</p>
                    </div>
                @endforelse

                <!-- State saat filter kategori / pencarian tidak menemukan hasil -->
                <div id="no-products-found" class="col-span-full py-12 text-center text-slate-400 text-sm hidden">
                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                    </div>
                    <p class="font-semibold text-slate-600">Tidak ada produk ditemukan</p>
                    <p class="text-xs mt-1 text-slate-400" id="no-products-msg">Tidak ada produk yang cocok dengan kategori atau pencarian saat ini.</p>
                    <button type="button" id="btn-reset-filter" class="mt-3 px-3.5 py-1.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-xl text-xs font-semibold transition cursor-pointer">
                        Reset Filter &amp; Tampilkan Semua
                    </button>
                </div>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- KANAN: KERANJANG BELANJA (CART)             -->
        <!-- ============================================ -->
        <div class="w-full lg:w-80 xl:w-96 flex flex-col gap-3 shrink-0">

            <!-- Cart Header -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900">Keranjang Belanja</h3>
                    </div>
                    <button id="btn-clear-cart" type="button" class="text-xs text-rose-500 hover:text-rose-700 font-semibold px-2 py-1 rounded-lg hover:bg-rose-50 transition cursor-pointer">
                        Kosongkan
                    </button>
                </div>
            </div>

            <!-- Cart Items -->
            <div id="cart-items" class="bg-white rounded-2xl border border-slate-200 shadow-xs flex flex-col overflow-hidden" style="max-height: 360px; min-height: 160px;">
                <!-- Empty State -->
                <div id="cart-empty" class="flex flex-col items-center justify-center py-10 text-slate-400 text-xs gap-2">
                    <svg class="w-8 h-8 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272"/>
                    </svg>
                    <p class="font-medium text-slate-500">Keranjang masih kosong</p>
                    <p class="text-center">Klik produk di kiri untuk menambahkan</p>
                </div>
                <!-- Items will be injected here by JS -->
                <div id="cart-list" class="overflow-y-auto divide-y divide-slate-100 hidden"></div>
            </div>

            <!-- Ringkasan Harga -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-4 space-y-3">
                <div class="flex justify-between text-sm text-slate-600">
                    <span>Jumlah Item</span>
                    <span id="summary-item-count" class="font-semibold text-slate-800">0 item</span>
                </div>
                <div class="flex justify-between text-sm text-slate-600">
                    <span>Subtotal</span>
                    <span id="summary-subtotal" class="font-semibold text-slate-800">Rp 0</span>
                </div>
                <div class="border-t border-slate-100 pt-3 flex justify-between text-base font-extrabold text-slate-900">
                    <span>Total Bayar</span>
                    <span id="summary-total">Rp 0</span>
                </div>

                <!-- Input Uang Diterima -->
                <div class="space-y-1.5 pt-1">
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider">Uang Diterima</label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm font-semibold text-slate-500">Rp</span>
                        <input
                            type="number"
                            id="uang-diterima"
                            placeholder="0"
                            class="w-full pl-10 pr-4 py-3 text-sm font-bold text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                            min="0"
                            inputmode="numeric"
                        >
                    </div>

                    <!-- Shortcut bayar cepat -->
                    <div class="grid grid-cols-5 gap-1.5 pt-1">
                        @foreach([5000, 10000, 20000, 50000] as $nominal)
                            <button type="button" class="btn-quick-pay text-xs font-semibold py-1.5 bg-slate-100 hover:bg-indigo-100 hover:text-indigo-700 rounded-lg transition cursor-pointer" data-amount="{{ $nominal }}">
                                {{ number_format($nominal/1000, 0) }}rb
                            </button>
                        @endforeach
                        <button type="button" id="btn-bayar-lunas" class="text-xs font-bold py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-lg transition cursor-pointer" title="Bayar Uang Pas / Lunas">
                            Lunas
                        </button>
                    </div>
                </div>

                <!-- Kembalian -->
                <div class="bg-emerald-50 border border-emerald-100 rounded-xl px-4 py-3 flex justify-between items-center">
                    <span class="text-sm font-semibold text-emerald-700">Kembalian</span>
                    <span id="kembalian-display" class="text-base font-extrabold text-emerald-700">Rp 0</span>
                </div>

                <!-- Tombol Bayar -->
                <button
                    id="btn-bayar"
                    type="button"
                    class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 disabled:bg-slate-300 disabled:cursor-not-allowed text-white font-bold text-sm rounded-2xl shadow-xs shadow-indigo-500/20 transition cursor-pointer flex items-center justify-center gap-2"
                    disabled
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <span id="btn-bayar-label">Bayar Sekarang</span>
                </button>

                <!-- Link ke Riwayat -->
                <a href="{{ route('kasir.riwayat') }}" class="flex items-center justify-center gap-1.5 text-xs text-slate-500 hover:text-indigo-600 transition font-medium pt-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Lihat Riwayat Transaksi
                </a>
            </div>
        </div>
    </div>

    <!-- ================================================ -->
    <!-- MODAL STRUK / BUKTI TRANSAKSI BERHASIL          -->
    <!-- ================================================ -->
    <div id="receipt-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden" role="dialog">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>
        <div class="relative w-full max-w-sm bg-white rounded-3xl shadow-2xl z-10 overflow-hidden">
            <!-- Header struk -->
            <div class="bg-gradient-to-r from-indigo-600 to-violet-600 p-6 text-center text-white">
                <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h3 class="text-xl font-extrabold">Transaksi Berhasil!</h3>
                <p id="receipt-invoice" class="text-indigo-200 text-xs mt-1 font-mono"></p>
            </div>

            <!-- Body struk -->
            <div class="p-6 space-y-4">
                <div id="receipt-items" class="space-y-2 text-sm border-b border-dashed border-slate-200 pb-4"></div>

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-slate-600">
                        <span>Total Bayar</span>
                        <span id="receipt-total" class="font-bold text-slate-900"></span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Uang Diterima</span>
                        <span id="receipt-diterima" class="font-bold text-slate-900"></span>
                    </div>
                    <div class="flex justify-between text-base font-extrabold text-emerald-700 pt-1 border-t border-slate-100">
                        <span>Kembalian</span>
                        <span id="receipt-kembalian"></span>
                    </div>
                </div>

                <div class="text-center text-xs text-slate-400 pt-1">
                    <p>{{ now()->format('d/m/Y H:i') }} &bull; {{ session('account_name', 'Kasir') }}</p>
                    <p class="mt-1 font-semibold">Terima kasih telah berbelanja! 🛍️</p>
                </div>

                <div class="flex gap-2 pt-2">
                    <button id="btn-print-receipt" type="button" class="flex-1 py-3 bg-slate-900 hover:bg-black text-white font-bold text-xs rounded-2xl flex items-center justify-center gap-1.5 transition cursor-pointer shadow-md">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Cetak Struk
                    </button>
                    <button id="btn-close-receipt" type="button" class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-2xl transition cursor-pointer shadow-md shadow-indigo-600/30">
                        Transaksi Baru
                    </button>
                </div>
            </div>
        </div>
    <!-- ================================================ -->
    <!-- MODAL POP-OUT CETAK STRUK & PILIH UKURAN        -->
    <!-- ================================================ -->
    <div id="modal-print-popout" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 hidden" role="dialog">
        <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs transition-opacity" onclick="closePrintPopout()"></div>
        
        <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl z-10 overflow-hidden flex flex-col max-h-[92vh] border border-slate-200">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Cetak Struk Transaksi</h3>
                        <p id="popout-invoice-label" class="text-xs font-mono text-indigo-600 font-semibold"></p>
                    </div>
                </div>
                <button type="button" onclick="closePrintPopout()" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-200/60 flex items-center justify-center transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Toolbar Pilih Ukuran Kertas -->
            <div class="p-4 bg-slate-50/80 border-b border-slate-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold text-slate-700">1. Pilih Ukuran Kertas Thermal:</span>
                    <span class="text-[11px] font-semibold text-indigo-600" id="paper-size-indicator">Ukuran Aktif: 58 mm</span>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <!-- Tombol 58mm -->
                    <button type="button" onclick="selectPopoutSize('58')" id="popout-btn-58" class="flex items-center gap-2.5 p-3 rounded-2xl border-2 border-indigo-600 bg-white text-indigo-950 font-semibold text-xs shadow-xs transition cursor-pointer">
                        <div class="w-4 h-4 rounded-full border-2 border-indigo-600 flex items-center justify-center shrink-0">
                            <span class="w-2 h-2 rounded-full bg-indigo-600" id="popout-dot-58"></span>
                        </div>
                        <div class="text-left">
                            <p class="font-bold">58 mm (Standar)</p>
                            <p class="text-[10px] text-slate-500 font-normal">Printer Thermal Mini / Kasir</p>
                        </div>
                    </button>

                    <!-- Tombol 80mm -->
                    <button type="button" onclick="selectPopoutSize('80')" id="popout-btn-80" class="flex items-center gap-2.5 p-3 rounded-2xl border-2 border-slate-200 bg-slate-50 text-slate-700 font-semibold text-xs transition cursor-pointer hover:bg-white">
                        <div class="w-4 h-4 rounded-full border-2 border-slate-300 flex items-center justify-center shrink-0">
                            <span class="w-2 h-2 rounded-full bg-transparent" id="popout-dot-80"></span>
                        </div>
                        <div class="text-left">
                            <p class="font-bold">80 mm (Lebar)</p>
                            <p class="text-[10px] text-slate-500 font-normal">Printer Thermal Lebar POS</p>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Pratinjau Kertas Struk (Iframe) -->
            <div class="p-4 flex-1 overflow-y-auto bg-slate-100/70 flex flex-col items-center justify-start min-h-[320px]">
                <p class="text-[11px] font-semibold text-slate-500 mb-2">2. Pratinjau Tampilan Struk:</p>
                <div class="w-full bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex justify-center p-2">
                    <iframe id="popout-print-iframe" class="w-full h-[320px] border-0" src="about:blank"></iframe>
                </div>
            </div>

            <!-- Modal Footer (Kolom Cetak Struk) -->
            <div class="p-4 bg-white border-t border-slate-200 flex items-center justify-between gap-3">
                <button type="button" onclick="closePrintPopout()" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="button" onclick="executePrint()" id="btn-execute-print" class="flex-1 py-3 px-5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-md shadow-indigo-600/30 flex items-center justify-center gap-2 transition cursor-pointer hover:scale-[1.01] active:scale-95">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span id="btn-execute-print-label">Cetak Struk Sekarang (58 mm)</span>
                </button>
            </div>
        </div>
    </div>

    <!-- =============================== -->
    <!-- SCRIPT POS                      -->
    <!-- =============================== -->
    <script>
        // Cart state
        let cart = {};  // { id_produk: { nama, harga, stok, satuan, jumlah } }

        const cartList        = document.getElementById('cart-list');
        const cartEmpty       = document.getElementById('cart-empty');
        const summaryCount    = document.getElementById('summary-item-count');
        const summarySubtotal = document.getElementById('summary-subtotal');
        const summaryTotal    = document.getElementById('summary-total');
        const uangInput       = document.getElementById('uang-diterima');
        const kembalianDisplay= document.getElementById('kembalian-display');
        const btnBayar        = document.getElementById('btn-bayar');
        const btnBayarLabel   = document.getElementById('btn-bayar-label');
        const receiptModal    = document.getElementById('receipt-modal');
        const productSearch   = document.getElementById('product-search');
        const productGrid     = document.getElementById('product-grid');

        // Format rupiah
        const rp = (n) => 'Rp ' + Number(n).toLocaleString('id-ID');

        // ---- Add product to cart ----
        document.querySelectorAll('.product-card').forEach(btn => {
            btn.addEventListener('click', () => addToCart(btn));
        });

        function addToCart(btn) {
            const id      = btn.dataset.id;
            const stok    = parseInt(btn.dataset.stok);
            if (cart[id] && cart[id].jumlah >= stok) {
                showToast(`Stok "${btn.dataset.nama}" tidak mencukupi`, 'warning');
                return;
            }
            if (!cart[id]) {
                cart[id] = {
                    id_produk : id,
                    nama      : btn.dataset.nama,
                    kode      : btn.dataset.kode,
                    harga     : parseFloat(btn.dataset.harga),
                    hargaBeli : parseFloat(btn.dataset.hargaBeli),
                    stok      : stok,
                    satuan    : btn.dataset.satuan,
                    jumlah    : 0,
                };
            }
            cart[id].jumlah++;
            renderCart();
            // Visual feedback on card
            btn.classList.add('ring-2', 'ring-indigo-400');
            setTimeout(() => btn.classList.remove('ring-2', 'ring-indigo-400'), 300);
        }

        // ---- Render cart ----
        function renderCart() {
            cartList.innerHTML = '';
            const ids = Object.keys(cart);

            if (ids.length === 0) {
                cartEmpty.classList.remove('hidden');
                cartList.classList.add('hidden');
            } else {
                cartEmpty.classList.add('hidden');
                cartList.classList.remove('hidden');

                ids.forEach(id => {
                    const item = cart[id];
                    const subtotal = item.harga * item.jumlah;
                    const row = document.createElement('div');
                    row.className = 'flex items-center gap-3 px-4 py-2.5';
                    row.innerHTML = `
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-800 truncate">${item.nama}</p>
                            <p class="text-[10px] text-slate-400 font-mono">${item.kode} &bull; ${rp(item.harga)}</p>
                        </div>
                        <div class="flex items-center gap-1.5 shrink-0">
                            <button type="button" onclick="changeQty('${id}', -1)" class="w-6 h-6 rounded-lg bg-slate-100 hover:bg-rose-100 hover:text-rose-600 text-slate-600 font-bold text-sm flex items-center justify-center transition cursor-pointer">−</button>
                            <span class="w-7 text-center text-xs font-extrabold text-slate-900">${item.jumlah}</span>
                            <button type="button" onclick="changeQty('${id}', 1)" class="w-6 h-6 rounded-lg bg-slate-100 hover:bg-indigo-100 hover:text-indigo-600 text-slate-600 font-bold text-sm flex items-center justify-center transition cursor-pointer">+</button>
                        </div>
                        <div class="text-right shrink-0 w-20">
                            <p class="text-xs font-extrabold text-slate-900">${rp(subtotal)}</p>
                        </div>
                    `;
                    cartList.appendChild(row);
                });
            }

            // Update summary
            const totalItems = ids.reduce((sum, id) => sum + cart[id].jumlah, 0);
            const total = ids.reduce((sum, id) => sum + cart[id].harga * cart[id].jumlah, 0);

            summaryCount.textContent    = `${totalItems} item`;
            summarySubtotal.textContent = rp(total);
            summaryTotal.textContent    = rp(total);
            updateKembalian();
        }

        // ---- Change qty ----
        function changeQty(id, delta) {
            if (!cart[id]) return;
            cart[id].jumlah += delta;
            if (cart[id].jumlah <= 0) delete cart[id];
            renderCart();
        }

        // ---- Clear cart ----
        document.getElementById('btn-clear-cart').addEventListener('click', () => {
            cart = {};
            uangInput.value = '';
            renderCart();
        });

        // ---- Quick pay buttons ----
        document.querySelectorAll('.btn-quick-pay').forEach(btn => {
            btn.addEventListener('click', () => {
                const total = getTotal();
                const current = parseFloat(uangInput.value) || 0;
                uangInput.value = current + parseInt(btn.dataset.amount);
                updateKembalian();
            });
        });

        // ---- Tombol Lunas (Uang Pas: uang diterima = total bayar) ----
        const btnLunas = document.getElementById('btn-bayar-lunas');
        if (btnLunas) {
            btnLunas.addEventListener('click', () => {
                const total = getTotal();
                if (total > 0) {
                    uangInput.value = total;
                    updateKembalian();
                }
            });
        }

        // ---- Uang diterima input ----
        uangInput.addEventListener('input', updateKembalian);

        function getTotal() {
            return Object.keys(cart).reduce((sum, id) => sum + cart[id].harga * cart[id].jumlah, 0);
        }

        function updateKembalian() {
            const total = getTotal();
            const diterima = parseFloat(uangInput.value) || 0;
            const kembalian = diterima - total;
            const isEmpty = Object.keys(cart).length === 0;

            if (!isEmpty && diterima >= total) {
                kembalianDisplay.textContent = rp(kembalian);
                kembalianDisplay.classList.remove('text-rose-600');
                kembalianDisplay.classList.add('text-emerald-700');
                btnBayar.disabled = false;
                btnBayarLabel.textContent = `Bayar ${rp(total)}`;
            } else if (!isEmpty && diterima > 0 && diterima < total) {
                kembalianDisplay.textContent = `Kurang ${rp(total - diterima)}`;
                kembalianDisplay.classList.remove('text-emerald-700');
                kembalianDisplay.classList.add('text-rose-600');
                btnBayar.disabled = true;
                btnBayarLabel.textContent = 'Bayar Sekarang';
            } else {
                kembalianDisplay.textContent = rp(0);
                kembalianDisplay.classList.remove('text-rose-600');
                kembalianDisplay.classList.add('text-emerald-700');
                btnBayar.disabled = (isEmpty || !diterima || diterima < total);
                btnBayarLabel.textContent = 'Bayar Sekarang';
            }
        }

        // ---- Category & Search Filter Logic ----
        let activeCategory = 'all';

        function filterProducts() {
            const query = (productSearch.value || '').toLowerCase().trim();
            const cards = document.querySelectorAll('.product-card');
            const noProductsFound = document.getElementById('no-products-found');
            let visibleCount = 0;

            cards.forEach(card => {
                const nama = (card.dataset.nama || '').toLowerCase();
                const kode = (card.dataset.kode || '').toLowerCase();
                const cardKategori = card.dataset.kategori;

                const matchesSearch = !query || nama.includes(query) || kode.includes(query);
                const matchesCategory = (activeCategory === 'all') || (cardKategori === activeCategory);

                if (matchesSearch && matchesCategory) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (noProductsFound) {
                if (cards.length > 0 && visibleCount === 0) {
                    noProductsFound.classList.remove('hidden');
                } else {
                    noProductsFound.classList.add('hidden');
                }
            }
        }

        // Category Dropdown Toggle & Selection Logic
        const catBtn = document.getElementById('kasir-category-btn');
        const catMenu = document.getElementById('kasir-category-menu');
        const catChevron = document.getElementById('kasir-category-chevron');
        const catLabel = document.getElementById('kasir-category-label');

        if (catBtn && catMenu) {
            catBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const isHidden = catMenu.classList.contains('hidden');
                catMenu.classList.toggle('hidden', !isHidden);
                if (catChevron) {
                    catChevron.style.transform = isHidden ? 'rotate(180deg)' : '';
                }
            });

            document.addEventListener('click', (e) => {
                if (!catBtn.contains(e.target) && !catMenu.contains(e.target)) {
                    catMenu.classList.add('hidden');
                    if (catChevron) catChevron.style.transform = '';
                }
            });
        }

        window.selectCategory = function(catId, label) {
            activeCategory = catId;
            if (catLabel) catLabel.textContent = label;
            if (catMenu) catMenu.classList.add('hidden');
            if (catChevron) catChevron.style.transform = '';

            // Update item styles in menu
            document.querySelectorAll('.kasir-cat-item').forEach(item => {
                if (item.dataset.cat === String(catId)) {
                    item.className = 'kasir-cat-item w-full text-left px-4 py-2.5 hover:bg-indigo-50/50 font-bold text-indigo-600 cursor-pointer flex items-center justify-between';
                } else {
                    item.className = 'kasir-cat-item w-full text-left px-4 py-2.5 hover:bg-slate-50 font-medium text-slate-700 cursor-pointer flex items-center justify-between';
                }
            });

            filterProducts();
        };

        // Search input event
        productSearch.addEventListener('input', filterProducts);

        // Reset filter button
        const btnResetFilter = document.getElementById('btn-reset-filter');
        if (btnResetFilter) {
            btnResetFilter.addEventListener('click', () => {
                productSearch.value = '';
                selectCategory('all', 'Semua Kategori');
                productSearch.focus();
            });
        }

        // Keyboard Shortcut F1 to focus search
        document.addEventListener('keydown', (e) => {
            if (e.key === 'F1') {
                e.preventDefault();
                productSearch.focus();
                productSearch.select();
            }
        });

        // ---- Process Payment ----
        btnBayar.addEventListener('click', async () => {
            const ids = Object.keys(cart);
            if (ids.length === 0) return;

            const total    = getTotal();
            const diterima = parseFloat(uangInput.value) || 0;
            if (diterima < total) return;

            const items = ids.map(id => ({
                id_produk : cart[id].id_produk,
                jumlah    : cart[id].jumlah,
            }));

            btnBayar.disabled = true;
            btnBayarLabel.textContent = 'Memproses...';

            try {
                const response = await fetch('{{ route("kasir.store") }}', {
                    method  : 'POST',
                    headers : {
                        'Content-Type'     : 'application/json',
                        'X-CSRF-TOKEN'     : document.querySelector('meta[name="csrf-token"]')?.content
                                           || '{{ csrf_token() }}',
                        'Accept'           : 'application/json',
                    },
                    body: JSON.stringify({ items, uang_diterima: diterima }),
                });

                const data = await response.json();

                if (data.success) {
                    showReceipt(data, items);
                } else {
                    showToast(data.message || 'Transaksi gagal.', 'error');
                    btnBayar.disabled = false;
                    btnBayarLabel.textContent = `Bayar ${rp(total)}`;
                }
            } catch (e) {
                showToast('Terjadi kesalahan koneksi.', 'error');
                btnBayar.disabled = false;
                btnBayarLabel.textContent = `Bayar ${rp(total)}`;
            }
        });

        // ---- Show receipt modal ----
        let lastSaleId = null;

        function showReceipt(data, items) {
            lastSaleId = data.id_penjualan || data.no_invoice;
            document.getElementById('receipt-invoice').textContent   = data.no_invoice;
            document.getElementById('receipt-total').textContent     = rp(data.total);
            document.getElementById('receipt-diterima').textContent  = rp(data.diterima);
            document.getElementById('receipt-kembalian').textContent = rp(data.kembalian);

            const itemsHtml = Object.keys(cart).map(id => {
                const item = cart[id];
                return `<div class="flex justify-between text-xs">
                    <span class="text-slate-700">${item.nama} ×${item.jumlah}</span>
                    <span class="font-semibold text-slate-900">${rp(item.harga * item.jumlah)}</span>
                </div>`;
            }).join('');
            document.getElementById('receipt-items').innerHTML = itemsHtml;

            receiptModal.classList.remove('hidden');
        }

        // ---- POPOUT PRINT RECEIPT MODAL LOGIC ----
        let popoutSaleId = null;
        let selectedPaperSize = '58';

        function openPrintPopout(id, invoiceNo) {
            popoutSaleId = id;
            selectedPaperSize = '58';
            document.getElementById('popout-invoice-label').textContent = invoiceNo || '';
            
            // Set initial button states
            updatePaperSizeUI('58');

            // Load iframe
            const iframe = document.getElementById('popout-print-iframe');
            iframe.src = `{{ url('/kasir/print') }}/${id}?embedded=1&size=58`;

            // Show popout modal
            document.getElementById('modal-print-popout').classList.remove('hidden');
        }

        function closePrintPopout() {
            document.getElementById('modal-print-popout').classList.add('hidden');
            const iframe = document.getElementById('popout-print-iframe');
            iframe.src = 'about:blank';
        }

        function selectPopoutSize(size) {
            selectedPaperSize = size;
            updatePaperSizeUI(size);

            const iframe = document.getElementById('popout-print-iframe');
            if (iframe && iframe.contentWindow) {
                if (typeof iframe.contentWindow.setPaperSize === 'function') {
                    iframe.contentWindow.setPaperSize(size);
                } else {
                    iframe.contentWindow.postMessage({ action: 'setSize', size: size }, '*');
                }
            }
        }

        function updatePaperSizeUI(size) {
            const btn58 = document.getElementById('popout-btn-58');
            const btn80 = document.getElementById('popout-btn-80');
            const dot58 = document.getElementById('popout-dot-58');
            const dot80 = document.getElementById('popout-dot-80');
            const indicator = document.getElementById('paper-size-indicator');
            const btnLabel = document.getElementById('btn-execute-print-label');

            if (size === '80') {
                btn80.className = 'flex items-center gap-2.5 p-3 rounded-2xl border-2 border-indigo-600 bg-white text-indigo-950 font-semibold text-xs shadow-xs transition cursor-pointer';
                dot80.className = 'w-2 h-2 rounded-full bg-indigo-600';
                btn80.querySelector('div').className = 'w-4 h-4 rounded-full border-2 border-indigo-600 flex items-center justify-center shrink-0';

                btn58.className = 'flex items-center gap-2.5 p-3 rounded-2xl border-2 border-slate-200 bg-slate-50 text-slate-700 font-semibold text-xs transition cursor-pointer hover:bg-white';
                dot58.className = 'w-2 h-2 rounded-full bg-transparent';
                btn58.querySelector('div').className = 'w-4 h-4 rounded-full border-2 border-slate-300 flex items-center justify-center shrink-0';

                indicator.textContent = 'Ukuran Aktif: 80 mm';
                btnLabel.textContent = 'Cetak Struk Sekarang (80 mm)';
            } else {
                btn58.className = 'flex items-center gap-2.5 p-3 rounded-2xl border-2 border-indigo-600 bg-white text-indigo-950 font-semibold text-xs shadow-xs transition cursor-pointer';
                dot58.className = 'w-2 h-2 rounded-full bg-indigo-600';
                btn58.querySelector('div').className = 'w-4 h-4 rounded-full border-2 border-indigo-600 flex items-center justify-center shrink-0';

                btn80.className = 'flex items-center gap-2.5 p-3 rounded-2xl border-2 border-slate-200 bg-slate-50 text-slate-700 font-semibold text-xs transition cursor-pointer hover:bg-white';
                dot80.className = 'w-2 h-2 rounded-full bg-transparent';
                btn80.querySelector('div').className = 'w-4 h-4 rounded-full border-2 border-slate-300 flex items-center justify-center shrink-0';

                indicator.textContent = 'Ukuran Aktif: 58 mm';
                btnLabel.textContent = 'Cetak Struk Sekarang (58 mm)';
            }
        }

        function executePrint() {
            const iframe = document.getElementById('popout-print-iframe');
            if (iframe && iframe.contentWindow) {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
            } else {
                showToast('Gagal memuat pratinjau struk.', 'error');
            }
        }

        // ---- Cetak Struk Thermal ----
        document.getElementById('btn-print-receipt').addEventListener('click', () => {
            if (lastSaleId) {
                const invoiceNo = document.getElementById('receipt-invoice').textContent;
                openPrintPopout(lastSaleId, invoiceNo);
            } else {
                showToast('ID Transaksi tidak ditemukan.', 'warning');
            }
        });

        // ---- Close receipt & reset ----
        document.getElementById('btn-close-receipt').addEventListener('click', () => {
            receiptModal.classList.add('hidden');
            // Reset semua
            cart = {};
            uangInput.value = '';
            renderCart();
            productSearch.value = '';
            document.querySelectorAll('.product-card').forEach(c => c.style.display = '');
            // Reload product stocks
            window.location.reload();
        });

        // ---- Toast helper ----
        function showToast(msg, type = 'info') {
            const colors = {
                info    : 'bg-slate-800 text-white',
                warning : 'bg-amber-500 text-white',
                error   : 'bg-rose-600 text-white',
                success : 'bg-emerald-600 text-white',
            };
            const toast = document.createElement('div');
            toast.className = `fixed bottom-6 right-6 z-[99] px-4 py-3 rounded-2xl text-sm font-semibold shadow-xl ${colors[type]} transition`;
            toast.textContent = msg;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3500);
        }

        // Initial render
        renderCart();
    </script>
</x-layout>
