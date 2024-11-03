<div class="cart-container container-fluid p-3">
    <div class="title">
        <p class="text-uppercase fw-semibold fs-4">
            <span>Giỏ hàng của bạn</span>
            <span class="text-lowercase fw-normal fs-5">(1 sản phẩm)</span>
        </p>
    </div>

    {{-- list order --}}
    <div class="list-order">
        @for ($i = 0; $i < 5; $i++)
            <div class="order-item row p-2">
                <div class="image col-lg-2 col-md-2 col-sm-2 col-3">
                    <img src="https://www.lotteria.vn/media/catalog/product/cache/7519c4b08d36a80a7631ac53889db3b4/c/h/chickenset_fried_1_.png"
                        alt="" class="img-fluid rounded">
                </div>

                <div class="order-info col-lg-6 col-md-6 col-sm-6 col-5 d-flex flex-column justify-content-center align-items-start">
                    <span class="name text-capitalize fw-semibold mb-2">Gà rán phần</span>
                    <div class="extra-food-list d-flex flex-column justify-content-center align-items-start mb-2">
                        <span>- 2 x Phô mai cay</span>
                        <span>- 3 x Gà kéo sợi</span>
                        <span>- 4 x Gà lắc</span>
                        <span>- 5 x Khoai tây lắc</span>
                    </div>
                    <div class="total-item">
                        <span>87.000đ</span>
                    </div>
                </div>

                <div class="options col-lg-4 col-md-4 col-sm-4 col-4 d-flex justify-content-center align-items-center">
                    <div class="quantity d-flex justify-content-center align-items-center gap-2">
                        <button class="decrease">
                            <i class="fa-solid fa-minus"></i>
                        </button>
                        <input type="number" value="1">
                        <button class="decrease">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                    <div class="delete text-center fs-3">
                        <i class="fa-solid fa-trash-can"></i>
                    </div>
                </div>
            </div>    
        @endfor
    </div>
</div>
