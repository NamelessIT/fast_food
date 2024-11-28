<?php

namespace App\Livewire\Order\DetailOrder;

use App\Models\Account;
use App\Models\Bill;
use App\Models\BillDetail;
use Livewire\Component;

class DetailOrder extends Component
{
    public $id;
    public $bills=[];
    public $detail_bills=[];
    public $account;
    public function mount(){
        $this->getDataUserLogedIn();
        $this->getDataBill();
        $this->getDataDetailBill();
    }
    public function getDataBill(){
        if($this->account!==null){
            $this->bills = Bill::where('id_customer',$this->account['user_id'])
            ->where('id',"=",(int)$this->id)
            ->select("*"
            )->get()->toArray();
        }
    }
    public function getDataDetailBill(){
        if($this->account!==null && $this->bills!==null){
            $this->detail_bills=BillDetail::where("id_bill","=",(int)$this->id)
            ->join("products","products.id","=","bill_details.id_product")
            ->select("*")
            ->get()->toArray();
        }
    }
    public function cancel_Bill(){
        dd("có chạy");
    }
    public function getDataUserLogedIn(){
        $this->account = Account::where('user_id', auth()->user()->user_id)
        ->where('user_type', auth()->user()->user_type)
        ->first();
    }
    public function render()
    {
        return view('livewire.order.detail-order.detail-order');
    }
}
