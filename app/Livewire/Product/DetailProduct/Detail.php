<?php

namespace App\Livewire\Product\DetailProduct;

use App\Models\Product;
use Livewire\Component;

class Detail extends Component
{
    public $idProduct;
    public $detail;

    public function mount($idProduct)
    {
        $this->idProduct = $idProduct;
        $this->detail = Product::find($idProduct)->toArray();
        // dd($this->detail);
    }
    public function render()
    {
        return view('livewire.product.detail-product.detail');
    }
}
