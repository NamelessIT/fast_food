<div class="total-container container-fluid p-3">
    <div class="address px-3 py-4 rounded-4">
        <span class="title mb-4 d-block">Giao hàng đến</span>
        <div class="detail-address d-flex justify-content-center mb-3">
            <p class="content">{{$detailAddress}}</p>
            <i class="fa-solid fa-pen-to-square edit" data-bs-toggle="modal" data-bs-target="#choose-address"></i>
        </div>
        <p class="title"><span class="text-capitalize">Cửa hàng: Công nghệ phần mềm nhóm ...</span></p>
        <div class="break-line w-100 my-3"></div>
        <div class="notification text-center">
            Thời gian tiếp nhận đơn hàng trực tuyến từ 08:00 đến 21:00 hằng ngày
        </div>
    </div>

    <div class="voucher mt-2 px-3 py-4 rounded-4">
        <span class="title mb-4 d-block">Voucher</span>
        <div class="voucher-use">
        @if($selectedVoucher)
        <p>Voucher đang dùng: {{ $selectedVoucher['description'] }} - {{ $selectedVoucher['discount_percent'] }}% off</p>
        <button class="cancel-voucher btn btn-link p-0" wire:click="$dispatch('removeVoucher')" style="color: #007bff; text-decoration: underline; cursor: pointer;">
             Cancel Voucher
        </button>
        @if ($selectedVoucher['minium_condition'] > $totalPrice)
            <p style="font-size:15px ; color : red ">Voucher không đủ điều kiện để sử dụng</p>
        @endif
    @else
        <p>Hiện không có voucher được sử dụng</p>
    @endif
        </div>
        <div>
            @livewire('order.list-order.voucher.voucher-popup')
        </div>
        <button class="add-voucher w-100 rounded" wire:click="$dispatch('showVoucherPopup')">Thêm voucher</button>
    </div>
    

    <div class="total mt-2 rounded-4 d-flex flex-column justify-content-center align-items-center">
        <div class="temporary-calculation px-2 py-3 d-flex justify-content-between align-items-center">
            <span class="title">Tạm tính</span>
            <span class="price">{{ number_format($tempTotalPrice, 0, '', '.') }}</span> 
        </div>
        <div class="price-total px-2 py-3 d-flex justify-content-between align-items-center fw-semibold">
            <span class="title">Tổng cộng</span>
            <span class="price">{{ number_format($totalBill, 0, '', '.') }}</span> 
        </div>
        <div class="btn-payment w-100 text-center px-2 py-3 rounded-bottom-4" wire:click="payment">
            <span>Thanh toán</span>
        </div>
    </div>

    {{-- modal address --}}
    <div class="modal fade" id="choose-address" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Chọn địa chỉ</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating">
                        <select class="form-select" id="floatingSelect" wire:model="idAddress" aria-label="Floating label select example">
                            @if (count($addressList) == 0)
                                <option value="">Không có địa chỉ</option>
                            @endif
                            @foreach ($addressList as $item)
                                <option value="{{ $item['id'] }}">
                                    {{ $item['detailAddress'] }}
                                </option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Chọn địa chỉ hiện có</label>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-info flex-grow-1" data-bs-toggle="modal"
                        data-bs-target="#choose-address-orther">Chọn địa chỉ khác</button>
                    <button type="button" class="btn btn-primary flex-grow-1" wire:click="selectAddress">Chọn</button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal address orther --}}
    <div class="modal fade" id="choose-address-orther" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
        tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Thêm địa chỉ đặt hàng</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid m-0 row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <select id="city" wire:model="idCity">
                                <option value="" selected>Chọn tỉnh thành</option>
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <select id="district" wire:model="idDistrict">
                                <option value="" selected>Chọn quận huyện</option>
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <select id="ward" wire:model="idWard">
                                <option value="" selected>Chọn phường xã</option>
                            </select>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <input type="text" id="address" class="form-control" placeholder="Nhập địa chỉ cụ thể" wire:model="address">
                        </div>


                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center">
                    <button class="btn btn-primary" wire:click="chooseAddress">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>

    {{-- loading --}}
    <div wire:loading>
        <x-loader />
    </div>
</div>

