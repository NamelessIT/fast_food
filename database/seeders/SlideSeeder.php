<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // url
        $image1 = "https://cdn.dribbble.com/users/3428605/screenshots/10007841/dribble.jpg";
        $image2= "https://images.squarespace-cdn.com/content/v1/5f96d9688397f415e887f7f2/1612065289710-TA94TDYZSCTVXRMXOLAT/LoveBird-Tenders-crop.jpg?format=1500w";
        $image3 = "https://library.urnerbarry.com/Images/Feed6_1.jpg";

        $imageContents = file_get_contents($image1);
        $imageBlob1 = base64_encode($imageContents);
        $imageContents = file_get_contents($image2);
        $imageBlob2 = base64_encode($imageContents);
        $imageContents = file_get_contents($image3);
        $imageBlob3 = base64_encode($imageContents);

        DB::table('slides')->insert([
            [
                'image_show' => $imageBlob1,
            ],
            [
                'image_show' => $imageBlob2,
            ],
            [
                'image_show' => $imageBlob3,
            ],

        ]);
    }
}