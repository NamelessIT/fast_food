<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'id_product',
        'id_ingredient',
        'quantity'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product','id');
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'id_ingredient','id');
    }
}
