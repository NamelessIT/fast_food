<?php

namespace App\Livewire\Home;

use DB;
use Livewire\Component;

class BestSellerProduct extends Component
{
    public $listProduct = [];

    public function mount()
    {
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
                WHERE (MONTH(bill_details.created_at) = MONTH(CURRENT_DATE())
                    AND YEAR(bill_details.created_at) = YEAR(CURRENT_DATE())
                    OR bill_details.created_at IS NULL)
            GROUP BY
                products.id, products.product_name, products.image_show, products.price, products.slug
            ORDER BY
                total_quantity_sold DESC
            LIMIT 4'
        );
    }
    public function render()
    {
        return view('livewire.home.best-seller-product');
    }
}