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
            // Xóa tài khoản khỏi cơ sở dữ liệu
            $this->account->delete();

            Auth::logout();
        
       
            // Điều hướng về trang đăng nhập hoặc trang khác tùy ý
            return redirect()->route('account.index');
        }        
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
                $this->createdAt = $customer->created_at->format('Y-m-d');
                $this->email=$this->account['email'];
            }
        }

    }


    public function render()
    {
        return view('livewire.user.delete-account');
    }
}
