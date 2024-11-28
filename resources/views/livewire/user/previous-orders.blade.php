<div class="card container mt-5">
    @if(auth()->user()->user_type === config('constants.user.customer'))
        <div class="card-header bg-primary text-white">
            <h1 class="mb-0">Các đơn hàng đã đặt</h1>
        </div>
        <div class="card-body">
            @if(empty($bills) && $searchTerm===null)
                <p>Bạn chưa có đơn hàng nào.</p>
                <button class="btn btn-success mt-3" wire:click="startBill">Bắt đầu đặt hàng</button>
            @else
                <!-- Filter đơn hàng -->
                <div class="mb-3">
                    <select class="form-select" wire:model.lazy="filterStatus">
                        <option value="">Tất cả</option>
                        <option value="0">Huỷ</option>
                        <option value="1">Đang chờ</option>
                        <option value="2">Xác nhận</option>
                        <option value="3">Đã giao</option>
                    </select>
                </div>

                <!-- Tìm kiếm đơn hàng -->
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm hoặc tổng tiền..." wire:model="searchTerm" wire:keydown.enter="searchBills">
                    <div class="input-group-append">
                        <span class="input-group-text" wire:click="searchBills"><i class="fas fa-search"></i></span>
                    </div>
                </div>

                @if(empty($bills))
                    <p>Đơn hàng không tồn tại</p>
                @else
                    <div class="custom-scroll">
                        <ul class="list-group mb-4">
                            @foreach($bills as $bill)
                                <li class="list-group-item d-flex justify-content-between align-items-center" style="cursor: pointer" wire:click="navigatBillDetail({{ $bill['id'] }})">
                                    <span>Đơn hàng #{{ $bill['id'] }}</span>
                                    <span>Trạng thái:
                                        @switch($bill['status'])
                                            @case(0)
                                                <span class="text-danger">Huỷ</span>
                                                @break
                                            @case(1)
                                                <span class="text-primary">Đang chờ</span>
                                                @break
                                            @case(2)
                                                <span class="text-warning">Xác nhận</span>
                                                @break
                                            @case(3)
                                                <span class="text-success">Đã giao</span>
                                                @break
                                            @default
                                                <span>Không xác định</span>
                                        @endswitch
                                    </span>
                                </li>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr style="border-bottom: 1px solid;">
                                            <th>Sản phẩm</th>
                                            <th>Số lượng</th>
                                            <th>Ngày tạo</th>
                                            <th>Tổng tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($this->fetchBillDetail($bill) as $detail)
                                            <tr class="list-group-item-BillDetail" wire:click="chooseProduct('{{ $detail['slug'] }}')">
                                                <td>{{ $detail['product_name'] }}</td>
                                                <td>{{ $detail['quantity'] }}</td>
                                                <td>{{ $detail['bill_created_at'] }}</td>
                                                <td class="bill-address">{{ $detail['total'] }}</td>
                                            </tr>
                                            @foreach($this->fetchExtraFood($detail['detail_id']) as $extra)
                                                <tr class="extra-info">
                                                    <td colspan="2"  class="text-muted ps-4">
                                                        <span>{{ $extra['food_name'] }} (x{{ $extra['quantity'] }})</span>
                                                    </td>
                                                    <td colspan="2" class="text-end text-muted">
                                                        <span>{{ $extra['cod_price'] }} VNĐ</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                                <li class="list-group-item">
                                    Thành tiền: {{ $bill['total'] }} VND
                                </li>
                                <div class="seperated"></div>
                            @endforeach
                            <button class="btn btn-success mt-3" wire:click="createBill">Mua Thêm</button>
                        </ul>
                    </div>    
                @endif  
            @endif
        </div>
    @endif
</div>
