@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Thêm lịch làm cho {{ $staff->full_name }}</h1>

    <form method="POST" action="{{ route('admin.schedule.store', $staff->id) }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-gray-700">Ngày làm việc</label>
            <input type="date" name="work_date" class="border rounded px-3 py-2 w-1/3" required>
        </div>

        <div>
            <label class="block text-gray-700">Ca làm</label>
            <select name="shift" class="border rounded px-3 py-2 w-1/3" required>
                <option value="">-- Chọn ca --</option>
                <option value="Sáng">Sáng</option>
                <option value="Chiều">Chiều</option>
                <option value="Tối">Tối</option>
            </select>
        </div>

        <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">
            Lưu lịch
        </button>
    </form>
</div>
@endsection
