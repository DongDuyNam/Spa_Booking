@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    {{-- Thẻ thống kê nhanh --}}
    <div class="bg-white rounded-xl shadow border border-pink-100 p-6">
        <div class="text-xs text-gray-500">Lịch hẹn hôm nay</div>
        <div class="text-3xl font-bold text-pink-600">18</div>
        <div class="text-[11px] text-gray-400 mt-1">+3 so với hôm qua</div>
    </div>

    <div class="bg-white rounded-xl shadow border border-pink-100 p-6">
        <div class="text-xs text-gray-500">Doanh thu (tháng này)</div>
        <div class="text-3xl font-bold text-pink-600">42.5M</div>
        <div class="text-[11px] text-gray-400 mt-1">+12% so với tháng trước</div>
    </div>

    <div class="bg-white rounded-xl shadow border border-pink-100 p-6">
        <div class="text-xs text-gray-500">Khách mới</div>
        <div class="text-3xl font-bold text-pink-600">7</div>
        <div class="text-[11px] text-gray-400 mt-1">trong 24h qua</div>
    </div>

    <div class="bg-white rounded-xl shadow border border-pink-100 p-6">
        <div class="text-xs text-gray-500">Đánh giá trung bình</div>
        <div class="text-3xl font-bold text-pink-600 flex items-center space-x-1">
            <span>4.8</span>
            <span class="text-yellow-400 text-lg">★</span>
        </div>
        <div class="text-[11px] text-gray-400 mt-1">128 lượt đánh giá</div>
    </div>
</div>

{{-- Bảng lịch hẹn gần nhất --}}
<div class="mt-8 bg-white rounded-xl shadow border border-pink-100 overflow-hidden">
    <div class="flex items-center justify-between px-4 py-3 border-b border-pink-100">
        <div class="font-semibold text-gray-700">Lịch hẹn sắp tới</div>
        <button class="text-xs bg-pink-500 hover:bg-pink-600 text-white font-medium px-3 py-1.5 rounded-lg">
            Xem tất cả
        </button>
    </div>

    <table class="w-full text-sm">
        <thead class="bg-pink-50 text-gray-600 text-left">
            <tr>
                <th class="px-4 py-2">Khách</th>
                <th class="px-4 py-2">Dịch vụ</th>
                <th class="px-4 py-2">Thời gian</th>
                <th class="px-4 py-2">Nhân viên</th>
                <th class="px-4 py-2 text-right">Trạng thái</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-pink-50">
            <tr>
                <td class="px-4 py-3">
                    <div class="font-semibold text-gray-800">Trần Mai</div>
                    <div class="text-[11px] text-gray-400">0938 xxx 241</div>
                </td>
                <td class="px-4 py-3">
                    Massage thư giãn
                    <div class="text-[11px] text-gray-400">60 phút</div>
                </td>
                <td class="px-4 py-3">
                    Hôm nay - 14:30
                    <div class="text-[11px] text-gray-400">29/10/2025</div>
                </td>
                <td class="px-4 py-3">
                    Hồng Nhung
                    <div class="text-[11px] text-gray-400">Chuyên viên massage</div>
                </td>
                <td class="px-4 py-3 text-right">
                    <span class="inline-block text-[11px] bg-green-100 text-green-600 font-medium px-2 py-1 rounded-md">
                        Đã xác nhận
                    </span>
                </td>
            </tr>

            <tr>
                <td class="px-4 py-3">
                    Lê Minh Châu
                    <div class="text-[11px] text-gray-400">0902 xxx 118</div>
                </td>
                <td class="px-4 py-3">
                    Gội đầu dưỡng sinh
                    <div class="text-[11px] text-gray-400">45 phút</div>
                </td>
                <td class="px-4 py-3">
                    Hôm nay - 15:15
                    <div class="text-[11px] text-gray-400">29/10/2025</div>
                </td>
                <td class="px-4 py-3">
                    Hà Vy
                    <div class="text-[11px] text-gray-400">Dưỡng sinh cổ vai gáy</div>
                </td>
                <td class="px-4 py-3 text-right">
                    <span class="inline-block text-[11px] bg-yellow-100 text-yellow-600 font-medium px-2 py-1 rounded-md">
                        Chờ xác nhận
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
