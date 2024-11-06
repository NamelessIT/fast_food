<div class="container mt-5">
    <div class="card" style="width:100%">
        <div class="card-header bg-secondary text-white">
            <h1 class="mb-0">Chi tiết tài khoản</h1>
        </div>
        <div class="card-body">
            <form>
                <div class="mb-3">
                    <label for="FirstName" class="form-label">Họ của bạn *</label>
                    <input type="text" class="form-control" id="FirstName" wire:model="firstName" disabled required>
                </div>
                <div class="mb-3">
                    <label for="FullName" class="form-label">Tên của bạn *</label>
                    <input type="text" class="form-control" id="FullName" wire:model="fullName" disabled required>
                </div>
                <div class="mb-3">
                    <label for="NumberPhone" class="form-label">Số điện thoại *</label>
                    <input type="number" class="form-control" id="NumberPhone" wire:model="numberPhone" disabled required>
                </div>
                <div class="mb-3">
                    <label for="Point" class="form-label">Số Điểm</label>
                    <input type="number" class="form-control" id="Point" wire:model="point" disabled>
                </div>
                <div class="mb-3">
                    <label for="CreatedAt" class="form-label">Ngày tạo</label>
                    <input type="date" class="form-control" id="CreatedAt" wire:model="createdAt" disabled>
                </div>
                {{-- <button type="button" class="btn btn-success" wire:click="UpdateAccount">Cập nhật tài khoản</button> --}}
            </form>
        </div>
    </div>
</div>
