<?php

namespace App\Livewire\Home;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;


class Header extends Component
{
    public $notifyQuantity;
    public function mount()
    {
        if (Auth::check())
            $this->notifyQuantity = Order::find(Auth::user()->user_id)->products->sum("pivot.quantity");
    }
    #[On('refresh')]
    public function updateNotifyQuantity()
    {
        $this->notifyQuantity = Order::find(Auth::user()->user_id)->products->sum("pivot.quantity");
    }

    public function render()
    {
        return view('livewire.home.header', [
            "notifyQuantity" => $this->notifyQuantity
        ]);
    }
}
