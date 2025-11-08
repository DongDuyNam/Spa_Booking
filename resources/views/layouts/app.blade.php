<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Beauty Booking')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lora:wght@400;600&family=Playfair+Display:wght@400;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Lora', serif;
            background-color: #fffafc;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Nút gradient hồng */
        .btn-pink {
            background: linear-gradient(135deg, #f472b6, #ec4899);
        }

        .btn-pink:hover {
            background: linear-gradient(135deg, #ec4899, #db2777);
        }

        /* Hiệu ứng hover input */
        .input-focus:focus {
            border-color: #ec4899;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.25);
        }

        .modal-card {
            animation: fadeUp 0.3s ease-out;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body x-data="{ showBooking: false }" @open-booking.window="showBooking = true"
    @close-booking.window="showBooking = false">

    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Nội dung --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    <!-- Overlay -->
    <div x-show="showBooking" x-cloak class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40"
        @click="showBooking = false"></div>

    <!-- Popup Form -->
    <div x-show="showBooking" x-cloak x-transition.opacity
        class="fixed inset-0 flex items-center justify-center z-50 p-4">
        <div @click.away="showBooking = false"
            class="modal-card bg-white rounded-2xl shadow-2xl p-8 w-full max-w-lg relative">
            <h2 class="text-2xl font-semibold text-pink-600 mb-6 text-center">💅 Đặt lịch ngay</h2>

            <form method="POST" action="{{ route('booking.store') }}" class="space-y-4">
                @csrf

                @auth
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Họ tên</label>
                            <input type="text" name="full_name" value="{{ Auth::user()->full_name }}" readonly
                                class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-700 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Số điện thoại</label>
                            <input type="text" name="phone_number" value="{{ Auth::user()->phone_number }}" readonly
                                class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-700 cursor-not-allowed">
                        </div>
                    </div>
                @else
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Họ tên</label>
                            <input type="text" name="full_name"
                                class="w-full border rounded-lg px-3 py-2 input-focus focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Email</label>
                            <input type="email" name="email"
                                class="w-full border rounded-lg px-3 py-2 input-focus focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Số điện thoại</label>
                            <input type="text" name="phone_number"
                                class="w-full border rounded-lg px-3 py-2 input-focus focus:outline-none" required>
                        </div>
                    </div>
                @endauth

                <div>
                    <label class="block text-sm text-gray-600 mb-1">Ngày đặt</label>
                    <input type="date" name="booking_date"
                        class="w-full border rounded-lg px-3 py-2 input-focus focus:outline-none" required>
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-2">Chọn dịch vụ</label>

                    <div class="space-y-2 max-h-56 overflow-y-auto rounded-lg border border-gray-200 p-3 bg-gray-50">
                        @foreach($services as $service)
                            <label
                                class="flex items-start gap-3 p-2 bg-white rounded-lg shadow-sm hover:shadow-md transition cursor-pointer">
                                <input type="checkbox" name="service_ids[]" value="{{ $service->service_id }}"
                                    class="mt-1 h-5 w-5 text-pink-500 border-gray-300 focus:ring-pink-400 rounded">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800">{{ $service->name }}</p>
                                    <p class="text-sm text-gray-500">{{ number_format($service->price, 0, ',', '.') }}₫</p>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <p class="text-xs text-gray-400 mt-2 italic">Bạn có thể chọn nhiều dịch vụ cùng lúc.</p>
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-1">Ghi chú thêm (tuỳ chọn)</label>
                    <textarea name="note" rows="3"
                        class="w-full border rounded-lg px-3 py-2 input-focus focus:outline-none resize-none"
                        placeholder="Ví dụ: muốn chọn nhân viên quen, giờ cụ thể, v.v..."></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" @click="showBooking = false"
                        class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                        Hủy
                    </button>
                    <button type="submit"
                        class="px-5 py-2 text-white rounded-lg btn-pink shadow-md hover:shadow-lg transition">
                        Xác nhận
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>