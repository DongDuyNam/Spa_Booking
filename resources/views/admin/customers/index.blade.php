@extends('layouts.admin')

@section('content')
    <div x-data="customerPage()" class="bg-white shadow-md rounded-xl p-6 border border-pink-100 relative">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-700">Danh sách khách hàng</h2>

            <form method="GET" action="{{ route('admin.customers.index') }}" class="flex space-x-2">
                <input type="text" name="keyword" placeholder="Tìm kiếm..." value="{{ request('keyword') }}"
                    class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none">
                <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition">
                    Tìm kiếm
                </button>
            </form>
        </div>

        <div class="overflow-hidden rounded-lg">
            <button type="button" @click="createModal = true"
                class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition">
                + Thêm khách hàng
            </button>
            <table class="mt-3 min-w-full divide-y divide-pink-100">
                <thead class="bg-pink-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Họ tên</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">SĐT</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Chi nhánh</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Giới tính</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Trạng thái</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($customers as $c)
                        <tr class="hover:bg-pink-50 transition">
                            <td class="px-6 py-3 text-gray-600">{{ $c->user_id }}</td>
                            <td class="px-6 py-3 font-medium text-gray-800">{{ $c->full_name }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ $c->email }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ $c->phone_number }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ $c->branch_id }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ $c->gender }}</td>
                            <td class="px-6 py-3">
                                <span
                                    class="px-3 py-1 text-sm rounded-full 
                                                                     {{ $c->status == 1 ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $c->status == 1 ? 'Hoạt động' : 'Ngưng' }}
                                </span>
                            </td>
                            <<td class="px-6 py-3 text-right space-x-2">
                                <a href="{{ route('admin.customers.show', $c->user_id) }}"
                                    class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Xem</a>

                                <a href="{{ route('admin.customers.edit', $c->user_id) }}"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Sửa</a>

                                <form action="{{ route('admin.customers.destroy', $c->user_id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Xác nhận xóa khách hàng này?')">
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
            {{ $customers->links('pagination::tailwind') }}
        </div>

        {{-- Modal thêm khách hàng --}}
        <template x-if="createModal">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50"
                x-transition.opacity>
                <div class="bg-white rounded-xl p-6 w-[480px] shadow-lg transform transition-all scale-95"
                    x-transition.scale @click.away="createModal = false">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Thêm khách hàng mới</h3>
                    <form method="POST" action="{{ route('admin.customers.store') }}">
                        @csrf
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Họ tên</label>
                                <input type="text" name="full_name"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none"
                                    required>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Email</label>
                                <input type="email" name="email"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none"
                                    required>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Số điện thoại</label>
                                <input type="text" name="phone_number"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Giới tính</label>
                                <select name="gender"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Chi nhánh</label>
                                <input type="number" name="branch_id"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                            </div>
                        </div>

                        <div class="mt-6 text-right">
                            <button type="button" @click="createModal = false"
                                class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 mr-2">
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


        {{-- Modal chi tiết --}}
        <template x-if="detailModal">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50"
                x-transition.opacity>
                <div class="bg-white rounded-xl p-6 w-[480px] shadow-lg transform transition-all scale-95"
                    x-transition.scale @click.away="detailModal = false">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Thông tin khách hàng</h3>
                    <div class="space-y-2 text-sm">
                        <p><strong>Họ tên:</strong> <span x-text="selected.full_name"></span></p>
                        <p><strong>Email:</strong> <span x-text="selected.email"></span></p>
                        <p><strong>SĐT:</strong> <span x-text="selected.phone_number"></span></p>
                        <p><strong>Giới tính:</strong> <span x-text="selected.gender"></span></p>
                        <p><strong>Chi nhánh:</strong> <span x-text="selected.branch_id"></span></p>
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
        <template x-if="editModal">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50"
                x-transition.opacity>
                <div class="bg-white rounded-xl p-6 w-[480px] shadow-lg transform transition-all scale-95"
                    x-transition.scale @click.away="editModal = false">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Chỉnh sửa khách hàng</h3>
                    <form method="POST" :action="'/admin/customers/' + selected.user_id">
                        @csrf
                        @method('PUT')

                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Họ tên</label>
                                <input type="text" name="full_name" x-model="selected.full_name"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Email</label>
                                <input type="email" name="email" x-model="selected.email"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Số điện thoại</label>
                                <input type="text" name="phone_number" x-model="selected.phone_number"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Trạng thái</label>
                                <select name="status" x-model="selected.status"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Ngưng</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6 text-right">
                            <button type="button" @click="editModal = false"
                                class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 mr-2">
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

    {{-- Script AlpineJS --}}
    @push('scripts')
        <script src="//unpkg.com/alpinejs" defer></script>
        <script>
            function customerPage() {
                return {
                    selected: {},
                    createModal: false,
                    detailModal: false,
                    editModal: false,
                    openDetail(cust) {
                        this.selected = cust;
                        this.detailModal = true;
                    },
                    openEdit(cust) {
                        this.selected = JSON.parse(JSON.stringify(cust));
                        this.editModal = true;
                    }
                };
            }
        </script>
    @endpush
@endsection