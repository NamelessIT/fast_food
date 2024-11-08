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
    public $pricePerOneProduct = 0;
    public $order;
    public $quantity = 0;
    public $orderDetail;
    public $listExtraFood;
    public $totalPriceExtraFood = 0;

    public function mount($id_product, $id_orderDetail, $product_name, $image_show, $quantity, $price)
    {
        $this->id_product = $id_product;
        $this->id_orderDetail = $id_orderDetail;
        $this->product_name = $product_name;
        $this->image_show = $image_show;
        $this->quantity = $quantity;
        $this->pricePerOneProduct = Product::find($this->id_product)->price;
        $this->orderDetail = OrderDetail::find($this->id_orderDetail);
        $this->listExtraFood =  OrderDetail::find($this->id_orderDetail)->extraFoods;
        foreach ($this->listExtraFood as $item) {
            $this->totalPriceExtraFood += $item->price * $item->pivot->quantity;
        }
        $this->price = $price + $this->totalPriceExtraFood;
        $this->order = Order::where("id_customer", Auth::user()->user_id)->first();
    }
    public function render()
    {

        return view(
            'livewire.order.list-order.cart',
            [
                "orderDetail" => $this->orderDetail,
            ]

        );
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
    public function updateTotalBill($total)
    {
        if ($this->order != null) {
            $this->order->total += $total;
            $this->order->save();
        }
    }

    public function updatedQuantity($value)
    {
        $this->dispatch("refresh");

        if ($value == 0) {
            $this->dispatch("deleteOrder", [
                "id" => $this->id_orderDetail
            ]);
            $this->orderDetail->delete();
            return;
        }
        $this->orderDetail->quantity = $value;
        $this->orderDetail->save();


        $this->price = $this->pricePerOneProduct * $value + $this->totalPriceExtraFood * $value;
        $this->updateTotalBill($this->price);
    }
}
