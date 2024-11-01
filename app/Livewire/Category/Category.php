<?php

namespace App\Livewire\Category;

use Livewire\Component;

class Category extends Component
{
    public $categoryName = '';
    public $categories = [];

    public function mount ($categoryName) {
        $this->categories = \App\Models\Category::all();
        $this->categoryName = $categoryName;
    }

    public function render()
    {
        return view('livewire.category.category');
    }
}