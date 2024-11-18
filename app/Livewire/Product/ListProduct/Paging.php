<?php

namespace App\Livewire\Product\ListProduct;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class Paging extends Component
{
    public $pageCurrent = 1;
    public $totalPage = 1;

    public function mount ($pageCurrent) {
        $this->pageCurrent = $pageCurrent;

        $categories = explode( '-',request()->query('category'));
        // dd ($categories);
        $search = request()->query('search');

        if ($categories && count($categories) > 0 && $categories[0] != '') {
            $this->pageCurrent = $pageCurrent;
            $category = Category::whereIn('slug', $categories)->get();
            // dd ($category);
            $count = 0;
            foreach ($category as $item) {
                $count+= count ($item->products);
            }

            $this->totalPage = ceil($count / config('constants.product.product_item_per_page'));
            // $this->totalPage = ceil(count ($category->products) / config('constants.product.product_item_per_page'));
            // dd ($this->totalPage);
        }
        else if ($search) {
            // dd ($search);
            $this->pageCurrent = $pageCurrent;
            $this->totalPage = ceil(Product::where('product_name', 'like', '%' . $search . '%')->count() / config('constants.product.product_item_per_page'));
            // dd($this->totalPage);
        }
        else {
            $this->totalPage = ceil(Product::count() / config('constants.product.product_item_per_page'));
        }

    }

    public function render()
    {
        return view('livewire.product.list-product.paging');
    }
}