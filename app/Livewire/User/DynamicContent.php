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
        session()->invalidate();
        session()->regenerateToken();
    
        // Xóa session tùy chỉnh của bạn
        session()->forget(['user_id', 'user_type']);
    
        // Điều hướng về trang đăng nhập hoặc trang khác tùy ý
        return redirect()->route('account.index');
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

