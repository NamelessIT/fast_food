@extends('components.layouts.main')
@section('content')
    @include('home.slideshow')
    @include('home.category')
@endsection

@section('custom-css')
    <link href="{{ asset('css/home/slideshow.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home/category.css') }}" rel="stylesheet">
@endsection
