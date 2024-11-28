<div style="scroll-behavior: auto;height:42rem"> 
    <div class="order-status">
        <h2>Tình trạng đơn hàng: đang giao hàng</h2>
        <div class="order-step container py-4">           
            <div class="order-step container py-4">
                <div class="row justify-content-center">
                    @if (!empty($bills) && isset($bills[0])) 
                        <!-- Đơn hàng đã đặt -->
                        <div class="col-12 col-md-6 d-flex align-items-center mb-3 {{ $bills[0]['status'] >= 1 && $bills[0]['status'] <= 3 ? 'text-primary' : '' }}">
                            <i class="bi bi-journal-text me-2"></i>
                            <div>Đơn hàng đã đặt</div>
                        </div>
                
                        <!-- Shipper đang giao hàng -->
                        <div class="col-12 col-md-6 d-flex align-items-center mb-3 {{ $bills[0]['status'] >= 2 && $bills[0]['status'] <= 3 ? 'text-primary' : '' }}">
                            <i class="bi bi-truck me-2"></i>
                            <div>Shipper đang giao hàng</div>
                        </div>
                
                        <!-- Hoàn tất đơn hàng -->
                        <div class="col-12 col-md-6 d-flex align-items-center mb-3 {{ $bills[0]['status'] == 3 ? 'text-success' : '' }}">
                            <i class="bi bi-check-circle me-2"></i>
                            <div>Hoàn tất đơn hàng</div>
                        </div>
                
                        <!-- Huỷ đơn hàng -->
                        <div class="col-12 col-md-6 d-flex align-items-center mb-3 {{ $bills[0]['status'] == 0 ? 'text-danger' : '' }}">
                            <i class="bi bi-x-circle me-2"></i>
                            <div>Huỷ đơn hàng</div>
                        </div>
                    @else
                        <p class="text-center">Không tìm thấy thông tin đơn hàng.</p>
                    @endif
                </div>
                
            </div>
            
        </div>
        <div class="order-details">
            <div>
                @foreach ($detail_bills as $item)                
                    <p>Tên sản phẩm: {{ $item['product_name'] }}</p>
                    <img src="{{ 'data:image/png;base64,' . $item['image_show'] }}" alt="sd"class="img-fluid card-img-top">
                    <p>Đơn giá: {{ $item['price'] }}</p>
                    <p>Số lượng: {{ $item['quantity'] }}</p>
                @endforeach
            </div>
            <h5>Địa chỉ giao:{{ $bills[0]['id_address'] }}</h5>
            <h5>Voucher:{{ $bills[0]['id_voucher'] ?? "không có"}}</h5>
            <h5>Tổng cộng:{{ $bills[0]["total"] }}</h5>
            <button class="cancel-btn" wire:click="cancel_Bill">Hủy đơn</button>
        </div>
    </div>
</div>
