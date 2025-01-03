<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillExtraFoodDetail extends Model
{
    use HasFactory;

    protected $table = 'bill_extra_food_detail';
    protected $appends = ['price','extra_food_total'];

    protected $fillable = [
        'id_bill_detail',
        'id_extra_food',
        'quantity',
        'created_at',
        'updated_at'
    ];

    // Định nghĩa quan hệ với các bảng khác

    // Mối quan hệ với BillDetail
    public function billDetail()
    {
        return $this->belongsTo(BillDetail::class, 'id_bill_detail');
    }

    // Mối quan hệ với ExtraFood
    public function extraFood()
    {
        return $this->belongsTo(ExtraFood::class, 'id_extra_food');
    }
    // Tạo thuộc tính ảo 'price' từ ExtraFood
    public function getPriceAttribute()
    {
        return $this->extraFood ? $this->extraFood->price : 0;
    }
    // Tạo thuộc tính ảo 'extra_food_total' tính từ price và quantity
    public function getExtraFoodTotalAttribute()
    {
        return ($this->quantity * $this->price); // Lấy giá trị từ price đã tính toán và quantity
    }
}
