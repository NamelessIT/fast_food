@extends('components.layouts.main')

@section('title')
    Trang chủ
@endsection

@section('content')
    @include('home.slideshow')
    @include('home.category')
    @include('home.mainContent')
@endsection

@section('custom-css')
    <link href="{{ asset('css/home/slideshow.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home/category.css') }}" rel="stylesheet">
    <link href="{{ asset('css/category/listProduct/litstProduct.css') }}" rel="stylesheet">
@endsection
