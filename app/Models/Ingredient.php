<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'ingredient_name',
        'remain_quantity',
        'unit',
        'created_at',
        'updated_at',
     ];

    public function recipes()
    {
        return $this->hasMany(Recipe::class,'id','id_ingredient');
    }
}
