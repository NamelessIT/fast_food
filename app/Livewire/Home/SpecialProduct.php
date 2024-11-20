<?php

namespace App\Livewire\Home;

use App\Models\Product;
use DB;
use Livewire\Component;

class SpecialProduct extends Component
{
    public $listProduct = [];

    public function mount()
    {
        // $this->listProduct = Product::orderBy('created_at', 'desc')->limit(4)->get();
        // $this->listProduct = Product::leftJoin('bill_details', 'products.id', '=', 'bill_details.id_product')->select('products.*', \DB::raw('COALESCE(SUM(bill_details.quantity), 0) as total_quantity_sold'))->groupBy('products.id', 'products.product_name', 'products.id_category', 'products.created_at', 'products.updated_at', 'products.deleted_at', 'products.cod_price', 'products.price', 'products.id_promotion', 'products.image_show', 'products.description', 'products.status', 'products.slug')->orderBy('total_quantity_sold', 'desc')->limit(4)->get();
        $this->listProduct = DB::select(
            'SELECT
                products.id, 
                products.product_name,
                products.image_show,
                products.price,
                products.slug,
                COALESCE(SUM(bill_details.quantity), 0) AS total_quantity_sold
            FROM
                products
            LEFT JOIN
                bill_details
            ON
                products.id = bill_details.id_product
            GROUP BY
                products.id, products.product_name, products.image_show, products.price, products.slug
            ORDER BY
                total_quantity_sold DESC
            LIMIT 4'
        );
    }

    public function render()
    {
        return view('livewire.home.special-product');
    }
}