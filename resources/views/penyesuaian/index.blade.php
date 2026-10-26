<x-layout>
    <x-slot:title>
        Penyesuaian Stok (Stock Opname)
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
                <button type="button" onclick="document.getElementById('success-alert').remove()" class="text-emerald-500 hover:text-emerald-700 p-1.5 rounded-lg hover:bg-emerald-100/50 cursor-pointer">
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
                <button type="button" onclick="document.getElementById('error-alert').remove()" class="text-rose-500 hover:text-rose-700 p-1.5 rounded-lg hover:bg-rose-100/50 cursor-pointer">
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
                    <span>Perhatian: Terdapat kesalahan input formulir</span>
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
            <!-- Card 1: Total Riwayat Penyesuaian -->
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-xs p-5 flex items-center justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ number_format($totalOpname) }}</h3>
                        <p class="text-xs font-medium text-slate-400 mt-0.5">Total Riwayat Opname</p>
                    </div>
                </div>
            </div>

            <!-- Card 2: Total Penambahan Stok (Positif) -->
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-xs p-5 flex items-center justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-emerald-600 tracking-tight">+{{ number_format($totalBertambah) }}</h3>
                        <p class="text-xs font-medium text-slate-400 mt-0.5">Total Stok Bertambah</p>
                    </div>
                </div>
            </div>

            <!-- Card 3: Total Pengurangan Stok (Rusak / Hilang) -->
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-xs p-5 flex items-center justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-rose-600 tracking-tight">-{{ number_format($totalBerkurang) }}</h3>
                        <p class="text-xs font-medium text-slate-400 mt-0.5">Total Stok Berkurang / Rusak</p>
                    </div>
                </div>
            </div>

            <!-- Card 4: Penyesuaian Bulan Ini -->
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-xs p-5 flex items-center justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ number_format($opnameBulanIni) }}</h3>
                        <p class="text-xs font-medium text-slate-400 mt-0.5">Opname Bulan Ini ({{ date('M Y') }})</p>
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
                    <h1 class="text-xl font-bold text-slate-900">Penyesuaian Stok (Stock Opname)</h1>
                    <p class="text-sm text-slate-500 mt-1">Koreksi perbedaan stok fisik dengan sistem, catat barang rusak, hilang, atau selisih opname berkala.</p>
                </div>

                <!-- Tombol Catat Penyesuaian -->
                <button id="btn-open-create-modal" type="button" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-xs hover:shadow-md transition shadow-indigo-500/20 cursor-pointer self-start md:self-auto shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Catat Penyesuaian Stok
                </button>
            </div>

            <!-- Filter Toolbar Form -->
            <form action="{{ route('penyesuaian.index') }}" method="GET" class="pt-4 border-t border-slate-100 flex flex-wrap items-center gap-3">
                <!-- Search input -->
                <div class="relative flex-1 min-w-[200px]">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari produk atau keterangan..." 
                        class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                    >
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <!-- Filter Jenis Selisih -->
                <div>
                    <select name="jenis" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition">
                        <option value="">Semua Jenis Selisih</option>
                        <option value="tambah" {{ request('jenis') === 'tambah' ? 'selected' : '' }}>Stok Bertambah (+)</option>
                        <option value="kurang" {{ request('jenis') === 'kurang' ? 'selected' : '' }}>Stok Berkurang (-)</option>
                    </select>
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
                @if(request('search') || request('start_date') || request('end_date') || request('jenis'))
                    <a href="{{ route('penyesuaian.index') }}" class="px-3 py-2 text-xs sm:text-sm font-medium text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
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
                            <th class="py-3.5 px-6">ID & Tanggal Cek</th>
                            <th class="py-3.5 px-6">Produk / Barang</th>
                            <th class="py-3.5 px-6">Stok Master Saat Ini</th>
                            <th class="py-3.5 px-6">Penyesuaian Selisih</th>
                            <th class="py-3.5 px-6">Alasan / Keterangan</th>
                            <th class="py-3.5 px-6 text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse ($penyesuaian as $item)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <!-- ID & Tanggal Cek -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs shrink-0">
                                            #{{ $item->id_penyesuaian }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-800">
                                                {{ $item->tanggal_cek ? \Carbon\Carbon::parse($item->tanggal_cek)->translatedFormat('d M Y') : '-' }}
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

                                <!-- Penyesuaian Selisih -->
                                <td class="py-4 px-6">
                                    @if ($item->jumlah_selisih > 0)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                            </svg>
                                            +{{ number_format($item->jumlah_selisih) }} {{ $item->product->satuan_terkecil ?? 'unit' }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                            </svg>
                                            {{ number_format($item->jumlah_selisih) }} {{ $item->product->satuan_terkecil ?? 'unit' }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Alasan / Keterangan -->
                                <td class="py-4 px-6">
                                    <div class="max-w-xs text-slate-700 text-xs line-clamp-2">
                                        {{ $item->keterangan ?: '-' }}
                                    </div>
                                </td>

                                <!-- Tombol Aksi -->
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Icon Edit -->
                                        <button 
                                            type="button" 
                                            class="btn-open-edit-modal p-1.5 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded-lg transition cursor-pointer"
                                            title="Edit penyesuaian"
                                            data-id="{{ $item->id_penyesuaian }}"
                                            data-produk-id="{{ $item->id_produk }}"
                                            data-tanggal="{{ $item->tanggal_cek ? \Carbon\Carbon::parse($item->tanggal_cek)->format('Y-m-d') : '' }}"
                                            data-selisih="{{ $item->jumlah_selisih }}"
                                            data-keterangan="{{ $item->keterangan ?? '' }}"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </button>
                                        <!-- Icon Hapus -->
                                        <button 
                                            type="button" 
                                            class="btn-open-delete-modal p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition cursor-pointer"
                                            title="Hapus penyesuaian"
                                            data-id="{{ $item->id_penyesuaian }}"
                                            data-nama="{{ $item->product->nama_produk ?? 'Penyesuaian #' . $item->id_penyesuaian }}"
                                            data-selisih="{{ $item->jumlah_selisih > 0 ? '+' . $item->jumlah_selisih : $item->jumlah_selisih }}"
                                            data-tanggal="{{ $item->tanggal_cek ? \Carbon\Carbon::parse($item->tanggal_cek)->format('d/m/Y') : '-' }}"
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
                                <td colspan="6" class="py-14 text-center text-slate-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-400 flex items-center justify-center mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                        <p class="font-semibold text-slate-800 text-base">Belum Ada Riwayat Penyesuaian Stok</p>
                                        <p class="text-xs text-slate-400 mt-1 max-w-sm">Klik tombol "Catat Penyesuaian Stok" di atas untuk melakukan opname stok, mencatat kerusakan barang, atau koreksi selisih fisik.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            @if($penyesuaian->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $penyesuaian->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 1. MODAL TAMBAH PENYESUAIAN STOK                         -->
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
                        <h3 class="font-bold text-slate-900 text-base">Catat Penyesuaian Stok (Opname)</h3>
                        <p class="text-xs text-slate-500">Koreksi fisik langsung memperbarui stok master produk</p>
                    </div>
                </div>
                <button type="button" class="btn-close-modal text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Form -->
            <form action="{{ route('penyesuaian.store') }}" method="POST" class="p-6 space-y-4">
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
                        <span class="text-indigo-600 font-medium">Stok Sistem Saat Ini:</span>
                        <span id="create_preview_stok" class="font-bold ml-1">0 unit</span>
                    </div>
                    <div>
                        <span class="text-slate-500 text-[11px]">Hitung fisik & input di bawah</span>
                    </div>
                </div>

                <!-- Tanggal Pengecekan -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Tanggal Pengecekan <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        name="tanggal_cek" 
                        value="{{ date('Y-m-d') }}" 
                        required 
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                    >
                </div>

                <!-- Dual Input: Stok Fisik & Jumlah Selisih -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Stok Fisik Dihitung <span class="text-slate-400 font-normal">(Opsional)</span>
                        </label>
                        <input 
                            type="number" 
                            id="create_stok_fisik" 
                            min="0"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                            placeholder="Contoh: 15"
                        >
                        <span class="text-[11px] text-slate-400 mt-1 block">Otomatis hitung selisih</span>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Jumlah Selisih (+/-) <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            id="create_selisih" 
                            name="jumlah_selisih" 
                            required 
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition font-mono font-bold"
                            placeholder="Contoh: -2 atau +5"
                        >
                        <span class="text-[11px] text-slate-400 mt-1 block">Gunakan minus (-) jika berkurang</span>
                    </div>
                </div>

                <!-- Quick Reason Chips -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Pilihan Alasan Cepat
                    </label>
                    <div class="flex flex-wrap gap-1.5">
                        <button type="button" class="btn-reason-chip px-2.5 py-1 bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 text-slate-600 rounded-lg text-xs font-medium transition cursor-pointer">
                            Barang Rusak
                        </button>
                        <button type="button" class="btn-reason-chip px-2.5 py-1 bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 text-slate-600 rounded-lg text-xs font-medium transition cursor-pointer">
                            Selisih Opname Fisik
                        </button>
                        <button type="button" class="btn-reason-chip px-2.5 py-1 bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 text-slate-600 rounded-lg text-xs font-medium transition cursor-pointer">
                            Barang Hilang
                        </button>
                        <button type="button" class="btn-reason-chip px-2.5 py-1 bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 text-slate-600 rounded-lg text-xs font-medium transition cursor-pointer">
                            Kadaluarsa / Expired
                        </button>
                        <button type="button" class="btn-reason-chip px-2.5 py-1 bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 text-slate-600 rounded-lg text-xs font-medium transition cursor-pointer">
                            Koreksi Salah Input
                        </button>
                    </div>
                </div>

                <!-- Keterangan / Catatan -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Keterangan / Alasan Lengkap
                    </label>
                    <textarea 
                        id="create_keterangan" 
                        name="keterangan" 
                        rows="2" 
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                        placeholder="Contoh: Ditemukan 2 pcs rusak saat pengecekan rak gudang..."
                    ></textarea>
                </div>

                <!-- Preview Dampak Stok (Live Box) -->
                <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl flex items-center justify-between">
                    <div>
                        <p class="text-xs font-extrabold text-slate-700 uppercase tracking-wider">Estimasi Stok Akhir</p>
                        <p id="create_preview_akhir" class="text-xl font-black text-indigo-700 mt-0.5">0 unit</p>
                    </div>
                    <div class="text-right">
                        <span id="create_badge_arah" class="inline-flex items-center px-2 py-1 rounded-lg text-[11px] font-bold bg-slate-100 text-slate-600">
                            Netral
                        </span>
                    </div>
                </div>

                <!-- Modal Actions -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" class="btn-close-modal px-4 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-xs hover:shadow-md transition shadow-indigo-500/20 cursor-pointer">
                        Simpan Penyesuaian
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 2. MODAL EDIT PENYESUAIAN STOK                           -->
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
                        <h3 class="font-bold text-slate-900 text-base">Edit Penyesuaian Stok</h3>
                        <p class="text-xs text-slate-500">Perubahan selisih akan otomatis menyesuaikan delta stok master</p>
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

                <!-- Tanggal Pengecekan -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Tanggal Pengecekan <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        id="edit_tanggal_cek" 
                        name="tanggal_cek" 
                        required 
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                    >
                </div>

                <!-- Jumlah Selisih -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Jumlah Selisih (+/-) <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="edit_selisih" 
                        name="jumlah_selisih" 
                        required 
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition font-mono font-bold"
                    >
                    <span class="text-[11px] text-slate-400 mt-1 block">Nilai positif (+) menambah stok, negatif (-) mengurangi stok.</span>
                </div>

                <!-- Keterangan -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Keterangan / Alasan
                    </label>
                    <textarea 
                        id="edit_keterangan" 
                        name="keterangan" 
                        rows="2" 
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                    ></textarea>
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
    <!-- 3. MODAL HAPUS PENYESUAIAN STOK                          -->
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
                    <h3 class="text-lg font-bold text-slate-900">Konfirmasi Hapus Penyesuaian</h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Apakah Anda yakin ingin menghapus data penyesuaian stok produk <span id="delete_nama_produk" class="font-bold text-slate-800"></span>?
                    </p>
                    <div class="mt-3 p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-800 text-left">
                        <span class="font-bold">⚠️ Perhatian:</span> Menghapus catatan ini akan mengembalikan efek selisih (<span id="delete_selisih_label" class="font-bold">0</span> unit) ke stok master produk sebelumnya.
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
    <!-- JAVASCRIPT MODAL & INTERACTIVE LOGIC                     -->
    <!-- ======================================================== -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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

            // CREATE MODAL: Interactive Stock Calculation
            const selectCreateProduk = document.getElementById('create_id_produk');
            const inputCreateFisik = document.getElementById('create_stok_fisik');
            const inputCreateSelisih = document.getElementById('create_selisih');
            const infoBox = document.getElementById('create_info_box');
            const previewStok = document.getElementById('create_preview_stok');
            const previewAkhir = document.getElementById('create_preview_akhir');
            const badgeArah = document.getElementById('create_badge_arah');
            const inputKeterangan = document.getElementById('create_keterangan');

            let currentProductStock = 0;
            let currentUnit = 'unit';

            function updateCreatePreview() {
                const selisih = parseInt(inputCreateSelisih.value) || 0;
                const akhir = Math.max(0, currentProductStock + selisih);
                previewAkhir.textContent = `${akhir} ${currentUnit}`;

                if (selisih > 0) {
                    badgeArah.className = 'inline-flex items-center px-2 py-1 rounded-lg text-[11px] font-bold bg-emerald-100 text-emerald-700';
                    badgeArah.textContent = `+${selisih} (Stok Bertambah)`;
                } else if (selisih < 0) {
                    badgeArah.className = 'inline-flex items-center px-2 py-1 rounded-lg text-[11px] font-bold bg-rose-100 text-rose-700';
                    badgeArah.textContent = `${selisih} (Stok Berkurang)`;
                } else {
                    badgeArah.className = 'inline-flex items-center px-2 py-1 rounded-lg text-[11px] font-bold bg-slate-100 text-slate-600';
                    badgeArah.textContent = 'Netral (0)';
                }
            }

            if (selectCreateProduk) {
                selectCreateProduk.addEventListener('change', function () {
                    const selected = this.options[this.selectedIndex];
                    if (this.value) {
                        currentProductStock = parseInt(selected.getAttribute('data-stok') || '0');
                        currentUnit = selected.getAttribute('data-satuan') || 'unit';

                        infoBox.classList.remove('hidden');
                        previewStok.textContent = `${currentProductStock} ${currentUnit}`;
                        
                        // Jika sudah ada input fisik, hitung ulang selisih
                        if (inputCreateFisik.value !== '') {
                            const fisik = parseInt(inputCreateFisik.value) || 0;
                            inputCreateSelisih.value = fisik - currentProductStock;
                        }
                    } else {
                        infoBox.classList.add('hidden');
                        currentProductStock = 0;
                    }
                    updateCreatePreview();
                });
            }

            // Ketika user mengetik Stok Fisik: otomatis hitung selisih = fisik - sistem
            if (inputCreateFisik) {
                inputCreateFisik.addEventListener('input', function () {
                    if (this.value !== '') {
                        const fisik = parseInt(this.value) || 0;
                        inputCreateSelisih.value = fisik - currentProductStock;
                    }
                    updateCreatePreview();
                });
            }

            // Ketika user langsung mengetik Selisih (+/-)
            if (inputCreateSelisih) {
                inputCreateSelisih.addEventListener('input', function () {
                    if (this.value !== '') {
                        const selisih = parseInt(this.value) || 0;
                        inputCreateFisik.value = Math.max(0, currentProductStock + selisih);
                    }
                    updateCreatePreview();
                });
            }

            // Quick Reason Chips
            document.querySelectorAll('.btn-reason-chip').forEach(chip => {
                chip.addEventListener('click', function () {
                    const text = this.textContent.trim();
                    if (inputKeterangan.value) {
                        inputKeterangan.value = `${text}. ${inputKeterangan.value}`;
                    } else {
                        inputKeterangan.value = text;
                    }
                });
            });

            // EDIT MODAL: Open & populate
            const formEdit = document.getElementById('form-edit');
            const selectEditProduk = document.getElementById('edit_id_produk');
            const inputEditTanggal = document.getElementById('edit_tanggal_cek');
            const inputEditSelisih = document.getElementById('edit_selisih');
            const textareaEditKet = document.getElementById('edit_keterangan');

            document.querySelectorAll('.btn-open-edit-modal').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const produkId = this.getAttribute('data-produk-id');
                    const tanggal = this.getAttribute('data-tanggal');
                    const selisih = this.getAttribute('data-selisih');
                    const ket = this.getAttribute('data-keterangan');

                    formEdit.action = `/penyesuaian-stok/${id}`;
                    selectEditProduk.value = produkId;
                    inputEditTanggal.value = tanggal;
                    inputEditSelisih.value = selisih;
                    textareaEditKet.value = ket;

                    modalEdit.classList.remove('hidden');
                });
            });

            // DELETE MODAL: Open & configure form
            const formDelete = document.getElementById('form-delete');
            const labelDeleteNama = document.getElementById('delete_nama_produk');
            const labelDeleteSelisih = document.getElementById('delete_selisih_label');

            document.querySelectorAll('.btn-open-delete-modal').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const nama = this.getAttribute('data-nama');
                    const selisih = this.getAttribute('data-selisih');

                    formDelete.action = `/penyesuaian-stok/${id}`;
                    labelDeleteNama.textContent = `"${nama}"`;
                    labelDeleteSelisih.textContent = selisih;

                    modalDelete.classList.remove('hidden');
                });
            });
        });
    </script>
</x-layout>
