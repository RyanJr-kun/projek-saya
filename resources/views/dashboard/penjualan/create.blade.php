<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/logo.svg') }}">
            <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
            <link rel="apple-touch-icon" href="{{ asset('assets/img/apple-touch-icon.png') }}">

            <title>Point Of Sales - JO Computer</title>

             @vite(['resources/scss/app.scss', 'resources/js/app.js'])
            <!--     Fonts and icons     -->
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
            <script src="https://kit.fontawesome.com/939a218158.js" crossorigin="anonymous"></script>
            <script async defer src="https://buttons.github.io/buttons.js"></script>

        </head>
    <body class="bg-gray-100 ">
        <nav class="navbar navbar-main navbar-expand-lg border-bottom sticky-top" style="height: 70px; background-color: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px);">
            <div class="container-fluid">
                <a class="navbar-brand ms-n3 pt-2 mt-n3 m-md-0" href="/dashboard" target="_blank">
                    <img src="{{ asset('assets/img/logomiring.svg') }}" class="navbar-brand" alt="Logo Jo Computer" style="height: 60px;">
                </a>
                <div class="text-white rounded px-3 py-1 mt-n2 ms-n6 m-md-2  d-flex align-items-center order-lg-2 ms-auto ms-lg-2" style="background-color: #1f8f6d;">
                    <i class="bi bi-clock-fill me-2"></i>
                    <span id="realtime-clock" class="fw-bold small">Memuat...</span>
                </div>

                <div class="collapse navbar-collapse order-lg-3" id="navbar">
                    <ul class="navbar-nav align-items-center ms-auto">
                        <li class="nav-item d-none d-lg-block">
                            <a href="/dashboard" class="nav-link"><button class="btn btn-primary btn-sm px-3 mb-0"><i class="bi bi-globe me-2"></i>Dashboard</button></a>
                        </li>
                        <div class="vr m-2 d-none d-lg-block"></div>
                        <li class="nav-item d-none d-md-block">
                            <a href="#fullscreen" class="nav-link" onclick="toggleFullScreen(event)">
                                <button class="btn btn-light d-flex align-items-center justify-content-center mb-0" style="width: 30px; height: 30px; padding: 0;">
                                    <i class="bi bi-fullscreen"></i>
                                </button>
                            </a>
                        </li>
                        <li class="nav-item d-none d-md-block">
                            <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#salesHistoryModal" title="Riwayat Penjualan">
                                <button class="btn btn-light d-flex align-items-center justify-content-center mb-0" style="width: 30px; height: 30px; padding: 0;">
                                    <i class="bi bi-clock-history"></i>
                                </button>
                            </a>
                        </li>
                    </ul>
                </div>
                @auth
                <div class="d-flex align-items-center order-lg-4 ms-lg-2">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link text-dark p-0 mb-2 mb-md-0" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (auth()->user()->img_user)
                                <img src="{{ asset('storage/' . auth()->user()->img_user) }}" alt="Profile" class="avatar avatar-sm rounded cursor-pointer">
                            @else
                                <i class="bi bi-person-circle cursor-pointer fs-5"></i>
                            @endif
                        </a>
                            <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="userDropdown">
                                <li class="text-start d-flex m-2">
                                    <img src="{{ asset('storage/' . auth()->user()->img_user) }}" alt="Profile" class="avatar avatar-sm rounded-circle cursor-pointer">
                                    <div class="ms-2">
                                        <p class="mb-0 text-xs fw-bolder">{{ auth()->user()->username }}</p>
                                        <p class="text-xs text-secondary">{{ auth()->user()->role->nama }}</p>
                                    </div>
                                </li>
                                <li class="d-md-none d-block">
                                    <hr class="horizontal dark mt-n2 mb-2">
                                    <a class="dropdown-item border-radius-md" href="#" data-bs-toggle="modal" data-bs-target="#salesHistoryModal">
                                        <i class="bi bi-clock-history me-2"></i> Riwayat Penjualan
                                    </a>
                                </li>
                                <li class="d-md-none d-block">
                                    <a class="dropdown-item border-radius-md" href="/dashboard">
                                        <i class="bi bi-globe me-2"></i> Dashboard
                                    </a>
                                </li>
                                <li>
                                    <hr class="horizontal dark mt-n2 mb-2 d-none d-md-block">
                                    <a class="dropdown-item border-radius-md" href="/">
                                        <i class="bi bi-shop me-2"></i> Web Market
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <button type="submit" class="dropdown-item border-radius-md w-100 text-danger" style="text-align: left;">
                                            <i class="bi bi-box-arrow-right me-2"></i>Log Out
                                        </button>
                                    </form>
                                </li>
                            </ul>
                    </div>
                </div>
                @endauth
            </div>
        </nav>
        <main class="main-content position-relative border-radius-lg d-flex flex-column min-vh-100">
            <div class="row m-0 m-md-3 d-md-flex d-block">
                <div class="col-md-8 col-12 border-end ">
                    <div class="row mt-3 mx-2">
                        <div class="col-md-8 col-12">
                            <h6 class="mb-0">Selamat Datang, {{ auth()->user()->username }}</h6>
                            <p class="text-sm">{{ now()->translatedFormat('l, d F Y') }}</p>
                        </div>
                        <div class="col-md-4 col-8 mt-2 mt-md-0">
                            <div class="ms-md-auto">
                                <input type="text" id="product-search" class="form-control " placeholder="Cari produk...">
                            </div>
                        </div>
                        <div class="col-12">
                            <div id="category-container" class="d-flex flex-nowrap gap-2 pb-2" style="overflow-x: auto;">
                                <div class="category-btn category-active border rounded-1 d-flex align-items-center ms-3 my-3 p-2" style="height: 40px; cursor: pointer;" data-category-id="all"><i class="bi bi-tags me-1"></i> <p class="fw-bolder text-xs ms-1 mb-0">Semua</p></div>
                                @foreach ($kategoris as $kategori)
                                <div class="category-btn border rounded-1 d-flex align-items-center my-3 p-2" style="height: 40px; cursor: pointer;" data-category-id="{{ $kategori->id }}">
                                    <img src="{{ $kategori->img_kategori ? asset('storage/' . $kategori->img_kategori) : asset('assets/img/produk.webp') }}" class="avatar avatar-xs rounded-1" alt="{{ $kategori->nama }}">
                                    <p class="fw-bolder text-xs ms-2 mb-0">{{ $kategori->nama }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="p-3 product-list-container mb-3" style="max-height: 85vh; overflow-y: auto;">
                        <div class="row" id="product-list">
                            @forelse ($produks as $produk)
                                <div class="col-12 col-md-4 col-xl-3 mb-3" data-product-category-id="{{ $produk->kategori_produk_id }}">
                                    <div class="card product-card h-100"
                                        data-id="{{ $produk->id }}"
                                        data-nama="{{ $produk->nama_produk }}"
                                        data-harga="{{ $produk->harga_jual }}"
                                        data-img="{{ $produk->img_produk ? asset('storage/' . $produk->img_produk) : asset('assets/img/produk.webp') }}"
                                        data-stok="{{ $produk->qty }}"
                                        data-disabled="{{ $produk->qty < 1 ? 'true' : 'false' }}">
                                        <img class="card-img-top " src="{{ $produk->img_produk ? asset('storage/' . $produk->img_produk) : asset('assets/img/produk.webp') }}" alt="Gambar Produk">
                                        <div class="card-body p-2">
                                            <div class="row g-1">
                                                <div class="col-12">
                                                    <p class="text-xs mb-1"><span class="font-weight-bold">{{ $produk->kategori_produk->nama }}</span></p>
                                                    <h6 class="mb-0 product-name text-sm">{{ $produk->nama_produk }}</h6>
                                                </div>
                                                <hr class="horizontal dark my-2">
                                                <div class="col-8">
                                                    <p class="font-weight-bold text-sm mb-0">{{ $produk->harga_formatted }}</p>
                                                </div>
                                                <div class="col-4 text-end">
                                                    <p class="text-xs mb-1">{{ $produk->qty }} {{ $produk->unit->singkat }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer p-2 pt-0 border-0">
                                            @if($produk->qty < 1)
                                                <p class="text-danger text-xs text-center fw-bold mb-0">Stok Habis</p>
                                            @endif
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
                <div class="col-md-4 col-12 ">
                    <form action="{{ route('penjualan.store') }}" method="POST" id="penjualanForm">
                        @csrf
                        <div class="card mt-3">
                            <div class="card-header pb-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Detail Pesanan</h6>
                                        <p class="text-sm mb-0">Invoice: <span class="font-weight-bold">{{ $referensi }}</span></p>
                                        <input type="hidden" name="nomer_invoice" value="{{ $referensi }}">
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-md badge-success me-2" id="cart-item-count">
                                            <i class="fas fa-shopping-cart me-1"></i> 0 Item
                                        </span>
                                        <button type="button" class="btn btn-outline-danger btn-tooltip btn-sm py-1 px-2 mb-0 btn-reset-cart" id="btn-reset-cart" data-bs-toggle="tooltip" data-bs-placement="bottom"  data-container="body" data-animation="true" title="Kosongkan Keranjang" disabled>
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
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
                                    <p class="text-sm mb-0">Ongkir</p>
                                    <div class="form-group mb-2" style="max-width: 120px;">
                                        <input type="number" name="ongkir" class="form-control form-control-sm text-end" value="0" min="0">
                                    </div>
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
        </main>
        {{-- create pelanggan --}}
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

        {{-- Modal Edit Item Keranjang --}}
        <div class="modal fade" id="editCartItemModal" tabindex="-1" aria-labelledby="editCartItemModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCartItemModalLabel">Edit Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editCartItemForm" onsubmit="return false;">
                            <input type="hidden" id="edit-item-id">
                            <div class="row g-3 px-1">
                                <div class="col-12">
                                    <label class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control" id="edit-item-nama" readonly disabled>
                                </div>
                                <div class="col-12 form-group">
                                    <label for="harga" class="form-control-label">Harga Jual <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp.</span>
                                        <input type="number" class="form-control" id="edit-item-harga" min="0">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="edit-item-diskon" class="form-label">Diskon (Rp)</label>
                                    <input type="number" class="form-control" id="edit-item-diskon" value="0" min="0">
                                </div>
                                <div class="col-6">
                                    <label for="edit-item-pajak-persen" class="form-label">Pajak (%)</label>
                                    <input type="number" class="form-control" id="edit-item-pajak-persen" value="0" min="0">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-info" id="saveItemChangesBtn">Simpan Perubahan</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Riwayat Penjualan --}}
        <div class="modal fade" id="salesHistoryModal" tabindex="-1" aria-labelledby="salesHistoryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="salesHistoryModalLabel">Riwayat Penjualan Hari Ini</h6>
                        <button type="button" class="btn btn-dark bg-dark btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="salesHistoryBody">
                        {{-- Konten akan dimuat di sini melalui AJAX --}}
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Fungsi untuk toggle fullscreen
            function toggleFullScreen(event) {
                event.preventDefault();
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen();
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    }
                }
            }
        </script>
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
                const allProductCards = document.querySelectorAll('.product-card'); // Ambil semua kartu produk
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
                const resetButton = document.getElementById('btn-reset-cart');
                const editItemModal = new bootstrap.Modal(document.getElementById('editCartItemModal'));
                const editItemForm = document.getElementById('editCartItemForm');

                // --- FUNCTIONS ---
                const updateCartAndTotals = () => {
                    renderCart();
                    calculateTotals();
                    toggleSaveButton();
                };

                const addToCart = (id, nama, harga, stok, img) => {
                    id = parseInt(id);
                    harga = parseFloat(harga);
                    stok = parseInt(stok);

                    if (cart.has(id)) {
                        const item = cart.get(id);
                        if (item.jumlah < item.stok) {
                            item.jumlah++;
                        } else {
                            alert(`Stok untuk ${nama} tidak mencukupi.`);
                        }
                    } else {
                        if (stok > 0) {
                            cart.set(id, {
                                id, nama, harga, stok, img,
                                jumlah: 1,
                                harga_jual: harga, // Harga jual yang bisa diedit
                                diskon: 0,
                                pajak_persen: 0,
                            });
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
                        document.querySelectorAll('.product-card.active').forEach(card => card.classList.remove('active'));
                        cartContainer.appendChild(cartEmptyMsg);
                        cartEmptyMsg.style.display = 'block';
                    } else {
                        if(cartEmptyMsg) cartEmptyMsg.style.display = 'none';
                        let formIndex = 0;
                        cart.forEach(item => {
                            const subtotalItem = (item.harga_jual * item.jumlah) - item.diskon;
                            const itemHtml = `
                                <div class="d-flex justify-content-between align-items-center px-0 py-2">
                                    <input type="hidden" name="items[${formIndex}][produk_id]" value="${item.id}">
                                    <input type="hidden" name="items[${formIndex}][jumlah]" value="${item.jumlah}">
                                    <input type="hidden" name="items[${formIndex}][harga_jual]" value="${item.harga_jual}">
                                    <input type="hidden" name="items[${formIndex}][diskon]" value="${item.diskon}">
                                    <input type="hidden" name="items[${formIndex}][pajak_persen]" value="${item.pajak_persen}">
                                    <div class="row w-100 g-1 px-2 mx-1 pb-1 border rounded-3 align-items-center">
                                        <div class="col-5 d-flex align-items-center">
                                            <img src="${item.img}" class="avatar rounded me-3" alt="product image">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0 text-xs">${item.nama}</h6>
                                                <p class="mb-0 text-xs">${formatCurrency(item.harga_jual)}</p>
                                            </div>
                                        </div>
                                        <div class="col-2 d-flex align-items-center justify-content-center">
                                            <button class="btn btn-outline-primary mt-3 btn-sm rounded-circle p-0 qty-decrease" data-id="${item.id}" type="button" style="width: 20px; height: 20px;">-</button>
                                            <span class="mx-2 fw-bold text-sm">${item.jumlah}</span>
                                            <button class="btn btn-outline-primary mt-3 btn-sm rounded-circle p-0 qty-increase" data-id="${item.id}" type="button" style="width: 20px; height: 20px;">+</button>
                                        </div>
                                        <div class="col-3 d-flex align-items-center justify-content-end">
                                            <p class="text-sm fw-bold mt-3">${formatCurrency(subtotalItem)}</p>
                                        </div>
                                        <div class="col-2 d-flex align-items-center justify-content-end">
                                            <button class="btn btn-link text-info mt-3 p-0 cart-action-btn edit-item" data-id="${item.id}" title="Edit Item" type="button">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button class="btn btn-link text-danger p-0 mt-3 ms-2 cart-action-btn remove-item" data-id="${item.id}" title="Hapus Item" type="button">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `;
                            cartContainer.insertAdjacentHTML('beforeend', itemHtml);
                            formIndex++;
                        });
                    }
                    const totalItems = Array.from(cart.values()).reduce((sum, item) => sum + item.jumlah, 0);
                    cartItemCount.innerHTML = `<i class="fas fa-shopping-cart me-1"></i> ${totalItems} Item`;

                    // Update status 'active' pada kartu produk
                    allProductCards.forEach(card => {
                        const cardId = parseInt(card.dataset.id);
                        if (cart.has(cardId)) card.classList.add('active');
                        else card.classList.remove('active');
                    });
                };

                const calculateTotals = () => {
                    let subtotal = 0;
                    let totalPajakItem = 0;
                    cart.forEach(item => {
                        const itemSubtotal = (item.harga_jual * item.jumlah) - item.diskon;
                        subtotal += itemSubtotal;
                        totalPajakItem += itemSubtotal * (item.pajak_persen / 100);
                    });

                    const diskon = parseFloat(diskonInput.value) || 0; // Diskon global
                    const pajakPercent = parseFloat(pajakInput.value) || 0; // Pajak global

                    const subtotalAfterDiskon = subtotal - diskon;
                    const pajakAmount = subtotalAfterDiskon * (pajakPercent / 100);
                    const total = subtotalAfterDiskon + pajakAmount;

                    subtotalEl.textContent = formatCurrency(subtotal);
                    totalAkhirEl.textContent = formatCurrency(total);
                };

                let selectedCategoryId = 'all'; // State untuk menyimpan kategori yang aktif

                const filterProducts = () => {
                    const searchTerm = productSearchInput.value.toLowerCase();

                    allProductCards.forEach(card => {
                        const wrapper = card.parentElement; // The .col-* div
                        const productName = card.dataset.nama.toLowerCase();
                        const productCategoryId = wrapper.dataset.productCategoryId; // FIX: Ambil ID kategori dari wrapper

                        const categoryMatch = (selectedCategoryId === 'all' || selectedCategoryId == productCategoryId);
                        const searchMatch = productName.includes(searchTerm);

                        // Logika yang disederhanakan: langsung tampilkan atau sembunyikan
                        if (categoryMatch && searchMatch) {
                            wrapper.style.display = ''; // Menghapus style inline akan mengembalikannya ke default (block)
                        } else {
                            wrapper.style.display = 'none';
                        }
                    });
                };

                const toggleSaveButton = () => {
                    saveButton.disabled = cart.size === 0;
                    resetButton.disabled = cart.size === 0;
                };

                // --- EVENT LISTENERS ---
                productList.addEventListener('click', (e) => {
                    const card = e.target.closest('.product-card');
                    if (card) {
                        const { id, nama, harga, stok, disabled, img } = card.dataset;
                        if (disabled === 'true') {
                            return; // Jangan lakukan apa-apa jika stok habis
                        }
                        addToCart(id, nama, harga, stok, img);
                    }
                });

                cartContainer.addEventListener('click', (e) => {
                    const id = parseInt(e.target.closest('[data-id]')?.dataset.id);
                    if (!id) return;

                    const button = e.target.closest('button');
                    if (!button) return;
                    if (e.target.classList.contains('qty-increase')) {
                        const item = cart.get(id);
                        updateQuantity(id, item.jumlah + 1);
                    } else if (e.target.classList.contains('qty-decrease')) {
                        const item = cart.get(id);
                        updateQuantity(id, item.jumlah - 1);
                    } else if (e.target.closest('.remove-item')) {
                        removeFromCart(id);
                    } else if (e.target.closest('.edit-item')) {
                        openEditModal(id);
                    }
                });

                diskonInput.addEventListener('input', calculateTotals);
                pajakInput.addEventListener('input', calculateTotals);

                if (resetButton) {
                    resetButton.addEventListener('click', () => {
                        if (cart.size > 0 && confirm('Anda yakin ingin mengosongkan keranjang?')) {
                            cart.clear();
                            updateCartAndTotals();
                        }
                    });
                }
                productSearchInput.addEventListener('keyup', filterProducts);

                mainForm.addEventListener('submit', (e) => {
                    if (cart.size === 0) {
                        e.preventDefault();
                        alert('Keranjang belanja kosong. Silakan tambahkan produk terlebih dahulu.');
                    }
                });

                // --- INITIALIZATION ---
                updateCartAndTotals();

                // --- EDIT ITEM MODAL LOGIC ---
                function openEditModal(id) {
                    const item = cart.get(id);
                    if (!item) return;

                    document.getElementById('edit-item-id').value = id;
                    document.getElementById('edit-item-nama').value = item.nama;
                    document.getElementById('edit-item-harga').value = item.harga_jual;
                    document.getElementById('edit-item-diskon').value = item.diskon;
                    document.getElementById('edit-item-pajak-persen').value = item.pajak_persen;

                    editItemModal.show();
                }

                document.getElementById('saveItemChangesBtn').addEventListener('click', () => {
                    const id = parseInt(document.getElementById('edit-item-id').value);
                    const item = cart.get(id);
                    if (!item) return;

                    item.harga_jual = parseFloat(document.getElementById('edit-item-harga').value) || item.harga;
                    item.diskon = parseFloat(document.getElementById('edit-item-diskon').value) || 0;
                    item.pajak_persen = parseFloat(document.getElementById('edit-item-pajak-persen').value) || 0;

                    updateCartAndTotals();
                    editItemModal.hide();
                });




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

                // --- CATEGORY FILTER HIGHLIGHT ---
                const categoryFilterContainer = document.getElementById('category-container');
                if (categoryFilterContainer) {
                    categoryFilterContainer.addEventListener('click', function(e) {
                        const clickedButton = e.target.closest('.category-btn');

                        // Keluar jika yang diklik bukan tombol kategori atau jika tombol yang diklik sudah aktif
                        if (!clickedButton || clickedButton.classList.contains('category-active')) {
                            return;
                        }

                        // 1. Cari tombol yang aktif saat ini dan hapus kelasnya
                        const currentActive = categoryFilterContainer.querySelector('.category-active');
                        if (currentActive) {
                            currentActive.classList.remove('category-active');
                        }

                        // 2. Tambahkan kelas 'category-active' ke tombol yang baru saja diklik
                        clickedButton.classList.add('category-active');

                        // 3. Update state kategori yang dipilih dan panggil fungsi filter
                        selectedCategoryId = clickedButton.dataset.categoryId;
                        filterProducts(); // Panggil filter setiap kali kategori diubah
                    });
                }

                // --- MODAL RIWAYAT PENJUALAN ---
                const salesHistoryModal = document.getElementById('salesHistoryModal');
                if (salesHistoryModal) {
                    salesHistoryModal.addEventListener('show.bs.modal', async function () {
                        const modalBody = document.getElementById('salesHistoryBody');
                        // Tampilkan spinner saat memuat
                        modalBody.innerHTML = `
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>`;

                        try {
                            // Ganti 'penjualan.history.today' dengan nama route Anda yang sebenarnya
                            const response = await fetch("{{ route('penjualan.history.today') }}", {
                                headers: {
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            });

                            if (!response.ok) {
                                throw new Error('Gagal memuat data riwayat penjualan.');
                            }

                            const sales = await response.json();

                            if (sales.length === 0) {
                                modalBody.innerHTML = `
                                    <div class="text-center py-5 text-muted">
                                        <i class="bi bi-cart-x fa-3x mb-3"></i>
                                        <p class="mb-0">Belum ada transaksi hari ini.</p>
                                    </div>`;
                                return;
                            }

                            let historyHtml = '<div class="list-group list-group-flush">';
                            sales.forEach(sale => {
                                historyHtml += `
                                    <a href="/penjualan/${sale.id}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0 text-sm">${sale.nomer_invoice}</h6>
                                            <p class="text-xs text-secondary mb-0">${sale.pelanggan_nama} &bull; ${sale.waktu}</p>
                                        </div>
                                        <div class="text-end">
                                            <span class="text-sm fw-bold text-success">${formatCurrency(sale.total_akhir)}</span>
                                            <p class="badge badge-sm bg-gradient-info mb-0">${sale.status}</p>
                                        </div>
                                    </a>`;
                            });
                            historyHtml += '</div>';
                            modalBody.innerHTML = historyHtml;
                        } catch (error) {
                            modalBody.innerHTML = `<div class="alert alert-danger text-white">${error.message}</div>`;
                        }
                    });
                }
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const clockElement = document.getElementById('realtime-clock');

                function updateClock() {
                    if (clockElement) {
                        const now = new Date();
                        const options = {
                            timeZone: 'Asia/Jakarta', // Zona Waktu Indonesia Barat
                            // weekday: 'long',
                            // day: 'numeric',
                            // month: 'long',
                            // year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit',
                            hour12: false
                        };
                        clockElement.textContent = new Intl.DateTimeFormat('id-ID', options).format(now).replace(/\./g, ':');
                    }
                }
                setInterval(updateClock, 1000); // Update setiap detik
                updateClock(); // Panggil sekali saat halaman dimuat
            });
        </script>
    </body>
</html>
