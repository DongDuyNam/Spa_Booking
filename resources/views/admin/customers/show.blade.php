@extends('layouts.admin')

@section('content')
<div x-data="{ show: true }" class="relative">
    <div x-show="show" 
         x-transition.opacity.scale.duration.300ms
         class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-40">
        <div class="bg-white rounded-xl shadow-xl w-[450px] p-6 transform transition-all scale-95"
             x-transition.scale>
            <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Thông tin khách hàng</h2>

            <div class="space-y-3 text-sm text-gray-700">
                <p><strong>ID:</strong> {{ $customer->user_id }}</p>
                <p><strong>Họ tên:</strong> {{ $customer->full_name }}</p>
                <p><strong>Email:</strong> {{ $customer->email }}</p>
                <p><strong>SĐT:</strong> {{ $customer->phone_number }}</p>
                <p><strong>Chi nhánh:</strong> {{ $customer->branch_id }}</p>
                <p><strong>Giới tính:</strong> {{ $customer->gender }}</p>
                <p><strong>Trạng thái:</strong> 
                    <span class="px-3 py-1 rounded-full text-sm 
                        {{ $customer->status == 1 ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-500' }}">
                        {{ $customer->status == 1 ? 'Hoạt động' : 'Ngưng' }}
                    </span>
                </p>
            </div>

            <div class="flex justify-center gap-4 mt-6">
                <a href="{{ route('admin.customers.index') }}" 
                   class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 text-gray-700">
                    ← Quay lại
                </a>

                <a href="{{ route('admin.customers.edit', $customer->user_id) }}" 
                   class="px-4 py-2 rounded-lg bg-pink-500 text-white hover:bg-pink-600">
                    Sửa thông tin
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
