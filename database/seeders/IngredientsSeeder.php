<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class IngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ingredients')->insert([
            ['id' => 1, 'ingredient_name' => 'Gà tây', 'remain_quantity' => 100, 'unit' => 'kg', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'ingredient_name' => 'Khoai tây', 'remain_quantity' => 200, 'unit' => 'kg', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'ingredient_name' => 'Bánh mì burger', 'remain_quantity' => 50, 'unit' => 'pcs', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'ingredient_name' => 'Xà lách', 'remain_quantity' => 30, 'unit' => 'kg', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'ingredient_name' => 'Nước ngọt lon', 'remain_quantity' => 100, 'unit' => 'pcs', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
