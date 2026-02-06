<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-200 via-blue-300 to-blue-500 min-h-screen">  
    <div id="stepVerifikasi" class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <h1 class="text-4xl font-bold text-center text-gray-800 mb-12">
                Lupa Kata Sandi
            </h1>
            <form onsubmit="handleVerifikasi(event)" class="space-y-6"> 
                <div class="flex gap-3">
                    <input
                        type="email"
                        id="emailVerifikasi"
                        placeholder="email yang terkait"
                        class="flex-1 px-6 py-4 rounded-full border-2 border-gray-300 bg-white text-lg focus:outline-none focus:border-blue-500 transition-colors"
                        required
                    />
                    <button
                        type="button"
                        onclick="kirimKode()"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-4 rounded-lg text-base transition-colors whitespace-nowrap leading-tight"
                    >
                        Kirim Kode<br>Verifikasi
                    </button>
                </div>
               
                <div>
                    <input
                        type="text"
                        id="kodeVerifikasi"
                        placeholder="Masukan kode"
                        class="w-full px-6 py-4 rounded-full border-2 border-gray-300 bg-white text-lg focus:outline-none focus:border-blue-500 transition-colors"
                        required
                    />
                </div>

                
                <div class="pt-6">
                    <button
                        type="submit"
                        class="w-full max-w-xs mx-auto block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-8 rounded-full text-xl transition-colors shadow-lg"
                    >
                        Konfirmasi
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

    
    <div id="stepReset" class="hidden min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <h1 class="text-4xl font-bold text-center text-gray-800 mb-12">
                Lupa Kata Sandi
            </h1>
            <form onsubmit="handleResetPassword(event)" class="space-y-6">  
                <div>
                    <input
                        type="password"
                        id="passwordBaru"
                        placeholder="Buat Katasandi Baru"
                        class="w-full px-6 py-4 rounded-full border-2 border-gray-300 bg-white text-lg focus:outline-none focus:border-blue-500 transition-colors"
                        required
                    />
                </div>
                <div>
                    <input
                        type="password"
                        id="konfirmasiPassword"
                        placeholder="Konfirmasi Katasandi"
                        class="w-full px-6 py-4 rounded-full border-2 border-gray-300 bg-white text-lg focus:outline-none focus:border-blue-500 transition-colors"
                        required
                    />
                </div>
                <div class="px-2">
                    <label class="flex items-center cursor-pointer">
                        <input
                            type="checkbox"
                            id="tampilkanSandi"
                            onchange="togglePasswordReset(this.checked)"
                            class="w-5 h-5 mr-3 rounded border-2 border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500 cursor-pointer"
                        />
                        <span class="text-gray-800 text-lg">Tampilkan Sandi</span>
                    </label>
                </div>
                <div class="pt-6">
                    <button
                        type="submit"
                        class="w-full max-w-xs mx-auto block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-8 rounded-full text-xl transition-colors shadow-lg"
                    >
                        konfirmasi
                    </button>
                </div>
            </form>
            <div class="text-center mt-8">
                <a href="login.html" class="text-white text-lg hover:underline">
                    Kembali ke halaman login
                </a>
            </div>
        </div>
    </div>

</body>
</html>