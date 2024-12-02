<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ReceiptsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('receipts')->insert([
            ['id' => 1, 'id_employee' => 1, 'total' => 20500000, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'id_employee' => 1, 'total' => 450000, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
