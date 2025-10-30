@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Lịch làm việc của {{ $staff->full_name }}</h1>

    <a href="{{ route('admin.schedule.create', $staff->id) }}" 
       class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">
       ➕ Thêm lịch mới
    </a>

    <table class="table-auto w-full mt-6 border-collapse border border-gray-200">
        <thead class="bg-pink-100">
            <tr>
                <th class="border p-2">Ngày làm việc</th>
                <th class="border p-2">Ca làm</th>
                <th class="border p-2">Chi nhánh</th>
                <th class="border p-2 text-center">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($schedules as $schedule)
                <tr class="text-center">
                    <td class="border p-2">{{ $schedule->work_date->format('d/m/Y') }}</td>
                    <td class="border p-2">{{ $schedule->shift }}</td>
                    <td class="border p-2">{{ $schedule->branch->branch_name ?? '-' }}</td>
                    <td class="border p-2">
                        <form action="{{ route('admin.schedule.destroy', $schedule->schedule_id) }}" method="POST" onsubmit="return confirm('Xóa lịch này?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:underline">🗑️ Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-gray-500 border p-2">Chưa có lịch làm việc nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
