<?php

namespace App\Livewire\Home;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class LoginButton extends Component
{

    public $isAuthenticated ;
    protected $listener = ['LogOut' => 'updateButton',];
    
    public function render()
    {
        return view('livewire.home.login-button');
    }
    #[On('LogOut')]
    public function updateButton(){
        dd('abdc');
        $this->isAuthenticated = Auth::check();

    }
    public function mount(){
        $this->isAuthenticated = Auth::check();
    }
}
