<div class="container mt-5">
    <div class="card" style="width:100%">
        <div class="card-header bg-warning text-dark">
            <h1 class="mb-0">Đặt lại mật khẩu</h1>
        </div>
        <div class="card-body">
            <form>
                <div class="mb-3">
                    <input type="password" class="form-control" placeholder="Mật khẩu hiện tại *" required name="CurrentPassword" id="CurrentPassword" wire:model="CurrentPassword">
                    @if ($messageCurrentPassword) 
                        <span class="message-error text-danger">{{ $messageCurrentPassword }}</span> 
                    @endif
                    @error('CurrentPassword')
                        <span class="message-error text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" placeholder="Mật khẩu *" required name="NewPassword" id="NewPassword" wire:model="NewPassword">
                    @if ($messageNewPassword) 
                        <span class="message-error text-danger">{{ $messageNewPassword }}</span> 
                    @endif
                    @error('NewPassword')
                        <span class="message-error text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" placeholder="Xác nhận mật khẩu *" required name="AcceptPassword" id="AcceptPassword" wire:model="AcceptPassword">
                    @if ($messageAcceptPassword) 
                        <span class="message-error text-danger">{{ $messageAcceptPassword }}</span> 
                    @endif
                    @error('AcceptPassword')
                        <span class="message-error text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="button" class="btn btn-primary" wire:click="ChangePassword">Đổi mật khẩu</button>
                @if (session()->has('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                @endif
            </form>
        </div>
    </div>
</div>
