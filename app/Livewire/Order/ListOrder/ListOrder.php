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
        $this->listOrder = Order::find(Auth::user()->user_id)->products;
    }

    public function render()
    {
        return view('livewire.order.list-order.list-order');
    }
}
