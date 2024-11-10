<div>
    @if($isVisible)
    <div class="overlay" id="voucherPopup">
        <div class="popup">
            <button class="close-btn" wire:click="hide">×</button>
            <h2 class="table-title">Available Vouchers</h2>

            @if($vouchers->isEmpty())
                <p>No vouchers available at the moment.</p>
            @else
            <div class="table-container">
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Voucher ID</th>
                                <th>Description</th>
                                <th>Discount %</th>
                                <th>Minimum Order (đ)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vouchers as $voucher)
                                <tr class="table-row">
                                    <td>{{ $voucher->id }}</td>
                                    <td>{{ $voucher->description }}</td>
                                    <td>{{ $voucher->discount_percent }}%</td>
                                    <td>{{ number_format($voucher->minium_condition) }}</td>
                                    <td>
                                       <button wire:click="apply({{$voucher->id}})">Sử dụng</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>