<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillExtraFoodDetail extends Model
{
    use HasFactory;

    protected $table = 'bill_extra_food_detail';

    protected $fillable = [
        'id_bill_detail',
        'id_extra_food',
        'quantity',
        'created_at',
        'updated_at'
    ];

    // Định nghĩa quan hệ với các bảng khác
   

  

   
}
