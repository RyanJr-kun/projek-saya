{{-- resources/views/dashboard/penjualan/_pelanggan_table.blade.php --}}
<div class="table-responsive p-0">
    <table class="table table-hover align-items-center justify-content-start mb-0" id="tableData">
        <thead>
            <tr class="table-secondary">
                <th class="text-uppercase text-dark text-xs font-weight-bolder">Nama</th>
                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Kontak</th>
                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Email</th>
                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Alamat</th>
                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder">Status</th>
                <th class="text-dark"></th>
            </tr>
        </thead>
        <tbody id="isiTable">
            @forelse ($pelanggans as $pelanggan)
            <tr id="pelanggan-row-{{ $pelanggan->id }}">
                <td>
                    <p title="Nama Pelanggan" class="ms-3 text-xs text-dark fw-bold mb-0">{{ $pelanggan->nama }}</p>
                </td>
                <td>
                    <p title="Kontak" class="text-xs text-dark fw-bold mb-0">{{ $pelanggan->kontak }}</p>
                </td>
                <td>
                    <p title="Email" class="text-xs text-dark fw-bold mb-0" >{{ $pelanggan->email }}</p>
                </td>
                <td>
                    <p title="Alamat" class="text-xs text-dark fw-bold mb-0">{!! wordwrap($pelanggan->alamat, 50, "<br>\n", true) !!}</p>
                </td>

                <td class="align-middle text-center text-sm">
                    @if ($pelanggan->status)
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-secondary">Tidak Aktif</span>
                    @endif
                </td>

                <td class="text-center align-middle">
                    @if ($pelanggan->id != 1)
                        <a href="#" class="text-dark fw-bold px-3 text-xs"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal"
                            data-url="{{ route('pelanggan.getjson', $pelanggan->id) }}"
                            data-update-url="{{ route('pelanggan.update', $pelanggan->id) }}"
                            title="Edit Pelanggan">
                            <i class="bi bi-pencil-square text-dark text-sm opacity-10"></i>
                        </a>
                        <a href="#" class="text-dark delete-btn me-md-4"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteConfirmationModal"
                            data-pelanggan-id="{{ $pelanggan->id }}"
                            data-pelanggan-name="{{ $pelanggan->nama }}"
                            title="Hapus Pelanggan">
                            <i class="bi bi-trash"></i>
                        </a>
                    @endif
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Data pelanggan tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3 px-3">
        {{ $pelanggans->links() }}
    </div>
</div>
