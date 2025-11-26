@extends('layouts.app')

@section('title', 'Lịch hẹn của tôi')

@section('content')
    <div class="max-w-5xl mx-auto py-10" x-data="{
            openCancel:false,
            cancelId:null
         }">
        <form method="GET" class="bg-white p-4 rounded-xl shadow mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">

            <div>
                <label class="text-sm text-gray-600">Từ ngày</label>
                <input type="date" name="from_date" value="{{ request('from_date') }}"
                    class="w-full border px-3 py-2 rounded-lg">
            </div>

            <div>
                <label class="text-sm text-gray-600">Đến ngày</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}"
                    class="w-full border px-3 py-2 rounded-lg">
            </div>

            <div>
                <label class="text-sm text-gray-600">Trạng thái</label>
                <select name="status" class="w-full border px-3 py-2 rounded-lg">
                    <option value="all">Tất cả</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </div>

            <div class="flex items-end">
                <button class="w-full px-4 py-2 bg-pink-500  bg-primary-150 text-white rounded-lg font-serif hover:bg-primary-200">
                    Lọc
                </button>
            </div>

        </form>

        <h1 class="text-3xl font-semibold text-pink-600 mb-6 text-center">
            📅 Lịch hẹn của tôi
        </h1>

        @if($appointments->count() === 0)
            <div class="bg-white rounded-xl shadow p-6 text-center">
                <p class="text-gray-600 text-lg">Bạn chưa có lịch hẹn nào.</p>
                <a href='{{ route('home') }}'
                    class="mt-4 inline-block px-6 py-2 rounded-lg bg-pink-500 text-white hover:bg-pink-600">
                    Đặt lịch ngay
                </a>
            </div>
        @else

            <div class="space-y-5">

                @foreach ($appointments as $item)
                    <div class="bg-white shadow rounded-xl p-6 border border-pink-100">

                        {{-- Services --}}
                        <h2 class="text-lg font-semibold text-gray-800 mb-2">💅 Dịch vụ:</h2>
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach ($item->details ?? [] as $detail)
                                @if($detail->service)
                                    <span class="px-3 py-1 rounded-full bg-pink-50 text-pink-600 text-sm border border-pink-200">
                                        {{ $detail->service->name }}
                                    </span>
                                @endif
                            @endforeach
                        </div>

                        {{-- Info --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                            <div>
                                <p class="text-gray-500 text-sm">Ngày hẹn</p>
                                <p class="text-gray-800 font-medium">📆
                                    {{ date('d/m/Y', strtotime($item->appointment_date)) }}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-500 text-sm">Giờ hẹn</p>
                                <p class="text-gray-800 font-medium">🕒 {{ $item->appointment_time }}</p>
                            </div>

                            <div>
                                <p class="text-gray-500 text-sm">Nhân viên</p>
                                <p class="text-gray-800 font-medium">
                                    👩‍🦱 {{ $item->staff->full_name ?? 'Đang chờ sắp lịch' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-500 text-sm">Trạng thái</p>

                                @php
                                    $color = [
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        'confirmed' => 'bg-blue-100 text-blue-700',
                                        'completed' => 'bg-green-100 text-green-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                    ][$item->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp

                                <span class="px-3 py-1 rounded-full text-sm {{ $color }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </div>

                        </div>

                        {{-- Actions --}}
                        <div class="flex justify-end gap-3 mt-3">

                            @if(in_array($item->status, ['pending', 'confirmed']))
                                <button @click="openCancel = true; cancelId = {{ $item->appointment_id }};"
                                    class="px-4 py-2 bg-primary-150 text-white rounded-lg">
                                    Hủy lịch
                                </button>
                            @endif

                            <button @click="$dispatch('open-rebook', { id: {{ $item->appointment_id }} })"
                                class="px-4 py-2 bg-primary-150 text-white rounded-lg">
                                Đặt lại lịch
                            </button>

                        </div>
                    </div>
                @endforeach

            </div>

            <div class="mt-6">
                {{ $appointments->links('pagination::tailwind') }}
            </div>

        @endif

        <!-- CANCEL POPUP -->
        <template x-if="openCancel">
            <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-2xl w-full max-w-md">

                    <h2 class="text-xl font-semibold text-pink-600 mb-3">❌ Hủy lịch</h2>

                    <form :action="`/customer/appointments/${cancelId}/cancel`" method="POST">
                        @csrf

                        <p class="mb-4 text-gray-700">Bạn chắc chắn muốn hủy lịch này?</p>

                        <div class="flex justify-end gap-3">
                            <button @click.prevent="openCancel=false" type="button"
                                class="px-4 py-2 bg-gray-200  bg-primary-150 text-white rounded-lg font-serif hover:bg-primary-200">
                                Đóng
                            </button>

                            <button
                                class="px-4 py-2 bg-red-500 bg-primary-150 text-white rounded-lg font-serif hover:bg-primary-200">
                                Xác nhận
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </template>

    </div>

@endsection


{{-- REBOOK POPUP --}}
<div x-data="rebookModal()" @open-rebook.window="loadAppointment($event.detail.id)">
    <template x-if="open">
        <div class="fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-xl p-6">

                <h2 class="text-2xl font-semibold text-pink-600 mb-4 text-center">
                    🔁 Đặt lại lịch
                </h2>

                <div x-show="loading" class="text-center py-6">
                    <div
                        class="animate-spin h-8 w-8 border-2 border-pink-500 border-t-transparent mx-auto rounded-full">
                    </div>
                    <p class="mt-3">Đang tải...</p>
                </div>

                <div x-show="!loading">

                    <h3 class="font-semibold text-gray-800 mb-2">💅 Dịch vụ</h3>
                    <template x-for="srv in services" :key="srv.service_id">
                        <div class="p-2 bg-pink-50 border border-pink-200 rounded-lg mb-1">
                            <span x-text="srv.name"></span>
                        </div>
                    </template>

                    <label class="block mt-4 text-sm text-gray-600">Ngày mới</label>
                    <input type="date" x-model="date" @change="loadSlots"
                        class="w-full border rounded-lg px-3 py-2 mt-1" />

                    <label class="block mt-4 text-sm text-gray-600">Giờ mới</label>
                    <select x-model="time" class="w-full border rounded-lg px-3 py-2 mt-1">
                        <template x-for="slot in slots" :key="slot">
                            <option :value="slot" x-text="slot"></option>
                        </template>
                    </select>

                    <p x-show="slots.length === 0 && date" class="text-red-500 text-sm mt-2">
                        Không có giờ trống.
                    </p>

                    <div class="flex justify-end gap-3 mt-5">
                        <button @click="close"
                            class="px-4 py-2 bg-gray-200 bg-primary-150 text-white rounded-lg font-serif hover:bg-primary-200">
                            Đóng
                        </button>

                        <button @click="submit"
                            class="px-4 py-2 bg-pink-500 bg-primary-150 text-white rounded-lg font-serif hover:bg-primary-200">
                            Xác nhận
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </template>
</div>

<script>
    function rebookModal() {
        return {
            open: false,
            loading: false,
            appointmentId: null,
            services: [],
            date: '',
            time: '',
            slots: [],

            loadAppointment(id) {
                this.open = true;
                this.loading = true;
                this.appointmentId = id;

                fetch(`/customer/appointment/${id}`)
                    .then(r => r.json())
                    .then(data => {
                        this.services = data.services;
                        this.loading = false;
                    });
            },

            loadSlots() {
                if (!this.date || this.services.length === 0) {
                    this.slots = [];
                    return;
                }

                let ids = this.services.map(x => x.service_id).join(',');

                fetch(`/customer/api/slots?date=${this.date}&services=${ids}`)
                    .then(r => r.json())
                    .then(data => {
                        this.slots = data.slots ?? [];
                        this.time = this.slots.length > 0 ? this.slots[0] : '';
                    });
            },

            submit() {
                if (!this.date || !this.time) {
                    alert("Vui lòng chọn ngày & giờ hợp lệ");
                    return;
                }

                let f = document.createElement('form');
                f.method = 'POST';
                f.action = `/customer/appointments/${this.appointmentId}/rebook`;

                f.innerHTML = `
                @csrf
                <input type="hidden" name="date" value="${this.date}">
                <input type="hidden" name="time" value="${this.time}">
            `;

                document.body.appendChild(f);
                f.submit();
            },

            close() {
                this.open = false;
                this.date = '';
                this.time = '';
                this.slots = [];
            }
        }
    }
</script>