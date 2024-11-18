@extends('components.layouts.main')

@section('title')
    Chi tiết sản phẩm
@endsection

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/product/categoryProduct/listProduct/litstProduct.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product/listProduct/range-price.css') }}">
    @livewireStyles
@endsection

@section('custom-header-js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- boostrap --}}
    @vite (['resources/js/app.js'])
@endsection

@section('content')
    <div class="shopSection">
        <div class="d-flex main-wrapper justify-content-center">
            @livewire('product.list-product.SideBarSearching')
            @livewire('product.list-product.list-product', [
                'page' => request('page', 1),
                'itemQuantity' => 6,
                'typeDisplay' => 'slide',
            ])
        </div>
    </div>
    @livewire('product.list-product.Paging', [
        'pageCurrent' => request('page', 1)
    ])
@endsection

@section('custom-js')
    @livewireScripts
    <script src="{{ asset('js/product/rangePrice.js') }}"></script>
@endsection
