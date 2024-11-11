<?php

namespace App\Livewire\Product\ListProduct;

use App\Models\Category;
use Livewire\Component;

class SideBarSearching extends Component
{
    public $listCategory = [];

    public function mount()
    {
        $query = request()->query('category');
        $query = explode('-', $query);
        $this->listCategory = Category::all();

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

                array_push($list, [
                    'id' => $item->id,
                    'slug' => $finalSlug,
                    'category_name' => $item->category_name,
                    'active' => $active
                ]);
            }

            $this->listCategory = $list;
        }
    }
    public function render()
    {
        return view('livewire.product.list-product.side-bar-searching');
    }
}