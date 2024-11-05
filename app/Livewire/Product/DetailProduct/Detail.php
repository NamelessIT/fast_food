<?php

namespace App\Livewire\Product\DetailProduct;

use App\Models\Product;
use Livewire\Component;

class Detail extends Component
{
    public $slug;
    public $detail;
    public $listExtraFood;

    public function mount($slug)
    {
        $this->slug = $slug;
        $getProduct = Product::where('slug', $slug);
        // dd($getProduct);
        $this->listExtraFood = $getProduct->first()->extraFoods->toArray();
        // dd ($this->listExtraFood);
        // $test = Product::where('slug', $slug)->with('extraFoods')->first();
        // dd($test->extraFoods);
        $this->detail = $getProduct->get()->toArray()[0];
        // dd ($this->detail);
    }
    public function render()
    {
        return view('livewire.product.detail-product.detail');
    }
}