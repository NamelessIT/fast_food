@extends('../components/layouts.main')

@section('title')
    Tài khoản
@endsection

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/account/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loading.css') }}">
    @livewireStyles
@endsection

@section('content')
    @livewire("account.form", [
        'form' => "login",
    ])
@endsection

@section('custom-js')
    {{-- @livewireScriptConfig --}}
@endSection