@extends('../components/layouts.main')

@section('title', 'Trang chu')

@section('js-header')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

<!-- Thêm CSS riêng cho trang... -->
@section('custom-css')

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


    @if (auth()->check())
        @foreach ($all_products as $item)
            {{-- {{dd ($item)}} --}}
            <img src="{{ 'data:image/png;base64,' . $item->image_show }}" alt="">
        @endforeach
    @endif

@endsection

<!-- Thêm JS riêng cho trang... -->
@section('custom-js')

@endsection
