<?php

namespace App\Livewire\Order\ListOrder;

use App\Models\CustomerAddress;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Livewire\Component;

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

    public function payment () {
        if ($this->idAddressChoose == 0) {
            $this->dispatch('paymentError');
            return;
        }
        dd ($this->idAddressChoose, $this->idAddress);
    }

    public function render()
    {
        return view('livewire.order.list-order.total', [
            // "totalPrice"=> $this->totalPrice,
        ]);
    }
    public function voucherApplied($voucher)
    {
        $this->selectedVoucher = $voucher; 
    }
}