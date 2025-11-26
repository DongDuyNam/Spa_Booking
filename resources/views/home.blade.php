@extends('layouts.app')

@section('title', 'Trang chủ AnhDuongSpa')

@section('content')
    @include('components.hero')
    @include('components.packages_spa')
    @include('components.favorite_services')
@endsection
