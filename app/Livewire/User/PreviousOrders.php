<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Bill;
use App\Models\BillDetail;


class PreviousOrders extends Component
{
    public $bills = [];
    public $cau1="";

    //tự động được gọi khi component được khởi động
    public function mount()
    {
        $this->fetchBills();
    }
    public function fetchBills(){
            $this->bills = Bill::select('id',
            'id_customer',
            'id_address',
            'id_payment',
            'id_voucher',
            'total',
            'point_receive',
            'status',
            )->get()->toArray();
    }
    public function fetchBillDetail($billId){
        $details = BillDetail::where('id_bill', $billId)->get()->toArray();
        return $details;
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
        return view('livewire.user.previous-orders');
    }
}
