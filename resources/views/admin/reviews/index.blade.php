@extends('layouts.admin')

@section('content')
<div x-data="appointmentPage()" class="bg-white shadow-md rounded-xl p-6 border border-pink-100">

    {{-- HEADER --}}
    <div class="mb-4">
        <h2 class="text-2xl font-bold text-gray-700">Danh sách lịch hẹn</h2>

        <form method="GET" class="flex space-x-2 mt-3">
            <input type="date" name="date" value="{{ request('date') }}"
                class="border border-gray-300 rounded-lg px-4 py-2">

            <select name="status" class="border border-gray-300 rounded-lg px-4 py-2">
                <option value="">Tất cả trạng thái</option>
                <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Chờ phân công</option>
                <option value="confirmed" {{ request('status')=='confirmed'?'selected':'' }}>Đã phân công</option>
                <option value="completed">Hoàn thành</option>
                <option value="cancelled">Đã huỷ</option>
            </select>

            <button class="bg-pink-500 text-white px-4 py-2 rounded-lg">Tìm</button>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="overflow-hidden rounded-lg border border-pink-100">
        <table class="min-w-full table-fixed">
            <thead class="bg-pink-50">
                <tr>
                    <th class="px-4 py-3 w-[70px]">ID</th>
                    <th class="px-4 py-3 w-[180px]">Khách</th>
                    <th class="px-4 py-3 w-[180px]">Nhân viên</th>
                    <th class="px-4 py-3 w-[130px]">Ngày</th>
                    <th class="px-4 py-3 w-[120px] text-center">Trạng thái</th>
                    <th class="px-4 py-3 w-[150px] text-center">Thao tác</th>
                </tr>
            </thead>

            <tbody class="divide-y">
            @foreach($appointments as $a)
                <tr class="hover:bg-pink-50">
                    <td class="px-4 py-3">{{ $a->appointment_id }}</td>

                    <td class="px-4 py-3">{{ $a->customer?->full_name }}</td>

                    <td class="px-4 py-3">
                        {{ $a->staff?->full_name ?? 'Chưa có' }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $a->appointment_date }}
                    </td>

                    <td class="px-4 py-3 text-center">
                        @if($a->status == 'pending')
                            <span @click="openAssign({{ json_encode($a) }})"
                                class="cursor-pointer bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                                Pending
                            </span>
                        @elseif($a->status == 'confirmed')
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
                                Confirmed
                            </span>
                        @elseif($a->status == 'completed')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                Completed
                            </span>
                        @else
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                                Cancelled
                            </span>
                        @endif
                    </td>

                    <td class="px-4 py-3 text-center space-x-2">
                        <button @click="openEdit({{ json_encode($a) }})"
                            class="bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                            Sửa
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{ $appointments->links('pagination::tailwind') }}

    {{-- MODAL PHÂN CÔNG --}}
    <template x-teleport="body">
        <div x-show="assignModal" class="fixed inset-0 bg-black/50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-xl w-[500px]">

                <h3 class="font-bold mb-3">Phân công nhân viên</h3>

                <form method="POST" :action="`/admin/appointments/${selected.appointment_id}/assign`">
                    @csrf

                    <select name="staff_id" class="w-full border rounded p-2 mb-3" required>
                        @foreach(\App\Models\User::where('role_id',2)->get() as $staff)
                            <option value="{{ $staff->user_id }}">
                                {{ $staff->full_name }}
                            </option>
                        @endforeach
                    </select>

                    <div class="text-right">
                        <button type="button" @click="assignModal=false"
                            class="border px-3 py-1 rounded">Hủy</button>

                        <button class="bg-pink-500 text-white px-4 py-1 rounded">
                            Phân công
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </template>

</div>

@push('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
<script>
function appointmentPage() {
    return {
        selected: {},
        assignModal: false,
        editModal: false,

        openAssign(a) {
            this.selected = a
            this.assignModal = true
        },

        openEdit(a) {
            this.selected = a
            this.editModal = true
        }
    }
}
</script>
@endpush
@endsection
