<?php

namespace App\Livewire\User;

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
    public function clearSessionData()
    {
    session()->forget(['user_id', 'user_type']);
    }


    public function render()
    {
        return view('livewire.user.dynamic-content', [
            'currentPage' => $this->currentPage,
            'index'=>$this->index,
        ]);
    }
}

