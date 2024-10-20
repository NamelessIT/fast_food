<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'full_name',
        'phone',
        'points',
        'created_at',
        'updated_at',
    ];

    public function account () {
        return $this->morphOne(Account::class, 'user');
    }
}