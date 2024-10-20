<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptDetail extends Model
{
    use HasFactory;
    protected $fillable = [
       'id_receipt',
        'id_ingredient',
        'quantity',
        'total_price',
        'created_at',
        'updated_at',
    ];
}
