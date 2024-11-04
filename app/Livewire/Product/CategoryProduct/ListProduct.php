<?php

namespace App\Livewire\Product\CategoryProduct;

use App\Models\Category;
use Livewire\Component;

class ListProduct extends Component
{
    public $categoryName = "";
    public $page = 1;
    public $itemQuantity;

    public $listProductItem = [];

    public $typeDisplay = "";

    public function mount($itemQuantity, $categoryName)
    {
        $this->itemQuantity = $itemQuantity;
        $this->categoryName = $categoryName;
        // dd ($this->categoryName);
        $categoryEN = Category::where('slug', $categoryName)->firstOrFail();
        // dd ($categoryEN);
        $this->listProductItem = $categoryEN->products;
        // dd ($this->listProductItem);
        // $this->listProductItem  = Product::all();
    }
    public function render()
    {
        return view('livewire.product.category-product.list-product', [
            "listProduct" => $this->listProductItem,
           
        ]);
    }
}