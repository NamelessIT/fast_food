<div class="order-status">
    <i class="bi bi-arrow-left backToUser" style="cursor: pointer"  wire:click="navigateUser"></i>
    <h2 class="text-center mb-4">Đơn hàng #{{ $bills[0]['id'] }}</h2>
    <h2 class="text-center mb-4">Tình trạng đơn hàng: 
        <span class="{{ $bills[0]['status'] == 0 ? 'text-danger' : ($bills[0]['status'] == 3 ? 'text-success' : 'text-primary') }}">
            @switch($bills[0]['status'])
                @case(0)
                    Huỷ
                    @break
                @case(1)
                    Đang chờ
                    @break
                @case(2)
                    Đang giao hàng
                    @break
                @case(3)
                    Hoàn tất
                    @break
                @default
                    Không xác định
            @endswitch
        </span>
    </h2>

    <!-- Các bước đơn hàng -->
    <div class="order-step container py-4">
        <div class="row justify-content-center">
            <!-- Đơn hàng đã đặt -->
            <div class="col-12 col-md-6 d-flex align-items-center mb-3 {{ $bills[0]['status'] >= 1 && $bills[0]['status'] <= 3 ? 'text-primary' : '' }}">
                <i class="bi bi-journal-text me-2"></i>
                <div>Đơn hàng đã đặt</div>
            </div>
            <!-- Đang giao hàng -->
            <div class="col-12 col-md-6 d-flex align-items-center mb-3 {{ $bills[0]['status'] >= 2 && $bills[0]['status'] <= 3 ? 'text-primary' : '' }}">
                <i class="bi bi-truck me-2"></i>
                <div>Shipper đang giao hàng</div>
            </div>
            <!-- Hoàn tất -->
            <div class="col-12 col-md-6 d-flex align-items-center mb-3 {{ $bills[0]['status'] == 3 ? 'text-success' : '' }}">
                <i class="bi bi-check-circle me-2"></i>
                <div>Hoàn tất đơn hàng</div>
            </div>
            <!-- Huỷ -->
            <div class="col-12 col-md-6 d-flex align-items-center mb-3 {{ $bills[0]['status'] == 0 ? 'text-danger' : '' }}">
                <i class="bi bi-x-circle me-2"></i>
                <div>Huỷ đơn hàng</div>
            </div>
        </div>
        <h5>
            <i class="bi bi-signpost-fill"></i>
            Địa chỉ giao: {{ $address['address'] }},{{ $address['district_name'] }},{{ $address['ward_name'] }},{{ $address['city_name'] }}</h5>
        <h5>
            <i class="bi bi-ticket-perforated-fill"></i>
            Voucher: {{ $nameVoucher['voucher_name'] ?? 'Không có' }} - {{ $nameVoucher['description']}}</h5>
        <h5 class="text-end fw-bold">
            <i class="bi bi-cash-coin"></i>
            Tổng cộng: {{ number_format($bills[0]["total"], 0, ',', '.') }} VND</h5>
    </div>

    <!-- Chi tiết đơn hàng -->
    <div class="order-details mt-4 p-4">
        @foreach ($detail_bills as $item)
            <div class="card mb-3 products_chosen" wire:click="chooseProduct('{{ $item['slug'] }}','{{ $item['exit'] }}')" >
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{ 'data:image/png;base64,' . $item['image_show'] }}" alt="Sản phẩm" class="img-fluid rounded-start">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item['product_name'] }}</h5>
                            <p class="card-text">
                                <i class="bi bi-cash"></i>
                                Đơn giá: {{ number_format($item['price'], 0, ',', '.') }} VND</p>
                            <p class="card-text">
                                <i class="bi bi-basket"></i>
                                Số lượng: {{ $item['quantity'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <button class="btn btn-danger mt-3 w-100" {{ $bills[0]['status'] == 0 || $bills[0]['status'] == 3 ||$bills[0]['status'] == 2  ? 'disabled' : '' }} wire:click="cancel_Bill">Hủy đơn</button>
    </div>
</div>
