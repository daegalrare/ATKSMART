<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            'no_telepon' => 'nullable|string|max:20',
            'role' => 'required|string|in:kasir,owner',
            'password' => 'required|string|min:6',
        ], [
            'nama_akun.required' => 'Nama pengguna wajib diisi.',
            'email_akun.required' => 'Email akun wajib diisi.',
            'email_akun.email' => 'Format email tidak valid.',
            'email_akun.unique' => 'Email ini sudah terdaftar.',
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
            'no_telepon' => 'nullable|string|max:20',
            'role' => 'required|string|in:kasir,owner',
            'password' => 'nullable|string|min:6',
        ], [
            'nama_akun.required' => 'Nama pengguna wajib diisi.',
            'email_akun.required' => 'Email akun wajib diisi.',
            'email_akun.email' => 'Format email tidak valid.',
            'email_akun.unique' => 'Email ini sudah terdaftar oleh akun lain.',
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

        $akun->update($updateData);

        return redirect()->route('account.index')->with('success', 'Akun pengguna berhasil diperbarui!');
    }

    public function destroy($id): RedirectResponse
    {
        $akun = Account::find($id);
        if ($akun) {
            $akun->delete();
        }

        $this->reorderAccountIds();

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
