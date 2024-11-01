<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Bill extends Model
{
    use HasFactory;

    protected $table = 'bills';
    
    protected $fillable = [
        'id_customer',
        'id_address',
        'id_payment',
        'id_voucher',
        'total',
        'point_receive',
        'status',
    ];

    // Tự động tạo id tự tăng cho khóa chính
    public $incrementing = true;

    // Định nghĩa quan hệ với các bảng khác
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'id_address');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'id_payment');
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'id_voucher');
    }

    // Thiết lập các thuộc tính trước khi lưu
    public static function boot()
    {
        parent::boot();

        // Xác định sự kiện khi tạo bill mới
        self::creating(function ($bill) {
            // Lấy id_customer từ tài khoản đăng nhập
            $bill->id_customer = Auth::id();
            
            // Tính point_receive dựa trên giá trị total
            if (!empty($bill->total)) {
                $bill->point_receive = $bill->total / 10000;
            }
            $bill->created_at = now();
            $bill->updated_at = now();
        });
    }
}
