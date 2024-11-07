<?php

namespace App\Livewire\Account;

use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Request;

class FormLogin extends Component
{
    public $username = '';
    public $password = '';

    public function login()
    {
        $this->validate([
            'username' => 'required|exists:accounts,username',
            'password' => 'required',
        ], [
            'username.required' => 'Vui lòng nhập tên đăng nhập',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'username.exists' => 'Tài khoản hoặc mật khẩu không chính xác'
        ]);
        
        $credentials = [
            'username' => $this->username,
            'password' => $this->password
        ];
        if (auth()->attempt($credentials)) {
            return redirect('/')->with('success', 'Đăng nhập thành công');
        }
        else {
            throw ValidationException::withMessages([
                'username' => ['Tài khoản hoặc mật khẩu không chính xác']
            ]);
        }
    }

    public function render()
    {
        return view('livewire.account.form-login');
    }
}