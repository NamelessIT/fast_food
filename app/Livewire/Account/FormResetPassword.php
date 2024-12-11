<?php

namespace App\Livewire\Account;

use App\Models\Account;
use Hash;
use Livewire\Component;

class FormResetPassword extends Component
{
    public $password;
    public $email;

    public function mount() {
        $this->email = request()->email;
    }

    public function resetPassword() {
        $this->validate([
            'password' => 'required|min:6'
        ], [
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự'
        ]);
        
        $account = Account::where('email', $this->email)->first();
        $account->password = Hash::make($this->password);
        $account->save();
        return redirect()->route('account.index');
    }

    public function render()
    {
        return view('livewire.account.form-reset-password');
    }
}