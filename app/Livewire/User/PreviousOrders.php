<?php

namespace App\Livewire\User;

use App\Models\BillExtraFoodDetail;
use DB;
use Livewire\Component;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Account;
use App\Models\Customer;
use App\Models\CustomerAddress;
use GuzzleHttp\Client;


class PreviousOrders extends Component
{
    public $filterStatus;
    public $account;
    public $bills = [];
    public $receipts=[];
    public $searchTerm;

    //tự động được gọi khi component được khởi động
    public function mount()
    {
        $this->fetchDetailUser();
        if(auth()->user()->user_type===config('constants.user.customer')){
            $this->fetchBills();
        }

    }
    public function fetchBills(){
        if($this->account!==null){
            $this->bills = Bill::where('id_customer',$this->account['user_id'])
            // ->where('status',"=",2)
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
                'products.status as exit',
                'products.product_name',
                'bill_details.quantity',
                DB::raw('SUM(bill_details.quantity * products.price) as total'),
                'bill_details.created_at as bill_created_at',
                'bill_details.updated_at as bill_updated_at'
            )
            ->groupBy(
                'bill_details.id',
                'slug',
                'products.status',
                'products.product_name',
                'bill_details.quantity',
                'bill_details.created_at',
                'bill_details.updated_at'
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
    
    
        public function fetchExtraFood($billDetail)
        {
            $details = BillExtraFoodDetail::join('extra_food', 'extra_food.id', '=', 'bill_extra_food_detail.id_extra_food')
                ->join('bill_details', 'bill_details.id', '=', 'bill_extra_food_detail.id_bill_detail')
                ->where('bill_details.id', '=', $billDetail) // Sửa thành bill_details.id như trong truy vấn gốc
                ->select(
                    'extra_food.food_name',
                    'extra_food.price as cod_price',
                    'bill_extra_food_detail.quantity'
                )
                ->get()
                ->toArray();
        
            return $details;
        }
    

    public function searchBills()
    {
        // Kiểm tra nếu searchTerm là số, tìm kiếm theo total
        if (is_numeric($this->searchTerm)) {
            $this->filterStatus===null ||$this->filterStatus==="" ?            
                $this->bills = Bill::where('id_customer', $this->account['user_id'])
                    ->where('total', 'like', '%' . $this->searchTerm . '%')
                    ->get()
                    ->toArray()
            :
                $this->bills = Bill::where('id_customer', $this->account['user_id'])
                ->where('total', 'like', '%' . $this->searchTerm . '%')
                ->where("status","=",$this->filterStatus)
                ->get()
                ->toArray();

        } elseif ($this->searchTerm !== null) {
            // Tìm các id_bill trong BillDetail có product_name giống với searchTerm
            $billIds = BillDetail::join('products', 'bill_details.id_product', '=', 'products.id')
                ->where('products.product_name', 'like', '%' . $this->searchTerm . '%')
                ->pluck('bill_details.id_bill')
                ->toArray();
    
            // Tìm các Bill với id trong danh sách billIds và id_customer là user hiện tại
            $this->filterStatus===null ||$this->filterStatus==="" ?
            $this->bills = Bill::where('id_customer', $this->account['user_id'])
                ->whereIn('id', $billIds)
                ->get()
                ->toArray()
            :
            $this->bills = Bill::where('id_customer', $this->account['user_id'])
            ->where("status","=",$this->filterStatus)
            ->whereIn('id', $billIds)
            ->get()
            ->toArray();
        }
         else {
            $this->filterStatus===null ||$this->filterStatus===""  ?
            $this->fetchBills()
            :
            $this->bills = Bill::where('id_customer',$this->account['user_id'])
            ->where('status',"=",$this->filterStatus)
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
    public function navigatBillDetail($number) {
        return redirect()->route('order.detail', ['id' => $number]);
    }
    
    public function fetchDetailUser()
    {
        $this->account = Account::where('user_id', auth()->user()->user_id)
                  ->where('user_type', auth()->user()->user_type)
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
    public function chooseProduct($slug,$exit)
    {
        if($slug && (int) $exit!==0){
            return redirect('product/detail-product/' . $slug);
        }
    }   

    public function render()
    {
        $this->searchBills();
        return view('livewire.user.previous-orders');
    }
}
