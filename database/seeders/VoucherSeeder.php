<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vouchers')->insert([
            [
                'voucher_name' => 'Discount10',
                'description' => ' Giảm 10% ở lượt mua tiếp theo.',
                'discount_percent' => 10,
                'minium_condition' => 100000,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addDays(30)->toDateString(),
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now(), 
            ],
            [
                'voucher_name' => 'Discount20',
                'description' => 'Giảm 20% với đơn hàng hơn 200k.',
                'discount_percent' => 20,
                'minium_condition' => 200000,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addDays(60)->toDateString(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'voucher_name' => 'SummerSale',
                'description' => 'Giảm 15% trong đợt hè này.',
                'discount_percent' => 15,
                'minium_condition' => 150,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addDays(45)->toDateString(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
