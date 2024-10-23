@extends('../components/layouts.main')

@section('title','Document')

<!-- Thêm CSS riêng cho trang đăng nhập -->
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
@endsection

@section('content')
    @livewire('account-user')
@endsection

{{-- <!-- Thêm JS riêng cho trang đăng nhập -->
@section('custom-js')
    <script src="{{ asset('js/login.js') }}"></script>
@endsection --}}
