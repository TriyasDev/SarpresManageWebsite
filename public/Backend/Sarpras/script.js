 const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const closeSidebarBtn = document.getElementById('closeSidebarBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        mobileMenuBtn.addEventListener('click', openSidebar);
        closeSidebarBtn.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);

        
        const menuLinks = sidebar.querySelectorAll('a');
        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    closeSidebar();
                }
            });
        });

        
        const barCtx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Peminjaman',
                    data: [125, 165, 120, 65, 85, 90, 80, 195, 170, 115, 110, 110],
                    backgroundColor: [
                        '#60A5FA', '#EC4899', '#9333EA', '#2DD4BF', 
                        '#34D399', '#FBBF24', '#FB923C', '#F97316', 
                        '#A3E635', '#F87171', '#64748B', '#475569'
                    ],
                    borderWidth: 0,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 200,
                        ticks: {
                            stepSize: 25,
                            font: { size: window.innerWidth < 640 ? 10 : 12 }
                        },
                        grid: { color: '#E5E7EB' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: {
                                size: window.innerWidth < 640 ? 10 : 12,
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });

        
        const donutCtx = document.getElementById('donutChart').getContext('2d');
        const donutChart = new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Prasarana', 'Media Pendidikan', 'Perlengkapan Kelas', 'Fasilitas Penunjang'],
                datasets: [{
                    data: [50, 15, 25, 10],
                    backgroundColor: ['#2DD4BF', '#FB923C', '#3B82F6', '#9333EA'],
                    borderWidth: 0,
                    cutout: '65%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed + '%';
                            }
                        }
                    }
                }
            }
        });

        
        window.addEventListener('resize', () => {
            const isMobile = window.innerWidth < 640;
            const fontSize = isMobile ? 10 : 12;
            
            barChart.options.scales.y.ticks.font.size = fontSize;
            barChart.options.scales.x.ticks.font.size = fontSize;
            barChart.update();
        });