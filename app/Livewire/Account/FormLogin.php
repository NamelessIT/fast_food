<?php

namespace App\Livewire\Account;

use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Request;
use App\Models\Account;

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
            $account = $this->getLoggedInAccount();
            if ($account) {
                session([
                    'user_id' => $account->user_id,
                    'user_type' => $account->user_type,
                ]);
            }
            return redirect('/')->with('success', 'Đăng nhập thành công');
        }
        else {
            throw ValidationException::withMessages([
                'username' => ['Tài khoản hoặc mật khẩu không chính xác']
            ]);
        }
    }

    public function getLoggedInAccount()
{
    return Account::select('user_id', 'user_type')
        ->where('username', $this->username)
        ->first();
}

    public function render()
    {
        return view('livewire.account.form-login');
    }
}