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
            $order = Order::find(Auth::user()->user_id);
            if ($order) {
                // Nếu tìm thấy order, gán listOrder bằng danh sách sản phẩm của order
                $this->listOrder = $order->products;
            } else {
                // Nếu không tìm thấy order, giữ listOrder là một mảng rỗng
                $this->listOrder = [];
            }
        } else {
            // Nếu người dùng chưa đăng nhập, giữ listOrder là một mảng rỗng
            $this->listOrder = [];
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
