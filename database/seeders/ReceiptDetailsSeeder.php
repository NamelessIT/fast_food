<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ReceiptDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('receipt_details')->insert([
            ['id_receipt' => 1, 'id_ingredient' => 1, 'quantity' => 20, 'total_price' => 1600000, 'created_at' => now(), 'updated_at' => now()],
            ['id_receipt' => 1, 'id_ingredient' => 2, 'quantity' => 30, 'total_price' => 450000, 'created_at' => now(), 'updated_at' => now()],
            ['id_receipt' => 2, 'id_ingredient' => 3, 'quantity' => 50, 'total_price' => 250000, 'created_at' => now(), 'updated_at' => now()],
            ['id_receipt' => 2, 'id_ingredient' => 4, 'quantity' => 10, 'total_price' => 200000, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
