@extends('../components/layouts.main')

@section('title')
    @if (Route::currentRouteName() == 'account.index')
        Đăng nhập
    @elseif (Route::currentRouteName() == 'account.register')
        Đăng ký
    @endif
@endsection

@section('custom-header-js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/account/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loading.css') }}">
    @livewireStyles
@endsection

@section('content')
    @if (session()->has('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    @if (session()->has('success'))
        <script>
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: `{{ session('success') }}`,
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

    @livewire('account.form')

    @if (Route::currentRouteName() == 'account.index')
        <div class="signup text-center" style="margin-bottom: 62px">
            Bạn chưa có tài khoản?
            <a href="{{ route('account.register') }}" wire:navigate style="cursor: pointer"
                class="fw-bold text-black">
                Đăng ký
            </a>
        </div>
    @elseif (Route::currentRouteName() == 'account.register')
        <div class="login mb-2 text-center">
            Bạn đã có tài khoản?
            <a href="{{ route('account.index') }}" wire:navigate style="cursor: pointer"
            class="fw-bold text-black">
                Đăng nhập
            </a>
        </div>
    @endif
@endsection

@section('custom-js')
    @livewireScripts
@endSection
