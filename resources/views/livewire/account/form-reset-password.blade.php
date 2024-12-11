<form action="" class="mx-auto mt-5 d-flex flex-column justify-content-center align-items-center"
    enctype="multipart/form-data">
    <h2 class="text-center text-uppercase fw-bold">Thay đổi mật khẩu</h2>

    {{-- {{dd (Cache::get('otp_trannam2712sgu@gmail.com'))}} --}}

    <div class="form-group my-3" x-data="{ showpassword: false }">
        <input x-bind:type="showpassword ? 'text' : 'password'" id="password" value="" placeholder=" "
            wire:model="password">
        <label for="password">Mật khẩu mới<span class="text-danger">*</span></label>
        <span class="underline"></span>
        <i x-bind:class="showpassword ? 'fa-solid fa-eye toggle-password' : 'fa-solid fa-eye-slash toggle-password'"
            x-on:click="showpassword = !showpassword"></i>
        @error('password')
            <span class="message-error">{{ $message }}</span>
        @enderror
    </div>

    <button class="btn-submit btn my-3 rounded-pill fw-bold" wire:click.prevent="resetPassword">Thay đổi</button>

    <div wire:loading >
        <x-loader />
    </div>
</form>
