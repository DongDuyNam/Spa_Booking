@extends('layouts.app')

@section('title', 'Trang chủ Beauty Booking')

@section('content')
    @include('components.hero')
    @include('components.featured_spa')
    @include('components.favorite_services')
@endsection
