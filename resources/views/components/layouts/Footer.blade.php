@if (Route::currentRouteName() != 'account.forgot-password' && Route::currentRouteName() != 'account.reset-password')
    
<footer class="bg-dark text-white p-4 mt-auto">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>
                    <a class="text-white d-md-none" data-bs-toggle="collapse" href="#productCategories" role="button" aria-expanded="false" aria-controls="productCategories">
                        Danh mục sản phẩm
                        <i class="fa-solid fa-angle-down"></i>
                    </a>
                    <span class="d-none d-md-block">Danh mục sản phẩm</span>
                </h5>
                <div class="collapse d-md-block" id="productCategories">
                    <ul class="menu-list">
                        <li><a href="#">Món ăn</a></li>
                        <li><a href="#">Nước giải khát và tráng miệng</a></li>
                        <li><a href="#">Khuyến mãi</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <h5>
                    <a class="text-white d-md-none" data-bs-toggle="collapse" href="#policies" role="button" aria-expanded="false" aria-controls="policies">
                        Chính sách
                        <i class="fa-solid fa-angle-down"></i>
                    </a>
                    <span class="d-none d-md-block">Chính sách</span>
                </h5>
                <div class="collapse d-md-block" id="policies">
                    <ul class="policies-list">
                        <li><a href="#">Chính sách giao hàng</a></li>
                        <li><a href="#">Chính sách thanh toán</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4">
                <h5>Liên hệ với chúng tôi</h5>
                <div>
                    <a href="#" class=""><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class=""><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class=""><i class="fa-sharp fa-regular fa-envelope"></i></a>
                </div>
                <div>Hotline: 19001009</div>
                <div>Địa chỉ: 273 D. An Dương Vương, Phường 3, Quận 5, Hồ Chí Minh</div>
            </div>
        </div>
    </div>
</footer>
@endif
