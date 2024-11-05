<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'image_show'  
    ];
    use HasFactory;

    public function category () {
        return $this->belongsTo(Category::class);
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
}