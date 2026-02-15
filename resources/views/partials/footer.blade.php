<footer class="bg-linear-to-br from-gray-900 via-gray-800 to-gray-900 text-white mt-20">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
        {{-- Footer Top --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            {{-- Brand --}}
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-xl font-bold">KlikA<span class="text-blue-400">set.</span></span>
                </div>
                <p class="text-sm text-gray-400 leading-relaxed mb-4">
                    Sistem peminjaman aset sekolah yang mudah, cepat, dan terpercaya untuk SMK BBC. Kelola peminjaman dengan lebih efisien.
                </p>
                <div class="flex gap-3">
                    <a href="#" class="w-9 h-9 rounded-full bg-gray-700 flex items-center justify-center hover:bg-blue-600 transition-colors">
                        <x-icon-facebook class="w-5 h-5" />
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full bg-gray-700 flex items-center justify-center hover:bg-blue-600 transition-colors">
                        <x-icon-instagram class="w-4 h-4" />
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full bg-gray-700 flex items-center justify-center hover:bg-blue-600 transition-colors">
                        <x-icon-x class="w-4 h-4" />
                    </a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h3 class="text-sm font-semibold mb-4">Menu Utama</h3>
                <ul class="space-y-2">
                    <li><a href="#beranda" class="text-sm text-gray-400 hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="#mengapa-kami" class="text-sm text-gray-400 hover:text-white transition-colors">Mengapa Kami</a></li>
                    <li><a href="#sarana" class="text-sm text-gray-400 hover:text-white transition-colors">Sarana/Prasarana</a></li>
                    <li><a href="#pinjam" class="text-sm text-gray-400 hover:text-white transition-colors">Pinjam</a></li>
                </ul>
            </div>

            {{-- Contact Info --}}
            <div>
                <h3 class="text-sm font-semibold mb-4">Hubungi Kami</h3>
                <ul class="space-y-2">
                    <li class="text-sm text-gray-400">
                        <span class="block">KlikAset</span>
                    </li>
                    <li class="text-sm text-gray-400">
                        <span class="block">Email: info@smkbbc.sch.id</span>
                    </li>
                    <li class="text-sm text-gray-400">
                        <span class="block">Telp: +6281-2345-6789 </span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Footer Bottom --}}
        <div class="pt-8 border-t border-gray-700">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-400">
                    © {{ date('Y') }} KlikAset SMK BBC. All rights reserved.
                </p>
                <div class="flex gap-6">
                    <a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>
</footer>
