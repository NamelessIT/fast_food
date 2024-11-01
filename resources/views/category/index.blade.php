@extends('components.layouts.main')

@section('title')
    {{ $title }}
@endsection

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/category/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/category/listProduct/litstProduct.css') }}">

    {{-- slick --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css"
        integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css"
        integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite (['resources/js/app.js'])

    @livewireStyles
@endsection

@section('custom-header-js')
    @vite(['resources/js/app.js'])
@endsection

@section('content')
    @livewire('category.category', ['categoryName' => $title])
    @livewire('category.list-product', [
        'categoryName' => $title,
        'itemQuantity' => 6,
    ])
@endsection

@section('custom-js')
    @livewireScripts
    {{-- slick --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"
        integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.category-navbar').slick({
                slidesToShow: 5,
                slidesToScroll: 2,
                infinite: false,
                prevArrow: `<button class="btn-slick btn-previous">
                                <i class="fa-solid fa-angle-left"></i>
                            </button>`,
                nextArrow: `<button class="btn-slick btn-next">
                                <i class="fa-solid fa-angle-right"></i>
                            </button>`,
                responsive: [{
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        });
    </script>
@endsection
