<?php

namespace App\Livewire\Product\DetailProduct;

use App\Models\Product;
use Livewire\Component;

class Detail extends Component
{
    public $slug;
    public $detail;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->detail = Product::where('slug', $slug)->get()->toArray();
        // dd($this->detail[0]);
        $this->detail = $this->detail[0];
        // dd ($this->detail);
    }
    public function render()
    {
        return view('livewire.product.detail-product.detail');
    }
}