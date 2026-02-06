  let asetData = [
            {
                id: 1,
                merek: 'Laptop HP Pavilion',
                kategori: 'Elektronik',
                deskripsi: 'Laptop untuk kantor',
                kondisi: 'Bagus',
                status: 'Bagus',
                image: null
            },
        ];

        let uploadedImage = null;
        let currentEditId = null;

        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('sidebar');

        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('sidebar-hidden');
        });
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 1024) {
                if (!sidebar.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                    sidebar.classList.add('sidebar-hidden');
                }
            }
        });

        const uploadArea = document.getElementById('uploadArea');
        const photoInput = document.getElementById('photoInput');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const removeImageBtn = document.getElementById('removeImage');

        uploadArea.addEventListener('click', (e) => {
            if (!e.target.closest('#removeImage')) {
                photoInput.click();
            }
        });

        photoInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    uploadedImage = e.target.result;
                    previewImg.src = uploadedImage;
                    uploadPlaceholder.classList.add('hidden');
                    imagePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        removeImageBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            uploadedImage = null;
            photoInput.value = '';
            uploadPlaceholder.classList.remove('hidden');
            imagePreview.classList.add('hidden');
        });
        function renderCards(data = asetData) {
            const container = document.getElementById('cardsContainer');
            container.innerHTML = '';

            data.forEach(item => {
                const card = document.createElement('div');
                card.className = 'bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1';
                
                const statusClass = item.status.toLowerCase().includes('rusak') ? 'bg-red-500' : 'bg-blue-500';
                const statusText = item.status.toLowerCase().includes('rusak') ? 'sedikit rusak' : 'Bagus';
                
                card.innerHTML = `
                    <div class="relative">
                        <span class="absolute top-3 right-3 px-4 py-1.5 ${statusClass} text-white rounded-full text-sm font-medium shadow-md z-10">
                            ${statusText}
                        </span>
                        <div class="h-56 bg-gray-100 flex items-center justify-center overflow-hidden">
                            ${item.image ? 
                                `<img src="${item.image}" alt="${item.merek}" class="w-full h-full object-cover">` :
                                `<span class="text-5xl font-bold text-gray-300">Gambar</span>`
                            }
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="space-y-2 mb-5">
                            <p class="text-sm text-gray-700"><span class="font-semibold">Merek :</span> ${item.merek}</p>
                            <p class="text-sm text-gray-700"><span class="font-semibold">Kategori :</span> ${item.kategori}</p>
                            <p class="text-sm text-gray-700"><span class="font-semibold">Deskripsi :</span> ${item.deskripsi}</p>
                        </div>
                        
                        <div class="flex gap-3">
                            <button onclick="editAset(${item.id})" class="flex-1 bg-blue-500 text-white py-2.5 rounded-lg hover:bg-blue-600 transition font-medium">
                                Edit
                            </button>
                            <button onclick="deleteAset(${item.id})" class="flex-1 bg-red-500 text-white py-2.5 rounded-lg hover:bg-red-600 transition font-medium">
                                Hapus
                            </button>
                        </div>
                    </div>
                `;
                
                container.appendChild(card);
            });
        }
        document.getElementById('simpanBtn').addEventListener('click', () => {
            const merek = document.getElementById('namaMerek').value.trim();
            const kategori = document.getElementById('kategori').value;
            const deskripsi = document.getElementById('deskripsi').value.trim();
            const kondisi = document.getElementById('kondisi').value.trim();

            if (!merek || !kategori || !deskripsi || !kondisi) {
                alert('Mohon lengkapi semua field!');
                return;
            }

            const newId = Math.max(...asetData.map(a => a.id), 0) + 1;
            const newAset = {
                id: newId,
                merek,
                kategori,
                deskripsi,
                kondisi,
                status: kondisi,
                image: uploadedImage
            };

            asetData.unshift(newAset);
            renderCards();

            document.getElementById('namaMerek').value = '';
            document.getElementById('kategori').value = '';
            document.getElementById('deskripsi').value = '';
            document.getElementById('kondisi').value = '';
            uploadedImage = null;
            photoInput.value = '';
            uploadPlaceholder.classList.remove('hidden');
            imagePreview.classList.add('hidden');

            alert('Aset berhasil ditambahkan!');
        });

        function editAset(id) {
            currentEditId = id;
            const aset = asetData.find(a => a.id === id);
            
            if (aset) {
                document.getElementById('editNamaMerek').value = aset.merek;
                document.getElementById('editKategori').value = aset.kategori;
                document.getElementById('editDeskripsi').value = aset.deskripsi;
                document.getElementById('editKondisi').value = aset.kondisi;
                
                document.getElementById('editModal').classList.remove('hidden');
            }
        }
        document.getElementById('saveEdit').addEventListener('click', () => {
            const aset = asetData.find(a => a.id === currentEditId);
            
            if (aset) {
                aset.merek = document.getElementById('editNamaMerek').value;
                aset.kategori = document.getElementById('editKategori').value;
                aset.deskripsi = document.getElementById('editDeskripsi').value;
                aset.kondisi = document.getElementById('editKondisi').value;
                aset.status = aset.kondisi;
                
                renderCards();
                document.getElementById('editModal').classList.add('hidden');
                alert('Aset berhasil diupdate!');
            }
        });
        document.getElementById('closeModal').addEventListener('click', () => {
            document.getElementById('editModal').classList.add('hidden');
        });

        document.getElementById('cancelEdit').addEventListener('click', () => {
            document.getElementById('editModal').classList.add('hidden');
        });

        // hapus data didieu yass
        function deleteAset(id) {
            if (confirm('Apakah Anda yakin ingin menghapus aset ini?')) {
                asetData = asetData.filter(a => a.id !== id);
                renderCards();
                alert('Aset berhasil dihapus!');
            }
        }

        document.getElementById('searchInput').addEventListener('input', (e) => {
            filterData();
        });

        document.getElementById('filterKategori').addEventListener('change', () => {
            filterData();
        });

        function filterData() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const kategoriFilter = document.getElementById('filterKategori').value;

            let filtered = asetData;

            if (searchTerm) {
                filtered = filtered.filter(item => 
                    item.merek.toLowerCase().includes(searchTerm) ||
                    item.deskripsi.toLowerCase().includes(searchTerm) ||
                    item.kondisi.toLowerCase().includes(searchTerm)
                );
            }

            if (kategoriFilter) {
                filtered = filtered.filter(item => item.kategori === kategoriFilter);
            }

            renderCards(filtered);
        }
        renderCards();