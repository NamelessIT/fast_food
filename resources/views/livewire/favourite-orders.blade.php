<div class="container mt-5">
    <div class="card" style="width:100%">
        <div class="card-header bg-danger text-white">
            <h1 class="mb-0">Đơn đặt hàng yêu thích của tôi</h1>
        </div>
        <div class="card-body">
            @if(empty($orders))
                <p>Bạn chưa có đơn hàng nào.</p>
            @else
                <ul class="list-group">
                    @foreach($orders as $order)
                        <li class="list-group-item">{{ $order }}</li>
                    @endforeach
                </ul>
            @endif
            <button class="btn btn-warning mt-3" wire:click="createOrder">Bắt đầu đặt hàng</button>
        </div>
    </div>
</div>
