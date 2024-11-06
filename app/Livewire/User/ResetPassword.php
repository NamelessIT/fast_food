<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;

class ResetPassword extends Component
{
    protected $rules = [
        'CurrentPassword' => 'required',
        'NewPassword' => 'required',
        'AcceptPassword' => 'required',
    ];
    protected $messages = [
        'CurrentPassword.required' => 'Mật khẩu hiện tại không được để trống.',
        'NewPassword.required' => 'Mật khẩu mới không được để trống.',
        'AcceptPassword.required' => 'Vui lòng xác nhận mật khẩu mới.',
    ];
    public $account;
    public $CurrentPassword;
    public $NewPassword;
    public $AcceptPassword;
    
    // Lưu các message lỗi
    public $messageCurrentPassword;
    public $messageNewPassword;
    public $messageAcceptPassword;

    public function mount()
    {
        $this->getAccount();
    }

    public function ChangePassword()
    {
        $this->validate();
        // Reset message lỗi mỗi lần thay đổi mật khẩu
        $this->resetMessages();
    
        // Nếu mật khẩu chưa được mã hóa, mã hóa mật khẩu hiện tại trong cơ sở dữ liệu
        if (!password_get_info($this->account->password)['algo']) {
            $this->account->password = Hash::make($this->account->password);
            $this->account->save();
        }
    
        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($this->CurrentPassword, $this->account->password)) {
            $this->messageCurrentPassword = "Mật khẩu hiện tại không đúng.";
            return;
        }
    
        // Kiểm tra mật khẩu mới và xác nhận mật khẩu có trùng khớp
        if ($this->NewPassword !== $this->AcceptPassword) {
            $this->messageAcceptPassword = "Vui lòng nhập đúng mật khẩu mới.";
            return;
        }
    
        // Kiểm tra mật khẩu mới có giống với mật khẩu cũ không
        if (Hash::check($this->NewPassword, $this->account->password)) {
            $this->messageNewPassword = "Vui lòng nhập mật khẩu mới khác mật khẩu cũ.";
            return;
        }
    
        // Nếu vượt qua tất cả các kiểm tra, cập nhật mật khẩu
        $this->account->password = Hash::make($this->NewPassword);
        $this->account->save();
    
        session()->flash('success', 'Mật khẩu đã được thay đổi thành công.');
    }
    

    public function getAccount()
    {
        // Lấy tài khoản của người dùng đang đăng nhập
        $this->account = Account::find(1); // Thay ID 1 bằng ID của người dùng đang đăng nhập
    }

    private function resetMessages()
    {
        $this->messageCurrentPassword = null;
        $this->messageNewPassword = null;
        $this->messageAcceptPassword = null;
    }

    public function render()
    {
        return view('livewire.user.reset-password');
    }
}
