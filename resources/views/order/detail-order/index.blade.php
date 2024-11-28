@extends('../components/layouts.main')

@section('title','Document')

<!-- Thêm CSS riêng cho trang đăng nhập -->
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/order/detail-order/detail-order.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
@endsection

@section('content')
@livewire('order.detail-order.detail-order',['id' => $id])
@endsection
@section('custom-js')
@endsection

