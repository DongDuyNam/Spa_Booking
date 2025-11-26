<section class="bg-primary-25 py-16"
         x-data="serviceSlider({{ $services->count() }})">

    <h2 class="text-4xl font-playfair font-bold text-center mb-10 text-gray-800">
        Dịch vụ ưa thích
    </h2>

    <div class="relative max-w-screen-xl mx-auto px-4">

        <!-- Nút trái -->
        <button @click="prev"
            class="absolute left-0 top-1/2 -translate-y-1/2 z-20 bg-white shadow-lg w-10 h-10 rounded-full flex items-center justify-center hover:bg-primary-200 transition">
            ❮
        </button>

        <!-- Nút phải -->
        <button @click="next"
            class="absolute right-0 top-1/2 -translate-y-1/2 z-20 bg-white shadow-lg w-10 h-10 rounded-full flex items-center justify-center hover:bg-primary-200 transition">
            ❯
        </button>

        <div class="overflow-hidden">
            <div class="flex transition-transform duration-500"
                 :style="'transform: translateX(-' + (currentIndex * cardWidth) + '%)'">

                @foreach ($services as $service)
                    <div class="w-full sm:w-1/2 lg:w-1/4 px-3 flex-shrink-0">

                        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl border border-primary-100 transition">

                            <!-- Thumbnail lấy từ DB -->
                            <img class="w-full h-40 object-cover rounded-t-xl"
                                 src="{{ $service->thumbnail ? asset('storage/' . $service->thumbnail) : '/image/default-service.jpg' }}"
                                 alt="{{ $service->name }}">

                            <div class="p-4 text-center">
                                <h3 class="text-xl font-playfair font-bold text-gray-800">
                                    {{ $service->name }}
                                </h3>

                                <p class="text-sm text-gray-500 h-12 overflow-hidden mb-3">
                                    {{ $service->description ?? '' }}
                                </p>

                                <button class="w-full bg-primary-200 text-white font-lora py-2 rounded-lg hover:bg-primary-225">
                                    Đặt ngay
                                </button>
                            </div>

                        </div>

                    </div>
                @endforeach

            </div>
        </div>

    </div>
</section>

<script>
    function serviceSlider(totalCard) {
        return {
            currentIndex: 0,
            total: totalCard,
            cardWidth: 25,

            next() {
                if (this.currentIndex < this.total - 4) {
                    this.currentIndex++;
                }
            },
            prev() {
                if (this.currentIndex > 0) {
                    this.currentIndex--;
                }
            }
        }
    }
</script>
