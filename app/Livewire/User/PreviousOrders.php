<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Account;
use App\Models\Customer;
use App\Models\Employee;

class PreviousOrders extends Component
{
    public $account;
    public $bills = [];
    public $cau1="";

    //tự động được gọi khi component được khởi động
    public function mount()
    {
        $this->fetchDetailUser();
        $this->fetchBills();
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
    public function fetchBillDetail($billId){
        $details = BillDetail::where('id_bill', $billId)
        ->join('products', 'bill_details.id_product', '=', 'products.id')
        ->select('*')
        ->get()
        ->toArray();
        return $details;
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
        $this->cau1 ="hello";
        // nhảy vào trang giỏ hàng
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
            if ($this->account && $this->account->user_type === 'App\Models\Customer') {
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
                }
            }
            else if($this->account && $this->account->user_type !== 'App\Models\Customer'){
                $employee=Employee::find($this->account['user_id']);
                if($employee){
                    $nameParts = explode(' ', $employee->full_name);
                    if(count($nameParts)>=2){
                        $this->firstName = array_shift($nameParts);
                        $this->fullName = implode(' ', $nameParts);
                    }
                    else{
                        $this->firstName='';
                        $this->fullName=array_shift($nameParts);
                    }
                                    // Gán các thông tin còn lại
                    $this->numberPhone = $employee->phone;
                    $this->idrole = $employee->id_role;
                    $this->salary=$employee->salary;
                    $this->createdAt = $employee->created_at->format('Y-m-d');
                }
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
        return view('livewire.user.previous-orders');
    }
}
