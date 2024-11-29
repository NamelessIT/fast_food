<div class="container mt-5">
    <div class="card" style="width:100%">
        <!-- Nội dung card chính -->
        <div class="card-header bg-info text-white">
            <h1 class="mb-0">Địa chỉ giao hàng đã lưu 
                <i class="bi bi-pin-map"></i>
            </h1>
        </div>
        <div class="card-body">
            @if(empty($CustomerAddresses))
                <p>Hiện chưa có địa chỉ nào được lưu</p>
            @else
                <ul class="list-group">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ĐỊA CHỈ</th>
                                <th>QUẬN,TỈNH</th>
                                <th>PHƯỜNG,HUYỆN</th>
                                <th>THÀNH PHỐ</th>
                            </tr>
                        </thead>
                    @foreach($CustomerAddresses as $item)
                        <tbody>
                                <tr
                                    data-id="{{ $item['id'] }}"
                                    onmousedown="startSwipe(event)"
                                    onmouseup="endSwipe(event)"
                                    onmousemove="detectSwipe(event)"
                                    class="swipeable-row itemAddress"
                                    style="transition: transform 0.3s;">
                                    <td>{{ $item['id'] }}</td>
                                    <td>{{ $item['address'] }}</td>
                                    <td>{{ $item['district_name'] }}</td>
                                    <td>{{ $item['ward_name'] }}</td>
                                    <td>{{ $item['city_name'] }}</td>
                                    
                                </tr>
                                
                        </tbody>
                        @endforeach
                    </table>
                </ul>
            @endif
            <button  class="btn btn-primary mt-3" wire:click="showForm">
                <i class="bi bi-geo-alt"></i>
                Thêm địa chỉ</button>
        </div>
    </div>


    <!-- Form thêm địa chỉ ở giữa màn hình -->
    @if($disableForm=="false")
        <div class="address-form">
            <h4>Thêm địa chỉ mới</h4>
            <form wire:submit.prevent="saveAddress">
                <div class="form-group my-3">
                    <label for="id_city">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                    <select id="id_city" wire:model.lazy="id_city" class="form-control">
                        <option value="" selected></option>
                        @foreach($city as $cityId => $cityName)
                            <option value="{{ $cityId }}">{{ $cityName }}</option>
                        @endforeach 
                    </select>
                    @error('id_city') <span class="message-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group my-3">
                    <label for="id_district">Quận/Huyện <span class="text-danger">*</span></label>
                    <select id="id_district" wire:model.lazy="id_district" class="form-control">
                        <option value="" selected>Chọn quận/huyện</option>
                        @foreach($districts as $districtId => $districtData)
                            <option value="{{ $districtId }}">{{ $districtData['name'] }}</option>
                        @endforeach
                    </select>
                    @error('id_district') <span class="message-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group my-3">
                    <label for="id_ward">Phường/Xã <span class="text-danger">*</span></label>
                    <select id="id_ward" wire:model="id_ward" class="form-control">
                        <option value="" selected>Chọn phường/xã</option>
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
