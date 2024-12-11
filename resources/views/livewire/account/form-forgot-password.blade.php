<form action="" class="mx-auto mt-5 d-flex flex-column justify-content-center align-items-center"
    enctype="multipart/form-data">
    <h2 class="text-center text-uppercase fw-bold">Xác thực thông tin</h2>

    {{-- {{dd (Cache::get('otp_trannam2712sgu@gmail.com'))}} --}}

    <div class="form-group my-3">
        <input type="text" id="email" value="" placeholder=" " wire:model="email">
        <label for="email">Nhập email của bạn <span class="text-danger">*</span></label>
        <span class="underline"></span>
        @error('email')
            <span class="message-error">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group send-otp my-3 d-flex justify-content-between align-items-center">
        <input type="text" id="otp" value="" placeholder=" " wire:model="otp">
        <label for="otp">Nhập OTP<span class="text-danger">*</span></label>
        <span class="underline"></span>
        @error('otp')
            <span class="message-error">{{ $message }}</span>
        @enderror
        <button class="btn-send rounded-pill" wire:click.prevent="sendOTP">Gửi OTP</button>
    </div>

    <button class="btn-submit btn my-3 rounded-pill fw-bold" wire:click.prevent="continue">Tiếp tục</button>

    <div wire:loading >
        <x-loader />
    </div>
</form>
