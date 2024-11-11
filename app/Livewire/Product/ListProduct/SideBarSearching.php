<?php

namespace App\Livewire\Product\ListProduct;

use App\Models\Category;
use Livewire\Component;

class SideBarSearching extends Component
{
    public $listCategory = [];

    public function mount () {
        $this->listCategory = Category::all();
        // dd ($this->listCategory);
    }
    public function render()
    {
        return view('livewire.product.list-product.side-bar-searching');
    }
}