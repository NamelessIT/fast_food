<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController
{
    public function index()
    {
        $categoryItems = DB::table('categories')->get();
        $slideshowImages = DB::table('categories')->pluck('image');
        return view("home.index", [
            "slideshowImages" => $slideshowImages,
            "categoryItems" =>   $categoryItems
        ]);
    }
}
