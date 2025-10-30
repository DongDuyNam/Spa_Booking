@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-lg mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-pink-700">Thêm khách hàng mới</h2>

    <form action="{{ route('admin.customers.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-1 font-semibold">Họ tên</label>
            <input type="text" name="full_name" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Số điện thoại</label>
            <input type="text" name="phone" class="w-full border p-2 rounded">
        </div>

        <div>
            <label class="block mb-1 font-semibold">Mật khẩu</label>
            <input type="password" name="password" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Xác nhận mật khẩu</label>
            <input type="password" name="password_confirmation" class="w-full border p-2 rounded" required>
        </div>

        <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded">Lưu</button>
    </form>
</div>
@endsection
