<x-layout>
    <x-slot:title>Data Kategori</x-slot:title>

    <div class="space-y-6">

        <!-- Header Halaman & Tombol Tambah -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Data Kategori</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola pengelompokan kategori barang untuk memudahkan inventaris dan kasir.</p>
            </div>
            <div>
                <button
                    type="button"
                    id="btn-open-modal-add"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold shadow-md shadow-indigo-600/20 transition-all cursor-pointer hover:scale-[1.02] active:scale-95"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Tambah Kategori</span>
                </button>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 text-base leading-none">&times;</button>
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900 text-base leading-none">&times;</button>
            </div>
        @endif

        <!-- 3 Metric Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-900">{{ $totalCategories }}</h3>
                    <p class="text-xs text-slate-500 font-medium">Total Kategori</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 8-7-4-7 4v8l7 4 7-4zM12 22V12m9-4-9 4-9-4"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-900">{{ $totalProductsInCat }}</h3>
                    <p class="text-xs text-slate-500 font-medium">Produk Terkategori</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-900">Aktif</h3>
                    <p class="text-xs text-slate-500 font-medium">Status Manajemen</p>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <!-- Table Header / Search Bar -->
            <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 bg-slate-50/50">
                <form action="{{ route('category.index') }}" method="GET" class="w-full sm:w-80 relative">
                    <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama kategori..."
                        class="w-full pl-9 pr-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs placeholder:text-slate-400 focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 transition"
                    >
                </form>
                <div class="text-xs text-slate-500 font-medium">
                    Menampilkan <span class="font-bold text-slate-800">{{ $categories->count() }}</span> dari <span class="font-bold text-slate-800">{{ $categories->total() }}</span> kategori
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-700 uppercase tracking-wider font-extrabold text-[11px] bg-slate-50/70">
                            <th class="px-5 py-3.5 text-center w-16">No</th>
                            <th class="px-5 py-3.5">Nama Kategori</th>
                            <th class="px-5 py-3.5 text-center">Jumlah Produk</th>
                            <th class="px-5 py-3.5">Tanggal Dibuat</th>
                            <th class="px-5 py-3.5 text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse ($categories as $index => $c)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="px-5 py-4 text-center font-medium text-slate-400">
                                    {{ $categories->firstItem() + $index }}
                                </td>
                                <td class="px-5 py-4 font-bold text-slate-900 text-sm">
                                    <div class="flex items-center gap-3">
                                        <x-category-icon :name="$c->nama_kategori" class="w-8 h-8 rounded-xl" icon-class="w-4 h-4" />
                                        <span>{{ $c->nama_kategori }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $c->products_count > 0 ? 'bg-indigo-50 text-indigo-700' : 'bg-slate-100 text-slate-500' }}">
                                        {{ $c->products_count }} Produk
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-slate-500">
                                    {{ $c->created_at ? $c->created_at->format('d M Y, H:i') : '-' }}
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Edit Button -->
                                        <button
                                            type="button"
                                            onclick="openEditModal({{ $c->id_kategori }}, '{{ addslashes($c->nama_kategori) }}')"
                                            class="p-1.5 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded-lg transition cursor-pointer"
                                            title="Edit Kategori"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </button>

                                        <!-- Delete Button -->
                                        <button
                                            type="button"
                                            onclick="openDeleteModal({{ $c->id_kategori }}, '{{ addslashes($c->nama_kategori) }}', {{ $c->products_count }})"
                                            class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition cursor-pointer"
                                            title="Hapus Kategori"
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
                                <td colspan="5" class="px-5 py-12 text-center text-slate-400">
                                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                                    </div>
                                    <p class="font-semibold text-slate-600">Tidak ada kategori ditemukan</p>
                                    <p class="text-xs mt-1 text-slate-400">Klik tombol "Tambah Kategori" untuk membuat kategori baru.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($categories->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>

    </div>

    <!-- ======================================================== -->
    <!-- MODAL POP-OUT TAMBAH KATEGORI (Compact max-w-md)         -->
    <!-- ======================================================== -->
    <div id="modal-add" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden" role="dialog" aria-modal="true">
        <!-- Backdrop Blur -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeAddModal()"></div>

        <!-- Dialog Box Container -->
        <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Tambah Kategori Baru</h3>
                        <p class="text-xs text-slate-500">Tentukan nama kategori untuk pengelompokan produk.</p>
                    </div>
                </div>
                <button type="button" onclick="closeAddModal()" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <form action="{{ route('category.store') }}" method="POST" class="p-6 space-y-4">
                @csrf

                <div>
                    <label for="nama_kategori" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nama Kategori <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="nama_kategori"
                        id="nama_kategori"
                        placeholder="Contoh: Makanan Ringan, Minuman, Elektronik"
                        required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder:text-slate-400 focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 focus:bg-white transition"
                    >
                </div>

                <!-- Action Buttons -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button
                        type="button"
                        onclick="closeAddModal()"
                        class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition cursor-pointer"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-md shadow-indigo-600/20 transition cursor-pointer"
                    >
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL POP-OUT EDIT KATEGORI (Compact max-w-md)            -->
    <!-- ======================================================== -->
    <div id="modal-edit" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden" role="dialog" aria-modal="true">
        <!-- Backdrop Blur -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeEditModal()"></div>

        <!-- Dialog Box Container -->
        <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Edit Kategori</h3>
                        <p class="text-xs text-slate-500">Perbarui nama kategori yang dipilih.</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditModal()" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <form id="form-edit" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="edit_nama_kategori" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nama Kategori <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="nama_kategori"
                        id="edit_nama_kategori"
                        required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder:text-slate-400 focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 focus:bg-white transition"
                    >
                </div>

                <!-- Action Buttons -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button
                        type="button"
                        onclick="closeEditModal()"
                        class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition cursor-pointer"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-md shadow-indigo-600/20 transition cursor-pointer"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL POP-OUT KONFIRMASI HAPUS (Ya / Tidak)              -->
    <!-- ======================================================== -->
    <div id="modal-delete" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden" role="dialog" aria-modal="true">
        <!-- Backdrop Blur -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeDeleteModal()"></div>

        <!-- Dialog Box Container -->
        <div class="relative w-full max-w-sm bg-white rounded-3xl shadow-2xl border border-slate-100 p-6 z-10 text-center space-y-4">
            <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-500 mx-auto flex items-center justify-center shadow-xs">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
            </div>

            <div>
                <h3 class="text-base font-bold text-slate-900">Konfirmasi Hapus</h3>
                <p class="text-xs text-slate-500 mt-1">
                    Apakah Anda yakin ingin menghapus kategori <span id="delete-cat-name" class="font-bold text-slate-800"></span>?
                </p>
                <p id="delete-cat-warning" class="text-[11px] text-amber-600 font-medium mt-1.5 hidden bg-amber-50 p-2 rounded-xl border border-amber-200">
                    Kategori ini memiliki produk terkait. Produk tersebut akan dialihkan menjadi tanpa kategori.
                </p>
            </div>

            <form id="form-delete" method="POST" class="pt-2 flex items-center justify-center gap-2.5">
                @csrf
                @method('DELETE')
                <button
                    type="button"
                    onclick="closeDeleteModal()"
                    class="flex-1 py-2.5 px-4 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition cursor-pointer"
                >
                    Tidak, Batal
                </button>
                <button
                    type="submit"
                    class="flex-1 py-2.5 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-md shadow-rose-600/20 transition cursor-pointer"
                >
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- JAVASCRIPT MODAL HANDLERS                                -->
    <!-- ======================================================== -->
    <script>
        // Modal Tambah
        const modalAdd = document.getElementById('modal-add');
        const btnOpenAdd = document.getElementById('btn-open-modal-add');
        if (btnOpenAdd && modalAdd) {
            btnOpenAdd.addEventListener('click', () => {
                modalAdd.classList.remove('hidden');
                setTimeout(() => document.getElementById('nama_kategori')?.focus(), 100);
            });
        }
        function closeAddModal() {
            modalAdd.classList.add('hidden');
        }

        // Modal Edit
        const modalEdit = document.getElementById('modal-edit');
        const formEdit = document.getElementById('form-edit');
        const inputEditNama = document.getElementById('edit_nama_kategori');

        function openEditModal(id, nama) {
            formEdit.action = `/category/${id}`;
            inputEditNama.value = nama;
            modalEdit.classList.remove('hidden');
            setTimeout(() => inputEditNama.focus(), 100);
        }
        function closeEditModal() {
            modalEdit.classList.add('hidden');
        }

        // Modal Delete
        const modalDelete = document.getElementById('modal-delete');
        const formDelete = document.getElementById('form-delete');
        const deleteName = document.getElementById('delete-cat-name');
        const deleteWarning = document.getElementById('delete-cat-warning');

        function openDeleteModal(id, nama, productsCount) {
            formDelete.action = `/category/${id}`;
            deleteName.textContent = `"${nama}"`;
            if (productsCount > 0) {
                deleteWarning.classList.remove('hidden');
            } else {
                deleteWarning.classList.add('hidden');
            }
            modalDelete.classList.remove('hidden');
        }
        function closeDeleteModal() {
            modalDelete.classList.add('hidden');
        }

        // Close on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeAddModal();
                closeEditModal();
                closeDeleteModal();
            }
        });
    </script>
</x-layout>
