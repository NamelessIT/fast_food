<?php

namespace App\Livewire\User;

use App\Models\BillExtraFoodDetail;
use Livewire\Component;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Account;
use App\Models\Customer;
use App\Models\CustomerAddress;
use GuzzleHttp\Client;


class PreviousOrders extends Component
{
    public $account;
    public $bills = [];
    public $receipts=[];
    public $searchTerm;

    //tự động được gọi khi component được khởi động
    public function mount()
    {
        $this->fetchDetailUser();
        if(session('user_type')===config('constants.user.customer')){
            $this->fetchBills();
        }
        else{
            $this->fetchReceipts();
        }
    }
    public function fetchBills(){
        if($this->account!==null){
            $this->bills = Bill::where('id_customer',$this->account['user_id'])
            ->select('id',
            'id_customer',
            'id_address',
            'id_payment',
            'id_voucher',
            'total',
            'point_receive',
            'status',
            )->get()->toArray();
        }
    }
    public function fetchBillDetail($bill)
    {
        $details = BillDetail::where('id_bill', $bill['id'])
            ->join('products', 'bill_details.id_product', '=', 'products.id')
            ->join('bills', 'bill_details.id_bill', '=', 'bills.id')
            ->select(
                'bill_details.id as detail_id',
                'slug',
                'bills.id_address as bill_address',
                'products.product_name',
                'bill_details.quantity',
                'bill_details.created_at as bill_created_at',
                'bill_details.updated_at as bill_updated_at'
            )
            ->get()
            ->map(function ($detail) {
                // Lấy thông tin từ CustomerAddress
                $address = CustomerAddress::find($detail->bill_address);
                if ($address) {
                    $client = new Client();
    
                    // Lấy tên thành phố
                    $res = $client->request('GET', 'https://provinces.open-api.vn/api/p/' . $address->id_city);
                    $name_city = json_decode($res->getBody()->getContents())->name;
    
                    // Lấy tên quận
                    $res = $client->request('GET', 'https://provinces.open-api.vn/api/d/' . $address->id_district);
                    $name_district = json_decode($res->getBody()->getContents())->name;
    
                    // Lấy tên phường
                    $res = $client->request('GET', 'https://provinces.open-api.vn/api/w/' . $address->id_ward);
                    $name_ward = json_decode($res->getBody()->getContents())->name;
    
                    // Format địa chỉ thành chuỗi
                    $detail->bill_address = "{$address->address}, {$name_ward}, {$name_district}, {$name_city}";
                } else {
                    $detail->bill_address = 'Địa chỉ không tồn tại';
                }
    
                // Format lại thời gian
                $detail->bill_created_at = \Carbon\Carbon::parse($detail->bill_created_at)->format('d/m/Y');
                $detail->bill_updated_at = \Carbon\Carbon::parse($detail->bill_updated_at)->format('d/m/Y');
    
                return $detail;
            })
            ->toArray();
    
        return $details;
    }
    
    public function fetchExtraFood($billDetail){
        $details = BillExtraFoodDetail::where('id_bill_detail', $billDetail)
        ->join('extra_food', 'extra_food.id', '=', 'bill_extra_food_detail.id_extra_food')
        ->select(
            'extra_food.food_name',
            'extra_food.price',
            'bill_extra_food_detail.quantity'
        )
        ->get()
        ->map(function ($detail) {
            // Format lại thời gian
            $detail->bill_created_at = \Carbon\Carbon::parse($detail->bill_created_at)->format('d/m/Y');
            $detail->bill_updated_at = \Carbon\Carbon::parse($detail->bill_updated_at)->format('d/m/Y');
            return $detail;
        })
        ->toArray();

    return $details;
    }

    public function searchBills()
    {
        // Kiểm tra nếu searchTerm là số, tìm kiếm theo total
        if (is_numeric($this->searchTerm)) {
            $this->bills = Bill::where('id_customer', $this->account['user_id'])
                ->where('total', 'like', '%' . $this->searchTerm . '%')
                ->get()
                ->toArray();
        } elseif ($this->searchTerm !== null) {
            // Tìm các id_bill trong BillDetail có product_name giống với searchTerm
            $billIds = BillDetail::join('products', 'bill_details.id_product', '=', 'products.id')
                ->where('products.product_name', 'like', '%' . $this->searchTerm . '%')
                ->pluck('bill_details.id_bill')
                ->toArray();
    
            // Tìm các Bill với id trong danh sách billIds và id_customer là user hiện tại
            $this->bills = Bill::where('id_customer', $this->account['user_id'])
                ->whereIn('id', $billIds)
                ->get()
                ->toArray();
        } else {
            // Nếu không có điều kiện tìm kiếm, fetch tất cả các bill
            $this->fetchBills();
        }
    }
    
    //Được gọi khi bất kỳ thuộc tính nào của component được cập nhật.
    public function update(){

    }
    //Được gọi mỗi khi component được re-render từ phía máy chủ.
    public function hydrate(){

    }
    public function startBill(){
        return redirect("/");
    }
    public function createBill(){  
        return redirect()->route('order.index');
    }
    public function fetchDetailUser()
    {
        $sessionData = $this->getSessionData();
        $user_id = $sessionData['user_id'];
        $user_type=$sessionData['user_type'];
        // lấy id account đang đăng nhập ở đây và user-type là customers dùng where
        $this->account = Account::where('user_id', $user_id)
                  ->where('user_type', $user_type)
                  ->first();
        
        if ($this->account && $this->account->user_type === config('constants.user.customer')) {
            $customer = Customer::find($this->account['user_id']);

            if ($customer) {
                $nameParts = explode(' ', $customer->full_name);
                if(count($nameParts)>=2){
                    $this->firstName = array_shift($nameParts);
                    $this->fullName = implode(' ', $nameParts);
                }
                else{
                    $this->firstName='';
                    $this->fullName=array_shift($nameParts);
                }

                // Gán các thông tin còn lại
                $this->numberPhone = $customer->phone;
                $this->point = $customer->points;
                $this->createdAt = $customer->created_at->format('Y-m-d');
                $this->email=$this->account['email'];
            }
        }

    }
    public function chooseProduct($slug)
    {
        if($slug){
            return redirect('product/detail-product/' . $slug);
        }
    }
    
    public function getSessionData()
    {
    $userId = session('user_id');
    $userType = session('user_type');
    
    return [
        'user_id' => $userId,
        'user_type' => $userType,
    ];
    }
    public function clearSessionData()
    {
    session()->forget(['user_id', 'user_type']);
    }
    public function render()
    {
        $this->searchBills();
        return view('livewire.user.previous-orders');
    }
}
