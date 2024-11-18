<nav class="navbar navbar-expand-lg navbar-light bg-light p-0 ">
    <div
        class="container-fluid d-flex justify-content-lg-around justify-content-between align-items-center shadow bg-body rounded p-3 mb-5 mb-sm-2 ">
        <!-- Logo bên trái -->
        <div class="navLogo">
            <a class="navbar-brand d-flex" href="{{ route('home.index') }}">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo">
                <h1>FastFoood</h1>
            </a>
        </div>
        {{-- nav menu wrapper  --}}
        <div class="navContainer collapse navbar-collapse flex-grow-0  ">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('product.list-product') }}">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#">Promotion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#">Best seller</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#">About</a>
                </li>
        </div>


        {{-- header event block  --}}

        <div class="d-flex headerEventBlock">
            <div class="eventBlock d-flex">
                {{-- button login  --}}
                <div class="accountLogin">
                    @if(session()->has('user_id') && session()->has('user_type'))
                        <a href={{ route('user.index') }} id="login" class=" border rounded-circle p-2 me-lg-2 me-2 bg-white btn " style="width:40px ;height:40px">
                    @else
                        <a href={{ route('account.index') }} id="login" class=" border rounded-circle p-2 me-lg-2 me-2 bg-white btn " style="width:40px ;height:40px">
                    @endif     
                        <i class="fa-solid fa-user" style="font-size: 20px"></i>
                    </a>
                </div>

                {{-- button cart --}}
                <a href="{{ route('order.index') }}" id="cart"
                    class=" btn border rounded-circle p-2 me-lg-5 me-3 bg-white  position-relative  ">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="notify_quantity ">{{ $notifyQuantity }}</span>
                </a>
                <button id="btnOrder" class="border rounded-pill px-4 px-lg-5"> Order now</button>

            </div>
            <!-- Nút toggle cho thiết bị di động -->
            <button class="navbar-toggler me-auto" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>


        </div>

        <!-- Offcanvas cho thiết bị di động -->
        <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">

            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">Fast foood</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('product.list-product') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Promotion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Best seller</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">About</a>
                    </li>
                </ul>
            </div>
        </div>
</nav>
