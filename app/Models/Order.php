<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'id_customer',
        'total',
        'created_at',
        'updated_at',
    ];
    public function products () {
        return $this->belongsToMany (
            Product::class,
            "order_details",
            "id_order",
            "id_product")->withPivot ("quantity","id","total_price");
    }
}
