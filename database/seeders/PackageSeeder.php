<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('packages')->insert([
            [
                'name' => 'Paket Dasar',
                'desc' => 'Ini adalah paket dasar.',
                'price' => 100000, // Harga dalam Rupiah
            ],
            [
                'name' => 'Paket Standar',
                'desc' => 'Ini adalah paket standar.',
                'price' => 200000, // Harga dalam Rupiah
            ],
            [
                'name' => 'Paket Premium',
                'desc' => 'Ini adalah paket premium.',
                'price' => 300000, // Harga dalam Rupiah
            ],
        ]);
    }
}
