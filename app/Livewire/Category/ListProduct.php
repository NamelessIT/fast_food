<?php

namespace App\Livewire\Category;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class ListProduct extends Component
{
    public $categoryName = "";
    public $page = 1;
    public $itemQuantity;

    public $listProductItem = [];

    public function mount($itemQuantity, $categoryName)
    {
        $this->itemQuantity = $itemQuantity;
        $this->categoryName = $categoryName;
        $categoryEN = Category::where('valueEn', $categoryName)->firstOrFail();
        $this->listProductItem =$categoryEN->products;
        // $this->listProductItem  = Product::all();
    }
    public function render()
    {
        return view('livewire.category.list-product', [
            "listProduct" => $this->listProductItem,
        ]);
    }
}