@extends('layouts.app')

@section('title', 'Staff Dashboard')

@section('content')
<div class="min-h-screen bg-pink-50 flex flex-col items-center py-10">
    <h1 class="text-3xl font-bold text-pink-700 mb-6">💼 Khu vực nhân viên</h1>

    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-3xl text-center">
        <p class="text-gray-600 mb-6">
            Xin chào, <strong class="text-pink-700">{{ $user->full_name }}</strong> — Nhân viên Spa
        </p>

        <p class="text-gray-500 mb-6">
            Bạn có thể xem và quản lý lịch hẹn, khách hàng, dịch vụ trong hệ thống.
        </p>

        <a href="#" class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-2 rounded-lg shadow">
            Xem lịch hẹn hôm nay
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
