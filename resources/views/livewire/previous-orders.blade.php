<div class="card container mt-5">
    <div class="card-header bg-primary text-white">
        <h1 class="mb-0">Các đơn hàng đã đặt</h1>
    </div>
    <div class="card-body">
        @if(empty($orders))
            <p>Bạn chưa có đơn hàng nào.</p>
        @else
            <ul class="list-group mb-4">
                @foreach($orders as $order)
                    <li class="list-group-item">
                        Đơn hàng #{{ $order['id'] }} - Tổng: {{ $order['total'] }} VND
                    </li>
                    <h2 class="mb-3">Chi tiết đơn hàng</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID Khách hàng</th>
                        <th>Tổng</th>
                        <th>Ngày tạo</th>
                        <th>Ngày cập nhật</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td>{{ $order['id'] }}</td>
                            <td>{{ $order['id_customer'] }}</td>
                            <td>{{ $order['total'] }}</td>
                            <td>{{ $order['created_at'] }}</td>
                            <td>{{ $order['updated_at'] }}</td>
                        </tr>
                </tbody>
            </table>
                @endforeach
            </ul>
            
            
        @endif
        <button class="btn btn-success mt-3" wire:click="createOrder">Bắt đầu đặt hàng</button>
    </div>
</div>
