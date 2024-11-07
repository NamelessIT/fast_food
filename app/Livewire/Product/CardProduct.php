<?php

namespace App\Livewire\Product;

use App\Models\Order;
use App\Models\OrderDetail;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Js;

class CardProduct extends Component
{
    public $id;
    public $product_name;
    public $price;
    public $imageShow;
    public $slug;
    public $id_order;

    public $orderDetail;
    public function mount($id, $product_name, $imageShow, $price, $slug)
    {
        $this->id = $id;
        $this->product_name = $product_name;
        $this->imageShow = $imageShow;
        $this->price = $price;

        $this->slug = $slug;
    }


    public function render()
    {

        return view('livewire.product.card-product', [
            'id' => $this->id,
            'product_name' => $this->product_name,
            'imageShow' => $this->imageShow,
            "price" =>   $this->price
        ]);
    }
    public function handleAddToCart()
    {

        if (!Auth::check()) {
            $this->dispatch("addToCartNotLogin", [
                "url" => route("account.index")
            ]);
        } else {
            $this->id_order = Auth::user()->user_id;
            $orderDetail = OrderDetail::where("id_product", $this->id)
                ->where("id_order", $this->id_order)
                ->first();
            if ($orderDetail != null) {
                $orderDetail->quantity++;
                $orderDetail->save();
            } else {
                OrderDetail::create([
                    "id_order" => $this->id_order,
                    "id_product" => $this->id,
                    "quantity" => 1
                ]);
            }

            $this->dispatch("refresh");
        }
    }
}
