<?php

namespace App\Livewire\Product\DetailProduct;

use App\Models\Product;
use DB;
use Livewire\Component;

class SimilarProduct extends Component
{
    public $listProduct = [];

    public function mount($slug)
    {
        $this->listProduct = DB::select(
            'SELECT *
            FROM products
            WHERE slug != ?
            AND id_category = ?
            ORDER BY RAND()
            LIMIT 4
            ',
            [
                $slug,
                Product::where('slug', $slug)->first()->id_category,
            ]
        );
        
    }

    public function render()
    {
        return view('livewire.product.detail-product.similar-product');
    }
}