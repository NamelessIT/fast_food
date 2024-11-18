<?php

namespace App\Livewire\Product\DetailProduct;

use Livewire\Component;

class Index extends Component
{
    public $slug = '';

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        return view('livewire.product.detail-product.index');
    }
}