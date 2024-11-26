<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'voucher_name',
        'description',
        'discount_percent',
        'minium_condition',
        'start_date',
        'end_date',
    ];
}
