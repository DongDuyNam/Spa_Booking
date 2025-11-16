@extends('layouts.admin')

@section('content')
<div class="bg-white shadow-md rounded-xl p-6 border border-blue-100">

    <h2 class="text-2xl font-bold text-gray-700 mb-6">Thêm nhân viên mới</h2>

    <form action="{{ route('admin.staffs.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- ============ THÔNG TIN USER ============ --}}
        <div class="border rounded-xl p-5 bg-blue-50/30">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Thông tin tài khoản (User)</h3>

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-gray-600">Họ tên</label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}"
                           class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300">
                    @error('full_name') 
                        <p class="text-red-500 text-xs">{{ $message }}</p> 
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300">
                    @error('email') 
                        <p class="text-red-500 text-xs">{{ $message }}</p> 
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Số điện thoại</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                           class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300">
                    @error('phone_number') 
                        <p class="text-red-500 text-xs">{{ $message }}</p> 
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Giới tính</label>
                    <select name="gender" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300">
                        <option value="Nam" {{ old('gender') == 'Nam' ? 'selected' : '' }}>Nam</option>
                        <option value="Nữ" {{ old('gender') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                    </select>
                    @error('gender') 
                        <p class="text-red-500 text-xs">{{ $message }}</p> 
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Chi nhánh</label>
                    <input type="number" name="branch_id" value="{{ old('branch_id') }}"
                           class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300">
                    @error('branch_id') 
                        <p class="text-red-500 text-xs">{{ $message }}</p> 
                    @enderror
                </div>

            </div>
        </div>

        {{-- ============ THÔNG TIN STAFF ============ --}}
        <div class="border rounded-xl p-5 bg-amber-50/30">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Thông tin nhân viên (Staff)</h3>

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-gray-600">Chuyên môn</label>
                    <input type="text" name="specialization" value="{{ old('specialization') }}"
                           class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-300">
                    @error('specialization') 
                        <p class="text-red-500 text-xs">{{ $message }}</p> 
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Kinh nghiệm (năm)</label>
                    <input type="number" name="experience_years" value="{{ old('experience_years') }}"
                           class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-300">
                    @error('experience_years') 
                        <p class="text-red-500 text-xs">{{ $message }}</p> 
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Lương</label>
                    <input type="number" name="salary" value="{{ old('salary') }}"
                           class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-300">
                    @error('salary') 
                        <p class="text-red-500 text-xs">{{ $message }}</p> 
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Ngày vào làm</label>
                    <input type="date" name="hire_date" value="{{ old('hire_date') }}"
                           class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-300">
                    @error('hire_date') 
                        <p class="text-red-500 text-xs">{{ $message }}</p> 
                    @enderror
                </div>
            </div>
        </div>

        {{-- ============ SUBMIT ============ --}}
        <div class="text-right">
            <a href="{{ route('admin.staffs.index') }}"
               class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 mr-2">
                Hủy
            </a>

            <button type="submit"
                    class="px-4 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600">
                Lưu
            </button>
        </div>

    </form>

</div>
@endsection
