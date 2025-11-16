@extends('layouts.admin')

@section('content')
<div class="bg-white p-6 shadow-md rounded-xl border border-blue-100">

    <h2 class="text-2xl font-bold text-gray-700 mb-4">
        Lịch làm việc của: {{ $staff->full_name }}
    </h2>

    <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
        <thead class="bg-blue-50">
            <tr>
                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Mã lịch</th>
                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Khách hàng</th>
                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Ngày</th>
                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Dịch vụ</th>
                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Thời lượng</th>
                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Ghi chú</th>
                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Trạng thái</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">

            @foreach($appointments as $a)
            <tr class="hover:bg-blue-50">
                <td class="px-4 py-2">{{ $a->appointment_id }}</td>
                <td class="px-4 py-2">{{ $a->customer_name }}</td>
                <td class="px-4 py-2">{{ $a->appointment_date }}</td>
                <td class="px-4 py-2">{{ $a->service_names }}</td>
                <td class="px-4 py-2">{{ $a->duration_minutes }} phút</td>
                <td class="px-4 py-2">{{ $a->note ?? '(Không)' }}</td>
                <td class="px-4 py-2 text-blue-600">{{ $a->status }}</td>
            </tr>
            @endforeach

        </tbody>
    </table>

</div>
@endsection
