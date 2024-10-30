<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
class PreviousOrders extends Component
{
    public $orders = [];
    public $cau1="";

    //tự động được gọi khi component được khởi động
    public function mount()
    {
        $this->fetchOrders();
    }
    public function fetchOrders(){
            $this->orders = Order::select('id', 'id_customer', 'total', 'created_at', 'updated_at')->get()->toArray();
    }
    //Được gọi khi bất kỳ thuộc tính nào của component được cập nhật.
    public function update(){

    }
    //Được gọi mỗi khi component được re-render từ phía máy chủ.
    public function hydrate(){

    }
    public function createOrder(){  
        $this->cau1 ="hello";
    }
    public function render()
    {
        return view('livewire.previous-orders',['string' => $this->cau1]);
    }
}
