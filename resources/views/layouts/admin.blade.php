<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - AnhDuongSpa Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
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

            <div x-data="{ open: {{ request()->routeIs('admin.appointments.*') ? 'true' : 'false' }} }">

                <a href="#" @click.prevent="open = !open" class="flex items-center justify-between block rounded-lg px-4 py-3
       {{ request()->routeIs('admin.appointments.*') ? 'bg-gray-800 text-white' : 'text-gray-300' }}
       hover:bg-gray-800 hover:text-white">

                    <span>📅 Lịch hẹn</span>
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>

                <div x-show="open" x-transition class="mt-1 ml-4 space-y-1">

                    <a href="{{ route('admin.appointments.index') }}" class="block rounded-lg px-4 py-2 text-sm
           {{ request()->routeIs('admin.appointments.*')
    ? 'bg-pink-500 text-white'
    : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        Danh sách lịch hẹn
                    </a>

                </div>

            </div>
            <button @click="toggle()" class="w-full flex items-center justify-between rounded-lg px-4 py-3
               text-gray-300 hover:bg-gray-800 hover:text-white">

                <span class="flex items-center space-x-2">
                    <span>Dịch vụ</span>
                </span>

                <svg :class="open ? 'rotate-90' : ''" class="w-4 h-4 transform transition-transform duration-200"
                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <div x-show="open" x-transition x-cloak class="mt-1 ml-6 space-y-1">

                <a href="{{ route('admin.services.index') }}" class="block px-4 py-2 text-sm rounded hover:bg-gray-700 hover:text-white
                  {{ request()->routeIs('admin.services.*') ? 'text-pink-400' : 'text-gray-300' }}">
                    ... Danh sách dịch vụ
                </a>

                <a href="{{ route('admin.servicepackages.index') }}" class="block px-4 py-2 text-sm rounded hover:bg-gray-700 hover:text-white
                  {{ request()->routeIs('admin.servicepackages.*') ? 'text-pink-400' : 'text-gray-300' }}">
                    ... Danh sách gói dịch vụ
                </a>
            </div>
            </div>

            <div x-data="menuSection('menu_staff')" class="relative">

                <button @click="toggle()" class="w-full flex items-center justify-between rounded-lg px-4 py-3
               text-gray-300 hover:bg-gray-800 hover:text-white">

                    <span>Nhân viên & Lịch làm</span>

                    <svg :class="open ? 'rotate-90' : ''" class="w-4 h-4 transform transition-transform duration-200"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <div x-show="open" x-transition x-cloak class="mt-1 ml-6 space-y-1">

                    <a href="{{ route('admin.staffs.index') }}" class="block px-4 py-2 text-sm rounded hover:bg-gray-700 hover:text-white
                {{ request()->routeIs('admin.staffs.*') ? 'text-pink-400' : 'text-gray-300' }}">
                        ... Danh sách nhân viên
                    </a>

                    <a href="{{ route('admin.schedules.index') }}" class="block px-4 py-2 text-sm rounded hover:bg-gray-700 hover:text-white
                {{ request()->routeIs('admin.schedules.*') ? 'text-pink-400' : 'text-gray-300' }}">
                        ... Lịch làm nhân viên
                    </a>

                </div>
            </div>

            <div x-data="menuSection('menu_customer')" class="relative">

                <button @click="toggle()" class="w-full flex items-center justify-between rounded-lg px-4 py-3
               text-gray-300 hover:bg-gray-800 hover:text-white">

                    <span>Khách hàng</span>

                    <svg :class="open ? 'rotate-90' : ''" class="w-4 h-4 transform transition-transform duration-200"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <div x-show="open" x-transition x-cloak class="mt-1 ml-6 space-y-1">

                    <a href="{{ route('admin.customers.index') }}" class="block px-4 py-2 text-sm rounded hover:bg-gray-700 hover:text-white
                {{ request()->routeIs('admin.customers.*') ? 'text-pink-400' : 'text-gray-300' }}">
                        ... Danh sách khách hàng
                    </a>

                    <a href="{{ route('admin.customers.index') }}" class="block px-4 py-2 text-sm rounded hover:bg-gray-700 hover:text-white
                {{ request()->routeIs('admin.customers.*') ? 'text-pink-400' : 'text-gray-300' }}">
                        ... Chi tiết khách hàng
                    </a>

                    <a href="{{ route('admin.customers.index') }}" class="block px-4 py-2 text-sm rounded hover:bg-gray-700 hover:text-white
                {{ request()->routeIs('admin.customers.*') ? 'text-pink-400' : 'text-gray-300' }}">
                        ... Quản lý gói dịch vụ / liệu trình
                    </a>

                    <a href="{{ route('admin.customers.index') }}" class="block px-4 py-2 text-sm rounded hover:bg-gray-700 hover:text-white
                {{ request()->routeIs('admin.customers.*') ? 'text-pink-400' : 'text-gray-300' }}">
                        ... Feedback / đánh giá khách hàng
                    </a>

                </div>
            </div>
            <a href="{{ route('admin.promotions.index') }}" class="block px-4 py-2 text-sm rounded hover:bg-gray-700 hover:text-white
                {{ request()->routeIs('admin.promotions.*') ? 'text-pink-400' : 'text-gray-300' }}">
                Khuyến mãi /Ưu đãi
            </a>
            <a href="#" class="block rounded-lg px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white">Doanh
                thu</a>
            <a href="{{ route('admin.reviews.index') }}" class="block px-4 py-2 text-sm rounded hover:bg-gray-700 hover:text-white
                {{ request()->routeIs('admin.reviews.*') ? 'text-pink-400' : 'text-gray-300' }}">
                Đánh giá
            </a>

            <a href="#" class="block rounded-lg px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white">Cài
                đặt</a>
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
                <div class="text-xl font-semibold text-pink-600">{{ Auth::user()->full_name }} 🌸</div>
                <div class="text-xs text-gray-400 mt-1">Chúc bạn một ngày rực rỡ 💖</div>
            </div>

            <div class="flex items-center space-x-4">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Chi nhánh</label>
                    <select class="bg-white border border-pink-200 text-gray-700 text-sm rounded-lg px-3 py-2"
                        onchange="window.location='?branch_id='+this.value">
                        <option value="">Tất cả chi nhánh</option>
                        <option value="1" {{ request('branch_id') == 1 ? 'selected' : '' }}>Chi nhánh 1</option>
                        <option value="2" {{ request('branch_id') == 2 ? 'selected' : '' }}>Chi nhánh 2</option>
                        <option value="3" {{ request('branch_id') == 3 ? 'selected' : '' }}>Chi nhánh 3</option>
                    </select>
                </div>

                <div class="flex items-center space-x-3 bg-white rounded-full px-3 py-2 shadow border border-pink-100">
                    <img src="https://th.bing.com/th/id/OIP.vmoycMUOmbcs0Vw-1iIdVAHaHa?w=215&h=215"
                        class="w-10 h-10 rounded-full border-2 border-pink-300" alt="avatar">
                    <div class="text-sm leading-tight">
                        <div class="font-semibold text-gray-700">{{ Auth::user()->full_name }} 🌸</div>
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

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('menuSection', (key) => ({
                open: localStorage.getItem(key) === 'true' ? true : false,

                toggle() {
                    this.open = !this.open;
                    localStorage.setItem(key, this.open);
                }
            }));
        });
    </script>
</body>

</html>