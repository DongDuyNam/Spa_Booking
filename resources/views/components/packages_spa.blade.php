<section class="bg-primary-50 py-16" x-data="packageSlider({{ $packages->count() }})" x-init="init()">

    <h2 class="text-4xl font-playfair font-bold text-center mb-10 text-gray-800">
        Gói dịch vụ nổi bật
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
                :style="'transform: translateX(-' + (currentIndex * cardWidth) + 'px)'">

                @foreach ($packages as $pkg)
                    <div class="w-full sm:w-1/2 lg:w-1/4 px-3 flex-shrink-0 package-slider-item">

                        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl border border-primary-100 transition">

                            <!-- Ảnh -->
                            <img class="w-full h-40 object-cover rounded-t-xl"
                                src="{{ $pkg->thumbnail ? asset('storage/' . $pkg->thumbnail) : '/image/no-image.png' }}"
                                alt="{{ $pkg->name }}">

                            <div class="p-4 text-center">

                                <!-- Tên -->
                                <h3 class="text-xl font-playfair font-bold text-gray-800">
                                    {{ $pkg->name }}
                                </h3>

                                <!-- Giá -->
                                <p class="text-pink-600 font-semibold text-lg mb-2">
                                    {{ number_format($pkg->price, 0, ',', '.') }} đ
                                </p>

                                <!-- Hiệu lực -->
                                <p class="text-sm text-gray-500 mb-2">
                                    {{ $pkg->valid_from }} — {{ $pkg->valid_to }}
                                </p>

                                <!-- Giới hạn -->
                                <p class="text-xs text-gray-500 mb-3">
                                    Lượt sử dụng: {{ $pkg->limit_usage ?? 'Không giới hạn' }}
                                </p>

                                <!-- Đánh giá giả lập -->
                                <div class="flex justify-center items-center space-x-1 text-primary-200 mb-4">
                                    <span class="text-xs">★★★★★</span>
                                    <span class="text-sm text-gray-600">5.0</span>
                                </div>

                                <button
                                    class="w-full bg-primary-200 text-white font-lora py-2 rounded-lg hover:bg-primary-225">
                                    Xem chi tiết
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
    function packageSlider(totalCard) {
        return {
            currentIndex: 0,
            total: totalCard,
            cardWidth: 0,

            init() {
                this.updateWidth();
                window.addEventListener('resize', () => this.updateWidth());
            },

            updateWidth() {
                const card = document.querySelector('.package-slider-item');
                if (card) {
                    this.cardWidth = card.offsetWidth + 24; // cộng padding px-3
                }
            },

            visibleCount() {
                if (window.innerWidth >= 1024) return 4;
                if (window.innerWidth >= 640) return 2;
                return 1;
            },

            next() {
                if (this.currentIndex < this.total - this.visibleCount()) {
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