<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Akun login admin default
        User::updateOrCreate(
            ['email' => 'admin@litaren.com'],
            [
                'name' => 'Admin Litaren',
                'email' => 'admin@litaren.com',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // Contoh 3 menu makanan/minuman kantin
        Menu::updateOrCreate(
            ['name' => 'Nasi Goreng Spesial'],
            [
                'name' => 'Nasi Goreng Spesial',
                'stan_name' => 'Stan Bu Ani',
                'category' => 'Makanan',
                'price' => 15000,
                'badge' => 'Best Seller',
                'description' => 'Nasi goreng dengan telur, ayam suwir, dan acar segar.',
                'image' => 'menus/nasi-goreng-spesial.jpg',
                'is_available' => true,
            ]
        );

        Menu::updateOrCreate(
            ['name' => 'Es Teh Manis'],
            [
                'name' => 'Es Teh Manis',
                'stan_name' => 'Stan Pak Joko',
                'category' => 'Minuman',
                'price' => 4000,
                'badge' => null,
                'description' => 'Teh manis dingin segar, cocok untuk cuaca panas.',
                'image' => 'menus/es-teh-manis.jpg',
                'is_available' => true,
            ]
        );

        Menu::updateOrCreate(
            ['name' => 'Mie Ayam Bakso'],
            [
                'name' => 'Mie Ayam Bakso',
                'stan_name' => 'Stan Mas Budi',
                'category' => 'Makanan',
                'price' => 12000,
                'badge' => 'Baru',
                'description' => 'Mie ayam dengan tambahan bakso sapi dan pangsit goreng.',
                'image' => 'menus/mie-ayam-bakso.jpg',
                'is_available' => true,
            ]
        );
    }
}