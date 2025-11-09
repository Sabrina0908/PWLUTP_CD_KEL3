<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Priority;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Mengisi tabel priorities dengan data awal.
     */
    public function run(): void
    {
        // Data prioritas awal yang dapat dipilih user
        $priorities = [
            [
                'name' => 'Tinggi (High)', 
                'color_code' => '#dc3545', // Merah
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'Sedang (Medium)', 
                'color_code' => '#ffc107', // Kuning
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'Rendah (Low)', 
                'color_code' => '#17a2b8', // Biru Muda
                'created_at' => now(), 
                'updated_at' => now()
            ],
        ];

        // Masukkan data ke tabel
        Priority::insert($priorities);
    }
}