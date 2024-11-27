<form action="" class="mx-auto mt-5 d-flex flex-column justify-content-center align-items-center"
    enctype="multipart/form-data">
    <h2 class="text-center text-uppercase fw-bold">Đăng ký</h2>

    {{-- {{dd (Cache::get('otp_trannam2712sgu@gmail.com'))}} --}}

    <div class="form-group my-3">
        <input type="text" id="email" value="" placeholder=" " wire:model="email">
        <label for="email">Email của bạn <span class="text-danger">*</span></label>
        <span class="underline"></span>
        @error('email')
            <span class="message-error">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group my-3">
        <input type="text" id="fullname" value="" placeholder=" " wire:model="fullname">
        <label for="fullname">Họ tên của bạn <span class="text-danger">*</span></label>
        <span class="underline"></span>
        @error('fullname')
            <span class="message-error">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group my-3">
        <input type="text" id="phoneNumber" value="" placeholder=" " wire:model="phoneNumber">
        <label for="phoneNumber">Số điện thoại <span class="text-danger">*</span></label>
        <span class="underline"></span>
        @error('phoneNumber')
            <span class="message-error">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group my-3">
        <input type="text" id="username" value="" placeholder=" " wire:model="username">
        <label for="email">Tên đăng nhập của bạn <span class="text-danger">*</span></label>
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

{{--     <div class="form-group send-otp my-3 d-flex justify-content-between align-items-center">
        <input type="text" id="otp" value="" placeholder=" " wire:model="otp">
        <label for="otp">Nhập OTP<span class="text-danger">*</span></label>
        <span class="underline"></span>
        @error('otp')
            <span class="message-error">{{ $message }}</span>
        @enderror
        <button class="btn-send rounded-pill" wire:click.prevent="sendOTP">Gửi OTP</button>
    </div> --}}

    <div class="upload my-1">
        <input type="file" id="avatar" hidden wire:model="avatar" accept="image/png, image/gif, image/jpeg">
        <label for="avatar" style="cursor: pointer;"
            class="bg-primary rounded-pill p-2 px-3 d-flex justify-content-center align-items-center text-white gap-1">
            <i class="fa-solid fa-upload"></i>
            <span>Upload ảnh đại diện</span>
        </label>
    </div>

    @if ($avatar)
        <img src="{{ $avatar->temporaryUrl() }}" class="image-show img-fluid my-3" alt="Ảnh đại diện">
    @endif

    <button class="btn-submit btn my-3 rounded-pill fw-bold" wire:click.prevent="register">Tạo tài khoản</button>

    <div wire:loading >
        <x-loader />
    </div>
</form>
