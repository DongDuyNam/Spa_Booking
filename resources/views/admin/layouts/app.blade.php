<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Beauty Booking Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-50 flex">
    {{-- Sidebar --}}
    <aside class="w-64 bg-pink-200 min-h-screen p-4">
        <h2 class="text-xl font-bold mb-6">Beauty Booking</h2>
        <nav>
            <ul class="space-y-2">
                <li><a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded hover:bg-pink-300">🏠 Dashboard</a></li>
                <li><a href="{{ route('admin.customers.index') }}" class="block px-3 py-2 rounded hover:bg-pink-300">👩‍💼 Khách hàng</a></li>
            </ul>
        </nav>
    </aside>

    {{-- Main content --}}
    <main class="flex-1 p-6">
        @yield('content')
    </main>
</body>
</html>
