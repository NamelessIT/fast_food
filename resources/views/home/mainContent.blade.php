{{-- @section('title')
    {{ $title }}
@endsection --}}
<div class="mainContentWrapper container-fluid mx-auto my-3" style="background-color: rgba(242, 156, 82, .15)">
    <div class="specialProduct my-3">
        <h1 class="mt-3 pt-3">Special Product</h1>
        @livewire('home.special-product')
    </div>
    <div class="bestSellerProduct">
        <h1 class="mt-3">Best Seller</h1>
        @livewire('home.best-seller-product')
    </div>
</div>
