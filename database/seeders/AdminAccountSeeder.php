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
        // 1. Seed akun admin di tabel account (Custom App)
        Account::updateOrCreate(
            ['email_akun' => 'admin@saleskip.com'],
            [
                'nama_akun' => 'Administrator',
                'no_telepon' => '081234567890',
                'role' => 'owner',
                'password_hashed' => Hash::make('admin123'),
            ]
        );

        // Akun default sesuai placeholder di login screen
        Account::updateOrCreate(
            ['email_akun' => 'hisalim.ux@gmail.com'],
            [
                'nama_akun' => 'Hi Salim (Owner)',
                'no_telepon' => '089876543210',
                'role' => 'owner',
                'password_hashed' => Hash::make('admin123'),
            ]
        );

        // 2. Seed akun Kasir di tabel account
        Account::updateOrCreate(
            ['email_akun' => 'kasir@atksmart.com'],
            [
                'nama_akun' => 'Siti (Kasir)',
                'no_telepon' => '082232857302',
                'role' => 'kasir',
                'password_hashed' => Hash::make('kasir123'),
            ]
        );

        Account::updateOrCreate(
            ['email_akun' => 'kasir@saleskip.com'],
            [
                'nama_akun' => 'Kasir Toko',
                'no_telepon' => '082232857302',
                'role' => 'kasir',
                'password_hashed' => Hash::make('kasir123'),
            ]
        );

        // 3. Seed akun admin di tabel users bawaan Laravel
        User::updateOrCreate(
            ['email' => 'admin@saleskip.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'hisalim.ux@gmail.com'],
            [
                'name' => 'Hi Salim',
                'password' => Hash::make('admin123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'kasir@atksmart.com'],
            [
                'name' => 'Siti Kasir',
                'password' => Hash::make('kasir123'),
            ]
        );

        $this->command->info('Akun Admin (admin123) dan Kasir (kasir123) berhasil di-seed.');
    }
}
