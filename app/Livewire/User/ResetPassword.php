<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;
use App\Models\Customer;
use App\Models\Employee;

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
        $this->fetchDetailUser();
    }

    public function ChangePassword()
    {
        $this->validate();
        // Reset message lỗi mỗi lần thay đổi mật khẩu
        $this->resetMessages();
    
        if($this->account!==null){
            // Nếu mật khẩu chưa được mã hóa, mã hóa mật khẩu hiện tại trong cơ sở dữ liệu
            if (!password_get_info($this->account['password'])['algo']) {
                $this->account['password'] = Hash::make($this->account->password);
                $this->account->save();
            }
        
            // Kiểm tra mật khẩu hiện tại
            if (!Hash::check($this->CurrentPassword, $this->account['password'])) {
                $this->messageCurrentPassword = "Mật khẩu hiện tại không đúng.";
                return;
            }
        
            // Kiểm tra mật khẩu mới và xác nhận mật khẩu có trùng khớp
            if ($this->NewPassword !== $this->AcceptPassword) {
                $this->messageAcceptPassword = "Vui lòng nhập đúng mật khẩu mới.";
                return;
            }
        
            // Kiểm tra mật khẩu mới có giống với mật khẩu cũ không
            if (Hash::check($this->NewPassword, $this->account['password'])) {
                $this->messageNewPassword = "Vui lòng nhập mật khẩu mới khác mật khẩu cũ.";
                return;
            }
        
            // Nếu vượt qua tất cả các kiểm tra, cập nhật mật khẩu
            $this->account['password'] = Hash::make($this->NewPassword);
            $this->account->save();
        
            session()->flash('success', 'Mật khẩu đã được thay đổi thành công.');
        }
    }
    

    public function fetchDetailUser()
    {
        $sessionData = $this->getSessionData();
        $user_id = $sessionData['user_id'];
        $user_type=$sessionData['user_type'];
        // lấy id account đang đăng nhập ở đây và user-type là customers dùng where
        $this->account = Account::where('user_id', $user_id)
                  ->where('user_type', $user_type)
                  ->first();
        
        if ($this->account && $this->account->user_type === 'App\Models\Customer') {
            $customer = Customer::find($this->account['user_id']);

            if ($customer) {
                $nameParts = explode(' ', $customer->full_name);
                if(count($nameParts)>=2){
                    $this->firstName = array_shift($nameParts);
                    $this->fullName = implode(' ', $nameParts);
                }
                else{
                    $this->firstName='';
                    $this->fullName=array_shift($nameParts);
                }

                // Gán các thông tin còn lại
                $this->numberPhone = $customer->phone;
                $this->point = $customer->points;
                $this->createdAt = $customer->created_at->format('Y-m-d');
            }
        }
        else if($this->account && $this->account->user_type !== 'App\Models\Customer'){
            $employee=Employee::find($this->account['user_id']);
            if($employee){
                $nameParts = explode(' ', $employee->full_name);
                if(count($nameParts)>=2){
                    $this->firstName = array_shift($nameParts);
                    $this->fullName = implode(' ', $nameParts);
                }
                else{
                    $this->firstName='';
                    $this->fullName=array_shift($nameParts);
                }
                                // Gán các thông tin còn lại
                $this->numberPhone = $employee->phone;
                $this->idrole = $employee->id_role;
                $this->salary=$employee->salary;
                $this->createdAt = $employee->created_at->format('Y-m-d');
            }
        }
    }
    public function getSessionData()
    {
    $userId = session('user_id');
    $userType = session('user_type');
    
    return [
        'user_id' => $userId,
        'user_type' => $userType,
    ];
    }
    public function clearSessionData()
    {
    session()->forget(['user_id', 'user_type']);
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
