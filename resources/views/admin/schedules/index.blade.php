@extends('layouts.admin')

@section('content')
    <div x-data="schedulePage()" class="bg-white shadow-md rounded-xl p-6 border border-blue-100 relative">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-700">Danh sách lịch làm</h2>
            </div>

            <button @click="openCreate()"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition flex items-center space-x-1">
                ➕ <span>Thêm lịch làm</span>
            </button>
        </div>

            <form method="GET" class="bg-white p-4 rounded-xl border border-gray-200 mb-5">
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">

        {{-- Từ khóa --}}
        <div>
            <label class="text-sm font-semibold text-gray-700">Từ khóa</label>
            <input type="text" name="keyword" value="{{ request('keyword') }}"
                class="mt-1 w-full border rounded-lg px-3 py-2"
                placeholder="Tên / Email / SĐT...">
        </div>

        {{-- Ngày --}}
        <div>
            <label class="text-sm font-semibold text-gray-700">Ngày</label>
            <input type="date" name="work_date" value="{{ request('work_date') }}"
                class="mt-1 w-full border rounded-lg px-3 py-2">
        </div>

        {{-- Tuần --}}
        <div>
            <label class="text-sm font-semibold text-gray-700">Tuần</label>
            <input type="week" name="week" value="{{ request('week') }}"
                class="mt-1 w-full border rounded-lg px-3 py-2">
        </div>

        {{-- Tháng --}}
        <div>
            <label class="text-sm font-semibold text-gray-700">Tháng</label>
            <input type="month" name="month" value="{{ request('month') }}"
                class="mt-1 w-full border rounded-lg px-3 py-2">
        </div>

        {{-- Trạng thái --}}
        <div>
            <label class="text-sm font-semibold text-gray-700">Trạng thái</label>
            <select name="status" class="mt-1 w-full border rounded-lg px-3 py-2">
                <option value="">Tất cả</option>
                <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Chờ xác nhận</option>
                <option value="confirmed" {{ request('status')=='confirmed'?'selected':'' }}>Đã xác nhận</option>
                <option value="off" {{ request('status')=='off'?'selected':'' }}>Nghỉ</option>
                <option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>Hủy</option>
            </select>
        </div>

        {{--	Multi-select Nhân viên --}}
        <div x-data="{ open:false }" class="relative">
            <label class="text-sm font-semibold text-gray-700">Nhân viên</label>
            <div @click="open=!open"
                class="mt-1 border px-3 py-2 rounded-lg bg-white cursor-pointer">
                Chọn nhân viên
            </div>

            <div x-show="open" @click.outside="open=false"
                class="absolute z-50 bg-white border rounded-lg mt-1 w-full max-h-48 overflow-y-auto shadow">
                @foreach($staffs as $st)
                    <label class="flex items-center px-3 py-2 hover:bg-gray-50">
                        <input type="checkbox" name="staff_ids[]"
                            value="{{ $st->staff_id }}"
                            {{ collect(request('staff_ids'))->contains($st->staff_id) ? 'checked':'' }}
                            class="mr-2">
                        {{ $st->user->full_name }}
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Multi-select Ca --}}
        <div x-data="{ open:false }" class="relative">
            <label class="text-sm font-semibold text-gray-700">Ca làm</label>
            <div @click="open=!open"
                class="mt-1 border px-3 py-2 rounded-lg bg-white cursor-pointer">
                Chọn ca làm
            </div>

            <div x-show="open" @click.outside="open=false"
                class="absolute z-50 bg-white border rounded-lg mt-1 w-full shadow max-h-32 overflow-y-auto">
                @foreach(['Sáng','Chiều','Tối'] as $ca)
                    <label class="flex items-center px-3 py-2 hover:bg-gray-50">
                        <input type="checkbox" name="shifts[]"
                            value="{{ $ca }}"
                            {{ collect(request('shifts'))->contains($ca) ? 'checked':'' }}
                            class="mr-2">
                        {{ $ca }}
                    </label>
                @endforeach
            </div>
        </div>

    </div>

    <div class="flex gap-3 mt-4">
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
            Tìm kiếm
        </button>
        <a href="{{ route('admin.schedules.index') }}"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
            Reset
        </a>
