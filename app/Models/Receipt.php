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
     protected $casts = [
        'id_employee'=> 'array',
    ];
    public function employee(){
        return $this->belongsTo(Employee::class,'id_employee', 'id');
    }
    public function receiptDetails() {
        return $this->hasMany(ReceiptDetail::class, 'id_receipt', 'id');
    }
    
}
