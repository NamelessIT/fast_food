<?php

namespace App\Livewire\Product\ListProduct;

use App\Models\Category;
use Livewire\Component;

class SideBarSearching extends Component
{
    public $listCategory = [];
    public $search = '';
    public $minPrice = '';
    public $maxPrice = '';

    public function mount()
    {
        $query = request()->query('category');
        $query = explode('-', $query);
        $this->listCategory = Category::all();
        $this->search = request()->query('search');

        $this->minPrice = request()->query('minPrice');
        $this->maxPrice = request()->query('maxPrice');

        if ($query) {
            $list = [];

            foreach ($this->listCategory as $item) {
                $slug = $item->slug;
                $active = false;

                if ($query && count($query) > 0 && $query[0] != '') {
                    foreach ($query as $queryItem) {
                        if ($item->slug != $queryItem) {
                            $slug .= '-' . $queryItem;
                        } else {
                            $active = true;
                        }
                    }
                }

                $finalSlug = $active ? substr($slug, strlen($item->slug) + 1) : $slug;

                if ($this->minPrice && $this->maxPrice) {
                    array_push($list, [
                        'id' => $item->id,
                        'slug' => $finalSlug,
                        'category_name' => $item->category_name,
                        'active' => $active,
                        'minPrice' => $this->minPrice,
                        'maxPrice' => $this->maxPrice,
                    ]);
                } else {
                    array_push($list, [
                        'id' => $item->id,
                        'slug' => $finalSlug,
                        'category_name' => $item->category_name,
                        'active' => $active,
                    ]);
                }
            }

            $this->listCategory = $list;
        }
    }

    public function handleSearch()
    {
        return redirect()->route('product.list-product', [
            'page' => 1,
            'search' => $this->search,
            // 'category' => $this->pathCategory,
            'minPrice' => $this->minPrice,
            'maxPrice' => $this->maxPrice,
        ]);
    }
    public function render()
    {
        return view('livewire.product.list-product.side-bar-searching');
    }
}