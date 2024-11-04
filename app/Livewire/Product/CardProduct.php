<?php

namespace App\Livewire\Product;

use Livewire\Component;

class CardProduct extends Component
{
    public $id;
    public $product_name;
    public $price;
    public $imageShow;
    public $slug;

    public function mount($id, $product_name, $imageShow,$price, $slug)
    {
        $this->id = $id;
        $this->product_name = $product_name;
        $this->imageShow = $imageShow;
        $this->price = $price;
        $this->slug = $slug;
    }


    public function render()
    {

        return view('livewire.product.card-product', [
            'id' =>$this->id,
            'product_name' => $this->product_name,
            'imageShow' => $this->imageShow,
            "price" =>   $this->price
        ]);
    }
}