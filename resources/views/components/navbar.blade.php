<nav class="bg-primary-125 border-gray-200">
    <div class="flex flex-wrap items-center justify-between max-w-screen-xl mx-auto p-4">
        <a href="{{ url('/') }}" class="flex items-center space-x-3">
            <img src="/image/logo.png" class="w-[200px] h-[50px] object-cover" alt="Beauty Logo" />
        </a>

        <div class="flex items-center md:order-2 space-x-2">
            @guest
                <a href="{{ route('login') }}" class="text-white bg-primary-150 hover:bg-primary-200 px-5 py-2.5 rounded-lg font-serif">Đăng nhập</a>
                <a href="{{ route('register') }}" class="text-white bg-primary-150 hover:bg-primary-200 px-5 py-2.5 rounded-lg font-serif">Đăng ký</a>
            @else
                <span class="text-gray-700 font-serif">Xin chào, {{ Auth::user()->full_name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-white bg-primary-150 hover:bg-primary-200 px-5 py-2.5 rounded-lg font-serif">Đăng xuất</button>
                </form>
            @endguest
        </div>
    </div>
</nav>
