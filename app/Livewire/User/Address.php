<?php

namespace App\Livewire\User;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\Storage;
use App\Models\Account;
use App\Models\Customer;
use App\Models\Employee;

class Address extends Component
{
    public $account;
    public $districts = [];
    public $wards = [];
    public $CustomerAddresses=[];

    public $disableForm = "true";
    public $id_city, $id_district, $id_ward, $address;
    
    protected $rules = [
        'id_city' => 'required',
        'id_district' => 'required',
        'id_ward' => 'required',
        'address' => 'required'
    ];

    public function mount(){
        $this->fetchDetailUser();
        $this->fetchAddress();
        $this->loadDistrictsAndWards();
    }

    public function showForm()
    {
        $this->disableForm = "false";
    }

    public function closeForm()
    {
        $this->disableForm = "true";
        $this->reset(['id_city', 'id_district', 'id_ward', 'address']);
    }

    public function saveAddress()
    {
        $this->validate();

        CustomerAddress::create([
            // 'id_customer' => auth()->user()->id,
            'id_customer' => $this->account['user_id'],
            'id_city' => $this->id_city,
            'id_district' => $this->id_district,
            'id_ward' => $this->id_ward,
            'address' => $this->address,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $this->fetchAddress();
        $this->closeForm();
    }
    public function fetchAddress()
    {
        // Gọi phương thức để load dữ liệu quận, phường
        $this->loadDistrictsAndWards();
    
        if($this->account!=null){
            // Truy vấn danh sách địa chỉ
            $addresses = CustomerAddress::where('id_customer',$this->account['user_id'])
                        ->select('id', 'id_customer', 'id_city', 'id_district', 'id_ward', 'address')->get();
        
            // Biến để chứa danh sách địa chỉ đã được ánh xạ sang tên
            $this->CustomerAddresses = $addresses->map(function ($address) {
                $id_district = $address->id_district;
                $id_ward = $address->id_ward;
                return [
                    'id' => $address->id,
                    'id_customer' => $address->id_customer,
                    'address' => $address->address,
                    'district_name' => $this->districts[$id_district]['name'] ?? 'N/A',
                    'ward_name' => collect($this->districts[$id_district]['wards'] ?? [])
                    ->firstWhere('ward_id', $id_ward)['ward_name'] ?? 'N/A',
                    'city_name' => 'Hồ Chí Minh', // Tên thành phố cố định
                ];
            })->toArray();
        }
    }
    
    public function loadDistrictsAndWards()
    {
        
        $filePath = storage_path('app/public/districts_wards.txt');
        $lines = file_get_contents($filePath);
    
        $districtsData = [];
        foreach (explode("\n", $lines) as $line) {
            $lineParts = explode('|', trim($line));
            if (count($lineParts) >= 4) {
                $id_district = $lineParts[0];
                $districtName = $lineParts[1];
                $wardId = $lineParts[2];
                $wardName = $lineParts[3];
                
                // Tạo danh sách ward theo district
                if (!isset($districtsData[$id_district])) {
                    $districtsData[$id_district] = [
                        'name' => $districtName,
                        'wards' => [],
                    ];
                }
                $districtsData[$id_district]['wards'][] = [
                    'ward_id' => $wardId,
                    'ward_name' => $wardName,
                ];
            }
        }
        
        // Cập nhật danh sách district và wards ban đầu
        $this->districts = $districtsData;
    }
    
    public function updatedIdDistrict()
    {
        // Lấy danh sách wards cho district được chọn
        if (isset($this->districts[$this->id_district])) {
            $this->wards = $this->districts[$this->id_district]['wards'];
        } else {
            $this->wards = [];
        }
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
        return view('livewire.user.address');
    }
}
