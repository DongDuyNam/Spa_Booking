@extends('layouts.app')

@section('title', 'Hồ sơ cá nhân')

@section('content')
<div class="max-w-3xl mx-auto py-10" x-data="{ showEdit: false }">

    <h1 class="text-3xl font-playfair font-bold text-primary-200 mb-6">
        Hồ sơ cá nhân 🌸
    </h1>

    <div class="bg-white shadow-md border border-primary-100 rounded-xl p-6">
        <div class="flex items-center space-x-6">
            <img src="{{ $user->avatar ?? '/image/default-avatar.png' }}"
                class="w-24 h-24 rounded-full border-4 border-primary-150 object-cover">

            <div>
                <h2 class="text-xl font-semibold">{{ $user->full_name }}</h2>
                <p class="text-gray-500">{{ $user->email }}</p>
            </div>
        </div>

        <div class="mt-6 space-y-3 text-gray-700">
            <p><strong>Điện thoại:</strong> {{ $user->phone_number ?? '—' }}</p>
            <p><strong>Giới tính:</strong> {{ $user->gender ?? '—' }}</p>
            <p><strong>Ngày sinh:</strong> {{ optional($user->customerData)->birth_date ?? '—' }}</p>
            <p><strong>Địa chỉ:</strong> {{ optional($user->customerData)->address ?? '—' }}</p>
        </div>

        <button @click="showEdit = true"
            class="block mt-6 w-full text-center bg-primary-150 text-white py-2 rounded-lg font-serif hover:bg-primary-200">
            Cập nhật hồ sơ
        </button>
    </div>


    <!-- 🟣 Popup Modal -->
    <div x-show="showEdit"
         x-transition
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

        <div @click.away="showEdit = false"
             class="bg-white w-full max-w-lg p-6 rounded-xl shadow-xl">

            <h2 class="text-2xl font-bold mb-4">Cập nhật hồ sơ</h2>

            <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
                @csrf

                {{-- Họ và tên --}}
                <div class="mb-4">
                    <label class="font-medium">Họ và tên</label>
                    <input type="text" name="full_name" value="{{ $user->full_name }}"
                        class="w-full border mt-2 p-2 rounded bg-primary-50">
                </div>

                {{-- Điện thoại --}}
                <div class="mb-4">
                    <label class="font-medium">Điện thoại</label>
                    <input type="text" name="phone_number" value="{{ $user->phone_number }}"
                        class="w-full border mt-2 p-2 rounded bg-primary-50">
                </div>

                {{-- Giới tính --}}
                <div class="mb-4">
                    <label class="font-medium">Giới tính</label>
                    <select name="gender" class="w-full border mt-2 p-2 rounded bg-primary-50">
                        <option value="">—</option>
                        <option value="Nam" {{ $user->gender == 'Nam' ? 'selected' : '' }}>Nam</option>
                        <option value="Nữ" {{ $user->gender == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                        <option value="Khác" {{ $user->gender == 'Khác' ? 'selected' : '' }}>Khác</option>
                    </select>
                </div>

                {{-- Ngày sinh --}}
                <div class="mb-4">
                    <label class="font-medium">Ngày sinh</label>
                    <input type="date" name="birth_date"
                        value="{{ optional($user->customerData)->birth_date }}"
                        class="w-full border mt-2 p-2 rounded bg-primary-50">
                </div>

                {{-- Địa chỉ --}}
                <div class="mb-4">
                    <label class="font-medium">Địa chỉ</label>
                    <input type="text" name="address"
                        value="{{ optional($user->customerData)->address }}"
                        class="w-full border mt-2 p-2 rounded bg-primary-50">
                </div>

                {{-- Buttons --}}
                <div class="flex justify-between mt-6">
                    <button type="submit"
                        class="bg-primary-150 text-white px-4 py-2 rounded hover:bg-primary-200">
                        Lưu thay đổi
                    </button>

                    <button type="button"
                        @click="showEdit = false"
                        class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                        Hủy
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
