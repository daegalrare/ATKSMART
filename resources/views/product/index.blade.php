<x-layout>
    <x-slot:title>
        Manajemen Data Produk
    </x-slot:title>

    <div class="space-y-6">
        <!-- Success Alert Notification -->
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

        <!-- Error Alert Notification -->
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

        <!-- Header Actions & Search Bar -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Katalog Produk</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola data master barang, stok minimum, serta harga beli dan jual.</p>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <!-- Search Form -->
                <form action="{{ route('product.index') }}" method="GET" class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari kode atau nama produk..." 
                        class="w-full sm:w-64 pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                    >
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    @if(request('search'))
                        <a href="{{ route('product.index') }}" class="absolute right-3 top-3 text-xs text-slate-400 hover:text-slate-600">✕</a>
                    @endif
                </form>

                <!-- Tombol Tambah Produk -->
                <button id="btn-open-create-modal" type="button" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-xs transition shadow-indigo-500/20 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Produk
                </button>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200/80 text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                            <th class="py-3.5 px-6">Kode & Nama Produk</th>
                            <th class="py-3.5 px-6">Kategori</th>
                            <th class="py-3.5 px-6">Stok Saat Ini</th>
                            <th class="py-3.5 px-6">Satuan</th>
                            <th class="py-3.5 px-6">Harga Beli</th>
                            <th class="py-3.5 px-6">Harga Jual</th>
                            <th class="py-3.5 px-6 text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse ($products as $item)
                            <tr class="hover:bg-slate-50/60 transition {{ request('edit') == $item->id_produk ? 'bg-amber-50/70 border-l-4 border-amber-500' : '' }}">
                                <!-- Kode & Nama -->
                                <td class="py-4 px-6">
                                    <div class="flex flex-col gap-1">
                                        <span class="font-bold text-slate-900 text-[15px] leading-tight">{{ $item->nama_produk }}</span>
                                        <span class="inline-flex items-center gap-1 font-mono text-xs font-bold text-indigo-600 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded-md w-fit">
                                            <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                                            {{ $item->kode_produk }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Kategori -->
                                <td class="py-4 px-6">
                                    @if($item->category)
                                        <div class="inline-flex items-center gap-1.5">
                                            <x-category-icon :name="$item->category->nama_kategori" class="w-6 h-6 rounded-lg" icon-class="w-3.5 h-3.5" />
                                            <span class="text-xs font-semibold text-slate-800">
                                                {{ $item->category->nama_kategori }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Tanpa Kategori</span>
                                    @endif
                                </td>

                                <!-- Stok -->
                                <td class="py-4 px-6">
                                    @php
                                        $isLowStock = ($item->stok_minimum !== null && $item->stok_produk <= $item->stok_minimum);
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold {{ $isLowStock ? 'text-rose-600' : 'text-slate-800' }}">
                                            {{ $item->stok_produk ?? 0 }}
                                        </span>
                                        @if($isLowStock)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-200 animate-pulse">
                                                Stok Menipis
                                            </span>
                                        @endif
                                    </div>
                                    <span class="text-[11px] text-slate-400">Min: {{ $item->stok_minimum ?? 0 }}</span>
                                </td>

                                <!-- Satuan -->
                                <td class="py-4 px-6 text-slate-600">
                                    {{ $item->satuan_terkecil ?? 'pcs' }}
                                    @if($item->satuan_besar)
                                        <div class="text-[11px] text-slate-400">({{ $item->isi_per_satuan_besar ?? 1 }} / {{ $item->satuan_besar }})</div>
                                    @endif
                                </td>

                                <!-- Harga Beli -->
                                <td class="py-4 px-6 text-slate-600 font-medium">
                                    Rp {{ number_format($item->harga_beli_terakhir ?? 0, 0, ',', '.') }}
                                </td>

                                <!-- Harga Jual -->
                                <td class="py-4 px-6 font-bold text-slate-900">
                                    Rp {{ number_format($item->harga_jual ?? 0, 0, ',', '.') }}
                                </td>

                                <!-- Tombol Aksi -->
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Icon Edit -->
                                        <button 
                                            type="button" 
                                            class="btn-open-edit-modal p-1.5 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded-lg transition cursor-pointer"
                                            title="Edit produk"
                                            data-id="{{ $item->id_produk }}"
                                            data-kode="{{ $item->kode_produk }}"
                                            data-nama="{{ $item->nama_produk }}"
                                            data-kategori="{{ $item->id_kategori }}"
                                            data-satuan-terkecil="{{ $item->satuan_terkecil }}"
                                            data-satuan-besar="{{ $item->satuan_besar }}"
                                            data-isi="{{ $item->isi_per_satuan_besar }}"
                                            data-lokasi="{{ $item->lokasi_produk }}"
                                            data-stok-min="{{ $item->stok_minimum }}"
                                            data-stok="{{ $item->stok_produk }}"
                                            data-harga-beli="{{ $item->harga_beli_terakhir }}"
                                            data-harga-jual="{{ $item->harga_jual }}"
                                            data-foto="{{ $item->foto_produk ? Storage::url($item->foto_produk) : '' }}"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </button>
                                        <!-- Icon Hapus -->
                                        <button 
                                            type="button" 
                                            class="btn-open-delete-modal p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition cursor-pointer"
                                            title="Hapus produk"
                                            data-id="{{ $item->id_produk }}"
                                            data-nama="{{ $item->nama_produk }}"
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
                                <td colspan="7" class="py-12 text-center text-slate-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m21 8-7-4-7 4v8l7 4 7-4zM12 22V12m9-4-9 4-9-4"/>
                                            </svg>
                                        </div>
                                        <p class="font-medium text-slate-700">Belum ada produk yang ditemukan</p>
                                        <p class="text-xs text-slate-400 mt-0.5">Tambahkan data produk baru menggunakan tombol di atas.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            @if($products->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 1. MODAL TAMBAH PRODUK (CREATE DIALOG BOX) -->
    <!-- ========================================== -->
    <div id="create-product-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 {{ ($errors->any() && !old('_method')) ? '' : 'hidden' }}" role="dialog" aria-modal="true">
        <div class="modal-backdrop fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>
        <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all z-10 max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-slate-100 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Tambah Produk Baru</h3>
                        <p class="text-xs text-slate-500">Lengkapi formulir untuk menambahkan produk baru.</p>
                    </div>
                </div>
                <button type="button" class="btn-close-create p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Form Body -->
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 overflow-y-auto">
                @csrf

                <!-- Kode & Kategori -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Kode Produk <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="kode_produk" 
                            value="{{ old('kode_produk') }}"
                            placeholder="Contoh: BRG-001" 
                            class="w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition {{ $errors->has('kode_produk') ? 'border-rose-400 bg-rose-50/20' : 'border-slate-200' }}"
                            required
                        >
                        @error('kode_produk') <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Kategori
                        </label>
                        <select 
                            name="id_kategori" 
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                        >
                            <option value="">Pilih Kategori...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id_kategori }}" {{ old('id_kategori') == $cat->id_kategori ? 'selected' : '' }}>
                                    {{ $cat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Nama Produk -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nama Produk <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="nama_produk" 
                        value="{{ old('nama_produk') }}"
                        placeholder="Contoh: Buku Tulis Sinar Dunia 58 Lembar" 
                        class="w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition {{ $errors->has('nama_produk') ? 'border-rose-400 bg-rose-50/20' : 'border-slate-200' }}"
                        required
                    >
                    @error('nama_produk') <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <!-- Harga Beli & Harga Jual -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Harga Beli (Rp)
                        </label>
                        <input 
                            type="number" 
                            name="harga_beli_terakhir" 
                            value="{{ old('harga_beli_terakhir') }}"
                            placeholder="0" 
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                        >
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Harga Jual (Rp) <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="harga_jual" 
                            value="{{ old('harga_jual') }}"
                            placeholder="0" 
                            class="w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition {{ $errors->has('harga_jual') ? 'border-rose-400 bg-rose-50/20' : 'border-slate-200' }}"
                            required
                        >
                        @error('harga_jual') <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Stok & Stok Minimal -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Stok Awal
                        </label>
                        <input 
                            type="number" 
                            name="stok_produk" 
                            value="{{ old('stok_produk', 0) }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                        >
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Stok Minimum (Alert)
                        </label>
                        <input 
                            type="number" 
                            name="stok_minimum" 
                            value="{{ old('stok_minimum', 5) }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                        >
                    </div>
                </div>

                <!-- Satuan & Lokasi Rak -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Satuan
                        </label>
                        <input 
                            type="text" 
                            name="satuan_terkecil" 
                            value="{{ old('satuan_terkecil', 'pcs') }}"
                            placeholder="Contoh: pcs, botol, rim" 
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                        >
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Lokasi Rak / Etalase
                        </label>
                        <input 
                            type="text" 
                            name="lokasi_produk" 
                            value="{{ old('lokasi_produk') }}"
                            placeholder="Contoh: Rak A-1" 
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                        >
                    </div>
                </div>

                <!-- Opsi Tambahan Satuan Besar (Collapsible/Accordion) -->
                <details class="group border border-slate-200 rounded-xl p-3 bg-slate-50/50">
                    <summary class="flex items-center justify-between text-xs font-semibold text-slate-600 cursor-pointer select-none">
                        <span>Opsi Satuan Grosir / Dus (Opsional)</span>
                        <svg class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </summary>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-3 pt-3 border-t border-slate-200">
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Satuan Besar</label>
                            <input type="text" name="satuan_besar" value="{{ old('satuan_besar') }}" placeholder="Dus, Box, Slop" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Isi per Satuan Besar</label>
                            <input type="number" name="isi_per_satuan_besar" value="{{ old('isi_per_satuan_besar') }}" placeholder="Contoh: 12" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm">
                        </div>
                    </div>
                </details>

                <!-- Foto Produk (Wajib) -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Foto Produk <span class="text-rose-500">*</span>
                        </label>
                        <span class="text-[11px] font-medium text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/>
                            </svg>
                            Fitur Zoom &amp; Crop
                        </span>
                    </div>

                    <!-- Placeholder / Upload Box -->
                    <div
                        id="create-foto-placeholder"
                        class="border-2 border-dashed rounded-2xl cursor-pointer transition-all p-6 text-center {{ $errors->has('foto_produk') ? 'border-rose-400 bg-rose-50/20' : 'border-slate-200 bg-slate-50/70 hover:border-indigo-400 hover:bg-indigo-50/30' }}"
                        onclick="document.getElementById('foto_produk_input').click()"
                    >
                        <div class="w-12 h-12 rounded-2xl bg-indigo-100/70 text-indigo-600 flex items-center justify-center mx-auto mb-2 shadow-xs">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                            </svg>
                        </div>
                        <p class="text-xs font-bold text-slate-700">Klik untuk upload foto produk</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">JPG, PNG, WEBP — Setelah dipilih, Anda bisa atur posisi, zoom in/out &amp; crop</p>
                    </div>

                    <!-- Preview Area with Action Buttons -->
                    <div id="create-foto-preview" class="hidden border border-slate-200 rounded-2xl p-3 bg-white shadow-xs">
                        <div class="w-full h-44 bg-slate-900 rounded-xl overflow-hidden flex items-center justify-center relative">
                            <img id="create-foto-img" src="" alt="Preview" class="max-w-full max-h-full object-contain">
                        </div>

                        <!-- Preview Tampilan Kasir -->
                        <div class="mt-3 p-2.5 bg-slate-50 border border-slate-200 rounded-xl">
                            <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider mb-2">🛒 Preview Tampilan Kasir</p>
                            <div class="flex items-start gap-3">
                                <div class="w-28 shrink-0">
                                    <div class="w-full aspect-[4/3] bg-white rounded-xl border border-slate-200 overflow-hidden flex items-center justify-center shadow-xs">
                                        <img id="create-kasir-preview-img" src="" class="w-full h-full object-contain p-1 hidden">
                                        <div id="create-kasir-preview-placeholder" class="flex items-center justify-center w-full h-full text-slate-300">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 6h16.5"/></svg>
                                        </div>
                                    </div>
                                    <p class="text-center text-[9px] text-slate-400 mt-1">Foto Produk</p>
                                </div>
                                <div class="flex-1 min-w-0 py-0.5">
                                    <span class="text-[9px] font-semibold text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded-md inline-block mb-1">Kategori</span>
                                    <p class="text-[11px] font-bold text-slate-800 leading-snug truncate">Nama Produk</p>
                                    <div class="mt-1.5 pt-1 border-t border-slate-100 flex items-end justify-between gap-1">
                                        <p class="text-xs font-extrabold text-slate-900">Rp 0</p>
                                        <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded-full bg-emerald-50 text-emerald-600">0 pcs</span>
                                    </div>
                                    <p class="text-[9px] text-slate-400 mt-1.5 italic">Tampilan di halaman kasir</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 mt-2.5">
                            <button
                                type="button"
                                id="btn-recrop-create"
                                class="flex-1 py-2 px-3 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 cursor-pointer"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/>
                                </svg>
                                Atur &amp; Crop Foto
                            </button>
                            <button
                                type="button"
                                onclick="document.getElementById('foto_produk_input').click()"
                                class="py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition flex items-center gap-1 cursor-pointer"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                </svg>
                                Ganti
                            </button>
                        </div>
                    </div>

                    <input type="file" name="foto_produk" id="foto_produk_input" accept="image/*" class="hidden" required>
                    @error('foto_produk') <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <!-- Modal Actions -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" class="btn-close-create px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-xs shadow-indigo-500/20 transition cursor-pointer">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================== -->
    <!-- 2. MODAL EDIT PRODUK (EDIT DIALOG BOX)   -->
    <!-- ======================================== -->
    <div id="edit-product-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 {{ ($errors->any() && old('_method') === 'PUT') ? '' : 'hidden' }}" role="dialog" aria-modal="true">
        <div class="modal-backdrop fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>
        <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all z-10 max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-slate-100 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Edit Data Produk</h3>
                        <p class="text-xs text-slate-500">Perbarui informasi barang, stok, atau harga jual.</p>
                    </div>
                </div>
                <button type="button" class="btn-close-edit p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Form Body -->
            <form id="edit-product-form" action="" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 overflow-y-auto">
                @csrf
                @method('PUT')

                <!-- Kode & Kategori -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Kode Produk <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="kode_produk" 
                            id="edit_kode_produk"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Kategori
                        </label>
                        <select 
                            name="id_kategori" 
                            id="edit_id_kategori"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                        >
                            <option value="">Pilih Kategori...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id_kategori }}">{{ $cat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Nama Produk -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nama Produk <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="nama_produk" 
                        id="edit_nama_produk"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                        required
                    >
                </div>

                <!-- Harga Beli & Jual -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Harga Beli (Rp)
                        </label>
                        <input 
                            type="number" 
                            name="harga_beli_terakhir" 
                            id="edit_harga_beli_terakhir"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                        >
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Harga Jual (Rp) <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="harga_jual" 
                            id="edit_harga_jual"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                            required
                        >
                    </div>
                </div>

                <!-- Stok & Stok Minimal -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Stok Saat Ini
                        </label>
                        <input 
                            type="number" 
                            name="stok_produk" 
                            id="edit_stok_produk"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                        >
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Stok Minimum
                        </label>
                        <input 
                            type="number" 
                            name="stok_minimum" 
                            id="edit_stok_minimum"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                        >
                    </div>
                </div>

                <!-- Satuan & Lokasi Rak -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Satuan
                        </label>
                        <input 
                            type="text" 
                            name="satuan_terkecil" 
                            id="edit_satuan_terkecil"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                        >
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Lokasi Rak / Etalase
                        </label>
                        <input 
                            type="text" 
                            name="lokasi_produk" 
                            id="edit_lokasi_produk"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                        >
                    </div>
                </div>

                <!-- Opsi Tambahan Satuan Besar (Collapsible/Accordion) -->
                <details class="group border border-slate-200 rounded-xl p-3 bg-slate-50/50">
                    <summary class="flex items-center justify-between text-xs font-semibold text-slate-600 cursor-pointer select-none">
                        <span>Opsi Satuan Grosir / Dus (Opsional)</span>
                        <svg class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </summary>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-3 pt-3 border-t border-slate-200">
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Satuan Besar</label>
                            <input type="text" name="satuan_besar" id="edit_satuan_besar" placeholder="Dus, Box, Slop" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Isi per Satuan Besar</label>
                            <input type="number" name="isi_per_satuan_besar" id="edit_isi_per_satuan_besar" placeholder="Contoh: 12" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm">
                        </div>
                    </div>
                </details>

                <!-- Foto Produk (Opsional saat edit) -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Foto Produk <span class="text-slate-400 font-normal text-[10px] normal-case">(kosongkan jika tidak ingin mengganti)</span>
                        </label>
                        <span class="text-[11px] font-medium text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/>
                            </svg>
                            Fitur Zoom &amp; Crop
                        </span>
                    </div>

                    <!-- Placeholder / Upload Box when no photo -->
                    <div
                        id="edit-foto-placeholder"
                        class="border-2 border-dashed border-slate-200 bg-slate-50/70 hover:border-indigo-400 hover:bg-indigo-50/30 rounded-2xl cursor-pointer transition-all p-6 text-center"
                        onclick="document.getElementById('edit_foto_produk_input').click()"
                    >
                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                            </svg>
                        </div>
                        <p class="text-xs font-bold text-slate-700" id="edit-foto-label">Klik untuk upload foto produk</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">JPG, PNG, WEBP — Maks. 2MB</p>
                    </div>

                    <!-- Preview Area with Action Buttons -->
                    <div id="edit-foto-preview" class="hidden border border-slate-200 rounded-2xl p-3 bg-white shadow-xs">
                        <div class="w-full h-44 bg-slate-900 rounded-xl overflow-hidden flex items-center justify-center relative">
                            <img id="edit-foto-img" src="" alt="Preview" class="max-w-full max-h-full object-contain">
                        </div>
                        <div class="flex items-center gap-2 mt-2.5">
                            <button
                                type="button"
                                id="btn-recrop-edit"
                                class="flex-1 py-2 px-3 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 cursor-pointer"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/>
                                </svg>
                                Atur &amp; Crop Foto
                            </button>
                            <button
                                type="button"
                                onclick="document.getElementById('edit_foto_produk_input').click()"
                                class="py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition flex items-center gap-1 cursor-pointer"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                </svg>
                                Ganti
                            </button>
                        </div>
                    </div>

                    <input type="file" name="foto_produk" id="edit_foto_produk_input" accept="image/*" class="hidden">
                </div>

                <!-- Modal Actions -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" class="btn-close-edit px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-xs shadow-indigo-500/20 transition cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 3. MODAL KONFIRMASI HAPUS (DELETE CONFIRMATION DIALOG)   -->
    <!-- ======================================================== -->
    <div id="delete-confirm-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 hidden" role="dialog" aria-modal="true">
        <div class="modal-backdrop fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>
        <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border border-slate-100 p-6 overflow-hidden transform transition-all z-10 text-center">
            
            <!-- Warning Icon -->
            <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto mb-4 border border-rose-100 shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>

            <!-- Title & Description -->
            <h3 class="text-lg font-bold text-slate-900 mb-1.5">Konfirmasi Hapus Produk</h3>
            <p class="text-sm text-slate-500 mb-4">
                Apakah Anda yakin ingin menghapus produk <br>
                <strong id="delete-product-name" class="text-slate-800 font-semibold"></strong>?
            </p>
            <p class="text-xs text-rose-500 bg-rose-50/60 border border-rose-100 p-2.5 rounded-xl mb-6">
                Peringatan: Data yang telah dihapus tidak dapat dipulihkan kembali.
            </p>

            <!-- Form Action -->
            <form id="delete-product-form" action="" method="POST" class="flex items-center justify-center gap-3">
                @csrf
                @method('DELETE')

                <!-- Tombol Tidak / Batal -->
                <button 
                    type="button" 
                    class="btn-close-delete w-1/2 py-2.5 text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition cursor-pointer"
                >
                    Tidak, Batal
                </button>

                <!-- Tombol Ya, Hapus -->
                <button 
                    type="submit" 
                    class="w-1/2 py-2.5 text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-xs shadow-rose-500/25 transition cursor-pointer"
                >
                    Ya, Hapus Data
                </button>
            </form>
        </div>
    </div>

    <!-- ====================================================== -->
    <!-- 4. MODAL CROP & ZOOM FOTO PRODUK (CROPPER.JS)          -->
    <!-- ====================================================== -->
    <div id="cropper-modal-overlay" class="fixed inset-0 z-[9999] hidden items-center justify-center p-3 sm:p-5 bg-slate-900/80 backdrop-blur-sm">
        <div class="relative w-full max-w-xl bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-100 flex flex-col" style="max-height: 92vh;">

            <!-- Header -->
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Sesuaikan &amp; Crop Foto Produk</h3>
                        <p class="text-xs text-slate-500">Geser untuk pindah posisi • Gunakan tombol / scroll untuk zoom in &amp; zoom out</p>
                    </div>
                </div>
                <button id="cropper-btn-cancel" type="button" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Cropper Canvas Area -->
            <div class="cropper-modal-box overflow-hidden bg-slate-900 flex items-center justify-center" style="height: 380px; max-height: 50vh;">
                <img id="cropper-image" src="" alt="Foto Produk" style="max-width: 100%; display: block;">
            </div>

            <!-- Toolbar Buttons -->
            <div class="px-5 py-3 border-t border-b border-slate-100 bg-slate-50 shrink-0">
                <div class="flex items-center justify-center gap-2 flex-wrap">
                    <!-- Zoom In -->
                    <button id="cropper-btn-zoom-in" type="button" class="cropper-toolbar-btn" title="Perbesar (Zoom In)">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6"/>
                        </svg>
                    </button>
                    <!-- Zoom Out -->
                    <button id="cropper-btn-zoom-out" type="button" class="cropper-toolbar-btn" title="Perkecil (Zoom Out)">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM13.5 10.5h-6"/>
                        </svg>
                    </button>

                    <div class="w-px h-6 bg-slate-200"></div>

                    <!-- Ratio 1:1 -->
                    <button id="cropper-btn-ratio-1-1" type="button" class="cropper-ratio-btn px-2.5 h-[38px] rounded-xl text-xs font-bold border border-indigo-200 bg-indigo-50 text-indigo-600 transition cursor-pointer" title="Rasio 1:1 (Kotak - Rekomendasi Kasir)">
                        1:1 Kotak
                    </button>
                    <!-- Ratio 4:3 -->
                    <button id="cropper-btn-ratio-4-3" type="button" class="cropper-ratio-btn px-2.5 h-[38px] rounded-xl text-xs font-semibold border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 transition cursor-pointer" title="Rasio 4:3 (Landscape)">
                        4:3
                    </button>
                    <!-- Ratio Free -->
                    <button id="cropper-btn-ratio-free" type="button" class="cropper-ratio-btn px-2.5 h-[38px] rounded-xl text-xs font-semibold border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 transition cursor-pointer" title="Rasio Bebas">
                        Bebas
                    </button>

                    <div class="w-px h-6 bg-slate-200"></div>

                    <!-- Rotate Left -->
                    <button id="cropper-btn-rotate-left" type="button" class="cropper-toolbar-btn" title="Putar Kiri 90°">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3"/>
                        </svg>
                    </button>
                    <!-- Rotate Right -->
                    <button id="cropper-btn-rotate-right" type="button" class="cropper-toolbar-btn" title="Putar Kanan 90°">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m15 15 6-6m0 0-6-6m6 6H9a6 6 0 0 0 0 12h3"/>
                        </svg>
                    </button>
                    <!-- Flip Horizontal -->
                    <button id="cropper-btn-flip-h" type="button" class="cropper-toolbar-btn" title="Balik Horizontal">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/>
                        </svg>
                    </button>

                    <div class="w-px h-6 bg-slate-200"></div>

                    <!-- Reset -->
                    <button id="cropper-btn-reset" type="button" class="cropper-toolbar-btn" title="Reset ke Awal">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 px-5 py-4 shrink-0">
                <button id="cropper-btn-cancel-bottom" type="button" class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button id="cropper-btn-confirm" type="button" class="px-6 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-xs shadow-indigo-500/25 transition cursor-pointer flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                    </svg>
                    Gunakan Foto Ini
                </button>
            </div>
        </div>
    </div>

    <!-- Modals & Cropper Script -->
    <script>
        // Modal references
        const createModal = document.getElementById('create-product-modal');
        const editModal = document.getElementById('edit-product-modal');
        const deleteModal = document.getElementById('delete-confirm-modal');

        // Open Create Modal
        const btnOpenCreate = document.getElementById('btn-open-create-modal');
        if (btnOpenCreate) {
            btnOpenCreate.addEventListener('click', () => {
                createModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });
        }

        // Close Create Modal
        document.querySelectorAll('.btn-close-create, #create-product-modal .modal-backdrop').forEach(el => {
            el.addEventListener('click', () => {
                createModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            });
        });

        // Open Edit Modal & Populate Form
        document.querySelectorAll('.btn-open-edit-modal').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const form = document.getElementById('edit-product-form');
                form.action = `/product/${id}`;

                document.getElementById('edit_kode_produk').value = btn.dataset.kode || '';
                document.getElementById('edit_nama_produk').value = btn.dataset.nama || '';
                document.getElementById('edit_id_kategori').value = btn.dataset.kategori || '';
                document.getElementById('edit_satuan_terkecil').value = btn.dataset.satuanTerkecil || '';
                document.getElementById('edit_satuan_besar').value = btn.dataset.satuanBesar || '';
                document.getElementById('edit_isi_per_satuan_besar').value = btn.dataset.isi || '';
                document.getElementById('edit_lokasi_produk').value = btn.dataset.lokasi || '';
                document.getElementById('edit_stok_minimum').value = btn.dataset.stokMin || '';
                document.getElementById('edit_stok_produk').value = btn.dataset.stok || '';
                document.getElementById('edit_harga_beli_terakhir').value = btn.dataset.hargaBeli || '';
                document.getElementById('edit_harga_jual').value = btn.dataset.hargaJual || '';

                // Reset foto input & show existing photo if available
                document.getElementById('edit_foto_produk_input').value = '';
                const existingFoto = btn.dataset.foto || '';
                const editPreview = document.getElementById('edit-foto-preview');
                const editPlaceholder = document.getElementById('edit-foto-placeholder');
                const editImg = document.getElementById('edit-foto-img');
                if (existingFoto) {
                    editImg.src = existingFoto;
                    editPreview.classList.remove('hidden');
                    editPlaceholder.classList.add('hidden');
                } else {
                    editImg.src = '';
                    editPreview.classList.add('hidden');
                    editPlaceholder.classList.remove('hidden');
                }

                editModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });
        });

        // Auto-open Edit Modal jika diarahkan dari dashboard/notifikasi stok (?edit=ID)
        const urlParams = new URLSearchParams(window.location.search);
        const autoEditId = urlParams.get('edit');
        if (autoEditId) {
            const targetBtn = document.querySelector(`.btn-open-edit-modal[data-id="${autoEditId}"]`);
            if (targetBtn) {
                setTimeout(() => {
                    targetBtn.click();
                    const stokInput = document.getElementById('edit_stok_produk');
                    if (stokInput) {
                        stokInput.focus();
                        stokInput.select();
                    }
                }, 120);
            }
        }

        // Close Edit Modal
        document.querySelectorAll('.btn-close-edit, #edit-product-modal .modal-backdrop').forEach(el => {
            el.addEventListener('click', () => {
                editModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            });
        });

        // Open Delete Confirmation Modal
        document.querySelectorAll('.btn-open-delete-modal').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const nama = btn.dataset.nama;

                document.getElementById('delete-product-name').textContent = `"${nama}"`;
                document.getElementById('delete-product-form').action = `/product/${id}`;

                deleteModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });
        });

        // Close Delete Modal
        document.querySelectorAll('.btn-close-delete, #delete-confirm-modal .modal-backdrop').forEach(el => {
            el.addEventListener('click', () => {
                deleteModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            });
        });

        // Close on Escape Key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const cropperOverlay = document.getElementById('cropper-modal-overlay');
                if (!cropperOverlay.classList.contains('hidden')) {
                    cropperOverlay.classList.add('hidden');
                    cropperOverlay.classList.remove('flex');
                    return;
                }
                createModal.classList.add('hidden');
                editModal.classList.add('hidden');
                deleteModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });

        // ============================================================
        // ADVANCED IMAGE CROPPER & ZOOM ENGINE (CROPPER.JS)
        // ============================================================
        let cropperInstance  = null;
        let cropperFileInput = null;
        let cropperMode      = null;   // 'create' | 'edit'
        let cropperScaleX    = 1;
        let currentImgSource = '';

        const overlay = document.getElementById('cropper-modal-overlay');
        const cropImg = document.getElementById('cropper-image');

        function startCropper(imageSrc, fileInput, mode) {
            cropperFileInput = fileInput;
            cropperMode      = mode;
            currentImgSource = imageSrc;

            if (cropperInstance) {
                cropperInstance.destroy();
                cropperInstance = null;
            }

            cropImg.src = imageSrc;
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
            document.body.classList.add('overflow-hidden');

            cropperInstance = new Cropper(cropImg, {
                aspectRatio: 4 / 3,         // 4:3 sesuai tampilan kasir
                viewMode: 0,                // viewMode 0: bebas zoom in & zoom out tanpa batas
                dragMode: 'move',
                autoCropArea: 0.88,
                responsive: true,
                restore: false,
                guides: true,
                center: true,
                highlight: true,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
            });
            cropperScaleX = 1;
        }

        function closeCropper() {
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
            if (cropperInstance) {
                cropperInstance.destroy();
                cropperInstance = null;
            }
            cropImg.src = '';
            cropperScaleX = 1;
            document.body.classList.add('overflow-hidden');
        }

        function applyCroppedResult(blob, originalName) {
            const mimeType = blob.type || 'image/jpeg';
            const ext = mimeType.split('/')[1] || 'jpg';
            const fileName = (originalName || 'foto-produk').replace(/\.[^.]+$/, '') + '-crop.' + ext;
            const croppedFile = new File([blob], fileName, { type: mimeType });

            if (cropperFileInput) {
                try {
                    const dt = new DataTransfer();
                    dt.items.add(croppedFile);
                    cropperFileInput.files = dt.files;
                } catch (e) {
                    console.warn('DataTransfer unavailable:', e);
                }
            }

            const objectUrl = URL.createObjectURL(blob);

            if (cropperMode === 'create') {
                document.getElementById('create-foto-img').src = objectUrl;
                document.getElementById('create-foto-preview').classList.remove('hidden');
                document.getElementById('create-foto-placeholder').classList.add('hidden');
                // Update preview kasir
                const kasirImg = document.getElementById('create-kasir-preview-img');
                const kasirPh  = document.getElementById('create-kasir-preview-placeholder');
                if (kasirImg) {
                    kasirImg.src = objectUrl;
                    kasirImg.classList.remove('hidden');
                    if (kasirPh) kasirPh.classList.add('hidden');
                }
            } else {
                document.getElementById('edit-foto-img').src = objectUrl;
                document.getElementById('edit-foto-preview').classList.remove('hidden');
                document.getElementById('edit-foto-placeholder').classList.add('hidden');
            }
        }

        // Toolbar: Zoom In & Out
        document.getElementById('cropper-btn-zoom-in').addEventListener('click', () => {
            if (cropperInstance) cropperInstance.zoom(0.1);
        });
        document.getElementById('cropper-btn-zoom-out').addEventListener('click', () => {
            if (cropperInstance) cropperInstance.zoom(-0.1);
        });

        // Toolbar: Rotate
        document.getElementById('cropper-btn-rotate-left').addEventListener('click', () => {
            if (cropperInstance) cropperInstance.rotate(-90);
        });
        document.getElementById('cropper-btn-rotate-right').addEventListener('click', () => {
            if (cropperInstance) cropperInstance.rotate(90);
        });

        // Toolbar: Flip
        document.getElementById('cropper-btn-flip-h').addEventListener('click', () => {
            if (!cropperInstance) return;
            cropperScaleX = (cropperScaleX === 1) ? -1 : 1;
            cropperInstance.scaleX(cropperScaleX);
        });

        // Toolbar: Reset
        document.getElementById('cropper-btn-reset').addEventListener('click', () => {
            if (cropperInstance) cropperInstance.reset();
        });

        // Toolbar: Ratio Buttons
        const ratioBtns = document.querySelectorAll('.cropper-ratio-btn');
        function setActiveRatioBtn(activeBtn) {
            ratioBtns.forEach(b => {
                b.classList.remove('border-indigo-200', 'bg-indigo-50', 'text-indigo-600', 'font-bold');
                b.classList.add('border-slate-200', 'bg-white', 'text-slate-600', 'font-semibold');
            });
            activeBtn.classList.add('border-indigo-200', 'bg-indigo-50', 'text-indigo-600', 'font-bold');
            activeBtn.classList.remove('border-slate-200', 'bg-white', 'text-slate-600', 'font-semibold');
        }

        document.getElementById('cropper-btn-ratio-1-1').addEventListener('click', function () {
            if (cropperInstance) cropperInstance.setAspectRatio(1);
            setActiveRatioBtn(this);
        });
        document.getElementById('cropper-btn-ratio-4-3').addEventListener('click', function () {
            if (cropperInstance) cropperInstance.setAspectRatio(4 / 3);
            setActiveRatioBtn(this);
        });
        document.getElementById('cropper-btn-ratio-free').addEventListener('click', function () {
            if (cropperInstance) cropperInstance.setAspectRatio(NaN);
            setActiveRatioBtn(this);
        });

        // Close Cropper
        document.getElementById('cropper-btn-cancel').addEventListener('click', closeCropper);
        document.getElementById('cropper-btn-cancel-bottom').addEventListener('click', closeCropper);

        // Confirm & Apply Cropped Image
        document.getElementById('cropper-btn-confirm').addEventListener('click', () => {
            if (!cropperInstance) return;
            const canvas = cropperInstance.getCroppedCanvas({
                maxWidth: 1200,
                maxHeight: 1200,
                fillColor: '#ffffff',
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });
            canvas.toBlob(function (blob) {
                const origName = (cropperFileInput && cropperFileInput.files && cropperFileInput.files[0])
                    ? cropperFileInput.files[0].name
                    : 'foto-produk.jpg';
                applyCroppedResult(blob, origName);
                closeCropper();
            }, 'image/jpeg', 0.92);
        });

        // File Input Handlers
        const createFileInput = document.getElementById('foto_produk_input');
        if (createFileInput) {
            createFileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = (e) => startCropper(e.target.result, createFileInput, 'create');
                reader.readAsDataURL(file);
            });
        }

        const editFileInput = document.getElementById('edit_foto_produk_input');
        if (editFileInput) {
            editFileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = (e) => startCropper(e.target.result, editFileInput, 'edit');
                reader.readAsDataURL(file);
            });
        }

        // Re-crop buttons
        const btnRecropCreate = document.getElementById('btn-recrop-create');
        if (btnRecropCreate) {
            btnRecropCreate.addEventListener('click', () => {
                const currentImg = document.getElementById('create-foto-img');
                if (currentImg && currentImg.src) {
                    startCropper(currentImg.src, createFileInput, 'create');
                }
            });
        }

        const btnRecropEdit = document.getElementById('btn-recrop-edit');
        if (btnRecropEdit) {
            btnRecropEdit.addEventListener('click', () => {
                const currentImg = document.getElementById('edit-foto-img');
                if (currentImg && currentImg.src) {
                    startCropper(currentImg.src, editFileInput, 'edit');
                }
            });
        }

        // Reset create modal
        document.querySelectorAll('.btn-close-create').forEach(el => {
            el.addEventListener('click', () => {
                if (createFileInput) createFileInput.value = '';
                const prev = document.getElementById('create-foto-preview');
                const ph   = document.getElementById('create-foto-placeholder');
                if (prev) prev.classList.add('hidden');
                if (ph)   ph.classList.remove('hidden');
                // Reset preview kasir
                const kasirImg = document.getElementById('create-kasir-preview-img');
                const kasirPh  = document.getElementById('create-kasir-preview-placeholder');
                if (kasirImg) { kasirImg.src = ''; kasirImg.classList.add('hidden'); }
                if (kasirPh)  kasirPh.classList.remove('hidden');
            });
        });
    </script>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/cropperjs/cropper.min.css') }}">
    <style>
        .cropper-toolbar-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #475569;
        }
        .cropper-toolbar-btn:hover {
            background: #eef2ff;
            color: #4f46e5;
            border-color: #c7d2fe;
            transform: translateY(-1px);
        }
        .cropper-toolbar-btn:active {
            transform: scale(0.95);
        }
    </style>
    @endpush

    @push('scripts')
    <script src="{{ asset('vendor/cropperjs/cropper.min.js') }}"></script>
    @endpush
</x-layout>
