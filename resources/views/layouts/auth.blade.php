<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'KlikAset - Login')</title>
    <link rel="preload" as="image" href="{{ asset('images/assets/universitas0.webp') }}">
    <link rel="preload" as="image" href="{{ asset('images/assets/universitas1.webp') }}">
    <link rel="preload" as="image" href="{{ asset('images/assets/universitas2.webp') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-linear-to-br from-slate-50 to-blue-50/50 min-h-screen flex items-center justify-center p-4">

    <!-- Main Content -->
    <div class="relative w-full">
        @yield('content')
    </div>

</body>
</html>
