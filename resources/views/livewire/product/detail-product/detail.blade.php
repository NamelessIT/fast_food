<div class="product-detail container my-5 mx-auto row">
    <div class="product-thumbnail col-lg-6 col-md-6 col-xs-12 d-flex flex-column justify-content-center align-items-center">
        <img src="data:image/jpeg;base64, {{$detail['image_show']}}" alt="" class="img-fluid">
        <span class="product-name fw-semibold fs-1 mt-3">{{$detail['product_name']}}</span>
        <div class="d-flex justify-content-center align-items-center">
            <span id="product-price" class="fw-medium fs-3 mt-3"></span><span class="fs-4 mt-3"> đ</span>
        </div>
    </div>

    {{-- extra food --}}
    <div class="product-description col-lg-6 col-md-6 col-xs-12 d-flex flex-column">
        <span class="title-description d-block fw-semibold fs-5 px-3 py-2 w-75">Ngon hơn khi ăn kèm</span>
        <div class="extra-food w-75 px-3">
            @foreach ($listExtraFood as $item)
            {{-- {{dd ($item)}} --}}
            <div class="food row d-flex flex-row align-items-center justify-content-between">
                <span class="quantity col-1">1x</span>
                <div class="name col-8">
                    <img src="{{ 'data:image/png;base64,' . $item['image_show']}}" alt="Error" class="img-fluid">
                    <span>{{$item['food_name']}}</span>
                </div>
                <div class="price col-3">
                    <span>{{number_format($item['price'], 0, '', '.')}} đ</span>
                </div>
            </div>
            @endforeach
        </div>

        {{-- add to cart --}}
        <div class="add-to-cart w-75 row mt-3">
            <div class="quantity col-md-6 col-lg-6 col-xs-12 d-flex align-items-center">
                <button class="decrease
                "><i class="fa-solid fa-minus"></i></button>
                <input type="number" name="" value="1" id="">
                <button class="increase"><i class="fa-solid fa-plus"></i></button>
            </div>
            <button class="add col-md-6 col-lg-6 col-xs-12">Thêm vào giỏ hàng</button>
        </div>
    </div>

    <script>
        document.querySelector ('.add-to-cart input').value = 1
        
        createOdometer (document.querySelector ('#product-price'), 0,{{$detail['price']}})

        // change quantity
        document.querySelector ('.add-to-cart .decrease').addEventListener ('click', () => {
            let quantity = changeQuantity ("-")
            createOdometer (document.querySelector ('#product-price'), {{$detail['price']}} * quantity + 1, {{$detail['price']}} * quantity)
        })
        document.querySelector ('.add-to-cart .increase').addEventListener ('click', () => {
            let quantity = changeQuantity ("+")
            createOdometer (document.querySelector ('#product-price'), {{$detail['price']}} * quantity -1 , {{$detail['price']}} * quantity)
        })
        document.querySelector ('.add-to-cart input').addEventListener ('blur', (e) => {
            let quantity = changeQuantityInput (e, {{$detail['price']}})
            createOdometer (document.querySelector ('#product-price'), {{$detail['price']}} * quantity -1 , {{$detail['price']}} * quantity)
        })

    </script>
</div>
