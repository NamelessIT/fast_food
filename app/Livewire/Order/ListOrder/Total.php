<?php

namespace App\Livewire\Order\ListOrder;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Total extends Component
{
    public $totalPrice;

    public function mount()
    {
        $id_user = Auth::user()->user_id;
        $this->totalPrice = Order::where("id_customer", $id_user)->first()->total;
    }
    public function render()
    {
        return view('livewire.order.list-order.total',[
            "totalPrice"=> $this->totalPrice,
        ]);
    }
}
