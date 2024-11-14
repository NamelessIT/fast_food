<div class="cart-container container-fluid p-3">
    @livewire('order.list-order.title')
    <div class="list-order">
        @if (collect($listOrder)->isEmpty())
            <img src="https://bizweb.dktcdn.net/100/325/189/themes/675912/assets/empty-cart.png?1533693226542"
                alt="" class="img-fluid d-block mx-auto">
        @else
            @foreach ($listOrder as $order)
                @livewire('order.list-order.cart', [
                    'id_product' => $order->id,
                    'id_orderDetail' => $order->pivot->id,
                    'product_name' => $order->product_name,
                    'image_show' => $order->image_show,
                    'quantity' => $order->pivot->quantity,
                    'priceProduct' => $order->price,
                    'totalPrice' => $order->pivot->total_price,
                ])
            @endforeach
        @endif

    </div>
</div>
