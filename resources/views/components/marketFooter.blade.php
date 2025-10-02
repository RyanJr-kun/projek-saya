<footer class="footer-market bg-dark text-white pt-5 pb-4">
    <div class="container text-md-left">
        <div class="row text-md-left">

            {{-- Kolom 1: Tentang Toko --}}
            <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mt-3">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('assets/img/logomiring_putih.svg') }}" alt="Logo Jo Computer Putih" style="height: 80px;">
                </a>
                <p class="mt-3" style="font-size: 0.9rem;">
                    Toko komponen dan aksesoris komputer terpercaya. Kami menyediakan produk berkualitas dengan harga terbaik untuk kebutuhan perakitan dan upgrade PC Anda.
                </p>
                <p class="small"><i class="bi bi-geo-alt-fill me-2"></i>Jl. Contoh No. 123, Kota Anda</p>
                <p class="small"><i class="bi bi-envelope-fill me-2"></i>kontak@jocomputer.com</p>
                <p class="small"><i class="bi bi-telephone-fill me-2"></i>(021) 123-4567</p>
            </div>

            {{-- Kolom 2: Tautan Cepat --}}
            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                <h6 class="text-uppercase mb-4 font-weight-bold text-info">Tautan Cepat</h6>
                <p><a href="{{ url('/') }}" class="footer-link">Beranda</a></p>
                <p><a href="{{ route('market.produk') }}" class="footer-link">Produk</a></p>
                <p><a href="#" class="footer-link">Promo</a></p>
                <p><a href="#" class="footer-link">Tentang Kami</a></p>
                <p><a href="#" class="footer-link">Kontak</a></p>
            </div>

            {{-- Kolom 3: Kategori --}}
            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                <h6 class="text-uppercase mb-4 font-weight-bold text-info">Kategori</h6>
                <p><a href="#" class="footer-link">Laptop</a></p>
                <p><a href="#" class="footer-link">PC Rakitan</a></p>
                <p><a href="#" class="footer-link">Komponen</a></p>
                <p><a href="#" class="footer-link">Aksesoris</a></p>
            </div>

            {{-- Kolom 4: Media Sosial & Newsletter --}}
            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                <h6 class="text-uppercase mb-4 font-weight-bold text-info">Ikuti Kami</h6>
                <div class="d-flex mb-4">
                    <a href="#" class="social-icon me-3"><i class="bi bi-facebook bi-lg"></i></a>
                    <a href="#" class="social-icon me-3"><i class="bi bi-instagram bi-lg"></i></a>
                    <a href="#" class="social-icon me-3"><i class="bi bi-youtube bi-lg"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-tiktok bi-lg"></i></a>
                </div>
                <h6 class="text-uppercase mb-3 font-weight-bold text-info">Newsletter</h6>
                <p class="small">Dapatkan info promo dan produk terbaru dari kami.</p>
                <form action="#">
                    <div class="d-flex align-items-center">
                        <div class="input-group">
                            <input type="email" class="form-control form-control-sm" placeholder="Email Anda" aria-label="Email Anda">
                        </div>
                        <button class="btn btn-info btn-sm ms-2 mt-3" type="button">Daftar</button>
                    </div>
                </form>
            </div>
        </div>

        <hr class="mb-4 mt-2 opacity-50">

        <div class="row align-items-center justify-content-center">
            <div class="col-12">
                <p class="text-center mb-3 mb-md-0 small">
                    © {{ date('Y') }} Copyright
                    <a href="{{ url('/') }}" class="text-info fw-bold text-decoration-none">JO Computer</a>.
                    All Rights Reserved.
                </p>
            </div>
        </div>
    </div>
</footer>
