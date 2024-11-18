<?php

namespace App\Livewire\Product\ListProduct;

use Livewire\Component;
use Route;
use URL;

class RangePrice extends Component
{
    public $minPrice = 0;
    public $maxPrice = 0;
    public $pathSearch = "";
    public $pathCategory = "";

    public function mount() {
        $this->pathSearch = request()->query('search');
        $this->pathCategory = request()->query('category');

        $this->minPrice = request()->query('minPrice');
        $this->maxPrice = request()->query('maxPrice');
    }

    public function handleFilter() {
        $this->validate([
            'minPrice' => 'required|numeric|min:0',
            'maxPrice' => 'required|numeric|min:0|gte:minPrice',
        ], [
            'minPrice.required' => 'Giá bắt buộc',
            'minPrice.numeric' => 'Giá phải là số',
            'minPrice.min' => 'Giá phải lớn hơn hoặc bằng 0',
            'maxPrice.required' => 'Giá bắt buộc',
            'maxPrice.numeric' => 'Giá phải là số',
            'maxPrice.min' => 'Giá phải lớn hơn hoặc bằng 0',
            'maxPrice.gte' => 'Giá phải lớn hơn giá trên',
        ]);

        return redirect()->route('product.list-product', [
            'page' => 1,
            'search' => $this->pathSearch,
            'category' => $this->pathCategory,
            'minPrice' => $this->minPrice,
            'maxPrice' => $this->maxPrice,
        ]);
    }

    public function render()
    {
        return view('livewire.product.list-product.range-price');
    }
}