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
        if (Auth::check()) {
            $order = Order::find(Auth::user()->user_id);
            if ($order) {
                $this->listOrder = $order->products->collect(); // Chuyển sang collection
            } else {
                $this->listOrder = collect(); // Tạo collection rỗng
            }
        } else {
            $this->listOrder = collect(); // Tạo collection rỗng
        }
    }

    public function render()
    {
        return view('livewire.order.list-order.list-order');
    }
}
