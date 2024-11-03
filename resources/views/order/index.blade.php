@extends('components.layouts.main')

@section('title')
    Danh sách đặt hàng
@endsection

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/order/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/order/total.css') }}">
@endsection

@section('custom-header-js')

@endsection

@section('content')
    @livewire('order.list-order.index')
@endsection

@section('custom-js')

@endsection