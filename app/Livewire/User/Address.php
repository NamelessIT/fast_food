<?php

namespace App\Livewire\User;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\Storage;
use App\Models\Account;
use App\Models\Customer;
use App\Models\Employee;
use GuzzleHttp\Client;
class Address extends Component
{
    public $account;
    public $city=[];
    public $districts = [];
    public $wards = [];
    public $CustomerAddresses=[];

    public $disableForm = "true";
    public $id_city, $id_district, $id_ward, $address;
    protected $listeners = ['deleteAddress'];
    protected $rules = [
        'id_city' => 'required',
        'id_district' => 'required',
        'id_ward' => 'required',
        'address' => 'required'
    ];

    public function mount(){
        $this->fetchDetailUser();
        $this->fetchAddress();
        $this->showAllCity();
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
        if ($this->id_city == 0 || $this->id_district == 0 || $this->id_ward == 0 || $this->address == '') {
            $this->dispatch('saveAddressError');
            return;
        }

        $this->dispatch('saveAddressSuccess');
        CustomerAddress::create([
            // 'id_customer' => auth()->user()->id,
            'id_customer' => $this->account['user_id'],
            'id_city' => $this->id_city,
            'id_district' => $this->id_district,
            'id_ward' => $this->id_ward,
            'address' => $this->address,
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $this->fetchAddress();
        $this->closeForm();
    }
    public function fetchAddress()
    {
        $this->CustomerAddresses = CustomerAddress::where('id_customer', auth()->user()->id)->get();
        $this->CustomerAddresses = $this->CustomerAddresses->toArray();
        $listTmp = [];

        $client = new Client();
        foreach ($this->CustomerAddresses as $key => $value) {
            $res = $client->request('GET', 'https://provinces.open-api.vn/api/p/' . $value['id_city']);
            $name_city = json_decode($res->getBody()->getContents())->name;

            $res = $client->request('GET', 'https://provinces.open-api.vn/api/d/' . $value['id_district']);
            $name_district = json_decode($res->getBody()->getContents())->name;

            $res = $client->request('GET', 'https://provinces.open-api.vn/api/w/' . $value['id_ward']);
            $name_ward = json_decode($res->getBody()->getContents())->name;
            $obj = [
                'id' => $value['id'],
                'city_name'=>$name_city,
                'district_name'=>$name_district,
                'ward_name'=>$name_ward,
                'address'=>$value['address'],
                'id_customer'=>$value['id_customer'],
            ];
            array_push($listTmp, $obj);
        }

        $this->CustomerAddresses = $listTmp;
    }
    public function showAllCity()
    {
        $client = new Client();
        $response = $client->request('GET', 'https://provinces.open-api.vn/api/p/');
        $cities = json_decode($response->getBody()->getContents(), true);

        $this->city = collect($cities)->mapWithKeys(function ($city) {
            return [$city['code'] => $city['name']];
        })->toArray();
    }
    
    public function updatedIdCity()
    {
        $this->id_district = null; // Reset quận/huyện và phường/xã khi chọn thành phố mới
        $this->id_ward = null;
        $this->wards = [];
        $client = new Client();
        $response = $client->request('GET', 'https://provinces.open-api.vn/api/p/' . $this->id_city . '?depth=2');
        $data = json_decode($response->getBody()->getContents(), true);

        $this->districts = collect($data['districts'])->mapWithKeys(function ($district) {
            return [$district['code'] => ['name' => $district['name']]];
        })->toArray();
    }
    
    public function updatedIdDistrict()
    {
        $this->id_ward = null; // Reset phường/xã khi chọn quận/huyện mới
        $client = new Client();
        $response = $client->request('GET', 'https://provinces.open-api.vn/api/d/' . $this->id_district . '?depth=2');
        $data = json_decode($response->getBody()->getContents(), true);

        $this->wards = collect($data['wards'])->map(function ($ward) {
            return [
                'ward_id' => $ward['code'],
                'ward_name' => $ward['name']
            ];
        })->toArray();
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
            }
        }
        $this->email=$this->account['email'];
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
