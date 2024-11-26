<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    use HasFactory;

    protected $table = 'bill_details';
    protected $appends = ['product_price','total_price'];

    protected $fillable = [
        'id_bill',
        'id_product',
        'quantity',
        'created_at',
        'updated_at'
    ];

    // Định nghĩa quan hệ với các bảng khác
    public function bill()
    {
        return $this->belongsTo(Bill::class, 'id_bill');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
    public function extraFoods()
    {
        return $this->hasMany(BillExtraFoodDetail::class, 'id_bill_detail');
    }

    public function getProductPriceAttribute()
    {
        return $this->product?->price ?? 0;
    }
    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->product_price; // quantity * product price
    }



    // Thiết lập các thuộc tính trước khi lưu
    public static function boot()
    {
        parent::boot();

        // Xác định thời gian tạo và cập nhật
        self::creating(function ($billDetail) {
            $billDetail->created_at = now();
            $billDetail->updated_at = now();
        });
    }
}
