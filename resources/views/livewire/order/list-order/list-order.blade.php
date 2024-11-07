<div class="cart-container container-fluid p-3">
    <div class="title">
        <p class="text-uppercase fw-semibold fs-4">
            <span>Giỏ hàng của bạn</span>
            <span class="text-lowercase fw-normal fs-5">({{ $listOrder->sum('pivot.quantity') }})</span>
        </p>
    </div>
    <div class="list-order">
        @foreach ($listOrder as $order)
            @livewire('order.list-order.cart', [
                'id_product' =>$order->id,
                'id_orderDetail' => $order->pivot->id,
                'product_name' => $order->product_name,
                'image_show' => $order->image_show,
                'quantity' => $order->pivot->quantity,
                'price' => $order->price * $order->pivot->quantity,
            ])
        @endforeach
    </div>
</div>
