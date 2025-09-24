<x-layout>
    @section('breadcrumb')
        @php
        $breadcrumbItems = [
            ['name' => 'Dashboard', 'url' => '/dashboard'],
            ['name' => 'Inventaris', 'url' => '#'],
            ['name' => 'Riwayat Penyesuaian', 'url' => route('stok-penyesuaian.index')],
        ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid p-3">
        <div class="card rounded-2">
            <div class="card-header pb-0 px-3 pt-2 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-2 ">
                        <h6 class="mb-n1">Riwayat Penyesuaian Stok</h6>
                        <p class="text-sm mb-0">Daftar semua penyesuaian stok yang pernah dibuat.</p>
                    </div>
                    <div class="ms-md-auto mt-2">
                        <a href="{{ route('stok-penyesuaian.create') }}" class="btn btn-outline-info mb-0 d-flex">
                            <i class="bi bi-plus-lg"></i>
                            <span class="d-none d-md-block ms-2"> Penyesuaian</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="filter-container p-3">
                    <form action="{{ route('stok-penyesuaian.index') }}" method="GET">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label for="search" class="form-label">Pencarian</label>
                                <input type="text" id="search" name="search" class="form-control" placeholder="Cari kode atau user..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="start_date" class="form-label">Tanggal Mulai</label>
                                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="end_date" class="form-label">Tanggal Akhir</label>
                                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-2 d-flex mb-n3">
                                <button type="submit" class="btn btn-dark me-2 w-100">Filter</button>
                                <a href="{{ route('stok-penyesuaian.index') }}" class="btn btn-secondary w-100">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive p-0">
                    <table class="table table-hover align-items-center mb-0">
                        <thead class="table-secondary">
                            <tr>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-4">Kode Penyesuaian</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Tanggal</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">User</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Catatan</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penyesuaians as $penyesuaian)
                            <tr>
                                <td class="ps-4"><p class="text-sm font-weight-bold mb-0">{{ $penyesuaian->kode_penyesuaian }}</p></td>
                                <td><p class="text-sm mb-0">{{ $penyesuaian->tanggal_penyesuaian->translatedFormat('d M Y, H:i') }}</p></td>
                                <td><p class="text-sm mb-0">{{ $penyesuaian->user->username ?? 'N/A' }}</p></td>
                                <td><p class="text-sm mb-0 text-truncate" style="max-width: 250px;">{{ $penyesuaian->catatan ?: '-' }}</p></td>
                                <td class="text-center">
                                    <a href="{{ route('stok-penyesuaian.show', $penyesuaian) }}" class="btn btn-link text-dark px-3 mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                                        <i class="bi bi-eye-fill" aria-hidden="true"></i>
                                    </a>
                                    <button type="button" class="btn btn-link text-danger px-3 mb-0" data-bs-toggle="modal" data-bs-target="#cancelConfirmationModal" data-kode-penyesuaian="{{ $penyesuaian->kode_penyesuaian }}">
                                        <i class="bi bi-trash-fill" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <p class="text-sm fw-bold mb-0">Tidak ada riwayat penyesuaian stok ditemukan.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center my-4">
                    {{ $penyesuaians->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Pembatalan --}}
    <div class="modal fade" id="cancelConfirmationModal" tabindex="-1" aria-labelledby="cancelConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center mt-3 mx-n5">
                    <i class="bi bi-exclamation-triangle-fill fa-3x text-warning mb-3"></i>
                    <h5 class="mb-2">Batalkan Penyesuaian?</h5>
                    <p class="mb-0">Anda yakin ingin membatalkan penyesuaian <strong id="kodePenyesuaianToCancel"></strong>?</p>
                    <small class="text-danger">Tindakan ini akan mengembalikan stok produk ke keadaan semula dan tidak dapat diurungkan.</small>
                    <div class="mt-4">
                        <form id="cancelForm" method="POST" action="#">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                            <button type="button" class="btn btn-outline-secondary ms-2" data-bs-dismiss="modal">Tutup</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cancelModal = document.getElementById('cancelConfirmationModal');
            if (cancelModal) {
                cancelModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const kodePenyesuaian = button.getAttribute('data-kode-penyesuaian');
                    const form = cancelModal.querySelector('#cancelForm');
                    const text = cancelModal.querySelector('#kodePenyesuaianToCancel');

                    if (text) text.textContent = kodePenyesuaian;
                    if (form) form.action = `{{ url('stok-penyesuaian') }}/${kodePenyesuaian}`;
                });
            }
        });
    </script>
    @endpush
</x-layout>
