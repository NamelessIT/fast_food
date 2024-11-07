<?php

namespace App\Livewire\Product\DetailProduct;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderExtraFoodDetail;
use App\Models\Product;
use Carbon\Carbon;
use Livewire\Component;

class Detail extends Component
{
    public $slug;
    public $detail;
    public $listExtraFood;
    public $listChooseExtraFood = [];
    public $totalPrice = 0;

    public $quantity;

    public function mount($slug)
    {
        $this->slug = $slug;
        $getProduct = Product::where('slug', $slug);
        $this->quantity =1;
        $this->listExtraFood = $getProduct->first()->extraFoods->toArray();
        // dd ($this->listExtraFood);
        foreach ($this->listExtraFood as $key => $value) {
            $obj = [
                'id' => $value['id'],
                'quantity' => 0,
            ];
            // dd ($obj);
            array_push($this->listChooseExtraFood, $obj);
        }

        $this->detail = $getProduct->get()->toArray()[0];
        $this->totalPrice = $this->detail['price'];
        // dd ($this->detail);
    }

    public function addExtraFood($id)
    {
        $price = $this->totalPrice;
        foreach ($this->listChooseExtraFood as $key => $value) {
            if ($value['id'] === $id) {
                $this->listChooseExtraFood[$key]['quantity']++;
                $this->totalPrice += $this->listExtraFood[$key]['price'] * $this->quantity;
            }
        }
    }

    public function deleteExtraFood($id)
    {
        foreach ($this->listChooseExtraFood as $key => $value) {
            if ($value['id'] === $id) {
                $this->totalPrice -= $this->listExtraFood[$key]['price'] * $this->listChooseExtraFood[$key]['quantity'] * $this->quantity;
                $this->listChooseExtraFood[$key]['quantity'] = 0;
            }
        }
    }

    public function increaseProduct()
    {
        if ($this->quantity < 50) {
            $this->quantity++;
            $this->updateTotalPrice();
        }
    }

    public function decreaseProduct()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
            $this->updateTotalPrice();
        }
    }

    private function updateTotalPrice()
    {
        $basePrice = $this->detail['price'];
        $extraFoodPrice = 0;

        foreach ($this->listChooseExtraFood as $key => $value) {
            $extraFoodPrice += $value['quantity'] * $this->listExtraFood[$key]['price'] * $this->quantity;
        }

        $this->totalPrice = $basePrice * $this->quantity + $extraFoodPrice;
    }

    public function addToCart()
    {
        if (auth()->check()) {
            // dd (auth()->user());
            $idCustomer = auth()->user()->user_id;

            $idOrder = 0;
            $order = Order::where('id_customer', $idCustomer)->first();

            // dd ($order);
            if ($order) {
                $order->total += $this->totalPrice;
                $order->save();
                $idOrder = $order->id;
            } else {
                $order = Order::create([
                    'id_customer' => $idCustomer,
                    'total' => $this->totalPrice,
                ]);
                $idOrder = $order->id;
            }

            $idProduct = $this->detail['id'];
            $idOrderDetail = 0;
            $orderDetail = OrderDetail::where('id_order', $idOrder)->where('id_product', $idProduct)->first();

            if ($orderDetail) {
                $orderDetail->quantity += $this->quantity;
                $orderDetail->save();
                $idOrderDetail = $orderDetail->id;
            } else {
                $orderDetail = OrderDetail::create([
                    'id_order' => $idOrder,
                    'id_product' => $idProduct,
                    'quantity' => $this->quantity,
                ]);
                $idOrderDetail = $orderDetail->id;
            }

            $orderExtra = OrderExtraFoodDetail::where('id_order_detail', $idOrderDetail)->get();

            if (count($orderExtra) > 0) {
                // dd ($orderExtra[0]);
                $orderExtraDetails = [];
                foreach ($this->listChooseExtraFood as $key => $value) {
                    $check = false;
                    // dd ()
                    foreach ($orderExtra as $key2 => $value2) {
                        // dd ($value2);
                        if ($value['id'] === $value2['id_extra_food']) {
                            if ($value['quantity'] > 0) {
                                $orderExtra[$key2]->quantity += $value['quantity'];
                                $orderExtra[$key2]->save();
                            }
                            $check = true;
                        }
                    }
                    if (!$check) {
                        if ($value['quantity'] > 0) {
                            $obj = [
                                'id_order_detail' => $idOrderDetail,
                                'id_extra_food' => $value['id'],
                                'quantity' => $value['quantity'],
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];
                            array_push($orderExtraDetails, $obj);
                        }
                    }
                }
                if (count($orderExtraDetails) > 0) {
                    OrderExtraFoodDetail::insert($orderExtraDetails);
                }
            } else {
                $orderExtraDetails = [];

                foreach ($this->listChooseExtraFood as $key => $value) {
                    if ($value['quantity'] > 0) {
                        $obj = [
                            'id_order_detail' => $idOrderDetail,
                            'id_extra_food' => $value['id'],
                            'quantity' => $value['quantity'],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                        array_push($orderExtraDetails, $obj);
                    }
                }
                if (count($orderExtraDetails) > 0) {
                    OrderExtraFoodDetail::insert($orderExtraDetails);
                }
            }

            $this->dispatch('order-success');
        } else {
            $this->dispatch("addToCartNotLogin", [
                "url" => route("account.index")
            ]);
        }
    }

    public function render()
    {
        return view('livewire.product.detail-product.detail');
    }
}
