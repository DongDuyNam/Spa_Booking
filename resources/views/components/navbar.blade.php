<nav class="bg-primary-125 border-gray-200">
    <div class="flex flex-wrap items-center justify-between max-w-screen-xl mx-auto p-4">
        <a href="{{ url('/') }}" class="flex items-center space-x-3">
            <img src="/image/logo.png" class="w-[200px] h-[50px] object-cover" alt="Beauty Logo" />
        </a>
        <button data-collapse-toggle="navbar-dropdown" type="button"
            class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            aria-controls="navbar-dropdown" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 1h15M1 7h15M1 13h15" />
            </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
            <ul
                class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <li>
                    <a href="#"
                        class="block py-2 px-3 text-black bg-primary-150 hover:text-primary-175 rounded-sm md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500 dark:bg-blue-600 md:dark:bg-transparent"
                        aria-current="page">Home</a>
                </li>
                <li>
                    <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
                        class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md: hover:text-primary-175 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">Dropdown
                        <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg></button>
                    <div id="dropdownNavbar"
                        class="z-10 hidden font-normal bg-primary-50 divide-y divide-gray rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-primary-150 dark:hover:bg-primary-150 dark:hover:text-primary-150">Dashboard</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-primary-150 dark:hover:bg-primary-150 dark:hover:text-primary-150">Settings</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-primary-150 dark:hover:bg-primary-150 dark:hover:text-primary-150">Earnings</a>
                            </li>
                        </ul>
                        <div class="py-1">
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign
                                out</a>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="#"
                        class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-primary-175 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Services</a>
                </li>
                <li>
                    <a href="#"
                        class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md: hover:text-primary-175 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Pricing</a>
                </li>
                <li>
                    <a href="#"
                        class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md: hover:text-primary-175 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Contact</a>
                </li>
            </ul>
        </div>
        <div class="flex items-center md:order-2 space-x-3">

            @guest
                <a href="{{ route('login') }}"
                    class="text-white bg-primary-150 hover:bg-primary-200 px-5 py-2.5 rounded-lg font-serif">
                    Đăng nhập
                </a>
                <a href="{{ route('register') }}"
                    class="text-white bg-primary-150 hover:bg-primary-200 px-5 py-2.5 rounded-lg font-serif">
                    Đăng ký
                </a>
            @else
                <div x-data="{ open:false }" class="relative">
                    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                        <img src="{{ Auth::user()->avatar ?? '/image/default-avatar.png' }}"
                            class="w-10 h-10 rounded-full border-2 border-primary-150 object-cover">
                        <span class="font-serif text-gray-700 hidden md:block">
                            {{ Auth::user()->full_name }}
                        </span>
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Dropdown --}}
                    <div x-show="open" @click.outside="open=false"
                        class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg py-2 z-50"
                        x-transition.opacity>
                        <a href="{{ route('customer.dashboard') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-primary-75">
                            🏠 Trang cá nhân
                        </a>
                        <a href="{{ route('customer.appointments') }}" class="block px-4 py-2 text-gray-700 hover:bg-primary-75">
                            📅 Lịch hẹn của tôi
                        </a>

                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-primary-75">
                            💆 Gói dịch vụ đã mua
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                🚪 Đăng xuất
                            </button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</nav>