<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraFood extends Model
{
    use HasFactory;

    protected $table = 'extra_food';

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'extra_food_details', 'id_extra_food', 'id_category');
    }
}