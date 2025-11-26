@extends('layouts.app')

@section('title', 'Khách hàng – Dashboard')

@section('content')
<div class="max-w-5xl mx-auto py-10">
    <h1 class="text-3xl font-playfair font-bold text-primary-200 mb-6">
        Xin chào {{ Auth::user()->full_name }} 🌸
    </h1>

    <p class="text-gray-600 mb-4">
        Chúc bạn một ngày rực rỡ và thư giãn ✨  
    </p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">

        <!-- Hồ sơ -->
        <a href="{{ route('customer.profile') }}"
            class="bg-white shadow-md border border-primary-100 p-6 rounded-xl hover:shadow-lg transition">
            <div class="text-primary-200 text-4xl mb-3">💁‍♀️</div>
            <h3 class="text-lg font-semibold">Hồ sơ cá nhân</h3>
            <p class="text-sm text-gray-500">Xem & chỉnh sửa thông tin</p>
        </a>

        <!-- Lịch sử -->
        <a href="{{ route('customer.appointments') }}"
            class="bg-white shadow-md border border-primary-100 p-6 rounded-xl hover:shadow-lg transition">
            <div class="text-primary-200 text-4xl mb-3">📅</div>
            <h3 class="text-lg font-semibold">Lịch hẹn của tôi</h3>
            <p class="text-sm text-gray-500">Xem lại các lần chăm sóc</p>
        </a>

    </div>
</div>
@endsection
