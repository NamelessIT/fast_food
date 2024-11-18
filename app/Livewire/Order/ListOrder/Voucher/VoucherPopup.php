<?php

namespace App\Livewire\Order\ListOrder\Voucher;
use App\Models\Voucher;
use Livewire\Component;

class VoucherPopup extends Component
{   
    public $vouchers;
    protected $listeners = ['showVoucherPopup' => 'show' , 'closeVoucherPopup' => 'hide'];

    public $isVisible = false;

    public function show()
    {
        $this->isVisible = true;
    }
    public function hide()
    {
        $this->isVisible =false;
    }
    public function mount()
    {
        $this->vouchers = Voucher::all();
    }
    public function apply($id)
    {
        $selected = Voucher::find($id);
        $this->dispatch('voucherApplied', $selected); 
        $this->isVisible = false;
    }

  
    public function render()
    {
        return view('livewire.order.list-order.voucher.voucher-popup');
    }

}
