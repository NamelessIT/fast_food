<?php

namespace App\Livewire\Product\ListProduct;

use App\Models\Product;
use Livewire\Component;

class ListProduct extends Component
{
    public $page = 1;
    public $itemQuantity;

    public $listProductItem = [];

    public $typeDisplay = "";

    public function mount ($page, $itemQuantity, $typeDisplay) {
        $this->page = $page;
        $this->itemQuantity = $itemQuantity;
        $this->typeDisplay = $typeDisplay;

        $offset = config('constants.product.product_item_per_page') * ($page - 1);
        $limit =  config('constants.product.product_item_per_page') * $page;

        $this->listProductItem = Product::all()->skip ($offset)->take ($limit);
        // dd ($this->listProductItem[0]['price']);
    }

    public function render()
    {
        return view('livewire.product.list-product.list-product',[
            "listProduct" => $this->listProductItem,
        ]);
    }
}