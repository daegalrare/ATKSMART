<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed akun admin utama di tabel account (Custom App)
        Account::updateOrCreate(
            ['email_akun' => 'admin@saleskip.com'],
            [
                'nama_akun' => 'Administrator',
                'no_telepon' => '081234567890',
                'role' => 'owner',
                'password_hashed' => Hash::make('admin123'),
            ]
        );

        // Hapus akun selain admin utama agar fresh
        Account::where('email_akun', '!=', 'admin@saleskip.com')->delete();

        // 2. Seed akun admin di tabel users bawaan Laravel
        User::updateOrCreate(
            ['email' => 'admin@saleskip.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
            ]
        );

        User::where('email', '!=', 'admin@saleskip.com')->delete();

        $this->command->info('Akun bawaan admin@saleskip.com (password: admin123) berhasil di-seed.');
    }
}
