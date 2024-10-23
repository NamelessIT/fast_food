<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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


}
