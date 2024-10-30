<?php

namespace App\Livewire;

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


    public function render()
    {
        return view('livewire.dynamic-content', [
            'currentPage' => $this->currentPage,
            'index'=>$this->index,
        ]);
    }
}

