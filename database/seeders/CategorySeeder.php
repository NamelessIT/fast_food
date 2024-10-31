<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // URL của hình ảnh
        $imageUrl1 = 'https://www.lotteria.vn/media/catalog/tmp/category/MENU_DAT_HANG_BURGER_1__1.jpg';
        $imageUrl2 = 'https://www.lotteria.vn/media/catalog/tmp/category/BG-Menu-Chicken-01-01_1.jpg';
        $imageUrl3 = 'https://www.lotteria.vn/media/catalog/tmp/category/MENU_DAT_HANG_THU_C_UO_NG_new_3.jpg';
        $imageUrl4 = 'https://www.lotteria.vn/media/catalog/tmp/category/MENU_DAT_HANG_COMBO_m_i_2.jpg';
        $imageUrl5 = "https://www.lotteria.vn/media/catalog/tmp/category/MENU_DAT_HANG_BESTSELLER.jpg";

        $imageContents = file_get_contents($imageUrl1);
        $imageBlob1 = base64_encode($imageContents);
        $imageContents = file_get_contents($imageUrl2);
        $imageBlob2 = base64_encode($imageContents);
        $imageContents = file_get_contents($imageUrl3);
        $imageBlob3 = base64_encode($imageContents);
        $imageContents = file_get_contents($imageUrl4);
        $imageBlob4 = base64_encode($imageContents);
        $imageContents = file_get_contents($imageUrl5);
        $imageBlob5 = base64_encode($imageContents);
        DB::table('categories')->insert([
            [
                'valueVi' => 'Burger',
                'valueEn' => 'Burger',
                'image' => $imageBlob1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'valueVi' => 'Gà rán',
                'valueEn' => 'Chicken',
                'image' => $imageBlob2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'valueVi' => 'Thức uống',
                'valueEn' => 'Drinks',
                'image' => $imageBlob3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'valueVi' => 'Combo',
                'valueEn' => 'Combo',
                'image' => $imageBlob4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),  
            ],
            [
                'valueVi' => 'Bestseller',
                'valueEn' => 'Bestseller',
                'image' => $imageBlob5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}