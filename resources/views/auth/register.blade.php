<x-guest-layout>
    <div class="text-center mb-6 pt-4">
        <h1 class="text-3xl font-bold text-primary-200 font-serif">ĐĂNG KÝ</h1>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="full_name" :value="__('Họ và tên')" class="text-gray" />
            <x-text-input id="full_name" class="block mt-1 w-full bg-primary-0" type="text" name="full_name"
                :value="old('full_name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-gray" />
            <x-text-input id="email" class="block mt-1 w-full  bg-primary-0" type="email" name="email"
                :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mật khẩu')" class="text-gray" />

            <x-text-input id="password" class="block mt-1 w-full  bg-primary-0" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4 ">
            <x-input-label for="password_confirmation" :value="__('Xác nhận mật khẩu')" class="text-gray" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-primary-0" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <a class="block mt-4 underline text-sm text-gray hover:text-black rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            href="{{ route('login') }}">
            {{ __('Đã có tài khoản?') }}
        </a>
        <div class="grid items-center justify-center mt-4">
            <x-primary-button
                class="font-serif text-white bg-primary-150 hover:bg-primary-200 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 ms-4">
                {{ __('Đăng ký') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>