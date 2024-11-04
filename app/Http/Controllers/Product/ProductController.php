<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController
{
    public function detail($slug)
    {
        // dd ($name, $id);
        return view('products.detail-product', [
            'slug' => $slug
        ]);
    }
}