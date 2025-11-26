@extends('layouts.admin')

@section('content')
    <div x-data="packagePage()" class="bg-white shadow-md rounded-xl p-6 border border-pink-100 relative">

        <div class="mb-4">
            <h2 class="text-2xl font-bold text-gray-700">Danh sách gói dịch vụ</h2>

            <div class="flex justify-between items-center mt-3">

                <button @click="openCreate()"
                    class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition flex items-center space-x-1">
                    ➕ Thêm gói dịch vụ
                </button>

                <form method="GET" class="flex space-x-2">
                    <input type="text" name="keyword" placeholder="Tìm kiếm..." value="{{ request('keyword') }}"
                        class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none">
                    <button class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition">
                        Tìm kiếm
                    </button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="p-3 bg-green-100 rounded text-green-700 mb-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-lg">
            <table class="min-w-full divide-y divide-pink-100">
                <thead class="bg-pink-50 text-gray-700 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-left">Ảnh</th>
                        <th class="px-4 py-3 text-left">Tên gói</th>
                        <th class="px-4 py-3 text-left">Giá</th>
                        <th class="px-4 py-3 text-left">Thời hạn</th>
                        <th class="px-4 py-3 text-left">Giới hạn</th>
                        <th class="px-4 py-3 text-left">Ngày sử dụng</th>
                        <th class="px-4 py-3 text-left">Trạng thái</th>
                        <th class="px-4 py-3 text-center">Thao tác</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @foreach($packages as $p)
                        <tr class="hover:bg-pink-50 transition">
                            <td class="px-4 py-3 text-gray-600">{{ $p->package_id }}</td>

                            <td class="px-4 py-3">
                                @if($p->thumbnail)
                                    <img src="{{ asset('storage/' . $p->thumbnail) }}"
                                        class="w-12 h-12 rounded object-cover shadow">
                                @else
                                    <span class="text-gray-400 text-sm">Không có</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 font-medium text-gray-800">{{ $p->name }}</td>

                            <td class="px-4 py-3 text-gray-700">
                                {{ number_format($p->price, 0, ',', '.') }} đ
                            </td>

                            <td class="px-4 py-3 text-gray-700 text-sm">
                                {{ $p->valid_from }} <br>
                                → <span class="font-semibold">{{ $p->valid_to }}</span>
                            </td>

                            <td class="px-4 py-3 text-gray-700">
                                {{ $p->limit_usage ?? '--' }}
                            </td>

                            <td class="px-4 py-3 text-gray-700">
                                {{ $p->duration_days ?? '--' }} ngày
                            </td>

                            <td class="px-4 py-3">
                                <span class="px-3 py-1 rounded-full text-sm 
                                            {{ $p->is_active ? 'bg-green-100 text-green-600' : 'bg-gray-200 text-gray-600' }}">
                                    {{ $p->is_active ? 'Hoạt động' : 'Ngưng' }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-center space-x-2">
                                <button @click="openEdit({{ json_encode($p) }})"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                    Sửa
                                </button>

                                <form action="{{ route('admin.servicepackages.destroy', $p->package_id) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Xóa gói dịch vụ này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                        Xóa
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $packages->links('pagination::tailwind') }}
        </div>

        {{-- ===================== MODAL THÊM ===================== --}}
        <template x-teleport="body">
            <div x-cloak x-show="createModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-[9999]"
                x-transition.opacity @click.self="createModal = false">

                <div class="bg-white rounded-xl p-6 w-[480px]" x-transition.scale>
                    <h3 class="text-xl font-semibold mb-4">Thêm gói dịch vụ</h3>

                    <form id="createForm" method="POST" action="{{ route('admin.servicepackages.store') }}"
                        enctype="multipart/form-data">

                        @csrf

                        <div class="space-y-3">

                            <div>
                                <label class="text-sm font-medium text-gray-600">Tên gói</label>
                                <input type="text" name="name" required class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Mô tả</label>
                                <textarea name="description" class="w-full border rounded-lg px-3 py-2"></textarea>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Giá</label>
                                <input type="number" name="price" step="0.01" required
                                    class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Hiệu lực từ</label>
                                <input type="date" name="valid_from" required class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Hiệu lực đến</label>
                                <input type="date" name="valid_to" required class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Giới hạn lượt sử dụng</label>
                                <input type="number" name="limit_usage" class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Số ngày sử dụng gói</label>
                                <input type="number" name="duration_days" class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Ảnh đại diện</label>
                                <input type="file" name="thumbnail" accept="image/*"
                                    class="w-full border rounded-lg px-3 py-2">
                            </div>


                            <div>
                                <label class="text-sm font-medium text-gray-600">Trạng thái</label>
                                <select name="is_active" class="w-full border rounded-lg px-3 py-2">
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Ngưng</option>
                                </select>
                            </div>

                        </div>

                        <div class="mt-5 text-right">
                            <button type="button" @click="createModal = false"
                                class="px-4 py-2 rounded-lg border border-gray-300 mr-2">
                                Hủy
                            </button>

                            <button type="submit" class="px-4 py-2 rounded-lg bg-pink-500 text-white">
                                Lưu
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </template>

        {{-- ===================== MODAL SỬA ===================== --}}
        <template x-teleport="body">
            <div x-cloak x-show="editModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-[9999]"
                x-transition.opacity @click.self="editModal = false">

                <div class="bg-white rounded-xl p-6 w-[480px]" x-transition.scale>
                    <h3 class="text-xl font-semibold mb-4">Chỉnh sửa gói dịch vụ</h3>

                    <form method="POST" :action="'/admin/servicepackages/' + selected.package_id"
                        enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="space-y-3">

                            <div>
                                <label class="text-sm font-medium text-gray-600">Tên gói</label>
                                <input type="text" name="name" x-model="selected.name" required
                                    class="w-full border rounded-lg px-3 py-2">

                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Mô tả</label>
                                <textarea name="description" class="w-full border rounded-lg px-3 py-2"></textarea>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Giá</label>
                                <input type="number" name="price" step="0.01" required
                                    class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Hiệu lực từ</label>
                                <input type="date" name="valid_from" required class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Hiệu lực đến</label>
                                <input type="date" name="valid_to" required class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Giới hạn lượt sử dụng</label>
                                <input type="number" name="limit_usage" class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Số ngày sử dụng gói</label>
                                <input type="number" name="duration_days" class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Ảnh đại diện</label>

                                <template x-if="selected.thumbnail">
                                    <img :src="'/storage/' + selected.thumbnail"
                                        class="w-20 h-20 rounded-lg mb-2 object-cover">
                                </template>

                                <input type="file" name="thumbnail" accept="image/*"
                                    class="w-full border rounded-lg px-3 py-2">
                            </div>


                            <div>
                                <label class="text-sm font-medium text-gray-600">Trạng thái</label>
                                <select name="is_active" class="w-full border rounded-lg px-3 py-2">
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Ngưng</option>
                                </select>
                            </div>

                        </div>

                        <div class="mt-5 text-right">
                            <button type="button" @click="editModal = false"
                                class="px-4 py-2 rounded-lg border border-gray-300 mr-2">
                                Hủy
                            </button>

                            <button type="submit" class="px-4 py-2 rounded-lg bg-pink-500 text-white">
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
            function packagePage() {
                return {
                    createModal: false,
                    editModal: false,
                    selected: {},

                    openCreate() {
                        this.createModal = true;
                    },

                    openEdit(pkg) {
                        this.selected = JSON.parse(JSON.stringify(pkg));
                        this.editModal = true;
                    }
                }
            }
        </script>
    @endpush

@endsection