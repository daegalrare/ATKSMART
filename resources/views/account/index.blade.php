<x-layout>
    <x-slot:title>
        Kelola Akun Pengguna
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

        <!-- Header Banner & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Daftar Akun Pengguna</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola data akun kasir, admin, dan hak akses pengguna sistem.</p>
            </div>
            <div>
                <button id="btn-open-modal" type="button" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-xs transition shadow-indigo-500/20 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Akun
                </button>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200/80 text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                            <th class="py-3.5 px-6">ID</th>
                            <th class="py-3.5 px-6">Nama Pengguna</th>
                            <th class="py-3.5 px-6">Email</th>
                            <th class="py-3.5 px-6">No. Telepon</th>
                            <th class="py-3.5 px-6">Role</th>
                            <th class="py-3.5 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse ($account ?? [] as $item)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-4 px-6 font-medium text-slate-900">#{{ $item->id_akun }}</td>
                                <td class="py-4 px-6 font-semibold text-slate-800">{{ $item->nama_akun ?? '-' }}</td>
                                <td class="py-4 px-6 text-slate-600">{{ $item->email_akun ?? '-' }}</td>
                                <td class="py-4 px-6 text-slate-600">{{ $item->no_telepon ?? '-' }}</td>
                                <td class="py-4 px-6">
                                    @php
                                        $badgeColor = match(strtolower($item->role ?? '')) {
                                            'admin' => 'bg-rose-50 text-rose-700 border-rose-100',
                                            'owner' => 'bg-amber-50 text-amber-700 border-amber-100',
                                            'kasir' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                                            default => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $badgeColor }}">
                                        {{ ucfirst($item->role ?? 'User') }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button
                                            type="button"
                                            class="btn-edit w-8 h-8 rounded-lg flex items-center justify-center text-indigo-500 hover:text-indigo-700 hover:bg-indigo-50 border border-transparent hover:border-indigo-200 transition cursor-pointer"
                                            title="Edit akun"
                                            data-id="{{ $item->id_akun }}"
                                            data-nama="{{ $item->nama_akun }}"
                                            data-email="{{ $item->email_akun }}"
                                            data-telepon="{{ $item->no_telepon }}"
                                            data-role="{{ $item->role }}"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn-hapus w-8 h-8 rounded-lg flex items-center justify-center text-rose-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-200 transition cursor-pointer"
                                            title="Hapus akun"
                                            data-id="{{ $item->id_akun }}"
                                            data-nama="{{ $item->nama_akun }}"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                        </div>
                                        <p class="font-medium text-slate-700">Belum ada akun terdaftar</p>
                                        <p class="text-xs text-slate-400 mt-0.5">Silakan tambahkan data akun baru menggunakan tombol di atas.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- POP OUT DIALOG BOX (MODAL TAMBAH AKUN) -->
    <div id="account-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 {{ $errors->any() ? '' : 'hidden' }}" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop Blur Overlay -->
        <div id="modal-backdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>

        <!-- Dialog Box Container -->
        <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 id="modal-title" class="text-lg font-bold text-slate-900">Tambah Akun Baru</h3>
                        <p class="text-xs text-slate-500">Isi formulir berikut untuk mendaftarkan akun pengguna.</p>
                    </div>
                </div>
                <button id="btn-close-modal" type="button" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <form action="{{ route('account.store') }}" method="POST" class="p-6 space-y-4" onsubmit="return validatePhoneOnSubmit('no_telepon','phone-hint-create')">
                @csrf

                <!-- Nama Lengkap / Akun -->
                <div>
                    <label for="nama_akun" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="nama_akun" 
                        id="nama_akun" 
                        value="{{ old('nama_akun') }}"
                        placeholder="Contoh: Budi Santoso"
                        class="w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition {{ $errors->has('nama_akun') ? 'border-rose-400 bg-rose-50/20' : 'border-slate-200' }}"
                        required
                    >
                    @error('nama_akun')
                        <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email & No Telepon Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="email_akun" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Email <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            name="email_akun" 
                            id="email_akun" 
                            value="{{ old('email_akun') }}"
                            placeholder="nama@email.com"
                            class="w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition {{ $errors->has('email_akun') ? 'border-rose-400 bg-rose-50/20' : 'border-slate-200' }}"
                            required
                        >
                        @error('email_akun')
                            <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="no_telepon" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            No. Telepon / WA
                        </label>
                        <input 
                            type="text" 
                            name="no_telepon" 
                            id="no_telepon" 
                            value="{{ old('no_telepon') }}"
                            placeholder="08xxxxxxxxxx"
                            inputmode="numeric"
                            pattern="^08\d{9,10}$"
                            minlength="11"
                            maxlength="12"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                            class="w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition {{ $errors->has('no_telepon') ? 'border-rose-400 bg-rose-50/20' : 'border-slate-200' }}"
                        >
                        <p id="phone-hint-create" class="text-[11px] mt-1 text-rose-500 font-semibold hidden"></p>
                        @error('no_telepon')
                            <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Role Selection -->
                <div>
                    <label for="role" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Role / Hak Akses <span class="text-rose-500">*</span>
                    </label>
                    <select 
                        name="role" 
                        id="role" 
                        class="w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition {{ $errors->has('role') ? 'border-rose-400 bg-rose-50/20' : 'border-slate-200' }}"
                        required
                    >
                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih peran pengguna...</option>
                        <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir (Transaksi & Penjualan)</option>
                        <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>Owner (Pemilik / Semua Hak Akses)</option>
                    </select>
                    @error('role')
                        <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Password <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative flex items-center">
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            placeholder="Minimal 6 karakter"
                            class="w-full pl-4 pr-11 py-2.5 bg-slate-50 border rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition {{ $errors->has('password') ? 'border-rose-400 bg-rose-50/20' : 'border-slate-200' }}"
                            required
                        >
                        <button 
                            type="button" 
                            onclick="togglePasswordVisibility('password', this)"
                            class="absolute right-3 text-slate-400 hover:text-slate-600 focus:outline-hidden p-1 rounded-lg transition-colors cursor-pointer"
                            title="Tampilkan / Sembunyikan Password"
                            aria-label="Toggle password visibility"
                        >
                            <svg class="w-5 h-5 eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <svg class="w-5 h-5 eye-closed hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Modal Footer Actions -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button 
                        id="btn-cancel-modal" 
                        type="button" 
                        class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition cursor-pointer"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-xs shadow-indigo-500/20 transition cursor-pointer"
                    >
                        Simpan Akun
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- POP OUT DIALOG BOX (MODAL EDIT AKUN) -->
    <div id="edit-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 hidden" aria-labelledby="edit-modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop Blur Overlay -->
        <div id="edit-modal-backdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>

        <!-- Dialog Box Container -->
        <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all z-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 id="edit-modal-title" class="text-lg font-bold text-slate-900">Edit Akun Pengguna</h3>
                        <p class="text-xs text-slate-500">Perbarui informasi akun pengguna yang dipilih.</p>
                    </div>
                </div>
                <button id="btn-close-edit-modal" type="button" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <form id="edit-form" action="" method="POST" class="p-6 space-y-4" onsubmit="return validatePhoneOnSubmit('edit_no_telepon','phone-hint-edit')">
                @csrf
                @method('PUT')

                <!-- Nama Lengkap -->
                <div>
                    <label for="edit_nama_akun" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="nama_akun" 
                        id="edit_nama_akun" 
                        placeholder="Contoh: Budi Santoso"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                        required
                    >
                </div>

                <!-- Email & No Telepon Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="edit_email_akun" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Email <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            name="email_akun" 
                            id="edit_email_akun" 
                            placeholder="nama@email.com"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                            required
                        >
                    </div>

                    <div>
                        <label for="edit_no_telepon" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            No. Telepon / WA
                        </label>
                        <input 
                            type="text" 
                            name="no_telepon" 
                            id="edit_no_telepon" 
                            placeholder="08xxxxxxxxxx"
                            inputmode="numeric"
                            pattern="^08\d{9,10}$"
                            minlength="11"
                            maxlength="12"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                        >
                        <p id="phone-hint-edit" class="text-[11px] mt-1 text-rose-500 font-semibold hidden"></p>
                    </div>
                </div>

                <!-- Role Selection -->
                <div>
                    <label for="edit_role" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Role / Hak Akses <span class="text-rose-500">*</span>
                    </label>
                    <select 
                        name="role" 
                        id="edit_role" 
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                        required
                    >
                        <option value="kasir">Kasir (Transaksi & Penjualan)</option>
                        <option value="owner">Owner (Pemilik / Semua Hak Akses)</option>
                    </select>
                </div>

                <!-- Password (opsional) -->
                <div>
                    <label for="edit_password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Password Baru <span class="text-slate-400 font-normal normal-case">(kosongkan jika tidak diubah)</span>
                    </label>
                    <div class="relative flex items-center">
                        <input 
                            type="password" 
                            name="password" 
                            id="edit_password" 
                            placeholder="Minimal 6 karakter"
                            class="w-full pl-4 pr-11 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition"
                        >
                        <button 
                            type="button" 
                            onclick="togglePasswordVisibility('edit_password', this)"
                            class="absolute right-3 text-slate-400 hover:text-slate-600 focus:outline-hidden p-1 rounded-lg transition-colors cursor-pointer"
                            title="Tampilkan / Sembunyikan Password"
                            aria-label="Toggle password visibility"
                        >
                            <svg class="w-5 h-5 eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <svg class="w-5 h-5 eye-closed hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Footer Actions -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button 
                        id="btn-cancel-edit-modal" 
                        type="button" 
                        class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition cursor-pointer"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-xs shadow-indigo-500/20 transition cursor-pointer"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- POP OUT DIALOG BOX (MODAL KONFIRMASI HAPUS) -->
    <div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 hidden" role="dialog" aria-modal="true">
        <!-- Backdrop Blur Overlay -->
        <div id="delete-modal-backdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>

        <!-- Dialog Box Container -->
        <div class="relative w-full max-w-sm bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all z-10">
            <!-- Icon & Body -->
            <div class="p-6 text-center">
                <div class="w-14 h-14 rounded-full bg-rose-50 flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">Hapus Akun?</h3>
                <p class="text-sm text-slate-500 mb-1">Anda akan menghapus akun:</p>
                <p id="delete-nama-target" class="text-sm font-semibold text-rose-600 mb-4">-</p>
                <p class="text-xs text-slate-400">Tindakan ini tidak dapat dibatalkan. Pastikan Anda yakin sebelum melanjutkan.</p>
            </div>

            <!-- Tombol Ya / Tidak -->
            <div class="flex border-t border-slate-100">
                <button 
                    id="btn-cancel-delete" 
                    type="button" 
                    class="flex-1 py-3.5 text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 transition cursor-pointer rounded-bl-3xl"
                >
                    Tidak, Batal
                </button>
                <div class="w-px bg-slate-100"></div>
                <form id="delete-form" action="" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button 
                        type="submit" 
                        class="w-full py-3.5 text-sm font-semibold text-rose-600 hover:text-rose-700 hover:bg-rose-50 transition cursor-pointer rounded-br-3xl"
                    >
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Pop Out Dialog Script -->
    <script>
        (function() {
            // ── MODAL TAMBAH ──────────────────────────────────────
            const modal = document.getElementById('account-modal');
            const openBtn = document.getElementById('btn-open-modal');
            const closeBtn = document.getElementById('btn-close-modal');
            const cancelBtn = document.getElementById('btn-cancel-modal');
            const backdrop = document.getElementById('modal-backdrop');

            function openModal() {
                if (!modal) return;
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                setTimeout(() => {
                    document.getElementById('nama_akun')?.focus();
                }, 50);
            }

            function resetPasswordToggle(modalEl) {
                if (!modalEl) return;
                const passInput = modalEl.querySelector('input[name="password"]');
                if (passInput) passInput.type = 'password';
                const eyeOpen = modalEl.querySelector('.eye-open');
                const eyeClosed = modalEl.querySelector('.eye-closed');
                if (eyeOpen) eyeOpen.classList.remove('hidden');
                if (eyeClosed) eyeClosed.classList.add('hidden');
            }

            function closeModal() {
                if (!modal) return;
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                resetPasswordToggle(modal);
            }

            if (openBtn) openBtn.addEventListener('click', openModal);
            if (closeBtn) closeBtn.addEventListener('click', closeModal);
            if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
            if (backdrop) backdrop.addEventListener('click', closeModal);

            // ── MODAL EDIT ────────────────────────────────────────
            const editModal = document.getElementById('edit-modal');
            const editForm = document.getElementById('edit-form');
            const editBackdrop = document.getElementById('edit-modal-backdrop');
            const closeEditBtn = document.getElementById('btn-close-edit-modal');
            const cancelEditBtn = document.getElementById('btn-cancel-edit-modal');

            function openEditModal(btn) {
                document.getElementById('edit_nama_akun').value = btn.dataset.nama || '';
                document.getElementById('edit_email_akun').value = btn.dataset.email || '';
                document.getElementById('edit_no_telepon').value = btn.dataset.telepon || '';
                document.getElementById('edit_password').value = '';
                resetPasswordToggle(editModal);
                document.getElementById('edit_role').value = btn.dataset.role || 'kasir';
                editForm.action = '/account/' + btn.dataset.id;
                editModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                setTimeout(() => {
                    document.getElementById('edit_nama_akun')?.focus();
                }, 50);
            }

            function closeEditModal() {
                editModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                resetPasswordToggle(editModal);
            }

            document.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', () => openEditModal(btn));
            });
            if (closeEditBtn) closeEditBtn.addEventListener('click', closeEditModal);
            if (cancelEditBtn) cancelEditBtn.addEventListener('click', closeEditModal);
            if (editBackdrop) editBackdrop.addEventListener('click', closeEditModal);

            // ── MODAL HAPUS ───────────────────────────────────────
            const deleteModal = document.getElementById('delete-modal');
            const deleteForm = document.getElementById('delete-form');
            const deleteBackdrop = document.getElementById('delete-modal-backdrop');
            const cancelDeleteBtn = document.getElementById('btn-cancel-delete');
            const deleteNamaEl = document.getElementById('delete-nama-target');

            function openDeleteModal(btn) {
                deleteNamaEl.textContent = btn.dataset.nama || 'akun ini';
                deleteForm.action = '/account/' + btn.dataset.id;
                deleteModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeDeleteModal() {
                deleteModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            document.querySelectorAll('.btn-hapus').forEach(btn => {
                btn.addEventListener('click', () => openDeleteModal(btn));
            });
            if (cancelDeleteBtn) cancelDeleteBtn.addEventListener('click', closeDeleteModal);
            if (deleteBackdrop) deleteBackdrop.addEventListener('click', closeDeleteModal);

            // ── ESCAPE KEY ────────────────────────────────────────
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (modal && !modal.classList.contains('hidden')) closeModal();
                    if (editModal && !editModal.classList.contains('hidden')) closeEditModal();
                    if (deleteModal && !deleteModal.classList.contains('hidden')) closeDeleteModal();
                }
            });
        })();

        // ── TOGGLE PASSWORD VISIBILITY ───────────────────────────
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            const eyeOpen = btn.querySelector('.eye-open');
            const eyeClosed = btn.querySelector('.eye-closed');
            if (eyeOpen && eyeClosed) {
                eyeOpen.classList.toggle('hidden', isPassword);
                eyeClosed.classList.toggle('hidden', !isPassword);
            }
        }
        window.togglePasswordVisibility = togglePasswordVisibility;

        // Phone validation — only on form submit
        function validatePhoneOnSubmit(inputId, hintId) {
            const input = document.getElementById(inputId);
            const hint = document.getElementById(hintId);
            if (!input || !hint) return true;

            const val = input.value.trim();

            // Kosong = wajib diisi
            if (val.length === 0) {
                hint.textContent = '✕ No. telepon wajib diisi';
                hint.classList.remove('hidden');
                input.classList.add('border-rose-400');
                input.focus();
                return false;
            }

            if (!val.startsWith('08')) {
                hint.textContent = '✕ Nomor harus diawali dengan 08';
                hint.classList.remove('hidden');
                input.classList.add('border-rose-400');
                input.classList.remove('border-slate-200');
                input.focus();
                return false;
            }

            if (val.length < 11 || val.length > 12) {
                hint.textContent = '✕ Nomor harus 11-12 digit (' + val.length + ' digit dimasukkan)';
                hint.classList.remove('hidden');
                input.classList.add('border-rose-400');
                input.classList.remove('border-slate-200');
                input.focus();
                return false;
            }

            // Valid
            hint.classList.add('hidden');
            input.classList.remove('border-rose-400');
            return true;
        }
    </script>
</x-layout>

