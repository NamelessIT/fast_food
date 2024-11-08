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
            $order = Order::find(Auth::user()->user_id);
            if ($order) {
                // Nếu tìm thấy order, lấy tổng quantity của sản phẩm
                $this->notifyQuantity = $order->products->sum("pivot.quantity");
            } else {
                // Nếu không tìm thấy order, đặt notifyQuantity là 0 hoặc giá trị mặc định
                $this->notifyQuantity = 0;
            }
        }
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
