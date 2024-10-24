<?php

namespace App\Livewire\Account;

use Livewire\Component;

class Form extends Component
{
    public $form = "";

    public function mount ($form) {
        $this->form = $form;
    }

    public function changeForm ($form) {
        $this->form = $form;
    }

    public function render()
    {
        return view('livewire.account.form');
    }
}