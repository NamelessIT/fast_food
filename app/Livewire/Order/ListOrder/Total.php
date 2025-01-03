<?php

namespace App\Livewire\Order\ListOrder;

use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\BillExtraFoodDetail;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Payment;

class Total extends Component
{
    public $addressList = [];
    public $idAddress = 0;
    public $idAddressChoose = 0;
    public $idCity = 0;
    public $idDistrict = 0;
    public $idWard = 0;

    public $address = '';
    public $detailAddress = '';
    protected $listeners = ['voucherApplied','removeVoucher'];

    public $selectedVoucher = null;
    public $tempTotalPrice ;
    public $order;
    public $totalBill;
    public function mount()
    {
        $this->addressList = CustomerAddress::where('id_customer', auth()->user()->id)
        ->where('status', 1)
        ->get();
        $this->addressList = $this->addressList->toArray();
        $listTmp = [];

        $client = new Client();
        foreach ($this->addressList as $key => $value) {
            $res = $client->request('GET', 'https://provinces.open-api.vn/api/p/' . $value['id_city']);
            $detailAddress = json_decode($res->getBody()->getContents())->name;

            $res = $client->request('GET', 'https://provinces.open-api.vn/api/d/' . $value['id_district']);
            $detailAddress .= ', ' . json_decode($res->getBody()->getContents())->name;

            $res = $client->request('GET', 'https://provinces.open-api.vn/api/w/' . $value['id_ward']);
            $detailAddress .= ', ' . json_decode($res->getBody()->getContents())->name . ', ' . $value['address'];
            $obj = [
                'id' => $value['id'],
                'detailAddress' => $detailAddress,
            ];
            array_push($listTmp, $obj);
        }

        $this->addressList = $listTmp;
      
        
         $this->order = Order::where("id_customer", Auth::user()->user_id)->first();
         if($this->order){            
             $this->tempTotalPrice = $this->order->products->sum(function($product) {
                        return $product->pivot->total_price;  
            });
            $this->totalBill = $this->tempTotalPrice;
         }
         else{
            return 0;
         }
           
         
        
        
    }

