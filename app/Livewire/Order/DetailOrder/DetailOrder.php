<?php

namespace App\Livewire\Order\DetailOrder;

use App\Models\Account;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\CustomerAddress;
use App\Models\Voucher;
use Livewire\Component;
use GuzzleHttp\Client;

class DetailOrder extends Component
{
    public $id;
    public $bills=[];
    public $detail_bills=[];
    public $account;
    public $address=[];
    public $nameVoucher=[];
    public function mount(){
        $this->getDataUserLogedIn();
        $this->getDataBill();
        $this->getDataDetailBill();
        $this->NameAddress();
        $this->NameVoucher();
    }
    public function NameVoucher(){
        $voucher =Voucher::where("id", "=", $this->bills[0]['id_voucher'])
        ->select("*")
        ->first();
        if ($voucher) {
            $this->nameVoucher = $voucher; // Gán bản ghi nếu có
        } else {
            $this->nameVoucher = [
                'voucher_name' => 'Không có', // Giá trị mặc định
                'description' => 'Không có',
            ];
        }
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
            ->select("*",
            "products.status as exit")
            ->get()->toArray();
        }
    }
    public function navigateUser(){
        return redirect()->route('user.index');
    }
    public function chooseProduct($slug,$exit)
    {
;        if($slug && (int) $exit!==0){
            return redirect('product/detail-product/' . $slug);
        }
    }   
    public function cancel_Bill()
    {
        // Lấy bill từ database
        $bill = Bill::find($this->bills[0]['id']); // Sử dụng ID của bill để truy vấn
        if ($bill) {
            // Cập nhật trạng thái
            $bill->status = 0;
            $bill->save(); // Lưu vào database
            // $this->emit('orderCancelled');
        }
    
        // Cập nhật lại biến $this->bills
        $this->bills[0]['status'] = 0;
    }
    public function NameAddress(){
        $CustomerAddresses = CustomerAddress::where('id_customer', auth()->user()->id)
        ->where("id","=",$this->bills[0]['id_address'])                                      
        ->get();
        $CustomerAddresses=$CustomerAddresses[0];
        $client = new Client();
        $res = $client->request('GET', 'https://provinces.open-api.vn/api/p/' . $CustomerAddresses['id_city']);
        $name_city = json_decode($res->getBody()->getContents())->name;

        $res = $client->request('GET', 'https://provinces.open-api.vn/api/d/' . $CustomerAddresses['id_district']);
        $name_district = json_decode($res->getBody()->getContents())->name;

        $res = $client->request('GET', 'https://provinces.open-api.vn/api/w/' . $CustomerAddresses['id_ward']);
        $name_ward = json_decode($res->getBody()->getContents())->name;
        $this->address = [
            'id' => $CustomerAddresses['id'],
            'city_name'=>$name_city,
            'district_name'=>$name_district,
            'ward_name'=>$name_ward,
            'address'=>$CustomerAddresses['address'],
            'id_customer'=>$CustomerAddresses['id_customer'],
        ];
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
