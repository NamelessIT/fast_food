<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController
{
    public function index()
    {
        // Fetch all products from the database
        $all_products = Product::all();
        
        // Return the view with all products
        return view('products.welcome', compact('all_products'));
    }
}
