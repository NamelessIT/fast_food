<div class="container mt-5">
    <div class="card" style="width:100%">
        <div class="card-header bg-info text-white">
            <h1 class="mb-0">Địa chỉ giao hàng đã lưu</h1>
        </div>
        <div class="card-body">
            @if(empty($address))
                <p>Hiện chưa có địa chỉ nào được lưu</p>
            @else
                <ul class="list-group">
                    @foreach($address as $each)
                        <li class="list-group-item">{{ $each }}</li>
                    @endforeach
                </ul>
            @endif
            <button class="btn btn-primary mt-3" wire:click="createOrder">Thêm địa chỉ</button>
        </div>
    </div>
</div>
