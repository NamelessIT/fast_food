@extends('components.layouts.main')

@section('title')
    Danh sách đặt hàng
@endsection

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/order/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/order/total.css') }}">
    <link rel="stylesheet" href="{{ asset('css/order/voucher/voucher-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loading.css') }}">

    @livewireStyles
@endsection

@section('custom-header-js')
@endsection

@section('content')
    @livewire('order.list-order.index')
@endsection

@section('custom-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script src="{{ asset('js/product/deleteOrderProduct.js') }}"></script>
    <script src="{{ asset('js/order/selectAddress.js') }}"></script>

    @livewireScripts
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('chooseAddressError', () => {
                Swal.fire({
                    icon: "error",
                    title: "Vui lòng điền đủ thông tin",
                });
                var myModal = new bootstrap.Modal(document.getElementById('choose-address-orther'), {
                    keyboard: false
                });
                fetchApi ();
                myModal.show();
            })

            Livewire.on('chooseAddressSuccess', () => {
                var myModal = new bootstrap.Modal(document.getElementById('choose-address-orther'), {
                    keyboard: false
                });
                myModal.hide();
                document.querySelector ('body').style.overflow = "auto";
                document.querySelectorAll ('.modal-backdrop').forEach(element => {
                    element.remove();
                })
                fetchApi ();
            })

            Livewire.on ('selectAddressSuccess', () => {
                var myModal = new bootstrap.Modal(document.getElementById('choose-address'), {
                    keyboard: false
                });
                myModal.hide();
                document.querySelector ('body').style.overflow = "auto";
                document.querySelectorAll ('.modal-backdrop').forEach(element => {
                    element.remove();
                })
                fetchApi ();
            })

            Livewire.on ('paymentError', () => {
                Swal.fire({
                    icon: "error",
                    title: "Vui lòng nhập hoặc chọn địa chỉ giao hàng!",
                });
            })
        })
    </script>
@endsection
