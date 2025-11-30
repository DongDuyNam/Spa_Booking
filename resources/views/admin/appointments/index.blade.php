@extends('layouts.admin')

@section('content')
    <div x-data="appointmentPage()" class="bg-white shadow-md rounded-xl p-6 border border-pink-100">

        <h2 class="text-2xl font-bold mb-4">Danh sách lịch hẹn</h2>

        <div class="overflow-hidden rounded-lg border">
            <table class="min-w-full table-fixed">
                <thead class="bg-pink-50">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Khách</th>
                        <th class="px-4 py-2">Ngày</th>
                        <th class="px-4 py-2">Giờ hẹn</th>
                        <th class="px-4 py-2">Nhân viên</th>
                        <th class="px-4 py-2 text-center">Trạng thái</th>
                        <th class="px-4 py-2 text-center">Thao tác</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach($appointments as $a)
                        <tr class="hover:bg-pink-50">

                            <td class="px-4 py-2">{{ $a->appointment_id }}</td>

                            <td class="px-4 py-2">
                                {{ $a->customer->full_name ?? 'N/A' }}
                            </td>

                            <td class="px-4 py-2">
                                {{ $a->appointment_date }}
                            </td>

                            <td class="px-4 py-2">
                                {{-- có thể để nguyên HH:MM:SS hoặc cắt còn HH:MM --}}
                                {{ $a->appointment_time ? \Illuminate\Support\Str::substr($a->appointment_time, 0, 5) : '--:--' }}
                            </td>

                            <td class="px-4 py-2">
                                {{ $a->staff->user->full_name ?? 'Chưa phân công' }}
                            </td>


                            {{-- ✅ CLICK VÀO STATUS ĐỂ PHÂN CÔNG --}}
                            <td class="px-4 py-2 text-center">
                                @if($a->status === 'pending')
                                    <span @click="openAssign({{ json_encode($a) }})"
                                        class="cursor-pointer px-3 py-1 rounded-full bg-yellow-100 text-yellow-700">
                                        PENDING
                                    </span>
                                @elseif($a->status === 'confirmed')
                                    <span @click="openEdit({{ json_encode($a) }})"
                                        class="cursor-pointer px-3 py-1 rounded-full bg-blue-100 text-blue-700">
                                        CONFIRMED
                                    </span>
                                @elseif($a->status === 'completed')
                                    <span @click="openEdit({{ json_encode($a) }})"
                                        class="cursor-pointer px-3 py-1 rounded-full bg-green-100 text-green-700">
                                        COMPLETED
                                    </span>
                                @else
                                    <span @click="openEdit({{ json_encode($a) }})"
                                        class="cursor-pointer px-3 py-1 rounded-full bg-red-100 text-red-700">
                                        CANCELLED
                                    </span>
                                @endif
                            </td>
                            {{-- ✅ THAO TÁC --}}
                            <td class="px-4 py-2 text-center space-x-1">

                                <button type="button" @click="openDetail({{ json_encode($a) }})"
                                    class="bg-blue-500 text-white px-3 py-1 rounded">
                                    Xem
                                </button>

                                <button type="button" @click="openEdit({{ json_encode($a) }})"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded">
                                    Sửa
                                </button>

                                <form method="POST" action="{{ route('admin.appointments.cancel', $a) }}" class="inline"
                                    onsubmit="return confirm('Bạn chắc chắn muốn hủy lịch hẹn này?')">
                                    @csrf

                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">
                                        Hủy
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $appointments->links() }}

        {{-- ================= MODAL XEM ================= --}}
        <template x-teleport="body">
            <div x-show="detailModal" x-transition class="fixed inset-0 bg-black/50 flex items-center justify-center">
                <div class="bg-white p-6 rounded-xl w-[500px]">

                    <h3 class="font-bold mb-3">Chi tiết lịch hẹn</h3>

                    <p><b>Khách:</b>
                        <span x-text="selected.customer?.full_name ?? 'N/A'"></span>
                    </p>

                    <p><b>Ngày:</b>
                        <span x-text="selected.appointment_date"></span>
                    </p>

                    <p><b>Nhân viên:</b>
                        <span x-text="selected.staff && selected.staff.user
                                                                ? selected.staff.user.full_name
                                                                : 'Chưa phân công'">
                        </span>
                    </p>

                    <p><b>Trạng thái:</b>
                        <span x-text="selected.status"></span>
                    </p>

                    <div class="mt-4 text-right">
                        <button type="button" @click="detailModal = false" class="bg-pink-500 text-white px-4 py-1 rounded">
                            Đóng
                        </button>
                    </div>
                </div>
            </div>
        </template>

        {{-- ================= MODAL PHÂN CÔNG ================= --}}
        <template x-teleport="body">
            <div x-show="assignModal" x-transition class="fixed inset-0 bg-black/50 flex items-center justify-center">

                <div class="bg-white p-6 rounded-xl w-[450px]">

                    <h3 class="font-bold mb-4">Phân công nhân viên</h3>

                    <p class="mb-2 text-sm text-gray-600">
                        Ngày:
                        <b x-text="selected.appointment_date"></b>
                    </p>

                    <form method="POST" :action="`/admin/appointments/${selected.appointment_id}/assign`">
                        @csrf

                        <label class="block mb-2">Chọn nhân viên</label>

                        <select name="staff_id" class="w-full border rounded p-2" required>
                            <option value="">-- Chọn --</option>

                            <template x-for="s in availableStaff" :key="s.staff_id">
                                <option :value="s.staff_id" x-text="s.user.full_name"></option>
                            </template>
                        </select>

                        <div x-show="loadingStaff" class="text-sm text-gray-500 mt-1">
                            Đang kiểm tra nhân viên rảnh...
                        </div>

                        <div x-show="availableStaff.length === 0 && !loadingStaff" class="text-sm text-red-500 mt-1">
                            Không có nhân viên rảnh giờ này
                        </div>

                        <div class="mt-5 text-right space-x-2">
                            <button type="button" @click="assignModal = false" class="border px-3 py-1 rounded">
                                Hủy
                            </button>

                            <button type="submit" :disabled="availableStaff.length === 0"
                                class="bg-pink-500 text-white px-4 py-1 rounded disabled:opacity-50">
                                Lưu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        {{-- ================= MODAL SỬA ================= --}}
        {{-- ================= MODAL SỬA ================= --}}
        <template x-teleport="body">
            <div x-show="editModal" x-transition class="fixed inset-0 bg-black/50 flex items-center justify-center">
                <div class="bg-white p-6 rounded-xl w-[450px]">

                    <h3 class="font-bold mb-4">Sửa lịch hẹn</h3>

                    <form method="POST" :action="`/admin/appointments/${selected.appointment_id}`">
                        @csrf
                        @method('PUT')

                        <label class="block mb-1">Ngày</label>
                        <input type="date" name="appointment_date" x-model="selected.appointment_date"
                            class="w-full border rounded p-2 mb-3">

                        <label class="block mb-1">Giờ hẹn</label>
                        <input type="time" name="appointment_time" x-model="selected.edit_time"
                            class="w-full border rounded p-2 mb-3">

                        <label class="block mb-1">Thời lượng (phút)</label>
                        <input type="number" name="duration_minutes" x-model="selected.duration_minutes"
                            class="w-full border rounded p-2 mb-3">

                        <label class="block mb-1">Nhân viên</label>
                        <select name="staff_id" class="w-full border rounded p-2 mb-3">
                            <option value="">-- Chưa phân công --</option>
                            @foreach($staffs as $s)
                                <option value="{{ $s->staff_id }}" :selected="selected.edit_staff_id == {{ $s->staff_id }}">
                                    {{ $s->user->full_name }}
                                </option>
                            @endforeach
                        </select>

                        <label class="block mb-1">Trạng thái</label>
                        <select name="status" class="w-full border rounded p-2 mb-3">
                            <option value="pending" :selected="selected.edit_status === 'pending'">PENDING</option>
                            <option value="confirmed" :selected="selected.edit_status === 'confirmed'">CONFIRMED</option>
                            <option value="completed" :selected="selected.edit_status === 'completed'">COMPLETED</option>
                            <option value="cancelled" :selected="selected.edit_status === 'cancelled'">CANCELLED</option>
                        </select>

                        <label class="block mb-1">Ghi chú</label>
                        <textarea name="note" x-model="selected.note" class="w-full border rounded p-2 mb-3"></textarea>

                        <div class="text-right space-x-2">
                            <button type="button" @click="editModal=false" class="border px-3 py-1 rounded">
                                Hủy
                            </button>

                            <button type="submit" class="bg-pink-500 text-white px-4 py-1 rounded">
                                Cập nhật
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </template>

    </div>

    <script>
        function appointmentPage() {
            return {
                selected: {},
                assignModal: false,
                editModal: false,
                detailModal: false,

                availableStaff: [],
                loadingStaff: false,

                openDetail(a) {
                    this.selected = a
                    this.detailModal = true
                },

                openEdit(a) {
                    this.selected = JSON.parse(JSON.stringify(a))

                    // chuẩn hoá giờ hẹn cho input type="time" (HH:MM)
                    if (this.selected.appointment_time) {
                        this.selected.edit_time = this.selected.appointment_time.substring(0, 5)
                    } else {
                        this.selected.edit_time = ''
                    }

                    this.selected.edit_status = this.selected.status
                    this.selected.edit_staff_id = this.selected.staff_id

                    this.editModal = true
                },

                openAssign(a) {
                    this.selected = a
                    this.assignModal = true
                    this.availableStaff = []
                    this.loadingStaff = true

                    fetch(`/admin/appointments/${a.appointment_id}/available-staff`)
                        .then(res => res.json())
                        .then(data => {
                            this.availableStaff = data
                        })
                        .finally(() => {
                            this.loadingStaff = false
                        })
                }
            }
        }
    </script>
@endsection