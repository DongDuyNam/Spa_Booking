@extends('layouts.admin')

@section('content')
    <div x-data="staffPage()" class="bg-white shadow-md rounded-xl p-6 border border-blue-100 relative">

        <div class="mb-4">
            <h2 class="text-2xl font-bold text-gray-700">Danh sách nhân viên</h2>

            <div class="flex justify-between items-center mt-3">

                <button @click="openCreate()"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition flex items-center space-x-1">
                    ➕ Thêm nhân viên
                </button>

                <form method="GET" action="{{ route('admin.staffs.index') }}" class="flex space-x-2">
                    <input type="text" name="keyword" placeholder="Tìm kiếm..." value="{{ request('keyword') }}"
                        class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                        Tìm kiếm
                    </button>
                </form>
            </div>
        </div>

        <div class="overflow-hidden rounded-lg">
            <table class="min-w-full divide-y divide-blue-100">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">ID</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Họ tên</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Email</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">SĐT</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Giới tính</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Chuyên môn</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Kinh nghiệm</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Lương</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Ngày vào làm</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($staffs as $s)
                                    <tr class="hover:bg-blue-50 transition">
                                        <td class="px-6 py-3 text-gray-600">{{ $s->staff_id }}</td>
                                        <td class="px-6 py-3 font-medium text-gray-800">{{ $s->user->full_name }}</td>
                                        <td class="px-6 py-3">{{ $s->user->email }}</td>
                                        <td class="px-6 py-3">{{ $s->user->phone_number }}</td>
                                        <td class="px-6 py-3">{{ $s->user->gender }}</td>
                                        <td class="px-6 py-3">{{ $s->specialization }}</td>
                                        <td class="px-6 py-3">{{ $s->experience_years }} năm</td>
                                        <td class="px-6 py-3">{{ number_format($s->salary) }}đ</td>
                                        <td class="px-6 py-3">{{ $s->hire_date }}</td>

                                        <td class="px-6 py-3 text-center space-x-1">
                                            <a @click="openDetail({{
                            json_encode([
                                'staff_id' => $s->staff_id,
                                'specialization' => $s->specialization,
                                'experience_years' => $s->experience_years,
                                'salary' => $s->salary,
                                'hire_date' => $s->hire_date,
                                'status' => $s->status,

                                // USER INFO
                                'full_name' => $s->user->full_name,
                                'email' => $s->user->email,
                                'phone_number' => $s->user->phone_number,
                                'gender' => $s->user->gender,
                                'branch_id' => $s->user->branch_id
                            ])
                                                                                                                                                                }})"
                                                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 cursor-pointer">Xem</a>
                                            <a @click='openEdit({!! json_encode([
                            "staff_id" => $s->staff_id,
                            "user_id" => $s->user->user_id,
                            "full_name" => $s->user->full_name,
                            "email" => $s->user->email,
                            "phone_number" => $s->user->phone_number,
                            "gender" => $s->user->gender,
                            "branch_id" => $s->user->branch_id,
                            "specialization" => $s->specialization,
                            "experience_years" => $s->experience_years,
                            "salary" => $s->salary,
                            "hire_date" => $s->hire_date,
                            "status" => $s->status,
                        ]) !!})' class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 cursor-pointer">
                                                Sửa
                                            </a>

                                            <form action="{{ route('admin.staffs.destroy', $s->staff_id) }}" method="POST" class="inline"
                                                onsubmit="return confirm('Xác nhận xóa nhân viên này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $staffs->links('pagination::tailwind') }}
        </div>

        {{-- Modal: Thêm --}}
        <template x-teleport="body">
            <div x-cloak x-show="createModal" class="fixed inset-0 z-[9999] bg-black/50 flex items-center justify-center"
                @keydown.escape.window="createModal = false" x-transition.opacity>

                <div class="bg-white rounded-xl p-6 w-[480px] shadow-lg" @click.outside="createModal = false"
                    x-transition.scale>

                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Thêm nhân viên mới</h3>

                    <form method="POST" action="{{ route('admin.staffs.store') }}">
                        @csrf

                        <div class="space-y-3">

                            <!-- USER -->
                            <div>
                                <label class="text-sm font-medium text-gray-600">Họ tên</label>
                                <input name="full_name" required
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Email</label>
                                <input type="email" name="email" required
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Số điện thoại</label>
                                <input name="phone_number"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Giới tính</label>
                                <select name="gender" class="w-full border rounded-lg px-3 py-2">
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Chi nhánh</label>
                                <input name="branch_id" type="number"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300">
                            </div>

                            <!-- STAFF -->
                            <div>
                                <label class="text-sm font-medium text-gray-600">Chuyên môn</label>
                                <input name="specialization" class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Kinh nghiệm (năm)</label>
                                <input type="number" name="experience_years"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Lương</label>
                                <input name="salary" type="number"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Ngày vào làm</label>
                                <input name="hire_date" type="date"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300">
                            </div>

                            <input type="hidden" name="status" value="1">
                        </div>

                        <div class="mt-6 text-right">
                            <button type="button" @click="createModal = false"
                                class="px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-100 mr-2">
                                Hủy
                            </button>

                            <button class="px-4 py-2 rounded-lg bg-pink-500 text-white hover:bg-pink-600">
                                Lưu
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </template>


        {{-- Modal chi tiết --}}
        <template x-teleport="body">
            <div x-cloak x-show="detailModal"
                class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-[9999]"
                x-transition.opacity @keydown.escape.window="detailModal = false" @click.self="detailModal = false">
                <div class="bg-white rounded-xl p-6 w-[500px] shadow-lg" x-transition.scale>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Thông tin nhân viên</h3>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <!-- USER INFO -->
                        <p><strong>Họ tên:</strong> <span x-text="selected.full_name"></span></p>
                        <p><strong>Email:</strong> <span x-text="selected.email"></span></p>
                        <p><strong>SĐT:</strong> <span x-text="selected.phone_number"></span></p>
                        <p><strong>Giới tính:</strong> <span x-text="selected.gender"></span></p>
                        <p><strong>Chi nhánh:</strong> <span x-text="selected.branch_id"></span></p>
                        <!-- STAFF INFO -->
                        <p><strong>Chuyên môn:</strong> <span x-text="selected.specialization"></span></p>
                        <p><strong>Kinh nghiệm:</strong>
                            <span x-text="selected.experience_years"></span> năm
                        </p>
                        <p><strong>Lương:</strong>
                            <span x-text="Number(selected.salary).toLocaleString()"></span> đ
                        </p>
                        <p><strong>Ngày vào làm:</strong> <span x-text="selected.hire_date"></span></p>
                        <p><strong>Trạng thái:</strong>
                            <span x-text="selected.status == 1 ? 'Hoạt động' : 'Ngưng'"></span>
                        </p>
                    </div>
                    <div class="mt-6 text-right">
                        <button @click="detailModal = false"
                            class="px-4 py-2 rounded-lg bg-pink-500 text-white hover:bg-pink-600">
                            Đóng
                        </button>
                    </div>
                </div>
            </div>
        </template>

        {{-- Modal chỉnh sửa --}}
        <template x-teleport="body">
            <div x-cloak x-show="editModal"
                class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-[9999]"
                x-transition.opacity @click.self="editModal = false">

                <div class="bg-white rounded-xl p-6 w-[480px] shadow-lg" x-transition.scale>

                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Chỉnh sửa nhân viên</h3>

                    <form method="POST" :action="'/admin/staffs/' + selected.staff_id">
                        @csrf
                        @method('PUT')

                        <div class="space-y-3">

                            <!-- USER -->
                            <div>
                                <label class="text-sm font-medium text-gray-600">Họ tên</label>
                                <input name="full_name" x-model="selected.full_name"
                                    class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Email</label>
                                <input type="email" name="email" x-model="selected.email"
                                    class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Số điện thoại</label>
                                <input name="phone_number" x-model="selected.phone_number"
                                    class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Giới tính</label>
                                <select name="gender" x-model="selected.gender" class="w-full border rounded-lg px-3 py-2">
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Chi nhánh</label>
                                <input name="branch_id" type="number" x-model="selected.branch_id"
                                    class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <!-- STAFF -->
                            <div>
                                <label class="text-sm font-medium text-gray-600">Chuyên môn</label>
                                <input name="specialization" x-model="selected.specialization"
                                    class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Kinh nghiệm (năm)</label>
                                <input type="number" name="experience_years" x-model="selected.experience_years"
                                    class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Lương</label>
                                <input name="salary" type="number" x-model="selected.salary"
                                    class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Ngày vào làm</label>
                                <input name="hire_date" type="date" x-model="selected.hire_date"
                                    class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Trạng thái</label>
                                <select name="status" x-model="selected.status" class="w-full border rounded-lg px-3 py-2">
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Ngưng</option>
                                </select>
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
        <script src="//unpkg.com/alpinejs" defer></script>
        <script>
            function staffPage() {
                return {
                    selected: {},
                    createModal: false,
                    detailModal: false,
                    editModal: false,

                    openCreate() {
                        this.createModal = true;
                    },
                    openDetail(info) {
                        this.selected = info;
                        this.detailModal = true;
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