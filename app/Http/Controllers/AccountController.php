<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(): View|\Illuminate\Http\RedirectResponse
    {
        if (session('account_role') === 'kasir') {
            return redirect()->route('kasir.index')->with('error', 'Halaman Kelola Akun hanya dapat diakses oleh Administrator.');
        }

        $this->reorderAccountIds();

        $account = Account::query()->orderBy('id_akun', 'asc')->get();

        return view('account.index', compact('account'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_akun' => 'required|string|max:255',
            'email_akun' => 'required|email|max:255|unique:account,email_akun',
            'no_telepon' => ['required', 'string', 'regex:/^08\d{9,10}$/', 'unique:account,no_telepon'],
            'role' => 'required|string|in:kasir,owner',
            'password' => 'required|string|min:6',
        ], [
            'nama_akun.required' => 'Nama pengguna wajib diisi.',
            'email_akun.required' => 'Email akun wajib diisi.',
            'email_akun.email' => 'Format email tidak valid.',
            'email_akun.unique' => 'Email ini sudah terdaftar.',
            'no_telepon.required' => 'No. telepon wajib diisi.',
            'no_telepon.regex' => 'No. telepon harus diawali 08 dan terdiri dari 11-12 digit angka.',
            'no_telepon.unique' => 'No. telepon ini sudah digunakan oleh akun lain.',
            'role.required' => 'Role wajib dipilih.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        Account::create([
            'nama_akun' => $validated['nama_akun'],
            'email_akun' => $validated['email_akun'],
            'no_telepon' => $validated['no_telepon'] ?? null,
            'role' => $validated['role'],
            'password_hashed' => Hash::make($validated['password']),
        ]);

        return redirect()->route('account.index')->with('success', 'Akun pengguna berhasil ditambahkan!');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $akun = Account::findOrFail($id);

        $validated = $request->validate([
            'nama_akun' => 'required|string|max:255',
            'email_akun' => 'required|email|max:255|unique:account,email_akun,' . $id . ',id_akun',
            'no_telepon' => ['required', 'string', 'regex:/^08\d{9,10}$/', 'unique:account,no_telepon,' . $id . ',id_akun'],
            'role' => 'required|string|in:kasir,owner',
            'password' => 'nullable|string|min:6',
        ], [
            'nama_akun.required' => 'Nama pengguna wajib diisi.',
            'email_akun.required' => 'Email akun wajib diisi.',
            'email_akun.email' => 'Format email tidak valid.',
            'email_akun.unique' => 'Email ini sudah terdaftar oleh akun lain.',
            'no_telepon.required' => 'No. telepon wajib diisi.',
            'no_telepon.regex' => 'No. telepon harus diawali 08 dan terdiri dari 11-12 digit angka.',
            'no_telepon.unique' => 'No. telepon ini sudah digunakan oleh akun lain.',
            'role.required' => 'Role wajib dipilih.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $updateData = [
            'nama_akun' => $validated['nama_akun'],
            'email_akun' => $validated['email_akun'],
            'no_telepon' => $validated['no_telepon'] ?? null,
            'role' => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password_hashed'] = Hash::make($validated['password']);
        }

        $isSelf = (
            session('account_id') == $akun->id_akun ||
            strtolower(session('account_email', '')) === strtolower($akun->email_akun)
        );
        $roleChanged = ($akun->role !== $validated['role']);

        $akun->update($updateData);

        // Jika akun yang diubah adalah akun yang sedang login dan rolenya berubah, logout otomatis
        if ($isSelf && $roleChanged) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('success', 'Role akun Anda berhasil diubah. Anda telah keluar otomatis, silakan login kembali dengan hak akses baru.');
        }

        return redirect()->route('account.index')->with('success', 'Akun pengguna berhasil diperbarui!');
    }

    public function destroy(Request $request, $id): RedirectResponse
    {
        $akun = Account::find($id);
        $isSelf = false;

        if ($akun) {
            $isSelf = (
                session('account_id') == $akun->id_akun ||
                strtolower(session('account_email', '')) === strtolower($akun->email_akun)
            );
            $akun->delete();
        }

        $this->reorderAccountIds();

        if ($isSelf) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('success', 'Akun Anda berhasil dihapus. Anda telah logout otomatis dari sistem.');
        }

        return redirect()->route('account.index')->with('success', 'Akun pengguna berhasil dihapus!');
    }

    private function reorderAccountIds(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        try {
            $accounts = Account::orderBy('id_akun', 'asc')->get();
            $targetId = 1;

            foreach ($accounts as $item) {
                $currentId = $item->id_akun;
                if ($currentId !== $targetId) {
                    if (Schema::hasTable('penjualan') && Schema::hasColumn('penjualan', 'id_akun')) {
                        DB::table('penjualan')->where('id_akun', $currentId)->update(['id_akun' => $targetId]);
                    }

                    if (session('account_id') == $currentId) {
                        session(['account_id' => $targetId]);
                    }

                    DB::table('account')->where('id_akun', $currentId)->update(['id_akun' => $targetId]);
                }
                $targetId++;
            }

            $nextAuto = max(1, (Account::max('id_akun') ?? 0) + 1);
            DB::statement("ALTER TABLE account AUTO_INCREMENT = {$nextAuto}");
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
}
