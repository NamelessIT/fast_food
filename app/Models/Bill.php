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
        'created_at',
        'updated_at',
    ];

    // Tự động tạo id tự tăng cho khóa chính
    // public $incrementing = true;

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

   
}
