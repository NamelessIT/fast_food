<?php

namespace App\Livewire\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\account;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;

class DynamicContent extends Component
{
    public $firstName;
    public $fullName;
    public $index;
    public $currentPage;

    protected $listeners = ['navigate'];

    public function mount(){
        $this->currentPage = session('currentPage', 'my-account.detail');
        $this->index=session("index",3);
        $this->fetchDetailUser();
    }
    public function navigate($page,$index)
    {
        $this->currentPage = $page;
        $this->index=$index;
        session(['currentPage' => $this->currentPage,
                        'index'=>$this->index
        ]);
    }
    public function logout()
    {
        // Hủy đăng nhập và xóa session khỏi bảng sessions
                    
        Auth::logout();
        $this->dispatch('LogOut');
        return redirect()->route('home.index');


        // Điều hướng về trang đăng nhập hoặc trang khác tùy ý
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

