<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // burger
        $image1 = base64_encode(file_get_contents('https://www.lotteria.vn/media/catalog/product/m/e/menu_burger_2.jpg'));
        $image2 = base64_encode(file_get_contents('https://www.lotteria.vn/media/catalog/product/b/u/burger_bulgogi_4.png'));
        $image3 = base64_encode(file_get_contents('https://www.lotteria.vn/media/catalog/product/b/u/burger_shrimp_1_.png'));
        $image4 = base64_encode(file_get_contents('https://www.lotteria.vn/media/catalog/product/b/u/burger_l-chicken.png'));

        // gà rán
        $image5 = base64_encode(file_get_contents('https://www.lotteria.vn/media/catalog/product/m/e/menu_1_mieng.jpg'));
        $image6 = base64_encode(file_get_contents('https://www.lotteria.vn/media/catalog/product/m/e/menu_k_chciken_menu_copy.png'));
        $image7 = base64_encode(file_get_contents('https://www.lotteria.vn/media/catalog/product/m/e/menu_k_chciken_menu.png'));
        $image8 = base64_encode(file_get_contents('https://www.lotteria.vn/media/catalog/product/l/c/lc0001_4.png'));

        // đồ uống
        $image9 = base64_encode(file_get_contents('https://www.lotteria.vn/media/catalog/product/d/r/drink_milkis.png'));
        $image10 = base64_encode(file_get_contents('https://www.lotteria.vn/media/catalog/product/l/_/l_coffee_matcha_latte-16.png'));
        $image11 = base64_encode(file_get_contents('https://www.lotteria.vn/media/catalog/product/l/_/l_coffee_c_ph_mu_i_2_1.png'));
        $image12 = base64_encode(file_get_contents('https://www.lotteria.vn/media/catalog/product/d/r/drink_pepsi_m_l_.png'));
      
        // combo
        $image13 = base64_encode(file_get_contents('https://www.lotteria.vn/media/catalog/product/c/o/combo_beef_teriyaki.png'));
        $image14 = base64_encode(file_get_contents('https://www.lotteria.vn/media/catalog/product/c/o/combo_d-double.png'));
        $image15 = base64_encode(file_get_contents('https://www.lotteria.vn/media/catalog/product/c/o/combo_l-chicken__1.png'));
        $image16 = base64_encode(file_get_contents('https://www.lotteria.vn/media/catalog/product/c/o/combo_beef_1.png'));

        $products = [
            [
                'id_category' => 1,
                'product_name' => 'Burger Gà Sốt Buldak',
                'cod_price' => 40000,
                'price' => 52000,
                'image_show' => $image1,
            ],
            [
                'id_category' => 1,
                'product_name' => 'Burger Bulgogi',
                'cod_price' => 35000,
                'price' => 49000,
                'image_show' => $image2,
            ],
            [
                'id_category' => 1,
                'product_name' => 'Burger Tôm',
                'cod_price' => 35000,
                'price' => 49000,
                'image_show' => $image3,
            ],
            [
                'id_category' => 1,
                'product_name' => 'Burger LChicken',
                'cod_price' => 45000,
                'price' => 52000,
                'image_show' => $image4,
            ],

                // gà rán
            [
                'id_category' => 2,
                'product_name' => 'Gà sốt Buldak',
                'cod_price' => 30000,
                'price' => 41000,
                'image_show' => $image5,
            ],
            [
                'id_category' => 2,
                'product_name' => 'K-Chicken 1 Miếng',
                'cod_price' => 30000,
                'price' => 41000,
                'image_show' => $image6,
            ],
            [
                'id_category' => 2,
                'product_name' => 'K-Chicken 3 Miếng',
                'cod_price' => 90000,
                'price' => 117000,
                'image_show' => $image7,
            ],
            [
                'id_category' => 2,
                'product_name' => 'Gà Rán 1 Miếng',
                'cod_price' => 28000,
                'price' => 36000,
                'image_show' => $image8,
            ],

            // đồ uống
            [
                'id_category' => 3,
                'product_name' => 'Milkis',
                'cod_price' => 17000,
                'price' => 22000,
                'image_show' => $image9,
            ],
            [
                'id_category' => 3,
                'product_name' => 'Matcha Latte',
                'cod_price' => 23000,
                'price' => 30000,
                'image_show' => $image10,
            ],
            [
                'id_category' => 3,
                'product_name' => 'Cafe Muối',
                'cod_price' => 21000,
                'price' => 30000,
                'image_show' => $image11,
            ],
            [
                'id_category' => 3,
                'product_name' => 'Pepsi (M)',
                'cod_price' => 10000,
                'price' => 14000,
                'image_show' => $image12,
            ],

            // combo
            [
                'id_category' => 4,
                'product_name' => 'Combo Burger Bò Teriyaki',
                'cod_price' => 65000,
                'price' => 72000,
                'image_show' => $image13,
            ],
            [
                'id_category' => 4,
                'product_name' => 'Combo Burger Double Double',
                'cod_price' => 92000,
                'price' => 102000,
                'image_show' => $image14,
            ],
            [
                'id_category' => 4,
                'product_name' => 'Combo Burger LChicken',
                'cod_price' => 70000,
                'price' => 84000,
                'image_show' => $image15,
            ],
            [
                'id_category' => 4,
                'product_name' => 'Combo Burger Bò',
                'cod_price' => 49000,
                'price' => 57000,
                'image_show' => $image16,
            ],
        ];

        foreach ($products as $productData) {
            $productData['created_at'] = Carbon::now();
            $productData['updated_at'] = Carbon::now();
            
            $product = DB::table('products')->insertGetId($productData);
            
            $slug = Str::slug($productData['product_name'] . '-' . $product);
        
            DB::table('products')->where('id', $product)->update(['slug' => $slug]);
        }
    }
}