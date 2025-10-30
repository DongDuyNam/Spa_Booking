<section class="bg-primary-25 py-16">
    <h2 class="text-4xl font-playfair font-bold text-center mb-10 text-gray-800">
        Dịch vụ ưa thích
    </h2>

    <div class="max-w-screen-xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach ([
            ['img' => '/image/image2.jpg', 'name' => 'Làm móng', 'desc' => 'Tặng voucher 100k'],
            ['img' => '/image/image3.jpg', 'name' => 'Làm tóc', 'desc' => 'Sản phẩm tóc Organic'],
            ['img' => '/image/image4.jpg', 'name' => 'Massage', 'desc' => 'Giảm 20% gói massage'],
            ['img' => '/image/image5.jpg', 'name' => 'Chăm sóc da', 'desc' => 'Chăm sóc da chuyên sâu']
        ] as $service)
            <div class="bg-white rounded-xl shadow-lg border border-primary-100 hover:shadow-xl transition duration-300">
                <img class="w-full h-40 object-cover rounded-t-xl" src="{{ $service['img'] }}" alt="{{ $service['name'] }}">
                <div class="p-4 text-center">
                    <h3 class="text-xl font-playfair font-bold text-gray-800">{{ $service['name'] }}</h3>
                    <p class="text-sm text-gray-500 mb-3">{{ $service['desc'] }}</p>
                    <button class="w-full bg-primary-200 text-white font-lora py-2 rounded-lg hover:bg-primary-225">
                        Đặt ngay
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</section>
