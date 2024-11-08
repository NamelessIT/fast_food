<?php

namespace App\Livewire\Order\ListOrder;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ListOrder extends Component
{
    public $listOrder = [];
    public function mount()
    {
        $order = Order::where('user_id', Auth::user()->user_id)->first();

        $this->listOrder = $order ? $order->products : [];
    }

    public function render()
    {
        return view('livewire.order.list-order.list-order');
    }
}
