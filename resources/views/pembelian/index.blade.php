<x-layout>
    <x-slot:title>
        Manajemen Pembelian Stok
    </x-slot:title>

    <div class="space-y-6 pb-12">
        <!-- ======================================================== -->
        <!-- NOTIFIKASI FLASH MESSAGE                                 -->
        <!-- ======================================================== -->
        @if (session('success'))
            <div id="success-alert" class="flex items-center justify-between p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl shadow-xs transition-all">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('success-alert').remove()" class="text-emerald-500 hover:text-emerald-700 p-1.5 rounded-lg hover:bg-emerald-100/50">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div id="error-alert" class="flex items-center justify-between p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl shadow-xs transition-all">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">{{ session('error') }}</p>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('error-alert').remove()" class="text-rose-500 hover:text-rose-700 p-1.5 rounded-lg hover:bg-rose-100/50">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div class="p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-2xl shadow-xs">
                <div class="flex items-center gap-2 mb-2 font-semibold text-sm">
                    <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>Perhatian: Terdapat kesalahan input form</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 text-amber-700">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- ======================================================== -->
        <!-- ROW 1: 4 TOP STAT CARDS                                  -->
        <!-- ======================================================== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            <!-- Card 1: Total Transaksi Pembelian -->
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-xs p-5 flex items-center justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ number_format($totalTransaksi) }}</h3>
                        <p class="text-xs font-medium text-slate-400 mt-0.5">Total Faktur Beli</p>
                    </div>
                </div>
            </div>

            <!-- Card 2: Total Biaya Pengeluaran -->
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-xs p-5 flex items-center justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                            @if ($totalPengeluaran >= 1000000000)
                                Rp {{ number_format($totalPengeluaran / 1000000000, 2, ',', '.') }} M
                            @elseif ($totalPengeluaran >= 1000000)
                                Rp {{ number_format($totalPengeluaran / 1000000, 1, ',', '.') }} jt
                            @else
                                Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                            @endif
                        </h3>
                        <p class="text-xs font-medium text-slate-400 mt-0.5">Total Pengeluaran</p>
                    </div>
                </div>
            </div>

            <!-- Card 3: Total Unit Barang Masuk -->
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-xs p-5 flex items-center justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ number_format($totalUnitMasuk) }}</h3>
                        <p class="text-xs font-medium text-slate-400 mt-0.5">Total Unit Masuk</p>
                    </div>
                </div>
            </div>

            <!-- Card 4: Pengeluaran Bulan Ini -->
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-xs p-5 flex items-center justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                            @if ($pembelianBulanIni >= 1000000)
                                Rp {{ number_format($pembelianBulanIni / 1000000, 1, ',', '.') }} jt
                            @else
                                Rp {{ number_format($pembelianBulanIni, 0, ',', '.') }}
                            @endif
                        </h3>
                        <p class="text-xs font-medium text-slate-400 mt-0.5">Bulan Ini ({{ date('M Y') }})</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- HEADER ACTIONS & FILTER TOOLBAR                          -->
        <!-- ======================================================== -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-slate-900">Riwayat Pembelian & Restock Barang</h1>
                    <p class="text-sm text-slate-500 mt-1">Catat transaksi kulakan stok barang masuk, harga beli supplier, dan update otomatis stok master.</p>
                </div>

                <!-- Tombol Catat Pembelian Baru -->
                <button id="btn-open-create-modal" type="button" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-xs hover:shadow-md transition shadow-indigo-500/20 cursor-pointer self-start md:self-auto shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Catat Pembelian Stok
                </button>
            </div>

            <!-- Filter Toolbar Form -->
            <form action="{{ route('pembelian.index') }}" method="GET" class="pt-4 border-t border-slate-100 flex flex-wrap items-center gap-3">
                <!-- Search input -->
                <div class="relative flex-1 min-w-[220px]">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari kode atau nama produk..." 
                        class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                    >
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <!-- Tanggal Mulai -->
                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-500 font-medium">Dari:</span>
                    <input 
                        type="date" 
                        name="start_date" 
                        value="{{ request('start_date') }}" 
                        class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                    >
                </div>

                <!-- Tanggal Selesai -->
                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-500 font-medium">Sampai:</span>
                    <input 
                        type="date" 
                        name="end_date" 
                        value="{{ request('end_date') }}" 
                        class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                    >
                </div>

                <!-- Tombol Submit Filter -->
                <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs sm:text-sm font-semibold transition cursor-pointer">
                    Filter
                </button>

                <!-- Reset Filter jika ada query -->
                @if(request('search') || request('start_date') || request('end_date'))
                    <a href="{{ route('pembelian.index') }}" class="px-3 py-2 text-xs sm:text-sm font-medium text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                        Reset Filter
                    </a>
                @endif
            </form>
        </div>

        <!-- ======================================================== -->
        <!-- DATA TABLE CARD                                          -->
        <!-- ======================================================== -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200/80 text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                            <th class="py-3.5 px-6">ID & Tanggal Masuk</th>
                            <th class="py-3.5 px-6">Produk / Barang</th>
                            <th class="py-3.5 px-6">Stok Master Saat Ini</th>
                            <th class="py-3.5 px-6">Jumlah Masuk</th>
                            <th class="py-3.5 px-6">Harga Satuan</th>
                            <th class="py-3.5 px-6">Total Pembelian</th>
                            <th class="py-3.5 px-6 text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse ($pembelian as $item)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <!-- ID & Tanggal Masuk -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs shrink-0">
                                            #{{ $item->id_pembelian }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-800">
                                                {{ $item->tanggal_masuk ? \Carbon\Carbon::parse($item->tanggal_masuk)->translatedFormat('d M Y') : '-' }}
                                            </p>
                                            <p class="text-[11px] text-slate-400">
                                                {{ $item->created_at ? $item->created_at->format('H:i') . ' WIB' : '' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Produk / Barang -->
                                <td class="py-4 px-6">
                                    @if ($item->product)
                                        <div class="font-semibold text-slate-900">{{ $item->product->nama_produk }}</div>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="inline-block px-1.5 py-0.5 rounded-md bg-slate-100 text-slate-600 font-mono text-[11px]">
                                                {{ $item->product->kode_produk }}
                                            </span>
                                            @if ($item->product->category)
                                                <span class="text-[11px] text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full font-medium">
                                                    {{ $item->product->category->nama_kategori }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-rose-500 italic text-xs font-medium">[Produk Telah Dihapus]</span>
                                    @endif
                                </td>

                                <!-- Stok Master Saat Ini -->
                                <td class="py-4 px-6">
                                    @if ($item->product)
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold text-slate-800">
                                                {{ number_format($item->product->stok_produk ?? 0) }}
                                            </span>
                                            <span class="text-xs text-slate-400">
                                                {{ $item->product->satuan_terkecil ?? 'pcs' }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>

                                <!-- Jumlah Masuk -->
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        +{{ number_format($item->jumlah_barang_masuk) }} {{ $item->product->satuan_terkecil ?? 'unit' }}
                                    </span>
                                </td>

                                <!-- Harga Satuan -->
                                <td class="py-4 px-6 font-medium text-slate-600">
                                    Rp {{ number_format($item->harga_beli_satuan ?? 0, 0, ',', '.') }}
                                </td>

                                <!-- Total Pembelian -->
                                <td class="py-4 px-6 font-bold text-indigo-900">
                                    Rp {{ number_format($item->total_harga_beli ?? 0, 0, ',', '.') }}
                                </td>

                                <!-- Tombol Aksi -->
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Icon Edit -->
                                        <button 
                                            type="button" 
                                            class="btn-open-edit-modal p-1.5 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded-lg transition cursor-pointer"
                                            title="Edit pembelian"
                                            data-id="{{ $item->id_pembelian }}"
                                            data-produk-id="{{ $item->id_produk }}"
                                            data-tanggal="{{ $item->tanggal_masuk ? \Carbon\Carbon::parse($item->tanggal_masuk)->format('Y-m-d') : '' }}"
                                            data-jumlah="{{ $item->jumlah_barang_masuk }}"
                                            data-harga="{{ $item->harga_beli_satuan }}"
                                            data-total="{{ $item->total_harga_beli }}"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </button>
                                        <!-- Icon Hapus -->
                                        <button 
                                            type="button" 
                                            class="btn-open-delete-modal p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition cursor-pointer"
                                            title="Hapus pembelian"
                                            data-id="{{ $item->id_pembelian }}"
                                            data-nama="{{ $item->product->nama_produk ?? 'Pembelian #' . $item->id_pembelian }}"
                                            data-jumlah="{{ $item->jumlah_barang_masuk }}"
                                            data-tanggal="{{ $item->tanggal_masuk ? \Carbon\Carbon::parse($item->tanggal_masuk)->format('d/m/Y') : '-' }}"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-14 text-center text-slate-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-400 flex items-center justify-center mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                        </div>
                                        <p class="font-semibold text-slate-800 text-base">Belum Ada Transaksi Pembelian Stok</p>
                                        <p class="text-xs text-slate-400 mt-1 max-w-sm">Klik tombol "Catat Pembelian Stok" di atas untuk menambahkan transaksi stok masuk dan memperbarui stok master produk secara otomatis.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            @if($pembelian->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $pembelian->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 1. MODAL TAMBAH PEMBELIAN STOK                           -->
    <!-- ======================================================== -->
    <div id="modal-create" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-200">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base">Catat Pembelian Stok Baru</h3>
                        <p class="text-xs text-slate-500">Stok master produk akan bertambah secara otomatis</p>
                    </div>
                </div>
                <button type="button" class="btn-close-modal text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Form -->
            <form action="{{ route('pembelian.store') }}" method="POST" class="p-6 space-y-4">
                @csrf

                <!-- Pilih Produk -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Pilih Produk <span class="text-rose-500">*</span>
                    </label>
                    <select id="create_id_produk" name="id_produk" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition">
                        <option value="">-- Pilih Produk --</option>
                        @foreach ($products as $p)
                            <option 
                                value="{{ $p->id_produk }}" 
                                data-stok="{{ $p->stok_produk ?? 0 }}"
                                data-harga-beli="{{ $p->harga_beli_terakhir ?? 0 }}"
                                data-satuan="{{ $p->satuan_terkecil ?? 'unit' }}"
                            >
                                {{ $p->nama_produk }} ({{ $p->kode_produk }}) - Stok: {{ $p->stok_produk ?? 0 }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Info Produk Terpilih (Badge Box) -->
                <div id="create_info_box" class="hidden p-3 bg-indigo-50/70 border border-indigo-100 rounded-xl text-xs text-indigo-900 flex items-center justify-between">
                    <div>
                        <span class="text-indigo-600 font-medium">Stok Saat Ini:</span>
                        <span id="create_preview_stok" class="font-bold ml-1">0 unit</span>
                    </div>
                    <div>
                        <span class="text-indigo-600 font-medium">Harga Terakhir:</span>
                        <span id="create_preview_harga" class="font-bold ml-1">Rp 0</span>
                    </div>
                </div>

                <!-- Tanggal Masuk -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Tanggal Masuk <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        name="tanggal_masuk" 
                        value="{{ date('Y-m-d') }}" 
                        required 
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                    >
                </div>

                <!-- Grid: Jumlah & Harga Beli -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Jumlah Masuk <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            id="create_jumlah" 
                            name="jumlah_barang_masuk" 
                            min="1" 
                            value="1" 
                            required 
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                            placeholder="Contoh: 10"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Harga Beli Satuan (Rp) <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            id="create_harga_satuan" 
                            name="harga_beli_satuan" 
                            min="0" 
                            step="any" 
                            required 
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                            placeholder="Contoh: 15000"
                        >
                    </div>
                </div>

                <!-- Total Estimasi Pembelian (Live Calculation Banner) -->
                <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl flex items-center justify-between">
                    <div>
                        <p class="text-xs font-extrabold text-slate-700 uppercase tracking-wider">Total Biaya Pembelian</p>
                        <p id="create_total_label" class="text-xl font-black text-indigo-700 mt-0.5">Rp 0</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-2 py-1 rounded-lg text-[11px] font-semibold bg-indigo-100 text-indigo-700">
                            Auto Calculate
                        </span>
                    </div>
                </div>

                <!-- Modal Actions -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" class="btn-close-modal px-4 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-xs hover:shadow-md transition shadow-indigo-500/20 cursor-pointer">
                        Simpan & Tambah Stok
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 2. MODAL EDIT PEMBELIAN STOK                             -->
    <!-- ======================================================== -->
    <div id="modal-edit" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-200">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base">Edit Transaksi Pembelian</h3>
                        <p class="text-xs text-slate-500">Perubahan jumlah akan otomatis menyesuaikan selisih stok</p>
                    </div>
                </div>
                <button type="button" class="btn-close-modal text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Form -->
            <form id="form-edit" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <!-- Pilih Produk -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Pilih Produk <span class="text-rose-500">*</span>
                    </label>
                    <select id="edit_id_produk" name="id_produk" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition">
                        <option value="">-- Pilih Produk --</option>
                        @foreach ($products as $p)
                            <option value="{{ $p->id_produk }}">
                                {{ $p->nama_produk }} ({{ $p->kode_produk }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal Masuk -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Tanggal Masuk <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        id="edit_tanggal_masuk" 
                        name="tanggal_masuk" 
                        required 
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                    >
                </div>

                <!-- Grid: Jumlah & Harga Beli -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Jumlah Masuk <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            id="edit_jumlah" 
                            name="jumlah_barang_masuk" 
                            min="1" 
                            required 
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Harga Beli Satuan (Rp) <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            id="edit_harga_satuan" 
                            name="harga_beli_satuan" 
                            min="0" 
                            step="any" 
                            required 
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                        >
                    </div>
                </div>

                <!-- Total Estimasi Pembelian -->
                <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl flex items-center justify-between">
                    <div>
                        <p class="text-xs font-extrabold text-slate-700 uppercase tracking-wider">Total Biaya Pembelian</p>
                        <p id="edit_total_label" class="text-xl font-black text-indigo-700 mt-0.5">Rp 0</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-2 py-1 rounded-lg text-[11px] font-semibold bg-amber-100 text-amber-700">
                            Terupdate
                        </span>
                    </div>
                </div>

                <!-- Modal Actions -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" class="btn-close-modal px-4 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-xs hover:shadow-md transition shadow-indigo-500/20 cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 3. MODAL HAPUS PEMBELIAN STOK                            -->
    <!-- ======================================================== -->
    <div id="modal-delete" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-200">
            <div class="p-6 text-center space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-slate-900">Konfirmasi Hapus Pembelian</h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Apakah Anda yakin ingin menghapus data pembelian stok produk <span id="delete_nama_produk" class="font-bold text-slate-800"></span>?
                    </p>
                    <div class="mt-3 p-3 bg-rose-50 border border-rose-100 rounded-xl text-xs text-rose-700 text-left">
                        <span class="font-bold">⚠️ Perhatian:</span> Menghapus transaksi ini akan secara otomatis mengurangi <span id="delete_jumlah_unit" class="font-bold">0</span> unit dari stok master produk.
                    </div>
                </div>

                <form id="form-delete" method="POST" class="flex items-center justify-center gap-3 pt-2">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn-close-modal px-4 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-xl shadow-xs hover:shadow-md transition shadow-rose-500/20 cursor-pointer">
                        Ya, Hapus Data
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- JAVASCRIPT MODAL & LIVE AUTO-CALCULATE                   -->
    <!-- ======================================================== -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Helper rupiah format
            function formatRupiah(amount) {
                return 'Rp ' + Number(amount || 0).toLocaleString('id-ID');
            }

            // MODAL OPEN / CLOSE CONTROLLERS
            const modalCreate = document.getElementById('modal-create');
            const modalEdit = document.getElementById('modal-edit');
            const modalDelete = document.getElementById('modal-delete');

            function closeModal() {
                modalCreate.classList.add('hidden');
                modalEdit.classList.add('hidden');
                modalDelete.classList.add('hidden');
            }

            // Close buttons
            document.querySelectorAll('.btn-close-modal').forEach(btn => {
                btn.addEventListener('click', closeModal);
            });

            // Close on backdrop click
            [modalCreate, modalEdit, modalDelete].forEach(modal => {
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) closeModal();
                });
            });

            // Close on Escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeModal();
            });

            // Open Create Modal
            const btnOpenCreate = document.getElementById('btn-open-create-modal');
            if (btnOpenCreate) {
                btnOpenCreate.addEventListener('click', function () {
                    modalCreate.classList.remove('hidden');
                });
            }

            // CREATE MODAL: Dynamic product select & live calculation
            const selectCreateProduk = document.getElementById('create_id_produk');
            const inputCreateJumlah = document.getElementById('create_jumlah');
            const inputCreateHarga = document.getElementById('create_harga_satuan');
            const labelCreateTotal = document.getElementById('create_total_label');
            const infoBox = document.getElementById('create_info_box');
            const previewStok = document.getElementById('create_preview_stok');
            const previewHarga = document.getElementById('create_preview_harga');

            function calculateCreateTotal() {
                const qty = parseFloat(inputCreateJumlah.value) || 0;
                const harga = parseFloat(inputCreateHarga.value) || 0;
                labelCreateTotal.textContent = formatRupiah(qty * harga);
            }

            if (selectCreateProduk) {
                selectCreateProduk.addEventListener('change', function () {
                    const selected = this.options[this.selectedIndex];
                    if (this.value) {
                        const stok = selected.getAttribute('data-stok') || '0';
                        const harga = selected.getAttribute('data-harga-beli') || '0';
                        const satuan = selected.getAttribute('data-satuan') || 'unit';

                        infoBox.classList.remove('hidden');
                        previewStok.textContent = `${stok} ${satuan}`;
                        previewHarga.textContent = formatRupiah(harga);

                        // If user hasn't typed price yet or it's 0, suggest last buy price
                        if (!inputCreateHarga.value || inputCreateHarga.value == 0) {
                            inputCreateHarga.value = harga;
                        }
                    } else {
                        infoBox.classList.add('hidden');
                    }
                    calculateCreateTotal();
                });
            }

            if (inputCreateJumlah) inputCreateJumlah.addEventListener('input', calculateCreateTotal);
            if (inputCreateHarga) inputCreateHarga.addEventListener('input', calculateCreateTotal);

            // EDIT MODAL: Open & populate
            const formEdit = document.getElementById('form-edit');
            const selectEditProduk = document.getElementById('edit_id_produk');
            const inputEditTanggal = document.getElementById('edit_tanggal_masuk');
            const inputEditJumlah = document.getElementById('edit_jumlah');
            const inputEditHarga = document.getElementById('edit_harga_satuan');
            const labelEditTotal = document.getElementById('edit_total_label');

            function calculateEditTotal() {
                const qty = parseFloat(inputEditJumlah.value) || 0;
                const harga = parseFloat(inputEditHarga.value) || 0;
                labelEditTotal.textContent = formatRupiah(qty * harga);
            }

            document.querySelectorAll('.btn-open-edit-modal').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const produkId = this.getAttribute('data-produk-id');
                    const tanggal = this.getAttribute('data-tanggal');
                    const jumlah = this.getAttribute('data-jumlah');
                    const harga = this.getAttribute('data-harga');

                    formEdit.action = `/pembelian-stok/${id}`;
                    selectEditProduk.value = produkId;
                    inputEditTanggal.value = tanggal;
                    inputEditJumlah.value = jumlah;
                    inputEditHarga.value = harga;

                    calculateEditTotal();
                    modalEdit.classList.remove('hidden');
                });
            });

            if (inputEditJumlah) inputEditJumlah.addEventListener('input', calculateEditTotal);
            if (inputEditHarga) inputEditHarga.addEventListener('input', calculateEditTotal);

            // DELETE MODAL: Open & configure form
            const formDelete = document.getElementById('form-delete');
            const labelDeleteNama = document.getElementById('delete_nama_produk');
            const labelDeleteJumlah = document.getElementById('delete_jumlah_unit');

            document.querySelectorAll('.btn-open-delete-modal').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const nama = this.getAttribute('data-nama');
                    const jumlah = this.getAttribute('data-jumlah');

                    formDelete.action = `/pembelian-stok/${id}`;
                    labelDeleteNama.textContent = `"${nama}"`;
                    labelDeleteJumlah.textContent = jumlah;

                    modalDelete.classList.remove('hidden');
                });
            });
        });
    </script>
</x-layout>
