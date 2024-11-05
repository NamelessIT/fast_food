<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExtraFoodDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('extra_food_detail')->insert([
            // Gà rán
            [
                'id_extra_food' => 1,
                'id_category' => 2
            ],
            [
                'id_extra_food' => 2,
                'id_category' => 2
            ],
            [
                'id_extra_food' => 3,
                'id_category' => 2
            ],

            // Burger
            [
                'id_extra_food' => 4,
                'id_category' => 1
            ],
            [
                'id_extra_food' => 5,
                'id_category' => 1
            ],
        ]);
    }
}