<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'product_name',
        'id_category',
        'cod_price',
        'price',
        'id_promotion',
        'description',
        'image_show',
        'status',
    ];

    public function category(){
        return $this->belongsTo(Category::class,'id_category','id');
    }
    public function recipes()
    {
        return $this->hasMany(Recipe::class,'id_product','id');
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