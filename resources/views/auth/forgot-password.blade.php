<x-guest-layout>
    <div class="font-playfair mb-4 text-sm text-black">
        {{ __('Quên mật khẩu của bạn? Không sao cả. Chỉ cần cho chúng tôi biết địa chỉ email của bạn và chúng tôi sẽ gửi cho bạn một liên kết đặt lại mật khẩu để bạn có thể chọn mật khẩu mới.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray"/>
            <x-text-input id="email" class="block mt-1 w-full bg-primary-0" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4 font-playfair ">
            <x-primary-button class="bg-primary-150 hover:bg-primary-200">
                {{ __('Liên kết Đặt lại Mật khẩu Email') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
