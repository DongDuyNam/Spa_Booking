<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - AnhDuongSpa Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#FFF8F9] text-gray-800 flex min-h-screen">

    {{-- Sidebar trái --}}
    <aside class="w-64 bg-gray-900 text-white flex flex-col">
        <div class="p-6 border-b border-gray-700">
            <div class="text-2xl font-bold text-pink-300">AnhDuong<span class="text-white">Spa</span></div>
            <div class="text-xs text-gray-400 mt-1">Admin Dashboard</div>
        </div>

        <nav class="flex-1 p-4 space-y-1 text-sm">
            <a href="{{ url('/admin/dashboard') }}"
                class="flex items-center justify-between bg-gray-800 text-white rounded-lg px-4 py-3 hover:bg-gray-700">
                <span class="flex items-center space-x-2">
                    <span class="w-2 h-2 bg-pink-400 rounded-full"></span>
                    <span>Tổng quan</span>
                </span>
                <span class="text-[10px] bg-pink-500 text-white px-2 py-0.5 rounded">Now</span>
            </a>

            <a href="#" class="block rounded-lg px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white">Lịch hẹn</a>
            <a href="#" class="block rounded-lg px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white">Dịch vụ</a>
            <a href="#" class="block rounded-lg px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white">Nhân viên
                &amp; Lịch làm</a>

            <a href="{{ route('admin.customers.index') }}"
                class="block rounded-lg px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white">
                Khách hàng
            </a>

            <a href="#" class="block rounded-lg px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white">Doanh thu</a>
            <a href="#" class="block rounded-lg px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white">Khuyến mãi / Ưu đãi</a>
            <a href="#" class="block rounded-lg px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white">Đánh giá</a>
            <a href="#" class="block rounded-lg px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white">Cài đặt</a>
        </nav>

        <div class="p-4 border-t border-gray-700 text-sm text-gray-400">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left hover:text-pink-400">Đăng xuất</button>
            </form>
            <div class="text-[10px] mt-2 text-gray-500">v1.0.0</div>
        </div>
    </aside>

    {{-- Nội dung --}}
    <main class="flex-1 flex flex-col">
        <header class="w-full bg-[#FFF0F3] border-b border-pink-100 flex items-center justify-between px-6 py-4">
            <div>
                <div class="text-sm text-gray-500">Xin chào,</div>
                <div class="text-xl font-semibold text-pink-600">Ngọc Anh 🌸</div>
                <div class="text-xs text-gray-400 mt-1">Chúc bạn một ngày rực rỡ 💖</div>
            </div>

            <div class="flex items-center space-x-4">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Chi nhánh</label>
                    <select class="bg-white border border-pink-200 text-gray-700 text-sm rounded-lg px-3 py-2 focus:ring-pink-300 focus:outline-none">
                        <option>The Muse Beauty Spa - Q1</option>
                        <option>Greenleaf Wellness - Q3</option>
                        <option>Queen Nails & Hair - HN</option>
                    </select>
                </div>

                <div class="flex items-center space-x-3 bg-white rounded-full px-3 py-2 shadow border border-pink-100">
                    <img src="https://th.bing.com/th/id/OIP.vmoycMUOmbcs0Vw-1iIdVAHaHa?w=215&h=215"
                        class="w-10 h-10 rounded-full border-2 border-pink-300" alt="avatar">
                    <div class="text-sm leading-tight">
                        <div class="font-semibold text-gray-700">Ngọc Anh</div>
                        <div class="text-[11px] text-gray-400">Quản lý Spa</div>
                    </div>
                </div>
            </div>
        </header>

        <section class="flex-1 p-6">
            @yield('content')
        </section>
    </main>

    {{-- Toast --}}
    <div x-data="{ show: false, message: '', type: 'success' }" x-show="show" x-transition.opacity.duration.300ms
        x-init="
            window.addEventListener('toast', (event) => {
                message = event.detail.message;
                type = event.detail.type || 'success';
                show = true;
                setTimeout(() => show = false, 3000);
            });
        " class="fixed top-5 right-5 z-50" x-cloak>
        <div :class="{
                'bg-green-100 text-green-800 border-green-300': type === 'success',
                'bg-red-100 text-red-800 border-red-300': type === 'error',
                'bg-yellow-100 text-yellow-800 border-yellow-300': type === 'warning'
            }" class="px-4 py-3 rounded-lg shadow-md border flex items-center space-x-3">
            <span x-text="message" class="font-medium"></span>
        </div>
    </div>

    {{-- Load AlpineJS & Script Stack --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('scripts')
</body>
</html>
