<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'user_id'     => 1, // id admin / penjual
                'name'       => 'Produk Contoh 1',
                'category_id'=> 'umum',
                'description'=> 'Deskripsi produk contoh 1',
                'price'      => 10000,
                'stock'      => 10,
                'image'      => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id'     => 1,
                'name'       => 'Produk Contoh 2',
                'category_id'=> 'umum',
                'description'=> 'Deskripsi produk contoh 2',
                'price'      => 20000,
                'stock'      => 5,
                'image'      => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}


