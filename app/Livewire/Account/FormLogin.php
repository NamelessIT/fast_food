<?php

namespace App\Livewire\Account;

use Livewire\Component;
use Request;

class FormLogin extends Component
{
    public $username = '';
    public $password = '';

    public function login()
    {
        $this->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Vui lòng nhập tên đăng nhập',
            'password.required' => 'Vui lòng nhập mật khẩu',
        ]);
        
        $credentials = [
            'username' => $this->username,
            'password' => $this->password
        ];
        if (auth()->attempt($credentials)) {
            return redirect('/')->with('success', 'Đăng nhập thành công');
        }
    }

    public function render()
    {
        return view('livewire.account.form-login');
    }
}