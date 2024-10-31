<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController
{
    public function index()
    {
        $categoryItems = DB::table('categories')->get();
        $slideshowImages = DB::table('slides')->pluck('image_show');
        return view("home.index", [
            "slideshowImages" => $slideshowImages,
            "categoryItems" =>   $categoryItems
        ]);
    }
}
