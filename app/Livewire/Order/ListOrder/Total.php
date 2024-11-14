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
    protected $listeners = ['voucherApplied'];

    public $selectedVoucher = null;

    public $order;
    public $totalBill;
    public function mount()
    {
        $this->addressList = CustomerAddress::where('id_customer', auth()->user()->id)->get();
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

        //bill
        $this->order = Order::where("id_customer", Auth::user()->user_id)->first();
        $this->totalBill =  $this->order->products->sum("pivot.total_price");
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
    public function payment()
    {
        if ($this->idAddressChoose == 0) {
            $this->dispatch('paymentError');
            return;
        }
        if ($this->totalBill==0){
            $this->dispatch('empty_order');
        }
        if ($this->selectedVoucher != null) {
            $this->totalBill -=  $this->totalBill * (float)($this->selectedVoucher->discount_percent / 100);
        }

        $bill = Bill::create([
            "id_customer" => Auth::user()->user_id,
            "id_address" => $this->idAddressChoose,
            "id_payment" => 1,
            "id_voucher" => $this->selectedVoucher->id ?? 0,
            "total" =>  $this->totalBill,
            "point_receive" => (float) $this->totalBill * 0.1,
            "status" => 1,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ]);

        if ($bill) {
            $billDetails = [];
            $orderDetails = OrderDetail::where("id_order", $this->order->id)->get();
            foreach ($orderDetails as $billDetail) {
                $item = $this->createBillDetail($bill->id, $billDetail->id_product, $billDetail->quantity);
                $listExtrafoods =  $billDetail->extraFoods;
                //IF HAVE EXTRAFOOD CREATE BILL DETAIL EXTRA FOOD
                if ($item && $listExtrafoods) {
                    array_push($billDetails, $item);
                    foreach ($listExtrafoods as $extrafood) {
                        $idExtraFood = $extrafood->id;
                        $quantity = $extrafood->orderdetails->first()->pivot->quantity;
                        $this->createBillExtraFoodDetail($item->id, $idExtraFood, $quantity);
                    }
                }
                // If success delete order detail row and re-render
                if ($bill && $billDetails) {
                    $delete = OrderDetail::where("id_order", $this->order->id)->delete();
                    if ($delete) {

                        $this->dispatch('order_success');
                        $this->dispatch('refresh');
                    }
                }
            }
        }
    }
    // dd($this->idAddressChoose, $this->idAddress);

    public function render()
    {
        return view('livewire.order.list-order.total', [
            "totalPrice" =>  $this->totalBill,
        ]);
    }
    public function voucherApplied($voucher)
    {
        $this->selectedVoucher = $voucher;
        dd($this->selectedVoucher);
    }


    // re-render
    #[On('refresh')]
    public function re_render()
    {
        $this->totalBill = $this->order->products->sum("pivot.total_price");
    }
}
