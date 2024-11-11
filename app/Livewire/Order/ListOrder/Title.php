<?php


namespace App\Livewire\Order\ListOrder;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

use Livewire\Component;

class Title extends Component
{
    public $notifyQuantity;
    public function mount()
    {
        if (Auth::check()) {
            $order = Order::where("id_customer", Auth::user()->user_id)->first();
            $this->notifyQuantity = $order ? $order->products->sum("pivot.quantity") : 0;
        } else {
            $this->notifyQuantity = 0;
        }
    }

    public function render()
    {
        return view('livewire.order.list-order.title', [
            "notifyQuantity" => $this->notifyQuantity
        ]);
    }
    #[On('refresh')]
    public function updateNotifyQuantity()
    {
        $this->notifyQuantity = Order::where("id_customer", Auth::user()->user_id)->first()->products->sum("pivot.quantity");
    }
}
