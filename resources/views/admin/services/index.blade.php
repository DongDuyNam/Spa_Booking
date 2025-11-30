@extends('layouts.admin')

@section('content')
    <div x-data="servicePage()" class="bg-white shadow-md rounded-xl p-6 border border-pink-100 relative">

        <div class="mb-4">
            <h2 class="text-2xl font-bold text-gray-700">Danh sách dịch vụ</h2>

            <div class="flex justify-between items-center mt-3">

                <button @click="openCreate()"
                    class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition flex items-center space-x-1">
                    ➕ Thêm dịch vụ
                </button>

                <form method="GET" action="{{ route('admin.services.index') }}" class="flex space-x-2">
                    <input type="text" name="keyword" placeholder="Tìm kiếm..." value="{{ request('keyword') }}"
                        class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none">

                    <select name="category"
                        class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-pink-300 focus:outline-none">
                        <option value="">-- Danh mục --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>

                    <select name="is_active"
                        class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-pink-300 focus:outline-none">
                        <option value="">-- Trạng thái --</option>
                        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Ngưng</option>
                    </select>

                    <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition">
                        Tìm kiếm
                    </button>
                </form>
            </div>
        </div>

        <div class="overflow-hidden rounded-lg">
            <table class="min-w-full divide-y divide-pink-100">
                <thead class="bg-pink-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tên dịch vụ</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Thời lượng (phút)</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Giá</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Danh mục</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Trạng thái</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Thao tác</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @foreach($services as $s)
                        <tr class="hover:bg-pink-50 transition">
                            <td class="px-6 py-3 text-gray-600">{{ $s->service_id }}</td>
                            <td class="px-6 py-3 font-medium text-gray-800">
                                {{ $s->name }}
                            </td>
                            <td class="px-6 py-3 text-gray-600">{{ $s->duration_minutes }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ number_format($s->price) }} đ</td>
                            <td class="px-6 py-3 text-gray-600">{{ $s->category }}</td>

                            <td class="px-6 py-3">
                                <span class="px-3 py-1 text-sm rounded-full 
                                        {{ $s->is_active ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $s->is_active ? 'Hoạt động' : 'Ngưng' }}
                                </span>
                            </td>

                            <td class="px-6 py-3 text-center space-x-2">
                                <a @click="openDetail({{ json_encode($s) }})"
                                    class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 cursor-pointer">Xem</a>

                                <a @click="openEdit({{ json_encode($s) }})"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 cursor-pointer">Sửa</a>

                                <form action="{{ route('admin.services.destroy', $s->service_id) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Xóa dịch vụ này?')">
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
            {{ $services->links('pagination::tailwind') }}
        </div>


        {{-- Modal thêm --}}
        <template x-teleport="body">
            <div x-cloak x-show="createModal" class="fixed inset-0 z-[9999] bg-black/50 flex items-center justify-center"
                @keydown.escape.window="createModal = false" x-transition.opacity>
                <div class="bg-white rounded-xl p-6 w-[480px] shadow-lg" @click.outside="createModal = false"
                    x-transition.scale>

                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Thêm dịch vụ mới</h3>

                    <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">


                        @csrf

                        <div class="space-y-3">

                            <div>
                                <label class="text-sm font-medium text-gray-600">Tên dịch vụ</label>
                                <input name="name" required
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Mô tả</label>
                                <textarea name="description"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none"></textarea>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Thời lượng (phút)</label>
                                <input type="number" name="duration_minutes" required
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Giá</label>
                                <input type="number" name="price" required
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Danh mục</label>
                                <select name="category"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Ảnh đại diện</label>
                                <input type="file" name="thumbnail" accept="image/*"
                                    class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Trạng thái</label>
                                <select name="is_active"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Ngưng</option>
                                </select>
                            </div>

                        </div>

                        <div class="mt-6 text-right">
                            <button type="button" @click="createModal = false"
                                class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 mr-2">
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



        {{-- Modal xem --}}
        <template x-teleport="body">
            <div x-cloak x-show="detailModal"
                class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-[9999]"
                x-transition.opacity @keydown.escape.window="detailModal = false" @click.self="detailModal = false">

                <div class="bg-white rounded-xl p-6 w-[480px] shadow-lg" x-transition.scale>

                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Chi tiết dịch vụ</h3>

                    <div class="space-y-2 text-sm">
                        <p><strong>Tên:</strong> <span x-text="selected.name"></span></p>
                        <p><strong>Thời lượng:</strong> <span x-text="selected.duration_minutes"></span> phút</p>
                        <p><strong>Giá:</strong> <span x-text="formatPrice(selected.price)"></span> đ</p>
                        <p><strong>Danh mục:</strong> <span x-text="selected.category"></span></p>
                        <p><strong>Mô tả:</strong> <span x-text="selected.description"></span></p>
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



        {{-- Modal sửa --}}
        <template x-teleport="body">
            <div x-cloak x-show="editModal"
                class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-[9999]"
                x-transition.opacity @keydown.escape.window="editModal = false" @click.self="editModal = false">

                <div class="bg-white rounded-xl p-6 w-[480px] shadow-lg" x-transition.scale>

                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Chỉnh sửa dịch vụ</h3>

                    <form method="POST" :action="'/admin/services/' + selected.service_id" enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="space-y-3">

                            <div>
                                <label class="text-sm font-medium text-gray-600">Tên dịch vụ</label>
                                <input type="text" name="name" x-model="selected.name"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Mô tả</label>
                                <textarea name="description" x-model="selected.description"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none"></textarea>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Thời lượng (phút)</label>
                                <input type="number" name="duration_minutes" x-model="selected.duration_minutes"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Giá</label>
                                <input type="number" name="price" x-model="selected.price"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Danh mục</label>
                                <select name="category" x-model="selected.category"
                                    class="w-full border rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Ảnh đại diện</label>
                                <input type="file" name="thumbnail" accept="image/*"
                                    class="w-full border rounded-lg px-3 py-2">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Trạng thái</label>
                                <select name="is_active" x-model="selected.is_active"
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



        @push('scripts')
            <script src="//unpkg.com/alpinejs" defer></script>
            <script>
                function servicePage() {
                    return {
                        selected: {},
                        createModal: false,
                        detailModal: false,
                        editModal: false,

                        openCreate() {
                            this.createModal = true;
                        },
                        openDetail(svc) {
                            this.selected = svc;
                            this.detailModal = true;
                        },
                        openEdit(svc) {
                            this.selected = JSON.parse(JSON.stringify(svc));
                            this.editModal = true;
                        },
                        formatPrice(val) {
                            return new Intl.NumberFormat().format(val)
                        }
                    };
                }
            </script>
        @endpush

    </div>
@endsection