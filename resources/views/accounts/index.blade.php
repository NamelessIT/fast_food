@extends('../components/layouts.main')

@section('title','Document')

<!-- Thêm CSS riêng cho trang đăng nhập -->
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div id="Page_Login">
    <div id="sign_up">
        <form action="{{ route('signup') }}" method="POST" id="SignUpForm">
            @csrf
            <header>
                <h1 style="margin: 2 ;">Chào mừng đến với của hàng Fast Food</h1>
                <h5 style="margin: 2 ;">Đã có tài khoản? <button class="link">Đăng nhập tại đây</button></h5>
            </header>
            <body>
                <h3>Email</h3>
                <input class="textBox" name="email_Sign" placeholder="example@abc.com" ></input>
                <h3>Username</h3>
                <input class="textBox" name="username_Sign" placeholder="tên đăng nhập" ></input>
                <h3>Password</h3>
                <input class="textBox" name="password_Sign" placeholder="mật khẩu" ></input>
                <div>
                    <h5>chính sách của chúng tui</h5>
                    <div class="detail"></div>
                </div>
                <div>
                    <input type="checkbox" class="checkbox">
                    <h5 class="textInline">Tôi đã đọc và chấp nhận với điều khoản và chính sách</h5>
                </div>
                <div>

                    <button class="submit">Tạo tài khoản</button>
                </div>
            </body>

        </form>
        <form  id="loginForm" action="{{ route('login') }}" method="POST"  class="hide" >
            @csrf
            <header>
                <h1 style="margin: 2;">Đăng nhập</h1>
                <h5 style="margin: 2;">Chưa có tài khoản? <button type="button" class="link" id="registerBtn">Đăng ký</button></h5>
            </header>
            <div>
                <h3>Email</h3>
                <input class="textBox" type="email" name="email_Login" placeholder="example@abc.com" />
                <h3>Password</h3>
                <input class="textBox" type="password_Login" placeholder="mật khẩu"/>
                <button class="submit">Đăng nhập</button>
            </div>
        </form>
    </div>

    <img src="{{ asset('images/background.png') }}" alt="Background" id="Background_Login" class="">
</div>
@endsection

<!-- Thêm JS riêng cho trang đăng nhập -->
@section('custom-js')
    <script src="{{ asset('js/login.js') }}"></script>
@endsection
