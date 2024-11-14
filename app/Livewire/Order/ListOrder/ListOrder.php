<?php

namespace App\Livewire\Order\ListOrder;

use App\Models\Order;
use Barryvdh\Reflection\DocBlock\Type\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class ListOrder extends Component
{
    protected $listeners = [
        'refresh' => '$refresh'
    ];

    public $listOrder;
    public $order;
    public function mount()
    {
        if (Auth::check()) {
            $this->order = Order::where("id_customer", Auth::user()->user_id)->first();

            $this->listOrder = $this->order ? $this->order->products : new Collection();
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

    #[On('refresh')]
    public function updateListOrder()
    {
        $this->listOrder = $this->listOrder = $this->order ? $this->order->products : new Collection();;
    }
}
