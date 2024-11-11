<?php

namespace App\Livewire\Product\ListProduct;

use App\Models\Product;
use Livewire\Component;

class Paging extends Component
{
    public $pageCurrent = 1;
    public $totalPage = 1;

    public function mount ($pageCurrent) {
        $this->pageCurrent = $pageCurrent;
        $this->totalPage = ceil(Product::count() / config('constants.product.product_item_per_page'));
        // dd ($this->totalPage);
    }

    public function render()
    {
        return view('livewire.product.list-product.paging');
    }
}