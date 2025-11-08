<section class="bg-primary-50 py-16">
    <h2 class="text-4xl font-playfair font-bold text-center mb-10 text-gray-800">
        Cơ sở nổi bật
    </h2>

    <div class="max-w-screen-xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach ([
            ['img' => '/image/trang_spa.jpg', 'name' => 'Chi nhánh', 'loc' => 'Hải Phòng'],
            ['img' => '/image/cam_on_spa.jpg', 'name' => 'Chi nhánh', 'loc' => 'Hà Nội'],
            ['img' => '/image/trustskin_spa.jpg', 'name' => 'Chi nhánh', 'loc' => 'Hà Nội'],
            ['img' => '/image/ben_shine_spa.jpg', 'name' => 'Chi nhánh', 'loc' => 'Hà Nội']
        ] as $spa)
            <div class="bg-white rounded-xl shadow-lg border border-primary-100 hover:shadow-xl transition duration-300">
                <img class="w-full h-40 object-cover rounded-t-xl" src="{{ $spa['img'] }}" alt="{{ $spa['name'] }}">
                <div class="p-4 text-center">
                    <h3 class="text-xl font-playfair font-bold text-gray-800">{{ $spa['name'] }}</h3>
                    <p class="text-sm text-gray-500 mb-3">{{ $spa['loc'] }}</p>
                    <div class="flex justify-center items-center space-x-1 text-primary-200 mb-4">
                        <span class="text-xs">★★★★☆</span>
                        <span class="text-sm text-gray-600">4.5</span>
                    </div>
                    <button class="w-full bg-primary-200 text-white font-lora py-2 rounded-lg hover:bg-primary-225">
                        Xem chi tiết
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</section>
