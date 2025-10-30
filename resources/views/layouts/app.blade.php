<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Tailwind Spa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Lora', serif;
        }
    </style>
    @vite('resources/css/app.css')
</head>

<body class="bg-primary-50">
    <nav class="bg-primary-125 border-gray-200 dark:bg-gray-900">
        <div class="flex flex-wrap items-center justify-between max-w-screen-xl mx-auto p-4">
            <a href="{{ url('/') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="/image/logo.png" class="w-[200px] h-[50px] object-cover " alt="Beauty Logo" />
            </a>
            <div class="flex items-center md:order-2 space-x-1 md:space-x-2 rtl:space-x-reverse">
                <button type="button"
                    class="font-serif text-white bg-primary-150 hover:bg-primary-200 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"><a
                        href="{{ route('login') }}">ĐĂNG NHẬP</a></button>
                <button type="button"
                    class="font-serif text-white bg-primary-150 hover:bg-primary-200 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"><a
                        href="{{ route('register') }}">ĐĂNG KÍ</a></button>
                <button data-collapse-toggle="mega-menu" type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    aria-controls="mega-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
            </div>
            <div id="mega-menu" class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1">
                <ul class="flex flex-col mt-4 font-medium md:flex-row md:mt-0 md:space-x-8 rtl:space-x-reverse">
                    <li>
                        <a href="{{ url('/') }}"
                            class="font-serif block py-2 px-3 text-blue-600 border-b border-gray-100 hover:bg-gray-50 md:hover:text-primary-200 md:border-0 md:hover:text-blue-600 md:p-0 dark:text-blue-500 md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700"
                            aria-current="page">Trang chủ</a>
                    </li>
                    <li>
                        <button id="mega-menu-dropdown-button" data-dropdown-toggle="mega-menu-dropdown" class="font-serif flex
                        items-center justify-between w-full py-2 px-3 font-medium text-gray-900 border-b border-gray-100
                        md:w-auto hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-primary-200 md:p-0
                        dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500
                        md:dark:hover:bg-transparent dark:border-gray-700">
                            Dịch vụ <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="mega-menu-dropdown"
                            class="absolute z-10 hidden block w-fit text-sm bg-white border border-gray-100 rounded-lg shadow-md dark:border-gray-700 dark:bg-gray-700">
                            <div class="p-4 pb-0 text-gray-900 md:pb-4 dark:text-white">
                                <ul class="space-y-4" aria-labelledby="mega-menu-dropdown-button">
                                    <li>
                                        <a href="#"
                                            class="font-serif text-gray-500 dark:text-gray-400 hover:bg-primary-25 dark:hover:text-blue-500">
                                            Chăm sóc tóc
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="font-serif text-gray-500 dark:text-gray-400 hover:bg-primary-25 dark:hover:text-blue-500">
                                            Làm móng & Trang điểm
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="font-serif text-gray-500 dark:text-gray-400 hover:bg-primary-25 dark:hover:text-blue-500">
                                            Spa & Massage
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="font-serif text-gray-500 dark:text-gray-400 hover:bg-primary-25 dark:hover:text-blue-500">
                                            Thẩm mỹ & Da liễu
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="font-serif text-gray-500 dark:text-gray-400 hover:bg-primary-25 dark:hover:text-blue-500">
                                            Khác
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <button id="mega-menu-dropdown-button" data-dropdown-toggle="mega-menu-dropdown2" class="font-serif flex
                        items-center justify-between w-full py-2 px-3 font-medium text-gray-900 border-b border-gray-100
                        md:w-auto hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-primary-200 md:p-0
                        dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500
                        md:dark:hover:bg-transparent dark:border-gray-700">
                            Khu vực <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="mega-menu-dropdown2"
                            class="absolute z-10 hidden block w-fit text-sm bg-white border border-gray-100 rounded-lg shadow-md dark:border-gray-700 dark:bg-gray-700">
                            <div class="p-4 pb-0 text-gray-900 md:pb-4 dark:text-white">
                                <ul class="space-y-4" aria-labelledby="mega-menu-dropdown-button">
                                    <li>
                                        <a href="#"
                                            class="font-serif text-gray-500 dark:text-gray-400 hover:bg-primary-25 dark:hover:text-blue-500">
                                            Hải Phòng
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="font-serif text-gray-500 dark:text-gray-400 hover:bg-primary-25 dark:hover:text-blue-500">
                                            Hà Nội
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="font-serif text-gray-500 dark:text-gray-400 hover:bg-primary-25 dark:hover:text-blue-500">
                                            TP.Hồ Chí Minh
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <button id="mega-menu-dropdown-button" data-dropdown-toggle="mega-menu-dropdown3" class="font-serif flex
                        items-center justify-between w-full py-2 px-3 font-medium text-gray-900 border-b border-gray-100
                        md:w-auto hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-primary-200 md:p-0
                        dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500
                        md:dark:hover:bg-transparent dark:border-gray-700">
                            Ưu đãi<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="mega-menu-dropdown3"
                            class="absolute z-10 hidden block w-fit text-sm bg-white border border-gray-100 rounded-lg shadow-md dark:border-gray-700 dark:bg-gray-700">
                            <div class="p-4 pb-0 text-gray-900 md:pb-4 dark:text-white">
                                <ul class="space-y-4" aria-labelledby="mega-menu-dropdown-button">
                                    <li>
                                        <a href="#"
                                            class="font-serif text-gray-500 dark:text-gray-400 hover:bg-primary-25 dark:hover:text-blue-500">
                                            Flash Sale
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="font-serif text-gray-500 dark:text-gray-400 hover:bg-primary-25 dark:hover:text-blue-500">
                                            Combo giảm giá
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="font-serif text-gray-500 dark:text-gray-400 hover:bg-primary-25 dark:hover:text-blue-500">
                                            Tích điểm & đổi quà
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <button id="mega-menu-dropdown-button" data-dropdown-toggle="mega-menu-dropdown4" class="font-serif flex
                        items-center justify-between w-full py-2 px-3 font-medium text-gray-900 border-b border-gray-100
                        md:w-auto hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-primary-200 md:p-0
                        dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500
                        md:dark:hover:bg-transparent dark:border-gray-700">
                            Hỗ trợ<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="mega-menu-dropdown4"
                            class="absolute z-10 hidden block w-fit text-sm bg-white border border-gray-100 rounded-lg shadow-md dark:border-gray-700 dark:bg-gray-700">
                            <div class="p-4 pb-0 text-gray-900 md:pb-4 dark:text-white">
                                <ul class="space-y-4" aria-labelledby="mega-menu-dropdown-button">
                                    <li>
                                        <a href="#"
                                            class="font-serif text-gray-500 dark:text-gray-400 hover:bg-primary-25 dark:hover:text-blue-500">
                                            Hướng dẫn đặt lịch
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="font-serif text-gray-500 dark:text-gray-400 hover:bg-primary-25 dark:hover:text-blue-500">
                                            Chính sách
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="font-serif text-gray-500 dark:text-gray-400 hover:bg-primary-25 dark:hover:text-blue-500">
                                            Liên hệ
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>


        <section class="bg-primary-25 pt-10 pb-20 dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-screen-xl text-center">
                <img class="h-auto w-full max-auto object-cover mx-auto rounded-lg shadow-xl mb-8"
                    src="/image/image1.png" alt="image1">
                <form class="max-w-xl mx-auto mt-4">
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="search" id="default-search"
                            class="font-lora block w-full p-4 ps-10 text-base text-gray-900 border border-primary-100 rounded-lg bg-white focus:ring-primary-200 focus:border-primary-200"
                            placeholder="Tìm kiếm dịch vụ..." required />
                        <button type="submit"
                            class="font-playfair text-white absolute end-2.5 bottom-2.5 bg-primary-200 hover:bg-primary-225 focus:ring-4 focus:outline-none focus:ring-primary-100 font-medium rounded-lg text-sm px-4 py-2">
                            Tìm kiếm
                        </button>
                    </div>
                </form>
            </div>
        </section>
        <section class="bg-primary-50 py-16 dark:bg-gray-900">
            <h2 class="text-4xl font-playfair font-bold text-center mb-10 text-gray-800">
                Cơ sở nổi bật
            </h2>

            <div class="max-w-screen-xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <div
                    class="bg-white rounded-xl shadow-lg overflow-hidden border border-primary-100 transition duration-300 hover:shadow-xl p-2">
                    <div class="relative overflow-hidden rounded-xl border-2 border-primary-100">
                        <img class="w-full h-40 object-cover" src="/image/trang_spa.jpg" alt="Trang Spa">
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="text-xl font-playfair font-bold text-gray-800">Trang Spa</h3>
                        <p class="text-sm text-gray-500 mb-3">Hải Phòng</p>
                        <div class="flex justify-center items-center space-x-1 text-primary-200 mb-4">
                            <span class="text-xs">★★★★</span><span class="text-xs">★</span>
                            <span class="text-sm text-gray-600">4,5</span>
                        </div>
                        <button
                            class="w-full bg-primary-200 text-white font-lora font-medium py-2 rounded-lg hover:bg-primary-225 transition duration-300">
                            Xem chi tiết
                        </button>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-lg overflow-hidden border border-primary-100 transition duration-300 hover:shadow-xl p-2">
                    <div class="relative overflow-hidden rounded-xl border-2 border-primary-100">
                        <img class="w-full h-40 object-cover" src="/image/cam_on_spa.jpg" alt="Cam On Spa">
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="text-xl font-playfair font-bold text-gray-800">Cam On Spa</h3>
                        <p class="text-sm text-gray-500 mb-3">Hà Nội</p>
                        <div class="flex justify-center items-center space-x-1 text-primary-200 mb-4">
                            <span class="text-xs">★★★★</span><span class="text-xs">★</span>
                            <span class="text-sm text-gray-600">4,5</span>
                        </div>
                        <button
                            class="w-full bg-primary-200 text-white font-lora font-medium py-2 rounded-lg hover:bg-primary-225 transition duration-300">
                            Xem chi tiết
                        </button>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-lg overflow-hidden border border-primary-100 transition duration-300 hover:shadow-xl p-2">
                    <div class="relative overflow-hidden rounded-xl border-2 border-primary-100">
                        <img class="w-full h-40 object-cover" src="/image/trustskin_spa.jpg" alt="Trustskin Spa">
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="text-xl font-playfair font-bold text-gray-800">Trustskin Spa</h3>
                        <p class="text-sm text-gray-500 mb-3">Hà Nội</p>
                        <div class="flex justify-center items-center space-x-1 text-primary-200 mb-4">
                            <span class="text-xs">★★★★</span><span class="text-xs">★</span>
                            <span class="text-sm text-gray-600">4,5</span>
                        </div>
                        <button
                            class="w-full bg-primary-200 text-white font-lora font-medium py-2 rounded-lg hover:bg-primary-225 transition duration-300">
                            Xem chi tiết
                        </button>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-lg overflow-hidden border border-primary-100 transition duration-300 hover:shadow-xl p-2">
                    <div class="relative overflow-hidden rounded-xl border-2 border-primary-100">
                        <img class="w-full h-40 object-cover" src="/image/ben_shine_spa.jpg" alt="Ben Shine Spa">
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="text-xl font-playfair font-bold text-gray-800">Ben Shine Spa</h3>
                        <p class="text-sm text-gray-500 mb-3">Hà Nội</p>
                        <div class="flex justify-center items-center space-x-1 text-primary-200 mb-4">
                            <span class="text-xs">★★★★</span><span class="text-xs">★</span>
                            <span class="text-sm text-gray-600">4,5</span>
                        </div>
                        <button
                            class="w-full bg-primary-200 text-white font-lora font-medium py-2 rounded-lg hover:bg-primary-225 transition duration-300">
                            Xem chi tiết
                        </button>
                    </div>
                </div>

            </div>
        </section>
        <section class="bg-primary-25 py-16 dark:bg-gray-900">
            <h2 class="text-4xl font-playfair font-bold text-center mb-10 text-gray-800">
                Dịch vụ ưa thích
            </h2>

            <div class="max-w-screen-xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <div
                    class="bg-white rounded-xl shadow-lg overflow-hidden border border-primary-100 transition duration-300 hover:shadow-xl p-2">
                    <div class="relative overflow-hidden rounded-xl border-2 border-primary-100">
                        <img class="w-full h-40 object-cover" src="/image/image2.jpg" alt="image2">
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="text-xl font-playfair font-bold text-gray-800">Làm móng</h3>
                        <p class="text-sm text-gray-500 mb-3">Tặng voucher 100k</p>
                        <button
                            class="w-full bg-primary-200 text-white font-lora font-medium py-2 rounded-lg hover:bg-primary-225 transition duration-300 mt-4">
                            Đặt ngay
                        </button>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-lg overflow-hidden border border-primary-100 transition duration-300 hover:shadow-xl p-2">
                    <div class="relative overflow-hidden rounded-xl border-2 border-primary-100">
                        <img class="w-full h-40 object-cover" src="/image/image3.jpg" alt="image3">
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="text-xl font-playfair font-bold text-gray-800">Làm tóc</h3>
                        <p class="text-sm text-gray-500 mb-3">Sản phẩm tóc Organic</p>
                        <button
                            class="w-full bg-primary-200 text-white font-lora font-medium py-2 rounded-lg hover:bg-primary-225 transition duration-300 mt-4">
                            Đặt ngay
                        </button>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-lg overflow-hidden border border-primary-100 transition duration-300 hover:shadow-xl p-2">
                    <div class="relative overflow-hidden rounded-xl border-2 border-primary-100">
                        <img class="w-full h-40 object-cover" src="/image/image4.jpg" alt="image4">
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="text-xl font-playfair font-bold text-gray-800">Massage</h3>
                        <p class="text-sm text-gray-500 mb-3">Giảm 20% gói massage</p>
                        <button
                            class="w-full bg-primary-200 text-white font-lora font-medium py-2 rounded-lg hover:bg-primary-225 transition duration-300 mt-4">
                            Đặt ngay
                        </button>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-lg overflow-hidden border border-primary-100 transition duration-300 hover:shadow-xl p-2">
                    <div class="relative overflow-hidden rounded-xl border-2 border-primary-100">
                        <img class="w-full h-40 object-cover" src="/image/image5.jpg" alt="image5">
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="text-xl font-playfair font-bold text-gray-800">Chăm sóc da</h3>
                        <p class="text-sm text-gray-500 mb-3">Chăm sóc da chuyên sâu</p>
                        <button
                            class="w-full bg-primary-200 text-white font-lora font-medium py-2 rounded-lg hover:bg-primary-225 transition duration-300 mt-4">
                            Đặt ngay
                        </button>
                    </div>
                </div>

            </div>
        </section>
        <footer class="bg-white py-10 dark:bg-gray-900 border-t border-primary-100">
            <div class="max-w-screen-xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8 text-sm">

                <div class="col-span-1">
                    <img src="/image/logo_footer.png" class="w-[100px] h-[30px] object-cover mb-4" alt="Footer Logo" />
                    <p class="text-gray-600 mb-2 font-lora">
                        Beauty Booking – Tự tin, xinh đẹp mỗi ngày.
                    </p>
                    <p class="text-gray-600 text-xs">&copy; 2025 Beauty Booking</p>
                </div>

                <div class="col-span-1">
                    <h4 class="font-playfair font-bold text-lg mb-4 text-gray-800">Liên kết nhanh</h4>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="#" class="hover:text-primary-200">Trang chủ</a></li>
                        <li><a href="#" class="hover:text-primary-200">Dịch vụ</a></li>
                        <li><a href="#" class="hover:text-primary-200">Ưu đãi</a></li>
                        <li><a href="#" class="hover:text-primary-200">Liên hệ</a></li>
                    </ul>
                </div>

                <div class="col-span-1">
                    <h4 class="font-playfair font-bold text-lg mb-4 text-gray-800">Liên hệ</h4>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-primary-200" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.772-1.549a1 1 0 011.06-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                                </path>
                            </svg>
                            <span>123 Hoa Hồng, Q1, TP.HCM</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-primary-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 2a8 8 0 100 16 8 8 0 000-16zM5 9.75a.75.75 0 01.75-.75h8.5a.75.75 0 010 1.5H5.75a.75.75 0 01-.75-.75z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span>0123.456.789</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-primary-200" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884zM18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z">
                                </path>
                            </svg>
                            <span>contact@beautybooking.com</span>
                        </li>
                    </ul>
                </div>

                <div class="col-span-1">
                    <h4 class="font-playfair font-bold text-lg mb-4 text-gray-800">Kết nối</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-600 hover:text-primary-200">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.477 2 2 6.477 2 12c0 5.143 3.526 9.429 8.203 10.596v-7.481h-2.776v-3.115h2.776v-2.31c0-2.753 1.68-4.254 4.14-4.254 1.18 0 2.195.088 2.486.127v2.871h-1.743c-1.37 0-1.637.65-1.637 1.608v2.128h3.385l-.441 3.115h-2.944v7.48c4.676-1.167 8.202-5.453 8.202-10.595C22 6.477 17.523 2 12 2z">
                                </path>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-primary-200">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2c2.716 0 3.056.011 4.123.064 1.066.053 1.79.23 2.428.473.66.257 1.25.602 1.815 1.168.566.565.91 1.155 1.168 1.815.243.638.42 1.362.473 2.428.053 1.067.064 1.407.064 4.123s-.011 3.056-.064 4.123c-.053 1.066-.23 1.79-.473 2.428-.257.66-.602 1.25-1.168 1.815-.565.566-1.155.91-1.815 1.168-.638.243-1.362.42-2.428.473-1.067.053-1.407.064-4.123.064s-3.056-.011-4.123-.064c-1.066-.053-1.79-.23-2.428-.473-.66-.257-1.25-.602-1.815-1.168-.566-.565-.91-1.155-1.168-1.815-.243-.638-.42-1.362-.473-2.428-.053-1.067-.064-1.407-.064-4.123s.011-3.056.064-4.123c.053-1.066.23-1.79.473-2.428.257-.66.602-1.25 1.168-1.815.565-.566 1.155-.91 1.815-1.168.638-.243 1.362-.42 2.428-.473C8.944 2.011 9.284 2 12 2zm0 2.16c-2.42 0-2.678.01-3.64.053-.9.043-1.472.22-1.8.347-.358.13-.673.306-.977.61-.304.305-.48.62-.61.977-.128.328-.305.9-.347 1.8-.043.962-.053 1.22-.053 3.64s.01 2.678.053 3.64c.043.9.22 1.472.347 1.8.13.358.306.673.61.977.305.304.62.48.977.61.328.128.9.305 1.8.347.962.043 1.22.053 3.64.053s2.678-.01 3.64-.053c.9-.043 1.472-.22 1.8-.347.13-.358.306-.673.61-.977.305-.304.48-.62.61-.977.128-.328.305-.9.347-1.8.043-.962.053-1.22.053-3.64s-.01-2.678-.053-3.64c-.043-.9-.22-1.472-.347-1.8-.13-.358-.306-.673-.61-.977-.305-.304-.62-.48-.977-.61-.328-.128-.9-.305-1.8-.347C14.678 4.01 14.42 4 12 4zm0 2.45a5.55 5.55 0 100 11.1 5.55 5.55 0 000-11.1zm0 2a3.55 3.55 0 110 7.1 3.55 3.55 0 010-7.1zm6.6-.725a1.275 1.275 0 11-2.55 0 1.275 1.275 0 012.55 0z">
                                </path>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-primary-200">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5.49 8.25c-.28 1.15-.83 2.19-1.61 3.12-.78.93-1.74 1.7-2.85 2.27s-2.37.86-3.64.86c-1.46 0-2.8-.4-4.04-1.19.82.09 1.6.07 2.34-.04.75-.1 1.47-.32 2.15-.67-.69-.23-1.3-.61-1.83-1.15s-.96-1.19-1.27-1.92c.23.05.46.07.69.07.34 0 .68-.05 1.01-.15-.71-.24-1.35-.61-1.93-1.12s-1.02-1.14-1.28-1.86c.49.08.97.1 1.45.05-.45-.3-.84-.71-1.17-1.22s-.58-1.1-.64-1.74c.15.15.32.27.52.36.19.09.4.16.63.2-.37-.4-.59-.85-.64-1.35s-.02-1.04.14-1.54c.48.59 1.05 1.12 1.7 1.6.65.48 1.35.87 2.1 1.17.06-.02.13-.04.19-.06.75-.27 1.48-.61 2.17-1.04s1.28-.93 1.76-1.55c.32-.42.58-.87.77-1.35.19-.48.28-.97.28-1.45 0-.17-.03-.33-.09-.49.49.23.95.53 1.39.9s.79.82 1.09 1.34c.19-.03.38-.05.57-.05.28 0 .56.03.83.08-.22.37-.47.72-.76 1.05s-.6.65-.95.95z">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
            <div class="text-center text-xs text-gray-500 mt-10 border-t pt-4">
                Bản quyền thuộc về Beauty Booking – Tự tin, xinh đẹp mỗi ngày
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>