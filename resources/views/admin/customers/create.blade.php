@extends('layouts.admin')

@section('content')
<div x-data="{ saved: false }" class="relative">
    <div class="bg-white shadow-md rounded-xl p-6 border border-pink-100 mx-auto max-w-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Thêm khách hàng mới</h2>

        {{-- Form action trỏ đến route store (POST) --}}
        <form action="{{ route('admin.customers.store') }}" method="POST" 
              @submit="saved = true; setTimeout(() => saved = false, 2500)">
            @csrf
            {{-- LOẠI BỎ @method('PUT') --}}

            <div class="space-y-4">
                {{-- Trường Họ Tên --}}
                <div>
                    <label class="text-sm font-medium text-gray-600">Họ tên <span class="text-red-500">*</span></label>
                    {{-- Dùng old() để giữ lại giá trị nếu có lỗi validation --}}
                    <input type="text" name="full_name" value="{{ old('full_name') }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none">
                    @error('full_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Trường Email --}}
                <div>
                    <label class="text-sm font-medium text-gray-600">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Trường Số điện thoại --}}
                <div>
                    <label class="text-sm font-medium text-gray-600">Số điện thoại</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none">
                    @error('phone_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                {{-- Trường Mật khẩu (Cần thiết cho Khách hàng mới) --}}
                <div>
                    <label class="text-sm font-medium text-gray-600">Mật khẩu <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Trường Chi nhánh --}}
                <div>
                    <label class="text-sm font-medium text-gray-600">Chi nhánh</label>
                    <input type="text" name="branch_id" value="{{ old('branch_id') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none">
                    @error('branch_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Trường Giới tính --}}
                <div>
                    <label class="text-sm font-medium text-gray-600">Giới tính</label>
                    <select name="gender" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none">
                        <option value="Nam" {{ old('gender') == 'Nam' ? 'selected' : '' }}>Nam</option>
                        <option value="Nữ" {{ old('gender') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                        <option value="Khác" {{ old('gender') == 'Khác' ? 'selected' : '' }}>Khác</option>
                    </select>
                </div>

                {{-- Trường Trạng thái (Mặc định là Hoạt động = 1) --}}
                <div>
                    <label class="text-sm font-medium text-gray-600">Trạng thái</label>
                    <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none">
                        <option value="1" {{ old('status') == 1 || old('status') === null ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Ngưng</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-center gap-4 mt-8">
                <a href="{{ route('admin.customers.index') }}" 
                   class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 text-gray-700 transition">
                    Hủy
                </a>
                <button type="submit"
                        class="px-5 py-2 rounded-lg bg-green-500 text-white hover:bg-green-600 transition">
                    Thêm khách hàng
                </button>
            </div>
        </form>
    </div>

    {{-- Toast thông báo --}}
    <div x-show="saved" 
         x-transition.opacity.duration.400ms
         class="fixed bottom-5 right-5 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <span>Thêm khách hàng thành công!</span>
    </div>
</div>
@endsection

@push('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
@endpush