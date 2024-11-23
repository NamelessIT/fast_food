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
        $this->account = Account::where('user_id', auth()->user()->user_id)
                  ->where('user_type', auth()->user()->user_type)
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

    public function render()
    {
        return view('livewire.user.my-account-detail');
    }
}
