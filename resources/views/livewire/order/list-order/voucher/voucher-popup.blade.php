
<div>
@if($isVisible)
<div class="overlay" id="voucherPopup">
    <div class="popup">
        <button class="close-btn" wire:click="hide">×</button>
        <h2>Available Vouchers</h2>
        @if($vouchers->isEmpty())
                <p>No vouchers available at the moment.</p>
        @else
        <ul>
            @foreach($vouchers as $voucher)
                    <strong>{{ $voucher->id }} - </strong>  {{ $voucher->description }} {{ $voucher->discount_precent }}  (đối với đơn hàng tối thiểu {{$voucher->minium_condition}} đ)<br>
            @endforeach
        </ul>
        @endif
    </div>
</div>
@endif
</div>