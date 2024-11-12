<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'supplier_name',
        'phone_contact',
        'email',
        'address',
        'created_at',
        'updated_at',
     ];
   
}
