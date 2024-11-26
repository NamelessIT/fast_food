<?php

namespace App\Livewire\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\account;
use App\Models\Customer;
class DynamicContent extends Component
{
    public $firstName;
    public $fullName;
    public $index=3;
    public $currentPage = 'my-account.detail';

    protected $listeners = ['navigate'];

    public function mount(){
        $this->fetchDetailUser();
    }
    public function navigate($page,$index)
    {
        $this->currentPage = $page;
        $this->index=$index;
    }
    public function logout()
    {
        // Hủy đăng nhập và xóa session khỏi bảng sessions
        Auth::logout();
    
        // Điều hướng về trang đăng nhập hoặc trang khác tùy ý
        return redirect()->route('account.index');
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
        return view('livewire.user.dynamic-content', [
            'currentPage' => $this->currentPage,
            'index'=>$this->index,
            'firstName'=>$this->firstName,
            'fullName'=>$this->fullName,
        ]);
    }
}

