<?php

namespace App\Livewire\Product\CategoryProduct;

use App\Models\Category;
use Livewire\Component;

class ListProduct extends Component
{
    public $page = 1;
    public $categoryName = "";
    public $itemQuantity;

    public $listProductItem = [];

    public $typeDisplay = "";

    public function mount($page, $itemQuantity,$categoryName)
    {
        $this->page = $page;
        $this->itemQuantity = $itemQuantity;
        $this->categoryName = $categoryName;
        // dd ($this->categoryName);
        $offset = config('constants.product.product_item_per_page') * ($page - 1);
        $limit =  config('constants.product.product_item_per_page') * $page;
        $categoryEN = Category::where('slug', $categoryName)->firstOrFail();
        // dd ($categoryEN);
        $this->listProductItem = $categoryEN->products->skip($offset)->take($limit);
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