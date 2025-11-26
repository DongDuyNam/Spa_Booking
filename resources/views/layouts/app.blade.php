<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Beauty Booking')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;600&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind / App CSS -->
    @vite('resources/css/app.css')

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        body {
            font-family: 'Lora', serif;
            background-color: #fffafc;
        }

        [x-cloak] {
            display: none !important;
        }

        .btn-pink {
            background: linear-gradient(135deg, #f472b6, #ec4899);
        }

        .btn-pink:hover {
            background: linear-gradient(135deg, #ec4899, #db2777);
        }

        .input-focus:focus {
            border-color: #ec4899;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.25);
        }

        .modal-card {
            animation: fadeUp 0.3s ease-out;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body x-data="{ showBooking: false }"
      @open-booking.window="showBooking = true"
      @close-booking.window="showBooking = false">

    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    <!-- SLOT SELECTOR LOGIC -->
    <script>
        function slotSelector() {
            return {
                date: '',
                slots: [],
                time: '',
                services: [],
                type: 'single',
                mode: 'single',
                selectedPackage: null,

                updateServices() {
                    if (this.mode === 'single') {
                        this.services = [...document.querySelectorAll('input[name="service_ids[]"]:checked')]
                            .map(x => x.value);
                    }
                },

                loadSlots() {
                    this.updateServices();

                    if (!this.date || this.services.length === 0) {
                        this.slots = [];
                        this.time = '';
                        return;
                    }

                    let url = `/api/slots?date=${this.date}&services=${this.services.join(',')}`;

                    if (this.mode === 'package' && this.selectedPackage) {
                        url += `&package_id=${this.selectedPackage}`;
                    }

                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            this.slots = data.slots || [];
                            this.time = this.slots[0] || '';
                        })
                        .catch(() => {
                            this.slots = [];
                            this.time = '';
                        });
                }
            };
        }
    </script>

    <!-- Backdrop -->
    <div x-show="showBooking"
         x-cloak
         class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40"
         @click="showBooking = false">
    </div>

    <!-- Booking Modal -->
    <div x-show="showBooking"
         x-cloak
         x-transition.opacity
         class="fixed inset-0 flex items-center justify-center z-50 p-4">

        <div x-data="slotSelector()"
             @click.away="showBooking = false"
             class="modal-card bg-white rounded-2xl shadow-2xl p-8 w-full max-w-lg relative">

            <h2 class="text-2xl font-semibold text-pink-600 mb-6 text-center">
                💅 Đặt lịch ngay
            </h2>

            <form method="POST" action="{{ route('booking.store') }}" class="space-y-4">
                @csrf

                <!-- USER INFO -->
                @auth
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Họ tên</label>
                            <input type="text" name="full_name" value="{{ Auth::user()->full_name }}" readonly
                                   class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-700">
                        </div>

                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Số điện thoại</label>
                            <input type="text" name="phone_number" value="{{ Auth::user()->phone_number }}" readonly
                                   class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-700">
                        </div>
                    </div>
                @else
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Họ tên</label>
                            <input type="text" name="full_name" required
                                   class="w-full border rounded-lg px-3 py-2 input-focus">
                        </div>

                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Email</label>
                            <input type="email" name="email" required
                                   class="w-full border rounded-lg px-3 py-2 input-focus">
                        </div>

                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Số điện thoại</label>
                            <input type="text" name="phone_number" required
                                   class="w-full border rounded-lg px-3 py-2 input-focus">
                        </div>
                    </div>
                @endauth

                <!-- DATE & TIME -->
                <div class="space-y-2">
                    <label class="block text-sm text-gray-600 mb-1">Ngày đặt</label>
                    <input type="date"
                           name="booking_date"
                           x-model="date"
                           @change="loadSlots"
                           class="w-full border rounded-lg px-3 py-2 input-focus"
                           required>

                    <!-- TIME SLOT DROPDOWN -->
                    <div x-show="slots.length > 0">
                        <label class="block text-sm text-gray-600 mt-3">Giờ hẹn</label>
                        <select name="booking_time"
                                x-model="time"
                                class="w-full border rounded-lg px-3 py-2 input-focus"
                                required>
                            <template x-for="slot in slots" :key="slot">
                                <option :value="slot" x-text="slot"></option>
                            </template>
                        </select>
                    </div>

                    <p x-show="slots.length === 0 && date && services.length > 0"
                       class="text-sm text-red-500 mt-1">
                        Ngày này đã kín lịch, vui lòng chọn ngày khác.
                    </p>
                </div>

                <!-- TYPE SELECT -->
                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-2">Loại đặt lịch</label>

                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio"
                                   name="booking_type"
                                   value="single"
                                   x-model="type"
                                   @change="mode='single'; services=[]; selectedPackage=null; loadSlots();">
                            <span>Dịch vụ đơn lẻ</span>
                        </label>

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio"
                                   name="booking_type"
                                   value="package"
                                   x-model="type"
                                   @change="mode='package'; services=[]; loadSlots();">
                            <span>Gói dịch vụ</span>
                        </label>
                    </div>
                </div>

                <!-- SINGLE SERVICES -->
                <div x-show="type === 'single'">
                    <label class="block text-sm text-gray-600 mb-2">Chọn dịch vụ</label>

                    <div class="space-y-2 max-h-56 overflow-y-auto border p-3 rounded-lg bg-gray-50">
                        @foreach($services as $service)
                            <label class="flex items-start gap-3 p-2 bg-white rounded-lg shadow-sm cursor-pointer">
                                <input type="checkbox"
                                       name="service_ids[]"
                                       value="{{ $service->service_id }}"
                                       @change="loadSlots()"
                                       class="mt-1 h-5 w-5 text-pink-500">

                                <div>
                                    <p class="font-medium text-gray-800">{{ $service->name }}</p>
                                    <p class="text-sm text-gray-500">{{ number_format($service->price, 0, ',', '.') }}₫</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- PACKAGE SERVICES -->
                <div x-show="type === 'package'">
                    <label class="block text-sm text-gray-600 mb-2">Chọn gói dịch vụ</label>

                    <div class="space-y-2 max-h-56 overflow-y-auto border p-3 rounded-lg bg-gray-50">
                        @foreach($packages as $pk)
                            <label class="flex items-start gap-3 p-2 bg-white rounded-lg shadow-sm cursor-pointer">

                                <input type="radio"
                                       name="package_id"
                                       value="{{ $pk->package_id }}"
                                       @change="
                                            mode='package';
                                            selectedPackage={{ $pk->package_id }};
                                            services='{{ $pk->serviceListString }}'.split(',');
                                            loadSlots();
                                       "
                                       class="mt-1 h-5 w-5 text-pink-500">

                                <div>
                                    <p class="font-medium text-gray-800">{{ $pk->name }}</p>
                                    <p class="text-sm text-gray-500">{{ number_format($pk->price, 0, ',', '.') }}₫</p>
                                    <p class="text-xs text-gray-400">
                                        Hiệu lực: {{ $pk->valid_from }} → {{ $pk->valid_to }}
                                    </p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- NOTE -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Ghi chú thêm</label>
                    <textarea name="note"
                              rows="3"
                              class="w-full border rounded-lg px-3 py-2 input-focus resize-none"
                              placeholder="Ví dụ: muốn chọn nhân viên quen, giờ cụ thể..."></textarea>
                </div>

                <!-- BUTTONS -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button"
                            @click="showBooking = false"
                            class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                        Hủy
                    </button>

                    <button type="submit"
                            class="px-5 py-2 text-white rounded-lg btn-pink shadow-md hover:shadow-lg">
                        Xác nhận
                    </button>
                </div>
            </form>

        </div>
    </div>

</body>
</html>
