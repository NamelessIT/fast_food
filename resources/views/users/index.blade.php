@extends('../components/layouts.main')

@section('title','Document')

<!-- Thêm CSS riêng cho trang đăng nhập -->
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/customers.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
@endsection

@section('content')
@livewire('user.dynamic-content')
@endsection
@section('custom-js')
    <script src="{{ asset('js/customers.js') }}"></script>
@endsection

