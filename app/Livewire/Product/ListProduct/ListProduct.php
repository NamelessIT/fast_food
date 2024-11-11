<?php

namespace App\Livewire\Product\ListProduct;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class ListProduct extends Component
{
    public $page = 1;
    public $itemQuantity;

    public $listProductItem = [];

    public $typeDisplay = "";

    public function mount ($page, $itemQuantity, $typeDisplay) {
        $this->page = (int) $page;
        // dd ($this->page);
        $this->itemQuantity = $itemQuantity;
        $this->typeDisplay = $typeDisplay;

        $offset = config('constants.product.product_item_per_page') * ($page - 1);
        $limit =  config('constants.product.product_item_per_page') * $page;

        $categories = explode( '-',request()->query('category'));
        $search = request()->query('search');
        if ($categories && count($categories) > 0 && $categories[0] != '') {
            $category = Category::whereIn('slug', $categories)->pluck('id');

            $this->listProductItem = Product::whereIn('id_category', $category)->skip ($offset)->take ($limit)->get ();

        }
        else if ($search) {
            $this->listProductItem = Product::where('product_name', 'like', '%' . $search . '%')->skip ($offset)->take ($limit)->get ();
        }
        else {
            $this->listProductItem = Product::all()->skip ($offset)->take ($limit);
        }
    }

    public function render()
    {
        return view('livewire.product.list-product.list-product',[
            "listProduct" => $this->listProductItem,
        ]);
    }
}