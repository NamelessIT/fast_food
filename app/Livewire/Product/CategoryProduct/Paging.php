<?php

namespace App\Livewire\Product\CategoryProduct;

use App\Models\Category;
use Livewire\Component;

class Paging extends Component
{
    public $pageCurrent = 1;
    public $totalPage = 1;
    public $categoryName = "";

    public function mount ($pageCurrent, $categoryName) {
        $this->pageCurrent = $pageCurrent;
        $this->categoryName = $categoryName;
        $category = Category::where('slug', $categoryName)->firstOrFail();
        // dd ($category);
        $this->totalPage = ceil(count ($category->products) / config('constants.product.product_item_per_page'));
        // dd ($this->totalPage);
    }
    public function render()
    {
        return view('livewire.product.category-product.paging');
    }
}