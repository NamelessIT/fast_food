<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;

class DeleteAccount extends Component
{
    public $account;
    public function mount()
    {
        $this->getAccount();
    }
    public function DeleteAccount()
    {
        // Kiểm tra xem tài khoản có tồn tại không
        if ($this->account) {
            // Xóa tài khoản khỏi cơ sở dữ liệu
            $this->account->delete();

            // Đăng xuất người dùng
            // Auth::logout();
            
            // Chuyển hướng đến trang đăng nhập hoặc trang chủ
            return redirect()->route('account.index');
        }        
    }
    public function getAccount(){
    // Lấy tài khoản của người dùng đang đăng nhập
    // $this->account = Account::find(Auth::id());
     $this->account = Account::find(2); // Thay ID 1 bằng ID của người dùng đang đăng nhập
    }

    public function render()
    {
        return view('livewire.user.delete-account');
    }
}
