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

    @livewireStyles
@endsection

@section('custom-header-js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- boostrap --}}
    @vite (['resources/js/app.js'])
@endsection

@section('content')
    {{-- {{dd (Str::slug ('Gà sốt Buldak'))}} --}}
    @livewire('product.detail-product.index', ['slug' => $slug])
@endsection

@section('custom-js')

        <script>
            document.addEventListener ("DOMContentLoaded", () => {
                Livewire.on('order-success', () => {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Thêm thành công",
                        showConfirmButton: false,
                        timer: 1500
                    });
                })
            })
        </script>

    @livewireScripts

@endsection
