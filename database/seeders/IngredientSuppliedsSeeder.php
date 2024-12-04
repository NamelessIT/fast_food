<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class IngredientSuppliedsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ingredient_supplieds')->insert([
            ['id_ingredient' => 1, 'id_supplier' => 1, 'ingredient_price' => 80000, 'created_at' => now(), 'updated_at' => now()],
            ['id_ingredient' => 2, 'id_supplier' => 2, 'ingredient_price' => 15000, 'created_at' => now(), 'updated_at' => now()],
            ['id_ingredient' => 3, 'id_supplier' => 3, 'ingredient_price' => 5000, 'created_at' => now(), 'updated_at' => now()],
            ['id_ingredient' => 4, 'id_supplier' => 2, 'ingredient_price' => 20000, 'created_at' => now(), 'updated_at' => now()],
            ['id_ingredient' => 5, 'id_supplier' => 3, 'ingredient_price' => 10000, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
