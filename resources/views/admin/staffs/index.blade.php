@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-pink-700">Danh sách nhân viên</h2>
        <a href="{{ route('admin.staffs.create') }}" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded">+ Thêm nhân viên</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead class="bg-pink-50">
            <tr>
                <th class="border p-2">#</th>
                <th class="border p-2 text-left">Họ tên</th>
                <th class="border p-2 text-left">Email</th>
                <th class="border p-2 text-left">Số điện thoại</th>
                <th class="border p-2 text-center">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staffs as $s)
            <tr class="hover:bg-pink-50">
                <td class="border p-2 text-center">{{ $loop->iteration }}</td>
                <td class="border p-2">{{ $s->full_name }}</td>
                <td class="border p-2">{{ $s->email }}</td>
                <td class="border p-2">{{ $s->phone ?? '-' }}</td>
                <td class="border p-2 text-center">
                    <a href="{{ route('admin.staff.schedule', $s->id) }}" class="text-indigo-600 hover:underline mr-2">📅 Lịch làm</a>
                    <a href="{{ route('admin.staffs.edit', $s->id) }}" class="text-blue-500 hover:underline mr-2">✏️ Sửa</a>
                    <form action="{{ route('admin.staffs.destroy', $s->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Xóa nhân viên này?')" class="text-red-500 hover:underline">🗑️ Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
