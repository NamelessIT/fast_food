{{-- @section('title')
    {{ $title }}
@endsection --}}
<div class="mainContentWrapper container-fluid mx-auto  " style="background-color: rgba(242, 156, 82, .15)">
    <div class="specialProduct  ">
        @livewire('category.list-product', [
            'categoryName' => 'drinks',
            'itemQuantity' => 6,
        ])
    </div>
    <div class="bestSellerProduct">

    </div>
</div>
