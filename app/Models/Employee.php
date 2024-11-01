<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
         'id',
         'full_name',
         'phone',
         'id_role',
         'salary',
         'created_at',
         'updated_at',
     ];


    public function account() {
        return $this->morphOne(Account::class, 'user', 'user_type', 'id_user');
    }
    public function role(){
        return $this->belongsTo(Role::class,'id_role','id');
    }
}
