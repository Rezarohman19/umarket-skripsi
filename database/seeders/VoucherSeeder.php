<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        $vouchers = [
            [
                'code' => 'UMARKETHEMAT',
                'name' => 'Diskon Pengguna Baru 15%',
                'description' => 'Potongan 15% hingga Rp 15.000 untuk pembelian minimal Rp 20.000',
                'type' => 'percentage',
                'value' => 15,
                'min_purchase' => 20000,
                'max_discount' => 15000,
                'usage_limit' => 100,
                'per_user_limit' => 3,
                'is_active' => true,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(3),
            ],
            [
                'code' => 'DISKON10RB',
                'name' => 'Potongan Langsung Rp 10.000',
                'description' => 'Potongan tunai Rp 10.000 dengan minimal belanja Rp 35.000',
                'type' => 'fixed',
                'value' => 10000,
                'min_purchase' => 35000,
                'max_discount' => null,
                'usage_limit' => 200,
                'per_user_limit' => 2,
                'is_active' => true,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(2),
            ],
            [
                'code' => 'KAMPUSSERU',
                'name' => 'Promo Spesial Kampus 20%',
                'description' => 'Diskon 20% maksimal potongan Rp 25.000 belanja min Rp 50.000',
                'type' => 'percentage',
                'value' => 20,
                'min_purchase' => 50000,
                'max_discount' => 25000,
                'usage_limit' => 150,
                'per_user_limit' => 2,
                'is_active' => true,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(1),
            ],
            [
                'code' => 'ONGKIRFREE',
                'name' => 'Subsidi Ongkir Rp 5.000',
                'description' => 'Potongan Rp 5.000 tanpa minimal belanja khusus pengiriman lokal',
                'type' => 'fixed',
                'value' => 5000,
                'min_purchase' => 10000,
                'max_discount' => null,
                'usage_limit' => 500,
                'per_user_limit' => 5,
                'is_active' => true,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(6),
            ],
        ];

        foreach ($vouchers as $voucher) {
            Voucher::firstOrCreate(['code' => $voucher['code']], $voucher);
        }
    }
}
