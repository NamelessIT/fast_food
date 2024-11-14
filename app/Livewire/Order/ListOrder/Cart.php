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
    public $order;
    public $quantity = 0;
    public $orderDetail;

    public $pricePerOne;
    public $priceExtraFood;
    public $totalPrice;

    public function mount($id_product, $id_orderDetail, $product_name, $image_show, $quantity, $priceProduct, $totalPrice)
    {
        $this->id_product = $id_product;
        $this->id_orderDetail = $id_orderDetail;
        $this->product_name = $product_name;
        $this->image_show = $image_show;
        $this->quantity = $quantity;
        $this->orderDetail = OrderDetail::find($this->id_orderDetail);
        $this->pricePerOne = $priceProduct;
        $this->totalPrice = $totalPrice;
        $listExtrafood = $this->orderDetail->extraFoods;
        if ($listExtrafood != null) {
            foreach ($listExtrafood as $extrafood) {
                $this->priceExtraFood += $extrafood->price * $extrafood->pivot->quantity;
            }
        }

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
    public function updateTotalBill()
    {
        if ($this->orderDetail != null)
            $this->order->total = $this->order->products->sum("pivot.total_price");
        // } else {
        //     $this->order->total = 0;
        // }

        $this->order->save();
    }

    public function updatedQuantity($value)
    {
        if ($value == 0) {
            $this->orderDetail->delete();
            $this->dispatch("refresh");
            $this->dispatch("deleteOrder", [
                "id" => $this->id_orderDetail
            ]);
            $this->updateTotalBill();
            return;
        }
        //price of orderItem in .blade
        $this->totalPrice =  $this->priceExtraFood * $value + $this->pricePerOne * $value;

        // total price in database
        $this->orderDetail->total_price =  $this->totalPrice;

        //quantity producy
        $this->orderDetail->quantity = $value;
        $this->orderDetail->save();
        $this->updateTotalBill();
        $this->dispatch("refresh");
    }
}
