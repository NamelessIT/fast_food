<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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
        return $this->morphOne(Account::class, 'user', 'user_type', 'user_id');
    }
    public function role(){
        return $this->belongsTo(Role::class,'id_role','id');
    }

    protected static function booted()
    {
        // Khi xóa mềm
        static::deleted(function ($model) {
            // Truy vấn trực tiếp để cập nhật bảng khác
            DB::table('accounts')
                ->where('user_id', $model->id)
                ->update(['status' => 0]);
        });

        // Khi khôi phục
        static::restored(function ($model) {
            DB::table('accounts')
                ->where('user_id', $model->id)
                ->update(['status' => 1]);
        });
    }
}
