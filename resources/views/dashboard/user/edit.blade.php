<x-layout>
    <x-slot:title>Edit User: {{ $user->nama }}</x-slot:title>

    @section('breadcrumb')
        @php
        $breadcrumbItems = [
            ['name' => 'Dashboard', 'url' => '/dashboard'],
            ['name' => 'Manajemen User', 'url' => route('users.index')],
            ['name' => 'Edit User', 'url' => '#'],
        ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="card m-4">
        <div class="card-body p-4">
            <form method="post" action="{{ route('users.update', $user->username) }}" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="row">
                    <div class="col-12 col-md-4 mb-md-0">
                        <div class="d-flex flex-column justify-content-center align-items-center h-100">
                            {{-- KOTAK PRATINJAU GAMBAR --}}
                            <div id="imagePreviewBox" class="border rounded p-2 d-flex justify-content-center align-items-center position-relative" style="height: 300px; width: 300px; border-style: dashed !important; border-width: 2px !important;">
                                @if ($user->img_user)
                                    <img src="{{ asset('storage/' . $user->img_user) }}" alt="User Image" style="width: 100%; height: 100%; object-fit: cover; border-radius: 0.5rem;">
                                @else
                                    <div class="text-center text-muted">
                                        <i class="bi bi-cloud-arrow-up-fill fs-1"></i>
                                        <p class="mb-0 small mt-2">Pratinjau Gambar</p>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-3 text-center">
                                <label for="img_user" class="btn btn-outline-primary">Pilih Gambar</label>
                                <input type="file" id="img_user" name="img_user" class="d-none @error('img_user') is-invalid @enderror" accept="image/jpeg, image/png, image/jpg">
                                <p class="mt-1 text-sm">JPEG, PNG, JPG maks 2MB</p>
                                @error('img_user')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-8">
                         <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Nama Lengkap" value="{{ old('nama', $user->nama) }}" required>
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Username" value="{{ old('username', $user->username) }}" required>
                                @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="example@gmail.com" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="kontak" class="form-label">Kontak</label>
                                <input type="tel" class="form-control @error('kontak') is-invalid @enderror" value="{{ old('kontak', $user->kontak) }}" id="kontak" name="kontak" placeholder="08...">
                                @error('kontak')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="role_id" class="form-label">Posisi <span class="text-danger">*</span></label>
                                <select class="form-select @error('role_id') is-invalid @enderror" id="role_id" name="role_id" required>
                                    <option value="" disabled selected>Pilih Role...</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id', $user->role->id) == $role->id ? 'selected' : '' }}>{{ $role->nama }}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="mulai_kerja" class="form-label">Mulai Bekerja</label>
                                <input id="mulai_kerja" name="mulai_kerja" class="form-control @error('mulai_kerja') is-invalid @enderror" value="{{ old('mulai_kerja', $user->mulai_kerja ? $user->mulai_kerja->format('Y-m-d') : '') }}" placeholder="Pilih tanggal" type="date">
                                @error('mulai_kerja')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label for="password">Password</label>
                                <input name="password" id="password" class="form-control @error('password') is-invalid @enderror" type="password" placeholder="Kosongkan jika tidak ingin diubah">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="justify-content-end form-check form-switch form-check-reverse">
                                    <label class="me-auto form-check-label" for="status_toggle">Status Aktif</label>
                                    <input type="hidden" name="status" value="0">
                                    <input id="status_toggle" class="form-check-input" type="checkbox" name="status" value="1" {{ old('status', $user->status) == 1 ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end pt-3 mt-3">
                    <button type="submit" class="btn btn-outline-success btn-sm">Perbarui User</button>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-danger btn-sm ms-3">Batal</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const uploadInput = document.getElementById('img_user');
                const previewBox = document.getElementById('imagePreviewBox');

                // Pastikan elemen ditemukan sebelum menambahkan event listener
                if (uploadInput && previewBox) {
                    uploadInput.addEventListener('change', function(event) {
                        // Ambil file yang dipilih oleh pengguna
                        const file = event.target.files[0];

                        // Jika ada file yang dipilih
                        if (file) {
                            // Buat objek FileReader untuk membaca file
                            const reader = new FileReader();

                            // Tentukan apa yang harus dilakukan setelah file selesai dibaca
                            reader.onload = function(e) {
                                // Ganti isi kotak pratinjau dengan gambar baru
                                previewBox.innerHTML =
                                    `<img src="${e.target.result}" alt="Pratinjau Gambar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 0.5rem;">`;
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                }
            });
        </script>
    @endpush
</x-layout>
