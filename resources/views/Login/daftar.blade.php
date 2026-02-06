<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-200 via-blue-300 to-blue-500 min-h-screen">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <h1 class="text-4xl font-bold text-center text-gray-800 mb-12">
                Daftar
            </h1>

            <form onsubmit="handleRegister(event)" class="space-y-6">
                <div>
                    <input
                        type="text"
                        id="registerUsername"
                        placeholder="Masukan Nama Akun"
                        class="w-full px-6 py-4 rounded-full border-2 border-gray-300 bg-white text-lg focus:outline-none focus:border-blue-500 transition-colors"
                        required
                    />
                </div>
                <div class="relative">
                    <input
                        type="password"
                        id="registerPassword"
                        placeholder="Masukan Kata Sandi"
                        class="w-full px-6 py-4 pr-14 rounded-full border-2 border-gray-300 bg-white text-lg focus:outline-none focus:border-blue-500 transition-colors"
                        required
                    />
                    <button
                        type="button"
                        onclick="togglePassword('registerPassword', 'eyeIcon1')"
                        class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-600 hover:text-gray-800 transition-colors"
                    >
                        <svg id="eyeIcon1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
                <div class="relative">
                    <input
                        type="password"
                        id="registerConfirmPassword"
                        placeholder="Masukan ulang Kata Sandi"
                        class="w-full px-6 py-4 pr-14 rounded-full border-2 border-gray-300 bg-white text-lg focus:outline-none focus:border-blue-500 transition-colors"
                        required
                    />
                    <button
                        type="button"
                        onclick="togglePassword('registerConfirmPassword', 'eyeIcon2')"
                        class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-600 hover:text-gray-800 transition-colors"
                    >
                        <svg id="eyeIcon2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
                <div>
                    <input
                        type="email"
                        id="registerEmail"
                        placeholder="Email"
                        class="w-full px-6 py-4 rounded-full border-2 border-gray-300 bg-white text-lg focus:outline-none focus:border-blue-500 transition-colors"
                        required
                    />
                </div>
                <div class="pt-6">
                    <button
                        type="submit"
                        class="w-full max-w-xs mx-auto block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-8 rounded-full text-xl transition-colors shadow-lg"
                    >
                        Daftar
                    </button>
                </div>
            </form>
            <div class="text-center mt-8">
                <a href="login" class="text-white text-lg hover:underline">
                    Kembali ke halaman login
                </a>
            </div>
        </div>
    </div>
</body>
</html>