<x-marketLayout>
    @push('styles')
    <style>
        /* Styling untuk rating bintang */
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            font-size: 2rem;
        }
        .star-rating input {
            display: none;
        }
        .star-rating label {
            color: #ccc;
            cursor: pointer;
            transition: color 0.2s;
        }
        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #ffc107;
        }
    </style>
    @endpush

    {{-- Page Header --}}
    <div class="bg-light">
        <div class="container pt-2 pb-0">
            <div class="text-start">
                <h4 class="fw-bolder ps-3 mb-n1">Tentang &nbsp;{{ $profils->nama_toko ?? 'JO Computer' }}</h4>
                <nav aria-label="breadcrumb p-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Tentang Kami</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <!-- Section: Detail Layanan -->
        <section class="mb-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="{{ $profils->img_profil ? asset('storage/' . $profils->img_profil) : 'https://via.placeholder.com/600x400/CCCCCC/FFFFFF?text=Profil+Toko' }}" class="img-fluid rounded-3 shadow-sm" alt="Profil Toko">
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-3">Layanan Terbaik Untuk Kebutuhan Anda</h2>
                    <p class="text-muted">
                        {!! $profils->deskripsi ?? 'Selamat datang di toko kami. Kami berkomitmen untuk menyediakan produk dan layanan terbaik bagi pelanggan kami. Dengan pengalaman bertahun-tahun di industri ini, kami bangga dapat menawarkan berbagai macam produk berkualitas tinggi dengan harga yang kompetitif.' !!}
                    </p>
                    <div class="row mt-4 g-3">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0"><i class="bi bi-patch-check-fill text-info fs-4"></i></div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="fw-bold mb-1">Kualitas Terjamin</h5>
                                    <p class="text-muted mb-0">Produk original dengan garansi resmi.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0"><i class="bi bi-headset text-info fs-4"></i></div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="fw-bold mb-1">Dukungan Pelanggan</h5>
                                    <p class="text-muted mb-0">Tim kami siap membantu Anda kapan saja.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <hr class="my-5">

        <!-- Section: Kontak & Peta -->
        <section class="mb-5">
            <h2 class="text-center fw-bold mb-5">Hubungi Kami & Lokasi</h2>
            <div class="row g-4">
                <div class="col-lg-5">
                    <h4 class="fw-bold mb-3">Informasi Kontak</h4>
                    <p><i class="bi bi-geo-alt-fill me-3 text-info"></i>{{ $profils->alamat ?? 'Alamat belum diatur.' }}</p>
                    <p><i class="bi bi-telephone-fill me-3 text-info"></i>{{ $profils->telepon ?? 'Telepon belum diatur.' }}</p>
                    <p><i class="bi bi-envelope-fill me-3 text-info"></i>{{ $profils->email ?? 'Email belum diatur.' }}</p>
                    <p><i class="bi bi-whatsapp me-3 text-success"></i><a href="https://wa.me/6281318000699" target="_blank" class="text-decoration-none text-dark">0813-1800-0699 (Layanan Pelanggan)</a></p>
                </div>
                <div class="col-lg-7">
                    <div class="ratio ratio-16x9 rounded-3 shadow-sm">
                        {{-- Ganti URL src dengan embed map dari Google Maps --}}
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.52126032222!2d106.8195973147689!3d-6.194420395514597!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5390917b759%3A0x6b45e6735624064b!2sMonumen%20Nasional!5e0!3m2!1sid!2sid!4v1623746334561!5m2!1sid!2sid" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </section>

        <hr class="my-5">

        <!-- Section: Form Penilaian -->
        <section>
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <h2 class="text-center fw-bold mb-4">Berikan Kami Penilaian</h2>
                    <form action="#" method="POST"> {{-- Ganti action dengan route yang sesuai --}}
                        @csrf
                        <div class="star-rating mb-3">
                            <input type="radio" id="5-stars" name="rating" value="5" /><label for="5-stars" class="bi bi-star-fill"></label>
                            <input type="radio" id="4-stars" name="rating" value="4" /><label for="4-stars" class="bi bi-star-fill"></label>
                            <input type="radio" id="3-stars" name="rating" value="3" /><label for="3-stars" class="bi bi-star-fill"></label>
                            <input type="radio" id="2-stars" name="rating" value="2" /><label for="2-stars" class="bi bi-star-fill"></label>
                            <input type="radio" id="1-star" name="rating" value="1" /><label for="1-star" class="bi bi-star-fill"></label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Tinggalkan komentar di sini" id="komentar" name="komentar" style="height: 120px" required></textarea>
                            <label for="komentar">Komentar atau Masukan Anda</label>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-info btn-lg" type="submit">Kirim Penilaian</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

</x-marketLayout>
