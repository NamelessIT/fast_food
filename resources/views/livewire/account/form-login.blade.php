<form action="" class="mx-auto mt-5 d-flex flex-column justify-content-center align-items-center">

    {{-- {{dd (env ('APP_URL'))}} --}}
    <h2 class="text-center text-uppercase fw-bold">Đăng nhập</h2>

    <div class="form-group my-3">
        <input type="text" id="username" value="" placeholder=" " wire:model="username">
        <label for="username">Tên đăng nhập của bạn <span class="text-danger">*</span></label>
        <span class="underline"></span>
        @error('username')
            <span class="message-error">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group my-3" x-data="{ showpassword: false }">
        <input x-bind:type="showpassword ? 'text' : 'password'" id="password" value="" placeholder=" "
            wire:model="password">
        <label for="password">Mật khẩu <span class="text-danger">*</span></label>
        <span class="underline"></span>
        <i x-bind:class="showpassword ? 'fa-solid fa-eye toggle-password' : 'fa-solid fa-eye-slash toggle-password'"
            x-on:click="showpassword = !showpassword"></i>
        @error('password')
            <span class="message-error">{{ $message }}</span>
        @enderror
    </div>

    <div class="options my-2 d-flex justify-content-end align-items-center">
        <a href="{{ route('account.forgot-password') }}" class="text-decoration-none" wire:navigate>Bạn quên mật khẩu?</a>
    </div>

    <button class="btn-submit btn my-2 rounded-pill fw-bold" wire:click.prevent="login">Đăng nhập</button>
   
  

    <p class="separator mt-3"><span>hoặc</span></p>

    {{-- <div class="socials d-flex justify-content-center align-items-center">
        <a href="{{ route('account.redirect', 'facebook') }}"
            class="social-facebook text-decoration-none d-flex justify-content-center rounded-pill mb-3 align-items-center">
            <i class="fa-brands fa-facebook"></i>
            Đăng nhập bằng Facebook
        </a>
    </div> --}}
    <div wire:loading >
        <x-loader />
    </div>
</form>