</form>
        </div>

        <div class="overflow-hidden rounded-lg">
            <table class="min-w-full divide-y divide-blue-100">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase">ID</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Nhân viên</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Ngày làm</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Ca</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Giờ bắt đầu</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Giờ kết thúc</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Trạng thái</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Ghi chú</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase text-center">Thao tác</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($schedules as $sc)
                                    <tr class="hover:bg-blue-50 transition">
                                        <td class="px-4 py-3 text-gray-600">{{ $sc->schedule_id }}</td>
                                        <td class="px-4 py-3 font-medium text-gray-800">
                                            {{ optional($sc->staff->user)->full_name ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3">{{ $sc->work_date }}</td>
                                        <td class="px-4 py-3">{{ $sc->shift }}</td>
                                        <td class="px-4 py-3">{{ $sc->start_time }}</td>
                                        <td class="px-4 py-3">{{ $sc->end_time }}</td>
                                        <td class="px-4 py-3">
                                            @php
                                                $map = [
                                                    'pending' => ['Chờ xác nhận', 'bg-yellow-100 text-yellow-800'],
                                                    'confirmed' => ['Đã xác nhận', 'bg-green-100 text-green-800'],
                                                    'cancelled' => ['Hủy', 'bg-red-100 text-red-800'],
                                                    'off' => ['Nghỉ', 'bg-gray-100 text-gray-700'],
                                                ];
                                                [$label, $class] = $map[$sc->status] ?? [$sc->status, 'bg-gray-100 text-gray-700'];
                                            @endphp
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $class }}">
                                                {{ $label }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600 max-w-xs truncate" title="{{ $sc->notes }}">
                                            {{ $sc->notes }}
                                        </td>
                                        <td class="px-4 py-3 text-center space-x-1">
                                            <button x-on:click="openEdit(
                            {{ json_encode([
                            'schedule_id' => $sc->schedule_id,
                            'staff_id' => $sc->staff_id,
                            'staff_name' => optional($sc->staff->user)->full_name,
                            'work_date' => $sc->work_date,
                            'shift' => $sc->shift,
                            'start_time' => substr($sc->start_time, 0, 5),
                            'end_time' => substr($sc->end_time, 0, 5),
                            'status' => $sc->status,
                            'notes' => $sc->notes,
                        ]) }}
                        )" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
                                                Sửa
                                            </button>


                                            <form action="{{ route('admin.schedules.destroy', $sc->schedule_id) }}" method="POST"
                                                class="inline" onsubmit="return confirm('Xóa lịch làm này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">
                                                    Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-6 text-center text-gray-500">
                                Chưa có lịch làm nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $schedules->appends(request()->query())->links('pagination::tailwind') }}
        </div>

        {{-- Modal Thêm --}}
        <template x-teleport="body">
            <div x-cloak x-show="createModal" class="fixed inset-0 z-[9999] bg-black/50 flex items-center justify-center"
                x-transition.opacity @keydown.escape.window="createModal = false" @click.self="createModal = false">
                <div class="bg-white rounded-xl p-6 w-[480px] shadow-lg" x-transition.scale>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Thêm lịch làm mới</h3>

                    <form method="POST" action="{{ route('admin.schedules.store') }}">
                        @csrf
                        <div class="space-y-3 text-sm">
                            <div>
                                <label class="font-medium text-gray-700">Nhân viên</label>
                                <select name="staff_id" class="w-full border rounded-lg px-3 py-2">
                                    @foreach($staffs as $st)
                                        <option value="{{ $st->staff_id }}">
                                            #{{ $st->staff_id }} -
                                            {{ optional($st->user)->full_name }}
                                            ({{ optional($st->user)->phone_number }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="font-medium text-gray-700">Ngày làm</label>
                                <input type="date" name="work_date" class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <div>
                                <label class="font-medium text-gray-700">Ca làm</label>
                                <select name="shift" class="w-full border rounded-lg px-3 py-2">
                                    <option value="Sáng">Ca sáng</option>
                                    <option value="Chiều">Ca chiều</option>
                                    <option value="Tối">Ca tối</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="font-medium text-gray-700">Giờ bắt đầu</label>
                                    <input type="time" name="start_time" class="w-full border rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="font-medium text-gray-700">Giờ kết thúc</label>
                                    <input type="time" name="end_time" class="w-full border rounded-lg px-3 py-2">
                                </div>
                            </div>

                            <div>
                                <label class="font-medium text-gray-700">Trạng thái</label>
                                <select name="status" class="w-full border rounded-lg px-3 py-2">
                                    <option value="pending">Chờ xác nhận</option>
                                    <option value="confirmed">Đã xác nhận</option>
                                    <option value="off">Nghỉ</option>
                                    <option value="cancelled">Hủy</option>
                                </select>
                            </div>

                            <div>
                                <label class="font-medium text-gray-700">Ghi chú</label>
                                <textarea name="notes" rows="2" class="w-full border rounded-lg px-3 py-2"></textarea>
                            </div>
                        </div>

                        <div class="mt-6 text-right">
                            <button type="button" @click="createModal = false"
                                class="px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-100 mr-2">
                                Hủy
                            </button>
                            <button type="submit" class="px-4 py-2 rounded-lg bg-pink-500 text-white hover:bg-pink-600">
                                Lưu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        {{-- Modal Sửa --}}
        <template x-teleport="body">
            <div x-cloak x-show="editModal" class="fixed inset-0 z-[9999] bg-black/50 flex items-center justify-center"
                x-transition.opacity @keydown.escape.window="editModal = false" @click.self="editModal = false">
                <div class="bg-white rounded-xl p-6 w-[480px] shadow-lg" x-transition.scale>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">
                        Chỉnh sửa lịch làm
                    </h3>

                    <form method="POST" :action="'/admin/schedules/' + selected.schedule_id">
                        @csrf
                        @method('PUT')

                        <div class="space-y-3 text-sm">
                            <div>
                                <label class="font-medium text-gray-700">Nhân viên</label>
                                <select name="staff_id" x-model="selected.staff_id"
                                    class="w-full border rounded-lg px-3 py-2">
                                    @foreach($staffs as $st)
                                        <option value="{{ $st->staff_id }}">
                                            #{{ $st->staff_id }} -
                                            {{ optional($st->user)->full_name }}
                                            ({{ optional($st->user)->phone_number }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="font-medium text-gray-700">Ngày làm</label>
                                <input type="date" name="work_date" x-model="selected.work_date"
                                    class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <div>
                                <label class="font-medium text-gray-700">Ca làm</label>
                                <select name="shift" x-model="selected.shift" class="w-full border rounded-lg px-3 py-2">
                                    <option value="Sáng">Ca sáng</option>
                                    <option value="Chiều">Ca chiều</option>
                                    <option value="Tối">Ca tối</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="font-medium text-gray-700">Giờ bắt đầu</label>
                                    <input type="time" name="start_time" x-model="selected.start_time"
                                        class="w-full border rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="font-medium text-gray-700">Giờ kết thúc</label>
                                    <input type="time" name="end_time" x-model="selected.end_time"
                                        class="w-full border rounded-lg px-3 py-2">
                                </div>
                            </div>

                            <div>
                                <label class="font-medium text-gray-700">Trạng thái</label>
                                <select name="status" x-model="selected.status" class="w-full border rounded-lg px-3 py-2">
                                    <option value="pending">Chờ xác nhận</option>
                                    <option value="confirmed">Đã xác nhận</option>
                                    <option value="off">Nghỉ</option>
                                    <option value="cancelled">Hủy</option>
                                </select>
                            </div>

                            <div>
                                <label class="font-medium text-gray-700">Ghi chú</label>
                                <textarea name="notes" rows="2" x-model="selected.notes"
                                    class="w-full border rounded-lg px-3 py-2"></textarea>
                            </div>
                        </div>

                        <div class="mt-6 text-right">
                            <button type="button" @click="editModal = false"
                                class="px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-100 mr-2">
                                Hủy
                            </button>
                            <button type="submit" class="px-4 py-2 rounded-lg bg-pink-500 text-white hover:bg-pink-600">
                                Lưu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>

    @push('scripts')
        <script>
            function schedulePage() {
                return {
                    selected: {},
                    createModal: false,
                    editModal: false,
                    openCreate() {
                        this.selected = {};
                        this.createModal = true;
                    },
                    openEdit(info) {
                        this.selected = JSON.parse(JSON.stringify(info));
                        this.editModal = true;
                    }
                };
            }
        </script>
    @endpush
@endsection