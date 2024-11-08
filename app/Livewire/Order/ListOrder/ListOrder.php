<?php

namespace App\Livewire\Order\ListOrder;

use App\Models\Order;
use Barryvdh\Reflection\DocBlock\Type\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ListOrder extends Component
{

    public $listOrder = [];
    public function mount()
    {
        if (Auth::check()) {
            $order = Order::where("id_customer", Auth::user()->user_id)->first();
            $this->listOrder = $order ? $order->products : new Collection();
        } else {
            redirect()->route("account.index");
        }
    }

    public function render()
    {
        return view('livewire.order.list-order.list-order');
    }
}
