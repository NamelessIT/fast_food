@extends('components.layouts.main')

@section('title')
    Chi tiết sản phẩm
@endsection

@section('custom-css')
    {{-- slick --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/odometer.js/0.4.7/themes/odometer-theme-default.min.css"
        integrity="sha512-/k/mL9TQSZHAqtVqXJAiy5bt2w1P7gxdra0UlnFjVHF9a/LC2vxt7otx3BMcn79V/DZsPRwdw8tPlwbElMnIAw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

        {{-- style --}}
    <link rel="stylesheet" href="{{ asset('css/product/detail-product.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product/feed-back-product.css') }}">
@endsection

@section('custom-header-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/odometer.js/0.4.7/odometer.min.js"
        integrity="sha512-v3fZyWIk7kh9yGNQZf1SnSjIxjAKsYbg6UQ+B+QxAZqJQLrN3jMjrdNwcxV6tis6S0s1xyVDZrDz9UoRLfRpWw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- boostrap --}}
    @vite (['resources/js/app.js'])

    {{-- js --}}
    <script src="{{ asset('js/product/detailProduct.js') }}"></script>
@endsection

@section('content')
    {{-- {{dd (Str::slug ('Gà sốt Buldak'))}} --}}
    @livewire('product.detail-product.index', ['slug' => $slug])
@endsection

@section('custom-js')
@endsection
