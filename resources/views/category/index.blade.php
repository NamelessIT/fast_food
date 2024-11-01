@extends('components.layouts.main')

@section('title')
    {{ $title }}
@endsection

@section('custom-header-js')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{asset("css/category/listProduct/litstProduct.css")}}">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@endsection


@section('custom-js')
@endsection

@section('content')
    @livewire('category.category')
    @livewire('category.list-product', [
        'categoryName' => $title,
        'itemQuantity' => 12 , 
    ])
@endsection
