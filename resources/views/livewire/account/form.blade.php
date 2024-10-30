<div class="container-fluid mx-auto container-form" x-data="{ isLogin: true }">
    @if ($form == 'login')
        @livewire('account.form-login')
    @elseif ($form == 'register') 
        @livewire('account.form-register')
    @endif

    <div class="signup mb-2 text-center" x-show="isLogin">
        Bạn chưa có tài khoản? 
        <a style="cursor: pointer" 
           x-on:click="isLogin = false" 
           wire:click.prevent="changeForm('register')" 
           class="fw-bold text-black">
           Đăng ký
        </a>
    </div>

    <div class="login mb-2 text-center" x-show="!isLogin">
        Bạn đã có tài khoản? 
        <a style="cursor: pointer" 
           x-on:click="isLogin = true"
           wire:click.prevent="changeForm('login')" 
           class="fw-bold text-black">
           Đăng nhập
        </a>
    </div>

    <div class="loader" wire:loading>
        <div class="loading"></div>
    </div>
</div>