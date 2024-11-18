@php
    $listExtraFood = $orderDetail->extraFoods;
@endphp


<div class="order-item row p-2" data-id={{ $id_orderDetail }}>
    <div class="image col-lg-2 col-md-2 col-sm-2 col-3">
        <img src="{{ 'data:image/png;base64,' . $image_show }}" alt="" class="img-fluid rounded">
    </div>

    <div class="order-info col-lg-6 col-md-6 col-sm-6 col-5 d-flex flex-column justify-content-center align-items-start">
        <span class="name text-capitalize fw-semibold mb-2">{{ $product_name }}</span>
        <div class="extra-food-list d-flex flex-column justify-content-center align-items-start mb-2">

            @foreach ($listExtraFood as $item)
                <small>{{ $item->pivot->quantity }} x {{ $item->food_name }} </small>
            @endforeach
        </div>
        <div class="total-item">
            <span>{{ number_format($totalPrice, 0, ',', '.') }} đ</span>
        </div>
    </div>

    <div class="options col-lg-4 col-md-4 col-sm-4 col-4 d-flex justify-content-center align-items-center">
        <div class="quantity d-flex justify-content-center align-items-center gap-2">
            <button class="decrease" wire:click ="decrementQuantity">
                <i class="fa-solid fa-minus"></i>
            </button>
            {{-- <input type="number" name="quantity" wire:model.number.live="quantity"> --}}

            <span>{{ $quantity }}</span>
            <button class="increase" wire:click ="incrementQuantity">
                <i class="fa-solid fa-plus"></i>
            </button>
        </div>
        <div class="delete text-center fs-3">
            <i class="fa-solid fa-trash-can" wire:click="deleteOrder"></i>
        </div>
    </div>
</div>
