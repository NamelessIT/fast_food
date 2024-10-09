
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">

        <!-- Custom CSS (Trang chủ (chinh xac hơn là cho header va footer)) -->
        <link href="{{ asset('css/homepage.css') }}" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <!-- Bootstrap JS + Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
<body>
@include('Layouts.Header')

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
    <img src="{{ asset('images/background.png') }}" alt="Background" id="Background_Login" class="img-responsive">
</div>
<script src="{{ asset('js/login.js') }}"></script>

@include('Layouts.Footer')
</body>
</html>

