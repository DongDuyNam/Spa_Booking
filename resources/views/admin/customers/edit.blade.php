@extends('layouts.admin')

@section('content')
<div x-data="{ show: true, saved: false }" class="relative">
    <div x-show="show" 
         x-transition.opacity.scale.duration.300ms
         class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-40">
        <div class="bg-white rounded-xl shadow-xl w-[480px] p-6 transform transition-all scale-95"
             x-transition.scale>
            <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Chỉnh sửa khách hàng</h2>

            <form action="{{ route('admin.customers.update', $customer->user_id) }}" method="POST" 
                  @submit="saved = true; setTimeout(() => saved = false, 2500)">
                @csrf
                @method('PUT')

                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Họ tên</label>
                        <input type="text" name="full_name" value="{{ $customer->full_name }}"
                               class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Email</label>
                        <input type="email" name="email" value="{{ $customer->email }}"
                               class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Số điện thoại</label>
                        <input type="text" name="phone_number" value="{{ $customer->phone_number }}"
                               class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Chi nhánh</label>
                        <input type="text" name="branch_id" value="{{ $customer->branch_id }}"
                               class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Giới tính</label>
                        <select name="gender" class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                            <option value="Nam" {{ $customer->gender == 'Nam' ? 'selected' : '' }}>Nam</option>
                            <option value="Nữ" {{ $customer->gender == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Trạng thái</label>
                        <select name="status" class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                            <option value="1" {{ $customer->status == 1 ? 'selected' : '' }}>Hoạt động</option>
                            <option value="0" {{ $customer->status == 0 ? 'selected' : '' }}>Ngưng</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-center gap-4 mt-6">
                    <a href="{{ route('admin.customers.index') }}" 
                       class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 text-gray-700">
                        Hủy
                    </a>
                    <button type="submit"
                            class="px-4 py-2 rounded-lg bg-pink-500 text-white hover:bg-pink-600">
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Toast thông báo --}}
    <div x-show="saved" 
         x-transition.opacity.duration.400ms
         class="fixed bottom-5 right-5 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <span>Lưu thay đổi thành công!</span>
    </div>
</div>
@endsection

@push('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
@endpush
