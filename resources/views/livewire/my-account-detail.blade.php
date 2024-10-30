<div class="container mt-5">
    <div class="card" style="width:100%">
        <div class="card-header bg-secondary text-white">
            <h1 class="mb-0">Chi tiết tài khoản</h1>
        </div>
        <div class="card-body">
            <form>
                <div class="mb-3">
                    <label for="FirstName" class="form-label">Họ của bạn *</label>
                    <input type="text" class="form-control" name="FirstName" id="FirstName" required>
                </div>
                <div class="mb-3">
                    <label for="FullName" class="form-label">Tên của bạn *</label>
                    <input type="text" class="form-control" name="FullName" id="FullName" required>
                </div>
                <div class="mb-3">
                    <label for="NumberPhone" class="form-label">Số điện thoại *</label>
                    <input type="number" class="form-control" name="NumberPhone" id="NumberPhone" required>
                </div>
                <div class="mb-3">
                    <label for="Gender" class="form-label">Giới tính *</label>
                    <select class="form-control" id="Gender" name="Gender" required>
                        <option value="nam">Nam</option>
                        <option value="nu">Nữ</option>
                        <option value="khac">Khác</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="birthDate" class="form-label">Ngày sinh của bạn (tuỳ chọn)</label>
                    <input type="date" class="form-control" id="birthDate">
                </div>
                <button type="button" class="btn btn-success" wire:click="UpdateAccount">Cập nhật tài khoản</button>
            </form>
        </div>
    </div>
</div>
