<div>
    <div id="Page_Login">
        <div id="toast">
        </div>
        <div id="sign_up">
            <form wire:submit.prevent="submit" id="SignUpForm">
                @csrf
                <header>
                    <h1 style="margin: 2 ;">Chào mừng đến với của hàng Fast Food</h1>
                    <h5 style="margin: 2 ;">Đã có tài khoản? <button class="link">Đăng nhập tại đây</button></h5>
                </header>
                <body>
                    <h3>Email</h3>
                    <input class="textBox" name="email_Sign" id="email_Sign" placeholder="example@abc.com" wire:model="email">
                    @error('email')
                        <span id="emailError">{{ $message }}</span>
                    @enderror
                    </input>
                    <h3>Username</h3>
                    <input class="textBox" name="username_Sign" id="username_Sign" placeholder="tên đăng nhập" wire:model="username"></input>
                    @error('username')
                        <span id="usernameError">{{ $message }}</span>
                    @enderror                    
                    <h3>Password</h3>
                    <input class="textBox" name="password_Sign" id="password_Sign" placeholder="mật khẩu" wire:model="password">
                    @error('password')
                        <span id="passwordError">{{ $message }}</span>
                    @enderror                    
                    </input>
                    <div>
                        <h5>chính sách của chúng tui</h5>
                        <div class="detail"></div>
                    </div>
                    <div>
                        <input type="checkbox" class="checkbox" id="agreeDocumentCB">
                        <h5 class="textInline">Tôi đã đọc và chấp nhận với điều khoản và chính sách</h5>
                    </div>
                    <div>
    
                        <button class="submit" id="CreateAccountBtn">Tạo tài khoản</button>
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
                    <input class="textBox" type="email" name="email_Login" id="email_Login" placeholder="example@abc.com" />
                    <h3>Password</h3>
                    <input class="textBox" type="password_Login" name="password_Login" id="password_Login" placeholder="mật khẩu"/>
                    <button class="submit" id="LoginAccount">Đăng nhập</button>
                </div>
            </form>
        </div>
    
        <img src="{{ asset('images/background.png') }}" alt="Background" id="Background_Login" class="">
    </div>
</div>
