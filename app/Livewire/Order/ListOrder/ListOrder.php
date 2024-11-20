<?php

namespace App\Livewire\Order\ListOrder;

use App\Models\Order;
use Illuminate\Support\Collection;

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
            // Tìm order dựa trên id_customer
            $this->order = Order::where('id_customer', Auth::user()->user_id)->first();
    
            if ($this->order) {
                // Nếu tìm thấy order, gán listOrder bằng danh sách sản phẩm của order
                $this->listOrder = $this->order->products;
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
        
        $this->listOrder =  $this->order ? $this->order->products : new Collection();;
        
    }
}