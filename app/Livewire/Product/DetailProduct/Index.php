<?php

namespace App\Livewire\Product\DetailProduct;

use Livewire\Component;

class Index extends Component
{
    public $idProduct = 0;

    public function mount($idProduct)
    {
        $this->idProduct = $idProduct;
    }

    public function render()
    {
        return view('livewire.product.detail-product.index');
    }
}