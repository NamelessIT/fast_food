<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingredient extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'id',
        'ingredient_name',
        'remain_quantity',
        'unit',
        'created_at',
        'updated_at',
     ];

     public function ingredient()
     {
         return $this->belongsTo(Ingredient::class, 'id_ingredient', 'id');
     }

}
