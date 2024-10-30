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
    
    protected $primaryKey = 'id_ingredient'; // Đặt khóa chính phức hợp
    public $incrementing = false; // Không tự động tăng
    public function ingredient(){
        return $this->belongsTo(Ingredient::class,'id_ingredient', 'id');
    }
    public function receiptDetails(){
        return $this->hasMany(ReceiptDetail::class, 'id_receipt', 'id');
    }

    protected static function booted(){
        static::created(function ($receiptDetail) {
            $ingredient = Ingredient::find($receiptDetail->id_ingredient);
            if ($ingredient) {// Tăng remain_quantity theo quantity trong receipt_detail
                $ingredient->increment('remain_quantity', $receiptDetail->quantity);
            }
        });

        static::saved(function ($receiptDetail) {
            $receipt = $receiptDetail->receipt;
            if ($receipt) {
                $receipt->total = $receipt->receiptDetails()->sum('total_price');
                $receipt->saveQuietly();
            }
        });

        static::deleted(function ($receiptDetail) {
            $receipt = $receiptDetail->receipt;
            if ($receipt) {
                $receipt->total = $receipt->receiptDetails()->sum('total_price');
                $receipt->saveQuietly();
            }
        });
    }

public function receipt()
{
    return $this->belongsTo(Receipt::class, 'id_receipt');
}


}
