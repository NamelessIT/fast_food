<?php

namespace App\Livewire\Order\ListOrder;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Cart extends Component
{
    public $id_product;
    public $id_orderDetail;
    public $product_name = "";
    public $image_show = "";
    public $price;
    public $pricePerOne = 0;
    public $quantity = 0;
    public $orderDetail;
    public function mount($id_product, $id_orderDetail, $product_name, $image_show, $quantity, $price)
    {
        $this->id_product = $id_product;
        $this->id_orderDetail = $id_orderDetail;
        $this->product_name = $product_name;
        $this->image_show = $image_show;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->pricePerOne = Product::find($this->id_product)->price;
        $this->orderDetail = OrderDetail::find($this->id_orderDetail);
    }
    public function render()
    {
        return view('livewire.order.list-order.cart');
    }


    public function incrementQuantity()
    {
        $this->quantity++;
        $this->updatedQuantity($this->quantity);
    }
    public function deleteOrder()
    {
        $this->updatedQuantity(0);
    }
    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
            $this->updatedQuantity($this->quantity);
        }
    }

    public function updatedQuantity($value)
    {
        $this->dispatch("refresh");
        $this->orderDetail->quantity = $value;
        $this->orderDetail->save();
        $this->price = $this->pricePerOne * $value;
        if ($value == 0) {
            $this->dispatch("deleteOrder", [
                "id" => $this->id_orderDetail
            ]);
            $this->orderDetail->delete();
        }
    }
}
