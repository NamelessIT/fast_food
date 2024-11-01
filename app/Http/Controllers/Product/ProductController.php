<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController
{
    public function detail($name, $id)
    {
        // dd ($name, $id);
        return view('products.detail-product', [
            'id' => $id,
            'name' => $name
        ]);
    }
}