<?php

namespace App\Livewire\User;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\Storage;

class Address extends Component
{
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
            'id_customer' => 1,
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
    
        // Truy vấn danh sách địa chỉ
        $addresses = CustomerAddress::select('id', 'id_customer', 'id_city', 'id_district', 'id_ward', 'address')->get();
    
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
    public function render()
    {
        return view('livewire.user.address');
    }
}
