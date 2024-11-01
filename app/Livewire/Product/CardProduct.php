<?php

namespace App\Livewire\Product;

use Livewire\Component;

class CardProduct extends Component
{
    public $product_name;
    public $price;
    public $imageShow;

    public function mount($product_name, $imageShow,$price)
    {
        $this->product_name = $product_name;
        $this->imageShow = $imageShow;
        $this->price = $price;
    }


    public function render()
    {

        return view('livewire.product.card-product', [
            'product_name' => $this->product_name,
            'imageShow' => $this->imageShow,
            "price" =>   $this->price
        ]);
    }
}
