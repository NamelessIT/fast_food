<?php

namespace App\Livewire\Product;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderExtraFoodDetail;
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
    public $totalBill;
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

        // check đăng nhập mới được đặt hàng
        if (!Auth::check()) {
            $this->dispatch("addToCartNotLogin", [
                "url" => route("account.index")
            ]);
        } else {
            $id_user = Auth::user()->user_id;
            $order = Order::where("id_customer", $id_user)->first();
            $this->id_order = $order->id;
            $orderDetail = OrderDetail::where("id_product", $this->id)
                ->where("id_order", $this->id_order)
                ->get();
            if ($orderDetail == null) {
                OrderDetail::create([
                    "id_order" => $this->id_order,
                    "id_product" => $this->id,
                    "quantity" => 1,
                    "total_price" => $this->price,
                ]);
            } else {
                $flag = false;
                // duyệt theo từng sản phẩm có trong order (order detail)
                foreach ($orderDetail as $key => $item) {
                    // nếu số lượng extra food của thằng order detail đó là không thì ta sẽ cộng dồn số lượng sản phẩm và đổi giá trị cờ
                    if (count($item->extraFoods) == 0) {
                        $flag = true;

                        $orderDetail[$key]->quantity++;
                        $orderDetail[$key]->total_price += $this->price;
                        $orderDetail[$key]->save();
                    }
                }
                // nếu cờ bằng false nghĩa là số lượng extra food có và ta sẽ tiến hành tạo mới order
                if ($flag == false) {
                    OrderDetail::create([
                        "id_order" => $this->id_order,
                        "id_product" => $this->id,
                        "quantity" => 1,
                        "total_price" => $this->price,
                    ]);
                }
            }
            $order->total += $this->price;
            $order->save();
            $this->dispatch("refresh", 'header,ListOrder');
        }
    }
}
