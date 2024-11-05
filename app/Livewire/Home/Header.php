<?php

namespace App\Livewire\Home;

use App\Models\Order;
use Livewire\Attributes\On;
use Livewire\Component;


class Header extends Component
{
    public $notifyQuantity;
    public function mount()
    {
        $this->notifyQuantity = Order::count();
    }
    #[On('refresh')]
    public function updateNotifyQuantity() {
        $this->notifyQuantity++;
    }
    public function render()
    {
        return view('livewire.home.header', [
            "notifyQuantity" => $this->notifyQuantity
        ]);
    }
}
