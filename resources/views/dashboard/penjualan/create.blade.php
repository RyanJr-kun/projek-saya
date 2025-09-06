<x-layout>
    {{-- breadcrumb --}}
    @section('breadcrumb')
        @php
            $breadcrumbItems = [['name' => 'Penjualan', 'url' => route('penjualan.index')], ['name' => 'Buat Transaksi Baru', 'url' => '#']];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="row">
        {{-- Kolom Kiri: Daftar Produk --}}
        <div class="col-lg-7 ms-3">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-md-8">
                            <h6 class="mb-0">Daftar Produk</h6>
                            <p class="text-sm">Klik "Tambah" untuk menambahkan produk ke keranjang.</p>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" id="product-search" class="form-control" placeholder="Cari produk...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3" style="max-height: 300vh; overflow-y: auto;">
                    <div class="row" id="product-list">
                        @forelse ($produks as $produk)
                            <div class="col-md-6 col-xl-4 mb-4">
                                <div class="card h-100">
                                    <img class="card-img-top" src="{{ $produk->img_produk ? asset('storage/' . $produk->img_produk) : 'https://placehold.co/600x400/e9ecef/344767?text=' . urlencode($produk->nama_produk) }}" alt="Gambar Produk">
                                    <div class="card-body px-3 py-2">
                                        <h6 class="mb-0 product-name">{{ $produk->nama_produk }}</h6>
                                        <p class="text-sm mb-1">Stok: <span class="font-weight-bold">{{ $produk->qty }}</span></p>
                                        <p class="font-weight-bold text-lg mb-0">{{ $produk->harga }}</p>
                                    </div>
                                    <div class="card-footer pt-0 px-3 pb-2">
                                        <button class="btn btn-sm btn-primary w-100 mb-0 add-to-cart-btn"
                                            data-id="{{ $produk->id }}"
                                            data-nama="{{ $produk->nama_produk }}"
                                            data-harga="{{ $produk->harga }}"
                                            data-stok="{{ $produk->qty }}"
                                            {{ $produk->qty < 1 ? 'disabled' : '' }}>
                                            <i class="fas fa-plus me-1"></i> {{ $produk->qty < 1 ? 'Stok Habis' : 'Tambah' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center">
                                <p class="text-muted">Tidak ada produk yang tersedia.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Keranjang dan Pembayaran --}}
        <div class="col-lg-4 me-3">
            <form action="{{ route('penjualan.store') }}" method="POST" id="penjualanForm">
                @csrf
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Detail Pesanan</h6>
                                <p class="text-sm mb-0">Invoice: <span class="font-weight-bold">{{ $nomer_invoice }}</span></p>
                                <input type="hidden" name="nomer_invoice" value="{{ $nomer_invoice }}">
                            </div>
                            <span class="badge bg-gradient-success" id="cart-item-count">
                                <i class="fas fa-shopping-cart me-1"></i> 0 Item
                            </span>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        {{-- Pilihan Pelanggan --}}
                        <div class="mb-3">
                            <label for="pelanggan_id" class="form-label">Pelanggan</label>
                            <div class="input-group">
                                <select class="form-select" id="pelanggan_id" name="pelanggan_id">
                                    <option value="">-- Pelanggan Umum --</option>
                                    @foreach ($pelanggans as $pelanggan)
                                        <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-outline-primary mb-0" type="button" title="Tambah Pelanggan Baru" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Daftar Item di Keranjang --}}
                        <div id="cart-items-container" class="list-group list-group-flush" style="max-height: 250px; overflow-y: auto;">
                            <div class="text-center py-5 text-muted" id="cart-empty-message">
                                <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                                <p>Keranjang masih kosong</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer pt-0">
                        <hr class="mt-0">
                        {{-- Rincian Biaya --}}
                        <div class="d-flex justify-content-between">
                            <p class="text-sm">Subtotal</p>
                            <p class="text-sm font-weight-bold" id="subtotal">Rp 0</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-sm mb-0">Diskon (Rp)</p>
                            <div class="form-group mb-0" style="max-width: 120px;">
                                <input type="number" name="diskon" class="form-control form-control-sm text-end" value="0" min="0">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <p class="text-sm mb-0">Pajak (%)</p>
                            <div class="form-group mb-0" style="max-width: 120px;">
                                <input type="number" name="pajak" class="form-control form-control-sm text-end" value="11" min="0">
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-bold">Total</h6>
                            <h6 class="font-weight-bold" id="total-akhir">Rp 0</h6>
                        </div>

                        {{-- Metode Pembayaran & Catatan --}}
                        <div class="mt-3">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                            <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                                <option value="TUNAI">TUNAI</option>
                                <option value="DEBIT">DEBIT</option>
                                <option value="KREDIT">KREDIT</option>
                                <option value="QRIS">QRIS</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea name="catatan" id="catatan" rows="2" class="form-control"></textarea>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-grid gap-2 mt-3">
                            <button type="submit" class="btn btn-success" id="btn-save-transaction">
                                <i class="fas fa-save me-1"></i> Simpan Transaksi
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tambah Pelanggan -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">Tambah Pelanggan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCustomerForm" onsubmit="return false;">
                        <div class="mb-3">
                            <label for="nama_pelanggan" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama_pelanggan" required>
                        </div>
                        <div class="mb-3">
                            <label for="kontak_pelanggan" class="form-label">Kontak</label>
                            <input type="text" class="form-control" id="kontak_pelanggan" required>
                        </div>
                        <div class="mb-3">
                            <label for="email_pelanggan" class="form-label">Email (Opsional)</label>
                            <input type="email" class="form-control" id="email_pelanggan">
                        </div>
                        <div class="mb-3">
                            <label for="alamat_pelanggan" class="form-label">Alamat (Opsional)</label>
                            <textarea class="form-control" id="alamat_pelanggan" rows="2"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveCustomerBtn">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // --- UTILITIES ---
                const formatCurrency = (number) => new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(number);

                // --- STATE ---
                const cart = new Map(); // Using Map for easier item management

                // --- DOM ELEMENTS ---
                const productList = document.getElementById('product-list');
                const cartContainer = document.getElementById('cart-items-container');
                const cartEmptyMsg = document.getElementById('cart-empty-message');
                const cartItemCount = document.getElementById('cart-item-count');
                const subtotalEl = document.getElementById('subtotal');
                const diskonInput = document.querySelector('input[name="diskon"]');
                const pajakInput = document.querySelector('input[name="pajak"]');
                const totalAkhirEl = document.getElementById('total-akhir');
                const productSearchInput = document.getElementById('product-search');
                const mainForm = document.getElementById('penjualanForm');
                const saveButton = document.getElementById('btn-save-transaction');

                // --- FUNCTIONS ---
                const updateCartAndTotals = () => {
                    renderCart();
                    calculateTotals();
                    toggleSaveButton();
                };

                const addToCart = (id, nama, harga, stok) => {
                    id = parseInt(id);
                    harga = parseFloat(harga);
                    stok = parseInt(stok);

                    if (cart.has(id)) {
                        const item = cart.get(id);
                        if (item.jumlah < stok) {
                            item.jumlah++;
                        } else {
                            alert(`Stok untuk ${nama} tidak mencukupi.`);
                        }
                    } else {
                        if (stok > 0) {
                            cart.set(id, { id, nama, harga, jumlah: 1, stok });
                        } else {
                            alert(`${nama} kehabisan stok.`);
                        }
                    }
                    updateCartAndTotals();
                };

                const updateQuantity = (id, newQuantity) => {
                    if (!cart.has(id)) return;
                    const item = cart.get(id);
                    newQuantity = parseInt(newQuantity);

                    if (newQuantity > 0 && newQuantity <= item.stok) {
                        item.jumlah = newQuantity;
                    } else if (newQuantity > item.stok) {
                        item.jumlah = item.stok;
                        alert(`Stok maksimum untuk ${item.nama} adalah ${item.stok}.`);
                    } else {
                        cart.delete(id);
                    }
                    updateCartAndTotals();
                };

                const removeFromCart = (id) => {
                    cart.delete(id);
                    updateCartAndTotals();
                };

                const renderCart = () => {
                    cartContainer.innerHTML = '';
                    if (cart.size === 0) {
                        cartContainer.appendChild(cartEmptyMsg);
                        cartEmptyMsg.style.display = 'block';
                    } else {
                        if(cartEmptyMsg) cartEmptyMsg.style.display = 'none';
                        let formIndex = 0;
                        cart.forEach(item => {
                            const itemHtml = `
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-0 text-sm">${item.nama}</h6>
                                        <p class="mb-0 text-xs">${formatCurrency(item.harga)}</p>
                                        <input type="hidden" name="items[${formIndex}][produk_id]" value="${item.id}">
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="input-group input-group-sm" style="width: 100px;">
                                            <button class="btn btn-outline-secondary btn-sm mb-0 qty-decrease" data-id="${item.id}" type="button">-</button>
                                            <input type="number" class="form-control form-control-sm text-center mb-0 qty-input" name="items[${formIndex}][jumlah]" value="${item.jumlah}" min="1" max="${item.stok}" data-id="${item.id}">
                                            <button class="btn btn-outline-secondary btn-sm mb-0 qty-increase" data-id="${item.id}" type="button">+</button>
                                        </div>
                                        <button class="btn btn-link text-danger p-0 ms-2 mb-0 remove-item" data-id="${item.id}" title="Hapus Item" type="button">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            `;
                            cartContainer.insertAdjacentHTML('beforeend', itemHtml);
                            formIndex++;
                        });
                    }
                    const totalItems = Array.from(cart.values()).reduce((sum, item) => sum + item.jumlah, 0);
                    cartItemCount.innerHTML = `<i class="fas fa-shopping-cart me-1"></i> ${totalItems} Item`;
                };

                const calculateTotals = () => {
                    let subtotal = 0;
                    cart.forEach(item => {
                        subtotal += item.harga * item.jumlah;
                    });

                    const diskon = parseFloat(diskonInput.value) || 0;
                    const pajakPercent = parseFloat(pajakInput.value) || 0;

                    const subtotalAfterDiskon = subtotal - diskon;
                    const pajakAmount = subtotalAfterDiskon * (pajakPercent / 100);
                    const total = subtotalAfterDiskon + pajakAmount;

                    subtotalEl.textContent = formatCurrency(subtotal);
                    totalAkhirEl.textContent = formatCurrency(total);
                };

                const filterProducts = () => {
                    const searchTerm = productSearchInput.value.toLowerCase();
                    document.querySelectorAll('.product-card').forEach(card => {
                        const productName = card.querySelector('.product-name').textContent.toLowerCase();
                        card.style.display = productName.includes(searchTerm) ? 'block' : 'none';
                    });
                };

                const toggleSaveButton = () => {
                    saveButton.disabled = cart.size === 0;
                };

                // --- EVENT LISTENERS ---
                productList.addEventListener('click', (e) => {
                    const button = e.target.closest('.add-to-cart-btn');
                    if (button) {
                        e.preventDefault();
                        const { id, nama, harga, stok } = button.dataset;
                        addToCart(id, nama, harga, stok);
                    }
                });

                cartContainer.addEventListener('input', (e) => {
                    if (e.target.classList.contains('qty-input')) {
                        const id = parseInt(e.target.dataset.id);
                        updateQuantity(id, e.target.value);
                    }
                });

                cartContainer.addEventListener('click', (e) => {
                    const id = parseInt(e.target.closest('[data-id]')?.dataset.id);
                    if (!id) return;

                    if (e.target.classList.contains('qty-increase')) {
                        const item = cart.get(id);
                        updateQuantity(id, item.jumlah + 1);
                    } else if (e.target.classList.contains('qty-decrease')) {
                        const item = cart.get(id);
                        updateQuantity(id, item.jumlah - 1);
                    } else if (e.target.closest('.remove-item')) {
                        removeFromCart(id);
                    }
                });

                diskonInput.addEventListener('input', calculateTotals);
                pajakInput.addEventListener('input', calculateTotals);
                productSearchInput.addEventListener('keyup', filterProducts);

                mainForm.addEventListener('submit', (e) => {
                    if (cart.size === 0) {
                        e.preventDefault();
                        alert('Keranjang belanja kosong. Silakan tambahkan produk terlebih dahulu.');
                    }
                });

                // --- INITIALIZATION ---
                updateCartAndTotals();

                // --- MODAL PELANGGAN BARU (AJAX) ---
                const addCustomerModalEl = document.getElementById('addCustomerModal');
                const saveCustomerBtn = document.getElementById('saveCustomerBtn');
                const addCustomerForm = document.getElementById('addCustomerForm');
                const pelangganSelect = document.getElementById('pelanggan_id');

                saveCustomerBtn.addEventListener('click', async function() {
                    // 1. Hapus pesan error sebelumnya
                    addCustomerForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                    addCustomerForm.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

                    // 2. Kumpulkan data dari form modal
                    const data = {
                        nama: document.getElementById('nama_pelanggan').value,
                        kontak: document.getElementById('kontak_pelanggan').value,
                        email: document.getElementById('email_pelanggan').value,
                        alamat: document.getElementById('alamat_pelanggan').value,
                    };

                    try {
                        // 3. Kirim data ke controller menggunakan Fetch API
                        const response = await fetch("{{ route('pelanggan.store') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json' // Penting agar Laravel tahu ini permintaan AJAX
                            },
                            body: JSON.stringify(data)
                        });

                        const result = await response.json();

                        if (!response.ok) {
                            // 4. Tangani error validasi (status 422)
                            if (response.status === 422 && result.errors) {
                                Object.keys(result.errors).forEach(key => {
                                    const inputId = key + '_pelanggan'; // e.g., 'nama_pelanggan'
                                    const input = document.getElementById(inputId);
                                    if (input) {
                                        input.classList.add('is-invalid');
                                        const errorDiv = document.createElement('div');
                                        errorDiv.className = 'invalid-feedback';
                                        errorDiv.innerText = result.errors[key][0];
                                        // Sisipkan pesan error tepat di bawah input
                                        input.parentNode.insertBefore(errorDiv, input.nextSibling);
                                    }
                                });
                            } else {
                                throw new Error(result.message || 'Terjadi kesalahan server.');
                            }
                        } else {
                            // 5. Tangani respons sukses (status 201)
                            const newPelanggan = result.pelanggan;

                            // Tambahkan pelanggan baru ke dropdown dan langsung pilih
                            const newOption = new Option(newPelanggan.nama, newPelanggan.id, true, true);
                            pelangganSelect.appendChild(newOption);

                            // Tutup modal dan reset form
                            const modal = bootstrap.Modal.getInstance(addCustomerModalEl);
                            modal.hide();
                            addCustomerForm.reset();
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Gagal menyimpan pelanggan: ' + error.message);
                    }
                });
            });
        </script>
    @endpush
</x-layout>
