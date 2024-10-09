<header class="sticky-top">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <!-- Logo bên trái -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo">
            </a>

            <!-- Nút toggle cho thiết bị di động -->
            <button class="navbar-toggler me-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu điều hướng cho máy tính -->
            <div class="collapse navbar-collapse justify-content-start">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="#">Món ăn</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="#">Nước giải khát và tráng miệng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="#">Khuyến Mãi</a>
                    </li>
                </ul>
            </div>

            <!-- Biểu tượng giỏ hàng và nút Đăng nhập cho màn hình nhỏ -->
            <div class="d-flex justify-content-end d-lg-none">
                <a href="#" class="btn btn-outline-secondary"><i class="fas fa-shopping-cart"></i></a>
                <a href="{{ url('/account') }}" class="btn btn-order-now ms-2">Đăng nhập!</a>
            </div>

            <!-- Nút Đăng nhập cho màn hình lớn -->
            <a href="{{ url('/account') }}" class="btn btn-order-now d-none d-lg-inline ms-2">Đăng nhập!</a>

            <!-- Biểu tượng giỏ hàng cho màn hình lớn -->
            <a href="#" class="btn btn-outline-secondary d-none d-lg-inline ms-2"><i class="fas fa-shopping-cart"></i></a>

            <!-- Offcanvas cho thiết bị di động -->
            <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="width: 50%;">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="#">Món ăn</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="#">Nước giải khát và tráng miệng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="#">Khuyến Mãi</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
