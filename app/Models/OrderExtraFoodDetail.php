<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderExtraFoodDetail extends Model
{
    use HasFactory;
    protected $table = 'order_extra_food_detail';

    protected $fillable = [
        'id_order_detail',
        'id_extra_food',
        'quantity',
        'created_at',
        'updated_at'
    ];
}