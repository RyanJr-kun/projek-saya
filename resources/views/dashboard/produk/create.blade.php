<x-layout>
    @section('breadcrumb')
        @php
        // Definisikan item breadcrumb dalam bentuk array
        $breadcrumbItems = [
            ['name' => 'Page', 'url' => '/dashboard'],
            ['name' => 'Manajemen Produk', 'url' => route('Produk.index')],
            ['name' => 'Buat Produk Baru', 'url' => '#'],
        ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="card m-4">
        <div class="card-body p-4">
            <form action="{{ route('produk.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    {{-- KOLOM KIRI: Upload Gambar --}}
                    <div class="col-12 col-md-4 mb-4 mb-md-0">
                        <div class="d-flex flex-column justify-content-center align-items-center h-100">
                            <div id="imagePreviewBox" class="border rounded p-2 d-flex justify-content-center align-items-center position-relative" style="height: 180px; width: 180px; border-style: dashed !important; border-width: 2px !important;">
                                <div class="text-center text-muted">
                                    <i class="bi bi-cloud-arrow-up-fill fs-1"></i>
                                    <p class="mb-0 small mt-2">Pratinjau Gambar</p>
                                </div>
                            </div>
                            <div class="mt-3 text-center">
                                <label for="img" class="btn btn-outline-primary">Pilih Gambar</label>
                                <input type="file" id="img" name="img_user" class="d-none" accept="image/jpeg, image/png">
                                <p class="text-muted mt-2 ps-2 small">JPEG, PNG maks 2MB</p>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: Form Isian --}}
                    <div class="col-12 col-md-8">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Nama Lengkap" value="{{ old('nama') }}" required>
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Username" value="{{ old('username') }}" required>
                                @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="example@gmail.com" value="{{ old('email') }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="kontak" class="form-label">Kontak</label>
                                <input type="tel" class="form-control @error('kontak') is-invalid @enderror" value="{{ old('kontak') }}" id="kontak" name="kontak" placeholder="08...">
                                @error('kontak')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="role_id" class="form-label">Posisi <span class="text-danger">*</span></label>
                                <select class="form-select @error('role_id') is-invalid @enderror" id="role_id" name="role_id" required>
                                    <option value="" disabled selected>Pilih Role...</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->nama }}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="mulai_kerja" class="form-label">Mulai Bekerja</label>
                                <input id="mulai_kerja" name="mulai_kerja" class="form-control @error('mulai_kerja') is-invalid @enderror" value="{{ old('mulai_kerja') }}" placeholder="Pilih tanggal" type="date">
                                @error('mulai_kerja')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <input name="password" id="password" class="form-control @error('password') is-invalid @enderror" type="password" placeholder="*****" required>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="justify-content-end form-check form-switch form-check-reverse">
                                    <label class="me-auto form-check-label" for="status_toggle">Status</label>
                                    <input id="status_toggle" class="form-check-input" type="checkbox" name="status" value="1" checked>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-end pt-4 mt-4 border-top">
                    <button type="submit" class="btn btn-outline-success btn-sm">Buat User</button>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-danger btn-sm ms-3">Batalkan</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Script untuk pratinjau gambar
            const uploadInput = document.getElementById('img');
            const previewBox = document.getElementById('imagePreviewBox');

            if (uploadInput) {
                uploadInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.width = '100%';
                            img.style.height = '100%';
                            img.style.objectFit = 'cover';
                            img.style.borderRadius = '0.5rem';
                            previewBox.innerHTML = '';
                            previewBox.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Script untuk Toast (jika ada)
            var toastElement = document.getElementById('successToast');
            if (toastElement) {
                var toast = new bootstrap.Toast(toastElement);
                toast.show();
            }

            // Script untuk scrollbar (khusus Windows)
            var isWindows = navigator.platform.indexOf('Win') > -1;
            if (isWindows && document.querySelector('#sidenav-scrollbar')) {
                var options = { damping: '0.5' };
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        });
    </script>
    @endpush
</x-layout>
