<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Account;
use App\Models\Customer;

class MyAccountDetail extends Component
{
    public $firstName;
    public $fullName;
    public $numberPhone;
    public $point;
    public $createdAt;

    public function mount()
    {
        $this->fetchDetailCustomer();
    }

    public function fetchDetailCustomer()
    {
        // lấy id account đang đăng nhập ở đây và user-type là customers dùng where
        $account = Account::select('user_id', 'user_type')->first();
        
        if ($account && $account->user_type === 'customers') {
            $customer = Customer::find($account->user_id);

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
    }

    public function render()
    {
        return view('livewire.user.my-account-detail');
    }
}
