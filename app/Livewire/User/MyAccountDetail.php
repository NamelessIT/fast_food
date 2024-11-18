<?php

namespace App\Livewire\User;

use App\Models\Role;
use Livewire\Component;
use App\Models\Account;
use App\Models\Customer;
use App\Models\Employee;

class MyAccountDetail extends Component
{
    public $account;
    public $firstName;
    public $fullName;
    public $numberPhone;
    public $email;
    public $point;
    public $createdAt;
    public $idrole;
    public $role;
    public $salary;

    public function mount()
    {
        $this->fetchDetailUser();
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
        
        if ($this->account && $this->account->user_type === config('constants.user.customer')) {
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
                $this->email=$this->account['email'];
                $this->createdAt = $customer->created_at->format('Y-m-d');
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
        return view('livewire.user.my-account-detail');
    }
}