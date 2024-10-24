<?php

namespace App\Livewire\Account;

use App\Models\account;
use App\Models\Customer;
use Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormRegister extends Component
{
    public $email = '';
    public $fullname = '';
    public $phoneNumber = '';
    public $username = '';
    public $password = '';

    use WithFileUploads;
    public $avatar = '';

    public function register()
    {
        $request = new \App\Http\Requests\Account\FormRegister();
        $this->validate($request->rules(), $request->messages());

        $base64 = null;
        if ($this->avatar->isValid()) {
            $base64 = base64_encode(file_get_contents($this->avatar->getRealPath()));
        }
        // dd($base64);

        $id = Customer::create([
            'full_name' => $this->fullname,
            'phone' => $this->phoneNumber
        ]);

        $idUser = $id->id;

        account::create ([
            'id_user' => $idUser,
            'email' => $this->email,
            'username' => $this->username,
            'password' => Hash::make($this->password),
            'avatar' => $base64
        ]);

        return redirect()->route('account.index')->with('success', 'Đăng kí thành công');
    }

    public function render()
    {
        return view('livewire.account.form-register');
    }
}