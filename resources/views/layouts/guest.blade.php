<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body style="background-image: url('{{ asset('image/image_in_login/bg-login.jpg') }}');
             background-size: cover;
             background-position: center;
             background-repeat: no-repeat;"
      class="font-serif text-gray-900 antialiased">

    <div class="min-h-screen flex flex-col justify-center items-center bg-black/10 backdrop-blur-sm px-4">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="/" class="inline-block">
                <img src="{{ asset('image/logo.png') }}" 
                     alt="AnhDuong Spa" 
                     class="w-36 sm:w-44 md:w-80 h-auto mx-auto drop-shadow-lg">
            </a>
        </div>

        <!-- Login Card -->
        <div class="w-full sm:max-w-md px-6 py-8 bg-white/90 rounded-2xl shadow-2xl backdrop-blur-md border border-white/30">
            {{ $slot }}
        </div>
    </div>

</body>
</html>
