<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'KlikAset - Login')</title>
    <!-- Preload gambar slider -->
    <link rel="preload" as="image" href="{{ asset('images/assets/universitas0.webp') }}">
    <link rel="preload" as="image" href="{{ asset('images/assets/universitas1.webp') }}">
    <link rel="preload" as="image" href="{{ asset('images/assets/universitas2.webp') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-linear-to-br from-costume-primary via-costume-primary to-costume-second min-h-screen flex items-center justify-center p-4">

    <!-- Background Pattern -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
    </div>

    <!-- Main Content -->
    <div class="relative w-full">
        @yield('content')
    </div>

</body>
</html>
