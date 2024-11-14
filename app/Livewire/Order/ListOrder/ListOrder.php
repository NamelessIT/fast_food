<?php

namespace App\Livewire\Order\ListOrder;

use App\Models\Order;
use App\Models\OrderDetail;
use Barryvdh\Reflection\DocBlock\Type\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class ListOrder extends Component
{
    protected $listeners = [
        're-render' => '$refresh'
    ];

    public $listOrder;

    public function mount()
    {
        if (Auth::check()) {
            $order = Order::where("id_customer", Auth::user()->user_id)->first();

            $this->listOrder = OrderDetail::where("id_order", $order->id)->first() ? $order->products : new Collection();
        } else {
            redirect()->route("account.index");
        }
    }


    public function render()
    {
        return view(
            'livewire.order.list-order.list-order'
        );
    }
}
