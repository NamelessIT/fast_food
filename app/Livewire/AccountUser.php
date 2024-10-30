<?php

namespace App\Livewire;

use Livewire\Component;
use Request;

class AccountUser extends Component
{
    public $email='';
    public $username='';
    public $password='';
    public function submit(Request $request){
        $request::validate([
            'email'=>'required|unique:account',
            'username'=>'required|unique:account|min:3',
            'password'=>'required|min:5',
        ]);

    }
    public function render()
    {
        return view('livewire.account-user');
    }
}
