<?php

namespace App\Livewire\User;

use Livewire\Component;
use Psy\Readline\Hoa\Console;

class ResetPassword extends Component
{
    public function render()
    {
        return view('livewire.user.reset-password');
    }
}
