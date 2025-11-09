<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Pastikan Model User sudah diimpor

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Langsung membuat akun Admin. 
        // Peringatan: Jika dijalankan berulang kali tanpa migrate:fresh, ini akan membuat duplikat.
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            // Password akan di-hash dan disimpan
            'password' => Hash::make('admin123'), 
            'role' => 'admin', // WAJIB: Atur role sebagai admin
        ]);
    }
}