    public function chooseAddress()
    {
        if ($this->idCity == 0 || $this->idDistrict == 0 || $this->idWard == 0 || $this->address == '') {
            $this->dispatch('chooseAddressError');
            return;
        }

        $this->dispatch('chooseAddressSuccess');

        $address = CustomerAddress::create([
            'id_customer' => auth()->user()->id,
            'id_city' => $this->idCity,
            'id_district' => $this->idDistrict,
            'id_ward' => $this->idWard,
            'address' => $this->address,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $this->idAddress = $address->id;
        $this->idAddressChoose = $this->idAddress;

        $client = new Client();
        $res = $client->request('GET', 'https://provinces.open-api.vn/api/p/' . $this->idCity);
        $this->detailAddress = json_decode($res->getBody()->getContents())->name;
        $res = $client->request('GET', 'https://provinces.open-api.vn/api/d/' . $this->idDistrict);
        $this->detailAddress .= ', ' . json_decode($res->getBody()->getContents())->name;
        $res = $client->request('GET', 'https://provinces.open-api.vn/api/w/' . $this->idWard);
        $this->detailAddress .= ', ' . json_decode($res->getBody()->getContents())->name . ', ' . $this->address;

        $this->idCity = 0;
        $this->idDistrict = 0;
        $this->idWard = 0;

        $obj = [
            'id' => $address->id,
            'detailAddress' => $this->detailAddress,
        ];
        array_push($this->addressList, $obj);

        // $this->dispatch("chooseAddressSuccess");
    }

    public function selectAddress()
    {
        if ($this->idAddress == 0) {
            $this->idAddress = $this->addressList[0]['id'];
        }
        $this->idAddressChoose = $this->idAddress;
        $address = CustomerAddress::find($this->idAddress);

        $client = new Client();

        $res = $client->request('GET', 'https://provinces.open-api.vn/api/p/' .  $address->id_city);
        $detailAddress = json_decode($res->getBody()->getContents())->name;
        $res = $client->request('GET', 'https://provinces.open-api.vn/api/d/' . $address->id_district);
        $detailAddress .= ', ' . json_decode($res->getBody()->getContents())->name;
        $res = $client->request('GET', 'https://provinces.open-api.vn/api/w/' . $address->id_ward);
        $detailAddress .= ', ' . json_decode($res->getBody()->getContents())->name . ', ' . $address->address;

        $this->idCity = 0;
        $this->idDistrict = 0;
        $this->idWard = 0;
        $this->address = '';

        $this->detailAddress = $detailAddress;

        $this->dispatch('selectAddressSuccess');
    }

    public function createBillDetail($idBill, $id_product, $quantity = 1)
    {
        if ($idBill != null && $id_product != null) {
            $billdetail = BillDetail::create([
                "id_bill" => $idBill,
                "id_product" => $id_product,
                "quantity" => $quantity,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);
            return $billdetail;
        } else {
            dd(1);
        }
        //else
    }

    public function createBillExtraFoodDetail($id_bill_detail, $id_extraFoods, $quantity)
    {

        $query = BillExtraFoodDetail::create([
            "id_bill_detail" => $id_bill_detail,
            "id_extra_food" => $id_extraFoods,
            "quantity" => $quantity,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ]);
        return $query;
    }

    public function createPayment()
    {
        
        if ($this->idAddressChoose == 0) {
            $this->dispatch('paymentError');
            return null;
        }

        if ($this->totalBill == 0) {
            $this->dispatch('empty_order');
            return null;
        }

    
        $payment = Payment::create([
            "payment_name" => \Illuminate\Support\Str::random(20),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ]);
        
        
        return $payment;
    }
    public function payment()
    {
        $payment = $this->createPayment();
        if (!$payment) {
            return; 
        }
    

        $bill = Bill::create([
            "id_customer" => Auth::user()->user_id,
            "id_address" => $this->idAddressChoose,
            "id_payment" => $payment->id,
            "id_voucher" => (isset($this->selectedVoucher) && $this->totalBill >= $this->selectedVoucher['minium_condition']) ? $this->selectedVoucher['id'] : null,
            "total" =>  $this->totalBill,
            "point_receive" => (float) $this->totalBill * 0.1,
            "status" => 1,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ]);

        if ($bill) {
            $billDetails = [];
            $orderDetails = OrderDetail::where("id_order", $this->order->id)->get();
            foreach ($orderDetails as $key => $billDetail) {
                $item = $this->createBillDetail($bill->id, $billDetail->id_product, $billDetail->quantity);
                $listExtrafoods =  $billDetail->extraFoods;
                //IF HAVE EXTRAFOOD CREATE BILL DETAIL EXTRA FOOD
                array_push($billDetails, $item);
                if ($item && $listExtrafoods->isNotEmpty()) {
                    $concac = [];
                    foreach ($listExtrafoods as $extrafood) {
                        $idExtraFood = $extrafood->id;
                        array_push($concac,$extrafood->orderdetails);
                        // dd ($extrafood->orderdetails->first(), $extrafood->orderdetails, $key);
                        $quantity = $extrafood->orderdetails->first()->pivot->quantity;
                        $this->createBillExtraFoodDetail($item->id, $idExtraFood, $quantity);
                    }
                    // dd ($concac);

                }
                
                // If success delete order detail row and re-render
               
            }

            if ($bill && $billDetails) {
                $delete = OrderDetail::where("id_order", $this->order->id)->delete();
                
                if ($delete) {

                    $this->dispatch('order_success');
                    $this->dispatch('refresh');
                }
            }
        }
    }
    // dd($this->idAddressChoose, $this->idAddress);

    public function render()
    {
        return view('livewire.order.list-order.total', [
            "totalPrice" =>  $this->tempTotalPrice,
        ]);
    }
    public function voucherApplied($voucher)
    {
        $this->selectedVoucher = $voucher;

        if ($this->tempTotalPrice >= $voucher['minium_condition']) {
            $this->totalBill = $this->tempTotalPrice -  $this->tempTotalPrice* (float)($voucher['discount_percent'] / 100);
        } 
        else {
            $this->totalBill = $this->tempTotalPrice;
        }
        
    }
    public function removeVoucher()
    {
        $this->selectedVoucher = null;
        $this->totalBill = $this->tempTotalPrice;

        
    }


    // re-render
    #[On('refresh')]
    public function re_render()
    {
        if ($this->order) {
            $this->tempTotalPrice = $this->order->products->sum("pivot.total_price");
            $this->selectedVoucher !== null ? $this->voucherApplied($this->selectedVoucher) : $this->totalBill=$this->tempTotalPrice;

        } else {
            
            $this->tempTotalPrice = 0; 
            $this->totalBill = 0; 
        }
    }
}