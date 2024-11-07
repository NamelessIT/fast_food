<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_category',
        'product_name',
        'cod_price',
        'price',
        'id_promotion',
        'description',
        'image_show',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function extraFoods()
    {
        return $this->hasManyThrough(
            ExtraFood::class,
            ExtraFoodDetail::class,
            'id_category',
            'id',
            'id_category',
            'id_extra_food'
        );
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, "order_details", "id_product", "id_order")->withPivot("quantity");
    }
}
