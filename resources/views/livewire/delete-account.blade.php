<div class="container mt-5">
    <div class="card" style="width:100%">
        <div class="card-header bg-danger text-white">
            <h1 class="mb-0">Bạn có chắc muốn xoá tài khoản không</h1>
        </div>
        <div class="card-body">
            <span class="text-danger">Xóa tài khoản của bạn cũng sẽ xóa vĩnh viễn các thông tin bên dưới.</span>
            <ul class="list-group my-3">
                <li class="list-group-item read-only">Đơn đặt hàng trước đây của tôi</li>
                <li class="list-group-item read-only">Đơn đặt hàng yêu thích của tôi</li>
                <li class="list-group-item read-only">Địa chỉ giao hàng đã lưu</li>
            </ul>
            <button type="button" class="btn btn-danger" wire:click="DeleteAccount">Xoá</button>
        </div>
    </div>
</div>
