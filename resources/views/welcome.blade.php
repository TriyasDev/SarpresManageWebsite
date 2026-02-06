<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMK BBC - Pinjam Monitor & Laptop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        .animate-slide-in {
            animation: slideInLeft 0.8s ease-out;
        }
    </style>
</head>
<body class="font-sans overflow-x-hidden">
    <!-- Navbar -->
    <nav class="flex justify-between items-center px-20 py-5 bg-white shadow-md sticky top-0 z-50 transition-all duration-300 hover:shadow-xl">
        <div class="flex items-center gap-4">
            <img src="{{ asset('Backend/bbc.jpg') }}"alt="SMK Budi Bakti Logo" class="w-12 h-12 transition-transform duration-300 hover:rotate-360">
            <div class="text-2xl font-bold text-gray-800">SMK BBC.</div>
        </div>
        <div class="flex gap-10 items-center">
            <a href="#beranda" class="text-gray-600 text-sm transition-all duration-300 hover:text-blue-600 relative after:content-[''] after:absolute after:bottom-[-5px] after:left-0 after:w-0 after:h-0.5 after:bg-blue-600 after:transition-all after:duration-300 hover:after:w-full">Beranda</a>
            <a href="#Kami" class="text-gray-600 text-sm transition-all duration-300 hover:text-blue-600 relative after:content-[''] after:absolute after:bottom-[-5px] after:left-0 after:w-0 after:h-0.5 after:bg-blue-600 after:transition-all after:duration-300 hover:after:w-full">Mengapa kami?</a>
            <a href="#sarana" class="text-gray-600 text-sm transition-all duration-300 hover:text-blue-600 relative after:content-[''] after:absolute after:bottom-[-5px] after:left-0 after:w-0 after:h-0.5 after:bg-blue-600 after:transition-all after:duration-300 hover:after:w-full">Sarana/Prasarana</a>
            <a href="#pinjam" class="text-gray-600 text-sm transition-all duration-300 hover:text-blue-600 relative after:content-[''] after:absolute after:bottom-[-5px] after:left-0 after:w-0 after:h-0.5 after:bg-blue-600 after:transition-all after:duration-300 hover:after:w-full">Pinjam</a>
            <a href="login" class="px-6 py-2 rounded border border-gray-300 bg-white text-gray-800 text-sm transition-all duration-300 hover:bg-gray-100 hover:-translate-y-0.5 hover:shadow-md">Login</a>
            <a href="daftar" class="px-6 py-2 rounded bg-black text-white text-sm transition-all duration-300 hover:bg-gray-800 hover:-translate-y-0.5 hover:shadow-lg">Daftar</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="flex px-20 py-20 items-center bg-linear-to-r from-white via-yellow-50 to-white min-h-[500px] relative" id="beranda">
        <div class="flex-1 animate-slide-in">
            <h1 class="text-[42px] mb-5 text-gray-800 leading-tight">Sulit pinjam monitor,laptop dan lainnya?karena tidak ada pengawas?</h1>
            <p class="text-base text-gray-600 leading-relaxed mb-8">Ingin tepat dana dengan web pinjam sampai memudahkan insan/guru untuk meminjam laptop dengan disiplin untuk kebersihan ketika ingin meminjam.</p>
        </div>
        <div class="flex-1 flex justify-center items-center relative w-full">
            <img src="heroo.png" alt="" class="max-w-full h-auto">
        </div>
    </section>

    <!-- Features Section -->
    <section class="px-20 py-10">
        <h2 class="text-center my-15 relative text-2xl text-gray-800 before:content-[''] before:absolute before:top-1/2 before:right-[60%] before:mr-5 before:w-24 before:h-px before:bg-gray-300 after:content-[''] after:absolute after:top-1/2 after:left-[60%] after:ml-5 after:w-24 after:h-px after:bg-gray-300" id="Kami">Mengapa Pilih kami?</h2>

        <div class="grid grid-cols-4 gap-8 mb-20">
            <div class="bg-white border border-gray-200 rounded-lg p-8 text-center transition-all duration-300 cursor-pointer hover:-translate-y-2 hover:shadow-2xl hover:border-blue-600 opacity-0">
                <div class="w-15 h-15 bg-gray-100 mx-auto mb-5 rounded-lg flex items-center justify-center text-xs text-gray-400 transition-all duration-300 group-hover:bg-blue-600 group-hover:text-white group-hover:rotate-6">Icon</div>
                <h3 class="text-base mb-2 text-gray-800">Mudah dan Satset</h3>
                <p class="text-sm text-gray-600 leading-relaxed">tanpa ribet bagi nyari nyari pengawas</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-8 text-center transition-all duration-300 cursor-pointer hover:-translate-y-2 hover:shadow-2xl hover:border-blue-600 opacity-0">
                <div class="w-15 h-15 bg-gray-100 mx-auto mb-5 rounded-lg flex items-center justify-center text-xs text-gray-400 transition-all duration-300">Icon</div>
                <h3 class="text-base mb-2 text-gray-800">Mudah dan Satset</h3>
                <p class="text-sm text-gray-600 leading-relaxed">tanpa ribet bagi nyari nyari pengawas</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-8 text-center transition-all duration-300 cursor-pointer hover:-translate-y-2 hover:shadow-2xl hover:border-blue-600 opacity-0">
                <div class="w-15 h-15 bg-gray-100 mx-auto mb-5 rounded-lg flex items-center justify-center text-xs text-gray-400 transition-all duration-300">Icon</div>
                <h3 class="text-base mb-2 text-gray-800">Mudah dan Satset</h3>
                <p class="text-sm text-gray-600 leading-relaxed">tanpa ribet bagi nyari nyari pengawas</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-8 text-center transition-all duration-300 cursor-pointer hover:-translate-y-2 hover:shadow-2xl hover:border-blue-600 opacity-0">
                <div class="w-15 h-15 bg-gray-100 mx-auto mb-5 rounded-lg flex items-center justify-center text-xs text-gray-400 transition-all duration-300">Icon</div>
                <h3 class="text-base mb-2 text-gray-800">Mudah dan Satset</h3>
                <p class="text-sm text-gray-600 leading-relaxed">tanpa ribet bagi nyari nyari pengawas</p>
            </div>
        </div>

        <h2 class="text-center my-15 relative text-2xl text-gray-800 before:content-[''] before:absolute before:top-1/2 before:right-[60%] before:mr-5 before:w-24 before:h-px before:bg-gray-300 after:content-[''] after:absolute after:top-1/2 after:left-[60%] after:ml-5 after:w-24 after:h-px after:bg-gray-300" id="sarana">Sarana/Prasarana</h2>

        <div class="grid grid-cols-4 gap-8 mb-20">
            <div class="bg-white border border-gray-200 rounded-lg p-8 text-center transition-all duration-300 cursor-pointer hover:-translate-y-2 hover:shadow-2xl hover:border-blue-600 opacity-0">
                <img src="monitor.png" alt="" class="w-[70%] mx-auto mb-4">
                <h3 class="text-base mb-2 text-gray-800">Laptop</h3>
                <p class="text-sm text-gray-600 leading-relaxed">30 monitor Tersedia<br>pinjam sekarang juga</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-8 text-center transition-all duration-300 cursor-pointer hover:-translate-y-2 hover:shadow-2xl hover:border-blue-600 opacity-0">
                <img src="Laptop.png" alt="" class="w-[70%] mx-auto mb-4">
                <h3 class="text-base mb-2 text-gray-800">Laptop</h3>
                <p class="text-sm text-gray-600 leading-relaxed">20 Tersedia</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-8 text-center transition-all duration-300 cursor-pointer hover:-translate-y-2 hover:shadow-2xl hover:border-blue-600 opacity-0">
                <img src="bbc.jpg" alt="" class="w-[70%] mx-auto mb-4">
                <h3 class="text-base mb-2 text-gray-800">Monitor</h3>
                <p class="text-sm text-gray-600 leading-relaxed">23 Tersedia</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-8 text-center transition-all duration-300 cursor-pointer hover:-translate-y-2 hover:shadow-2xl hover:border-blue-600 opacity-0">
                <img src="bbc.jpg" alt="" class="w-[70%] mx-auto mb-4">
                <h3 class="text-base mb-2 text-gray-800">Sapu</h3>
                <p class="text-sm text-gray-600 leading-relaxed">45 Tersedia</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-8 text-center transition-all duration-300 cursor-pointer hover:-translate-y-2 hover:shadow-2xl hover:border-blue-600 opacity-0">
                <img src="bbc.jpg" alt="" class="w-[70%] mx-auto mb-4">
                <h3 class="text-base mb-2 text-gray-800">Lapangan</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Tidak Tersedia<br>Silahkan Cek lagi Nanti</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-8 text-center transition-all duration-300 cursor-pointer hover:-translate-y-2 hover:shadow-2xl hover:border-blue-600 opacity-0">
                <img src="bbc.jpg" alt="" class="w-[70%] mx-auto mb-4">
                <h3 class="text-base mb-2 text-gray-800">Ruang Bk</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Tersedia</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-8 text-center transition-all duration-300 cursor-pointer hover:-translate-y-2 hover:shadow-2xl hover:border-blue-600 opacity-0">
                <img src="bbc.jpg" alt="" class="w-[70%] mx-auto mb-4">
                <h3 class="text-base mb-2 text-gray-800">Papan Tulis</h3>
                <p class="text-sm text-gray-600 leading-relaxed">5 Tersedia</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-8 text-center transition-all duration-300 cursor-pointer hover:-translate-y-2 hover:shadow-2xl hover:border-blue-600 opacity-0">
                <img src="bbc.jpg" alt="" class="w-[70%] mx-auto mb-4">
                <h3 class="text-base mb-2 text-gray-800">Aula 2</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Tersedia</p>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="px-20 py-10 pb-20" id="pinjam">
        <h2 class="text-center my-15 relative text-2xl text-gray-800 before:content-[''] before:absolute before:top-1/2 before:right-[60%] before:mr-5 before:w-24 before:h-px before:bg-gray-300 after:content-[''] after:absolute after:top-1/2 after:left-[60%] after:ml-5 after:w-24 after:h-px after:bg-gray-300">Pinjam</h2>

        <div class="grid grid-cols-3 gap-8">
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden transition-all duration-300 cursor-pointer hover:scale-105 hover:shadow-2xl opacity-0">
                <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-lg text-gray-400 transition-all duration-300">Foto</div>
                <div class="p-5">
                    <h3 class="text-lg mb-2 text-gray-800">Monitor</h3>
                    <button class="w-full py-3 bg-black text-white border-none cursor-pointer text-sm transition-all duration-300 hover:bg-blue-600 hover:-translate-y-0.5">Pinjam Sekarang</button>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden transition-all duration-300 cursor-pointer hover:scale-105 hover:shadow-2xl opacity-0">
                <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-lg text-gray-400 transition-all duration-300">Foto</div>
                <div class="p-5">
                    <h3 class="text-lg mb-2 text-gray-800">Monitor</h3>
                    <button class="w-full py-3 bg-black text-white border-none cursor-pointer text-sm transition-all duration-300 hover:bg-blue-600 hover:-translate-y-0.5">Pinjam Sekarang</button>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden transition-all duration-300 cursor-pointer hover:scale-105 hover:shadow-2xl opacity-0">
                <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-lg text-gray-400 transition-all duration-300">Foto</div>
                <div class="p-5">
                    <h3 class="text-lg mb-2 text-gray-800">Monitor</h3>
                    <button class="w-full py-3 bg-black text-white border-none cursor-pointer text-sm transition-all duration-300 hover:bg-blue-600 hover:-translate-y-0.5">Pinjam Sekarang</button>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden transition-all duration-300 cursor-pointer hover:scale-105 hover:shadow-2xl opacity-0">
                <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-lg text-gray-400 transition-all duration-300">Foto</div>
                <div class="p-5">
                    <h3 class="text-lg mb-2 text-gray-800">Monitor</h3>
                    <button class="w-full py-3 bg-black text-white border-none cursor-pointer text-sm transition-all duration-300 hover:bg-blue-600 hover:-translate-y-0.5">Pinjam Sekarang</button>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden transition-all duration-300 cursor-pointer hover:scale-105 hover:shadow-2xl opacity-0">
                <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-lg text-gray-400 transition-all duration-300">Foto</div>
                <div class="p-5">
                    <h3 class="text-lg mb-2 text-gray-800">Monitor</h3>
                    <button class="w-full py-3 bg-black text-white border-none cursor-pointer text-sm transition-all duration-300 hover:bg-blue-600 hover:-translate-y-0.5">Pinjam Sekarang</button>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden transition-all duration-300 cursor-pointer hover:scale-105 hover:shadow-2xl opacity-0">
                <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-lg text-gray-400 transition-all duration-300">Foto</div>
                <div class="p-5">
                    <h3 class="text-lg mb-2 text-gray-800">Monitor</h3>
                    <button class="w-full py-3 bg-black text-white border-none cursor-pointer text-sm transition-all duration-300 hover:bg-blue-600 hover:-translate-y-0.5">Pinjam Sekarang</button>
                </div>
            </div>
        </div>

        <div class="text-center p-10">
            <a href="#" class="inline-block px-10 py-4 bg-white text-gray-800 no-underline rounded border border-gray-300 transition-all duration-300 text-base hover:bg-blue-600 hover:text-white hover:border-blue-600 hover:translate-x-2">Lihat lainnya →</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-blue-600 to-blue-800 text-white px-20 pt-15 pb-8 mt-20">
        <h2 class="text-center text-2xl mb-10">Sarpars</h2>
        <div class="flex justify-center gap-15 mb-10">
            <a href="#" class="text-white no-underline text-sm transition-all duration-300 relative hover:-translate-y-1 after:content-[''] after:absolute after:bottom-[-5px] after:left-0 after:w-0 after:h-0.5 after:bg-white after:transition-all after:duration-300 hover:after:w-full">Beranda</a>
            <a href="#" class="text-white no-underline text-sm transition-all duration-300 relative hover:-translate-y-1 after:content-[''] after:absolute after:bottom-[-5px] after:left-0 after:w-0 after:h-0.5 after:bg-white after:transition-all after:duration-300 hover:after:w-full">Pinjam</a>
            <a href="#" class="text-white no-underline text-sm transition-all duration-300 relative hover:-translate-y-1 after:content-[''] after:absolute after:bottom-[-5px] after:left-0 after:w-0 after:h-0.5 after:bg-white after:transition-all after:duration-300 hover:after:w-full">mengapa kami</a>
            <a href="#" class="text-white no-underline text-sm transition-all duration-300 relative hover:-translate-y-1 after:content-[''] after:absolute after:bottom-[-5px] after:left-0 after:w-0 after:h-0.5 after:bg-white after:transition-all after:duration-300 hover:after:w-full">kemdang kulira</a>
            <a href="#" class="text-white no-underline text-sm transition-all duration-300 relative hover:-translate-y-1 after:content-[''] after:absolute after:bottom-[-5px] after:left-0 after:w-0 after:h-0.5 after:bg-white after:transition-all after:duration-300 hover:after:w-full">FAQS</a>
        </div>
    </footer>

    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if(target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar shadow on scroll
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if(window.scrollY > 50) {
                nav.classList.add('shadow-xl');
            } else {
                nav.classList.remove('shadow-xl');
            }
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if(entry.isIntersecting) {
                    entry.target.style.animation = 'slideInLeft 0.8s ease-out';
                    entry.target.style.opacity = '1';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.opacity-0').forEach(card => {
            observer.observe(card);
        });
    </script>
</body>
</html>
