<div class="card container mt-5">
    @if(session('user_type') === config('constants.user.customer'))
        <div class="card-header bg-primary text-white">
            <h1 class="mb-0">Các đơn hàng đã đặt</h1>
        </div>
        <div class="card-body">
            @if(empty($bills) && $searchTerm===null)
                <p>Bạn chưa có đơn hàng nào.</p>
                <button class="btn btn-success mt-3" wire:click="startBill">Bắt đầu đặt hàng</button>
            @else
                        <!-- Tìm kiếm đơn hàng -->
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm hoặc tổng tiền..." wire:model="searchTerm">
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
                                    <li class="list-group-item">
                                        Đơn hàng #{{ $bill['id'] }}
                                    </li>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>Số lượng</th>
                                                <th>Ngày tạo</th>
                                                <th>Ngày cập nhật</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($this->fetchBillDetail($bill['id']) as $detail)
                                                <tr class="list-group-item-BillDetail" wire:click="chooseProduct({{ $detail['slug'] }})">
                                                    <td>{{ $detail['product_name'] }}</td>
                                                    <td>{{ $detail['quantity'] }}</td>
                                                    <td>{{ $detail['created_at'] }}</td>
                                                    <td>{{ $detail['updated_at'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <li class="list-group-item">
                                        Thành tiền: {{ $bill['total'] }} VND
                                    </li>
                                    <button class="btn btn-success mt-3" wire:click="createBill">Mua lại</button>
                                    <div class="seperated"></div>
                                @endforeach
                            </ul>
                        </div>    
                    @endif  
            @endif
        </div>
    @endif
</div>
