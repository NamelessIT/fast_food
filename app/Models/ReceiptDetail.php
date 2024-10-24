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
    protected $casts = [
        'id'=> 'array',
    ];
    protected $primaryKey = 'id_ingredient'; // Đặt khóa chính phức hợp
    public $incrementing = false; // Không tự động tăng
    public function ingredient(){
        return $this->belongsTo(Ingredient::class,'id_ingredient', 'id');
    }
}
