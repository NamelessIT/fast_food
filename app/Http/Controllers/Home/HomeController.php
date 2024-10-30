<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

class HomeController
{
    public function index () {
        return view("home.index");
    }
}
