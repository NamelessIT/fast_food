<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExtraFoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // gà rán
        $imageGR1 = 'https://www.lotteria.vn/media/catalog/product/cache/7519c4b08d36a80a7631ac53889db3b4/d/e/dessert_shake_chicken_ph_mai_.png';
        $imageContents = file_get_contents($imageGR1);
        $imageBlobGR1 = base64_encode($imageContents);
        $imageGR2 = 'https://www.lotteria.vn/media/catalog/product/cache/7519c4b08d36a80a7631ac53889db3b4/d/e/dessert_shake_potato_ph_mai_.png';
        $imageContents = file_get_contents($imageGR2);
        $imageBlobGR2 = base64_encode($imageContents);
        $imageGR3 = 'https://www.lotteria.vn/media/catalog/product/cache/7519c4b08d36a80a7631ac53889db3b4/d/e/dessert_cheese_stick_1_.png';
        $imageContents = file_get_contents($imageGR3);
        $imageBlobGR3 = base64_encode($imageContents);

        // burger
        $imageBG1 = 'https://www.lotteria.vn/media/catalog/product/cache/7519c4b08d36a80a7631ac53889db3b4/l/s/ls0023_4.png';
        $imageContents = file_get_contents($imageBG1);
        $imageBlobBG1 = base64_encode($imageContents);
        $imageBG2 = 'https://www.lotteria.vn/media/catalog/product/cache/7519c4b08d36a80a7631ac53889db3b4/e/x/extra_fried_egg_1_.png';
        $imageContents = file_get_contents($imageBG2);
        $imageBlobBG2 = base64_encode($imageContents);

        DB::table('extra_food')->insert([
            // gà rán
            [
                'food_name' => 'Gà Lắc',
                'cod_price' => 35000,
                'price' => 44000,
                'quantity' => 10,
                'image_show' => $imageBlobGR1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'food_name' => 'Khoai Tây Lắc',
                'cod_price' => 30000,
                'price' => 39000,
                'quantity' => 10,
                'image_show' => $imageBlobGR2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'food_name' => 'Phô Mai Que',
                'cod_price' => 30000,
                'price' => 36000,
                'quantity' => 10,
                'image_show' => $imageBlobGR3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Burger
            [
                'food_name' => 'Phô Mai Miếng',
                'cod_price' => 5000,
                'price' => 7000,
                'quantity' => 10,
                'image_show' => $imageBlobBG1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'food_name' => 'Trứng',
                'cod_price' => 5000,
                'price' => 7000,
                'quantity' => 10,
                'image_show' => $imageBlobBG2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}