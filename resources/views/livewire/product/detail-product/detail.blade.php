<div class="product-detail container my-5 mx-auto row">
    <div
        class="product-thumbnail col-lg-6 col-md-6 col-xs-12 d-flex flex-column justify-content-center align-items-center">
        <img src="data:image/jpeg;base64, {{ $detail['image_show'] }}" alt="" class="img-fluid">
        <span class="product-name fw-semibold fs-1 mt-3">{{ $detail['product_name'] }}</span>
        <div class="d-flex justify-content-center align-items-center">
            <span id="product-price" class="fw-medium fs-3 mt-3">{{ number_format($totalPrice, 0, '', '.') }}</span><span
                class="fs-4 mt-3"> đ</span>
        </div>
    </div>

    {{-- extra food --}}
    <div class="product-description col-lg-6 col-md-6 col-xs-12 d-flex flex-column">
        <span class="title-description d-block fw-semibold fs-5 px-3 py-2 w-75">Ngon hơn khi ăn kèm</span>
        <div class="extra-food w-75 px-3">
            @foreach ($listExtraFood as $key => $item)
                <div class="food row d-flex flex-row align-items-center justify-content-between">
                    <span class="quantity col-1">x{{ $listChooseExtraFood[$key]['quantity'] }}</span>
                    <div class="name col-8" wire:click="addExtraFood ({{ $listChooseExtraFood[$key]['id'] }})">
                        <img src="{{ 'data:image/png;base64,' . $item['image_show'] }}" alt="Error"
                            class="img-fluid">
                        <span>{{ $item['food_name'] }}</span>
                    </div>
                    <div class="price col-3">
                        <span>{{ number_format($item['price'], 0, '', '.') }} đ</span>
                        <span class="delete-extra-food"
                            wire:click="deleteExtraFood ({{ $listChooseExtraFood[$key]['id'] }})"><i
                                class="fa-solid fa-circle-xmark"></i></span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- add to cart --}}
        <div class="add-to-cart w-75 row mt-3">
            <div class="quantity col-md-6 col-lg-6 col-xs-12 d-flex align-items-center">
                <button
                    @if ($quantity == 1) class="decrease opacity-50"
                    @else class="decrease" wire:click="decreaseProduct" @endif>
                    <i class="fa-solid fa-minus"></i></button>
                <input type="number" wire:model.number.live="quantity">
                {{-- <span> {{ $quantity }} </span> --}}
                <button
                    @if ($quantity < 50) class="increase" wire:click="increaseProduct"
                @else
                    class="increase opacity-50" @endif><i
                        class="fa-solid fa-plus"></i>
                </button>
            </div>
            <button class="add col-md-6 col-lg-6 col-xs-12" wire:click="addToCart">Thêm vào giỏ hàng</button>
        </div>
    </div>
</div>
