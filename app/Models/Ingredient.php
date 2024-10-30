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
     
}
