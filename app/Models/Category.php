<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'category_name',
        'description',
        'slug',
        'image',
        'status',
    ];

    public function products () {
        return $this->hasMany(Product::class, 'id_category');
    }

    public function extraFoodDetails()
    {
        return $this->hasMany(ExtraFoodDetail::class, 'id_category');
    }

    public function extraFoods()
    {
        return $this->belongsToMany(ExtraFood::class, 'extra_food_detail', 'id_category', 'id_extra_food');
    }
}
