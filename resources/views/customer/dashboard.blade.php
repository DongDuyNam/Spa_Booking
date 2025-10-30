@extends('layouts.app')

@section('title', 'Customer Dashboard')

@section('content')
<div class="min-h-screen bg-pink-50 flex flex-col items-center py-10">
    <h1 class="text-3xl font-bold text-pink-700 mb-6">🌷 Xin chào quý khách</h1>

    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-2xl text-center">
        <p class="text-gray-600 mb-6">
            Cảm ơn bạn, <strong class="text-pink-700">{{ $user->full_name }}</strong>, đã tin tưởng hệ thống Beauty Booking.
        </p>

        <p class="text-gray-500 mb-6">
            Hãy đặt lịch hẹn tại spa yêu thích của bạn và tận hưởng dịch vụ chăm sóc sắc đẹp tuyệt vời 🌸
        </p>

        <a href="#" class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-2 rounded-lg shadow">
            Đặt lịch ngay
        </a>

        <div class="mt-8">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm text-gray-600 hover:text-pink-600">
                    Đăng xuất
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
