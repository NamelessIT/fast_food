<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'id_employee',
        'total',
        'created_at',
        'updated_at',
     ];

    public function employee(){
        return $this->hasMany(Employee::class,'id', 'id_employee');
    }
   
    public function receiptDetails() {
        return $this->hasMany(ReceiptDetail::class, 'id_receipt', 'id');
    }





    protected static function booted(){
        static::saved(function ($receipt) {
            $receipt->total = $receipt->receiptDetails()->sum('total_price');
            $receipt->saveQuietly(); // Sử dụng saveQuietly để tránh vòng lặp vô hạn
        });
    }

    
}
