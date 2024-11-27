<?php

namespace App\Models;

use App\Livewire\User\Address;
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
        return $this->belongsTo(CustomerAddress::class, 'id_address');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'id_payment');
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'id_voucher');
    }

    public function billDetails()
    {
        return $this->hasMany(BillDetail::class, 'id_bill');
    }

    public function extraFoods()
    {
        return $this->belongsToMany(ExtraFood::class, 'bill_extra_food_detail', 'id_bill_detail', 'id_extra_food')
                    ->withPivot('quantity'); // Lấy thêm cột quantity từ bảng trung gian
    }
}
