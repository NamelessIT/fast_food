<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;

class Account extends Authenticatable implements HasName, FilamentUser
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'username',
        'password',
        'user_id',
        'user_type',
        'avatar',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function user () {
        return $this->morphTo('user','user_type','user_id');
    }

    public function getFilamentName(): string{
        return $this->username;
    }

    //chỉ cho employee đăng nhập admin panel
    // Phương thức kiểm tra quyền truy cập vào admin panel
    public function canAccessPanel(Panel $panel): bool
    {
        if ($this->user_type === 'App\Models\Customer') {
            // Nếu người dùng không phải là employee, trả về lỗi với thông báo tùy chỉnh
            //abort(403, 'access denied.');
            //return false;
            // Lưu thông báo lỗi vào session và điều hướng
            session()->flash('error', 'Bạn không có quyền truy cập vào trang quản trị.');

            redirect()->route('account.index'); // Điều hướng đến trang đăng nhập
            return false;
        }

        return true; // Nếu người dùng có quyền, tiếp tục
    }
}
