<div class="container mt-5">
    <div class="card" style="width:100%">
        <div class="card-header bg-warning text-dark">
            <h1 class="mb-0">Đặt lại mật khẩu</h1>
        </div>
        <div class="card-body">
            <form>
                <div class="mb-3">
                    <input type="password" class="form-control" placeholder="Mật khẩu hiện tại *" required name="CurrentPassword" id="CurrentPassword">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" placeholder="Mật khẩu *" required name="NewPassword" id="NewPassword">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" placeholder="Xác nhận mật khẩu *" required name="AcceptPassword" id="AcceptPassword">
                </div>
                <button type="button" class="btn btn-primary" wire:click="ChangePassword">Đổi mật khẩu</button>
            </form>
        </div>
    </div>
</div>
