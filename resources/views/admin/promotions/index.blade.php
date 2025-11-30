@extends('layouts.admin')

@section('content')
<div x-data="promotionPage()" class="bg-white shadow-md rounded-xl p-6 border border-pink-100 relative">

    {{-- HEADER --}}
    <div class="mb-4">
        <h2 class="text-2xl font-bold text-gray-700">Danh sách khuyến mãi</h2>

        <div class="flex justify-between items-center mt-3">
            <button @click="openCreate()"
                class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition flex items-center space-x-1">
                ➕ Thêm khuyến mãi
            </button>

            <form method="GET" class="flex space-x-2">
                <input type="text" name="keyword"
                    placeholder="Tìm theo mã hoặc mô tả"
                    value="{{ request('keyword') }}"
                    class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none">

                <select name="status"
                    class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-pink-300 focus:outline-none">
                    <option value="">Tất cả trạng thái</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Đang bật</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Đã tắt</option>
                </select>

                <button class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition">
                    Tìm kiếm
                </button>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="overflow-hidden rounded-lg">
        <table class="min-w-full divide-y divide-pink-100">
            <thead class="bg-pink-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Mã</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Mô tả</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Giảm %</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Từ</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Đến</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Trạng thái</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Thao tác</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @foreach($promotions as $p)
                <tr class="hover:bg-pink-50 transition">
                    <td class="px-6 py-3 text-gray-600">{{ $p->promotion_id }}</td>
                    <td class="px-6 py-3 font-semibold text-gray-800">{{ $p->code }}</td>
                    <td class="px-6 py-3 text-gray-600">{{ $p->description }}</td>
                    <td class="px-6 py-3 text-center">{{ $p->discount_percent }}%</td>
                    <td class="px-6 py-3 text-center">{{ $p->valid_from }}</td>
                    <td class="px-6 py-3 text-center">{{ $p->valid_to }}</td>
                    <td class="px-6 py-3 text-center">
                        <span class="px-3 py-1 text-sm rounded-full 
                            {{ $p->is_active ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                            {{ $p->is_active ? 'Đang bật' : 'Đã tắt' }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-center space-x-2">

                        <a @click="openDetail({{ json_encode($p) }})"
                           class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 cursor-pointer">
                           Xem
                        </a>

                        <a @click="openEdit({{ json_encode($p) }})"
                           class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 cursor-pointer">
                           Sửa
                        </a>

                        <a href="{{ route('admin.promotions.toggle', $p->promotion_id) }}"
                           class="bg-purple-500 text-white px-3 py-1 rounded hover:bg-purple-600">
                           Bật/Tắt
                        </a>

                        <form action="{{ route('admin.promotions.destroy', $p->promotion_id) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Xác nhận xóa khuyến mãi này?')">
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
        {{ $promotions->links('pagination::tailwind') }}
    </div>

    {{-- MODAL: THÊM --}}
    <template x-teleport="body">
        <div x-cloak x-show="createModal"
             class="fixed inset-0 z-[9999] bg-black/50 flex items-center justify-center">
            <div class="bg-white rounded-xl p-6 w-[480px] shadow-lg">
                <h3 class="text-xl font-semibold mb-4">Thêm khuyến mãi</h3>

                <form method="POST" action="{{ route('admin.promotions.store') }}">
                    @csrf
                    <div class="space-y-3">
                        <input name="code" placeholder="Mã khuyến mãi"
                               class="w-full border rounded-lg px-3 py-2">
                        <textarea name="description" placeholder="Mô tả"
                                  class="w-full border rounded-lg px-3 py-2"></textarea>

                        <input name="discount_percent" type="number" min="1" max="100"
                               class="w-full border rounded-lg px-3 py-2">

                        <div class="grid grid-cols-2 gap-3">
                            <input name="valid_from" type="date"
                                   class="w-full border rounded-lg px-3 py-2">
                            <input name="valid_to" type="date"
                                   class="w-full border rounded-lg px-3 py-2">
                        </div>
                    </div>

                    <div class="mt-6 text-right">
                        <button type="button" @click="createModal=false"
                                class="px-4 py-2 border rounded mr-2">Hủy</button>
                        <button class="px-4 py-2 bg-pink-500 text-white rounded">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </template>

    {{-- MODAL: XEM --}}
    <template x-teleport="body">
        <div x-cloak x-show="detailModal"
             class="fixed inset-0 bg-black/50 flex items-center justify-center">
            <div class="bg-white rounded-xl p-6 w-[480px] shadow-lg">
                <h3 class="text-xl font-semibold mb-4">Chi tiết khuyến mãi</h3>

                <div class="space-y-2 text-sm">
                    <p><b>Mã:</b> <span x-text="selected.code"></span></p>
                    <p><b>Mô tả:</b> <span x-text="selected.description"></span></p>
                    <p><b>Giảm:</b> <span x-text="selected.discount_percent"></span>%</p>
                    <p><b>Từ:</b> <span x-text="selected.valid_from"></span></p>
                    <p><b>Đến:</b> <span x-text="selected.valid_to"></span></p>
                </div>

                <div class="mt-6 text-right">
                    <button @click="detailModal=false"
                            class="px-4 py-2 bg-pink-500 text-white rounded">Đóng</button>
                </div>
            </div>
        </div>
    </template>

    {{-- MODAL: SỬA --}}
    <template x-teleport="body">
        <div x-cloak x-show="editModal"
             class="fixed inset-0 bg-black/50 flex items-center justify-center">
            <div class="bg-white rounded-xl p-6 w-[480px] shadow-lg">
                <h3 class="text-xl font-semibold mb-4">Sửa khuyến mãi</h3>

                <form method="POST"
                      :action="`{{ url('/admin/promotions') }}/${selected.promotion_id}`">
                    @csrf
                    @method('PUT')

                    <div class="space-y-3">
                        <input name="code" x-model="selected.code"
                               class="w-full border rounded-lg px-3 py-2">

                        <textarea name="description"
                                  x-model="selected.description"
                                  class="w-full border rounded-lg px-3 py-2"></textarea>

                        <input name="discount_percent" type="number"
                               x-model="selected.discount_percent"
                               class="w-full border rounded-lg px-3 py-2">

                        <div class="grid grid-cols-2 gap-3">
                            <input name="valid_from" type="date"
                                   x-model="selected.valid_from"
                                   class="w-full border rounded-lg px-3 py-2">

                            <input name="valid_to" type="date"
                                   x-model="selected.valid_to"
                                   class="w-full border rounded-lg px-3 py-2">
                        </div>
                    </div>

                    <div class="mt-6 text-right">
                        <button type="button" @click="editModal=false"
                                class="px-4 py-2 border rounded mr-2">Hủy</button>
                        <button class="px-4 py-2 bg-pink-500 text-white rounded">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </template>

</div>

@push('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
<script>
function promotionPage() {
    return {
        selected: {},
        createModal: false,
        detailModal: false,
        editModal: false,

        openCreate() {
            this.createModal = true;
        },

        openDetail(promo) {
            this.selected = promo;
            this.detailModal = true;
        },

        openEdit(promo) {
            this.selected = JSON.parse(JSON.stringify(promo));
            this.editModal = true;
        }
    }
}
</script>
@endpush
@endsection
