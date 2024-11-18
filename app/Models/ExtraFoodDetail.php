<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraFoodDetail extends Model
{
    use HasFactory;

    protected $table = 'extra_food_detail';

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function extraFood()
    {
        return $this->belongsTo(ExtraFood::class, 'id_extra_food');
    }
}