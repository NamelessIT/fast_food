@extends('../components/layouts.main')

@section('title')
    Tài khoản
@endsection

@section('js-header')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/account/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loading.css') }}">
    @livewireStyles
@endsection

@section('content')
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

    @livewire('account.form', [
        'form' => 'login',
    ])
@endsection

@section('custom-js')
    {{-- @livewireScriptConfig --}}
@endSection
