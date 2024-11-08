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
        if (Auth::check()) {
            $order = Order::where("id_customer", Auth::user()->user_id)->first();
            if ($order) {
                $this->notifyQuantity = $order->products->sum("pivot.quantity");
            } else $this->notifyQuantity = 0;
        }
    }
    #[On('refresh')]
    public function updateNotifyQuantity()
    {
        $this->notifyQuantity = Order::where("id_customer", Auth::user()->user_id)->first()->products->sum("pivot.quantity");
    }

    public function render()
    {
        return view('livewire.home.header', [
            "notifyQuantity" => $this->notifyQuantity
        ]);
    }
}
