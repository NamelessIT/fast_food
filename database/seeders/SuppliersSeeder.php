<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SuppliersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('suppliers')->insert([
            ['id' => 1, 'supplier_name' => 'Nhà cung cấp Gà ChickenGang', 'phone_contact' => '0901234567', 'email' => 'supplier1@example.com', 'address' => '123 Đường A, TP HCM', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'supplier_name' => 'Nhà cung cấp Khoai Lang Thang', 'phone_contact' => '0912345678', 'email' => 'supplier2@example.com', 'address' => '456 Đường B, TP HCM', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'supplier_name' => 'Nhà cung cấp Bánh mì PewPew', 'phone_contact' => '0923456789', 'email' => 'supplier3@example.com', 'address' => '789 Đường C, TP HCM', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
