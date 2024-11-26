<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExtraFood extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'food_name',
        'price',
        'cod_price',
        'quantity',
        'image_show',
    ];

    protected $table = 'extra_food';

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'extra_food_detail', 'id_extra_food', 'id_category');
    }

    public function orderdetails () {
        return $this->belongsToMany(OrderDetail::class , 'order_extra_food_detail', 'id_extra_food','id_order_detail' )->withPivot("quantity");
    }

}
