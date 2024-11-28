<?php

namespace App\Livewire\Home;

use DB;
use Livewire\Component;

class BestSellerProduct extends Component
{
    public $listProduct = [];

    public function mount()
    {
        $this->listProduct = DB::table('products')
        ->select(
            'products.id',
            'products.product_name',
            'products.image_show',
            'products.price',
            'products.slug',
            DB::raw('COALESCE(SUM(bill_details.quantity), 0) AS total_quantity_sold')
        )
        ->leftJoin('bill_details', 'products.id', '=', 'bill_details.id_product')
        ->where(function ($query) {
            $query->whereRaw("MONTH(bill_details.created_at) = MONTH(CURRENT_DATE())")
                  ->whereRaw("YEAR(bill_details.created_at) = YEAR(CURRENT_DATE())")
                  ->orWhereNull('bill_details.created_at');
        })
        ->groupBy(
            'products.id',
            'products.product_name',
            'products.image_show',
            'products.price',
            'products.slug'
        )
        ->orderBy('total_quantity_sold', 'DESC')
        ->limit(4)
        ->get();
    
        
    }
    public function render()
    {
        return view('livewire.home.best-seller-product');
    }
}