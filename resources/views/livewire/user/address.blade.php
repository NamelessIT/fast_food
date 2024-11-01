<div class="container mt-5">
    <div class="card" style="width:100%">
        <!-- Nội dung card chính -->
        <div class="card-header bg-info text-white">
            <h1 class="mb-0">Địa chỉ giao hàng đã lưu</h1>
        </div>
        <div class="card-body">
            @if(empty($CustomerAddresses))
                <p>Hiện chưa có địa chỉ nào được lưu</p>
            @else
                <ul class="list-group">
                    @foreach($CustomerAddresses as $customerAddress)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ID Khách hàng</th>
                                <th>ĐỊA CHỈ</th>
                                <th>QUẬN,TỈNH</th>
                                <th>PHƯỜNG,HUYỆN</th>
                                <th>THÀNH PHỐ</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td>{{ $customerAddress['id'] }}</td>
                                    <td>{{ $customerAddress['id_customer'] }}</td>
                                    <td>{{ $customerAddress['address'] }}</td>
                                    <td>{{ $customerAddress['district_name'] }}</td>
                                    <td>{{ $customerAddress['ward_name'] }}</td>
                                    <td>{{ $customerAddress['city_name'] }}</td>
                                </tr>
                        </tbody>
                    </table>
                    @endforeach
                </ul>
            @endif
            <button  class="btn btn-primary mt-3" wire:click="showForm">Thêm địa chỉ</button>
        </div>
    </div>
    <!-- Form thêm địa chỉ ở giữa màn hình -->
    @if($disableForm=="false")
        <div class="address-form">
            <h4>Thêm địa chỉ mới</h4>
            <form wire:submit.prevent="saveAddress">
                <div class="form-group my-3">
                    <label for="id_city">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                    <select id="id_city" wire:model="id_city" class="form-control">
                        <option value=""></option>
                        <option value="1">Hồ Chí Minh</option>
                    </select>
                    @error('id_city') <span class="message-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group my-3">
                    <label for="id_district">Quận/Huyện <span class="text-danger">*</span></label>
                    <select id="id_district" wire:model.lazy="id_district" class="form-control">
                        <option value="">Chọn quận/huyện</option>
                        @foreach($districts as $districtId => $districtData)
                            <option value="{{ $districtId }}">{{ $districtData['name'] }}</option>
                        @endforeach
                    </select>
                    @error('id_district') <span class="message-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group my-3">
                    <label for="id_ward">Phường/Xã <span class="text-danger">*</span></label>
                    <select id="id_ward" wire:model="id_ward" class="form-control">
                        <option value="">Chọn phường/xã</option>
                        @foreach($wards as $ward)
                        <option value="{{ $ward['ward_id'] }}">{{ $ward['ward_name'] }}</option>
                        @endforeach
                    </select>
                    @error('id_ward') <span class="message-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group my-3">
                    <label for="address">Địa chỉ <span class="text-danger">*</span></label>
                    <input type="text" id="address" placeholder="Địa chỉ" wire:model="address" class="form-control">
                    @error('address') <span class="message-error">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn btn-success mt-3" wire:click="saveAddress">Lưu</button>
                <button type="button" class="btn btn-secondary mt-3" wire:click="closeForm">Đóng</button>
            </form>
        </div>
    @endif
</div>
