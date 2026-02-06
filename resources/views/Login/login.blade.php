<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-200 via-blue-300 to-blue-500 min-h-screen"> 
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <h1 class="text-4xl font-bold text-center text-gray-800 mb-12">
                Log In
            </h1>
            <form onsubmit="handleLogin(event)" class="space-y-6">  
                <div>
                    <input
                        type="text"
                        id="loginUsername"
                        placeholder="Nama Akun"
                        class="w-full px-6 py-4 rounded-full border-2 border-gray-300 bg-white text-lg focus:outline-none focus:border-blue-500 transition-colors"
                        required
                    />
                </div>
                <div>
                    <input
                        type="password"
                        id="loginPassword"
                        placeholder="Kata Sandi"
                        class="w-full px-6 py-4 rounded-full border-2 border-gray-300 bg-white text-lg focus:outline-none focus:border-blue-500 transition-colors"
                        required
                    />
                </div>
                <div class="flex items-center justify-between px-2">
                    <label class="flex items-center cursor-pointer">
                        <input
                            type="checkbox"
                            id="showLoginPassword"
                            onchange="togglePassword(this.checked)"
                            class="w-5 h-5 mr-3 rounded border-2 border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500 cursor-pointer"
                        />
                        <span class="text-gray-800 text-lg">Tampilkan Sandi</span>
                    </label>
                    <a href="{{ asset('lupa') }}" class="text-blue-700 text-lg hover:underline">
                        Lupa kata sandi?
                    </a>
                </div>
                <div class="pt-6">
                    <button
                        type="submit"
                        class="w-full max-w-xs mx-auto block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-8 rounded-full text-xl transition-colors shadow-lg"
                    >
                        Login
                    </button>
                </div>
            </form>

            
            <div class="text-center mt-8">
                <a href="daftar" class="text-white text-lg hover:underline">
                    Tidak mempunyai akun? Daftar
                </a>
            </div>
        </div>
    </div>

</body>
</html>