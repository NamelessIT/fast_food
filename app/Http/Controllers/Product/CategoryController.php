<?php

namespace App\Http\Controllers\Product;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController
{
    public function index ($categoryName) {
        // $category = Category::where('valueEn', $categoryName)->firstOrFail();
        // $products = $category->products;

        // dd ($products);
        return view ('category.index', [
            "title" => $categoryName
        ]);
    }
}