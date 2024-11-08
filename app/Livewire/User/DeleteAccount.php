<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Account;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class DeleteAccount extends Component
{
    public $account;
    public function mount()
    {
        $this->fetchDetailUser();
    }
    public function DeleteAccount()
    {
        // Kiểm tra xem tài khoản có tồn tại không
        if ($this->account) {
            $this->clearSessionData();
            // Xóa tài khoản khỏi cơ sở dữ liệu
            $this->account->delete();

            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
        
            // Xóa session tùy chỉnh của bạn
            session()->forget(['user_id', 'user_type']);
        
            // Điều hướng về trang đăng nhập hoặc trang khác tùy ý
            return redirect()->route('account.index');
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



    public function render()
    {
        return view('livewire.user.delete-account');
    }
}
