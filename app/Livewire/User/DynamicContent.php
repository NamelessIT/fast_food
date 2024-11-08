<?php

namespace App\Livewire\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DynamicContent extends Component
{
    public $index=3;
    public $currentPage = 'my-account.detail';

    protected $listeners = ['navigate'];

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


    public function render()
    {
        return view('livewire.user.dynamic-content', [
            'currentPage' => $this->currentPage,
            'index'=>$this->index,
        ]);
    }
}

