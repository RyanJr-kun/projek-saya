<div class="table-responsive p-0 mt-3">
    <table class="table table-hover align-items-center mb-0">
        <thead>
            <tr class="table-secondary">
                <th class="text-uppercase text-dark text-xs fw-bolder">Pelanggan</th>
                <th class="text-uppercase text-dark text-xs fw-bolder ps-2">Invoice</th>
                <th class="text-uppercase text-dark text-xs fw-bolder ps-2">Tanggal</th>
                <th class="text-uppercase text-dark text-xs fw-bolder ps-2">Total</th>
                <th class="text-uppercase text-dark text-xs fw-bolder text-center">Status</th>
                <th class="text-uppercase text-dark text-xs fw-bolder">Pembuat</th>
                <th class="text-dark"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penjualan as $item)
                <tr>
                    <td>
                        <div class="d-flex flex-column justify-content-center ms-3">
                            <h6 class="mb-0 text-sm">{{ $item->pelanggan->nama ?? 'Pelanggan Umum' }}</h6>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{ $item->referensi }}</h6>
                        </div>
                    </td>
                    <td>
                        <p class="text-sm fw-bolder mb-0">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</p>
                    </td>
                    <td class="align-middle">
                        <span class="text-secondary text-sm fw-bolder">{{ $item->total }}</span>
                    </td>
                    <td class="align-middle text-center text-sm">
                        @php
                            $statusClass = '';
                            if ($item->status_pembayaran === 'Lunas') $statusClass = 'badge-success';
                            elseif ($item->status_pembayaran === 'Belum Lunas') $statusClass = 'badge-danger';
                            elseif ($item->status_pembayaran === 'Dibatalkan') $statusClass = 'badge-warning';
                        @endphp
                        <span class="badge badge-sm {{ $statusClass }}">{{ str_replace('_', ' ', $item->status_pembayaran) }}</span>
                    </td>
                    <td>
                        <div title="foto & nama user" class="d-flex align-items-center px-2 py-1">
                            @if ($item->user->img_user)
                                <img src="{{ asset('storage/' . $item->user->img_user) }}" class="avatar avatar-sm me-3" alt="user_img">
                            @else
                                <img src="{{ asset('assets/img/user.webp') }}" class="avatar avatar-sm me-3" alt="Gambar User default">
                            @endif
                            <h6 class="mb-0 text-sm">{{ $item->user->nama }}</h6>
                        </div>
                    </td>
                    <td class="align-middle text-center">
                        <a href="{{ route('penjualan.show', $item->referensi) }}" class="text-dark fw-bold text-sm px-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                            <i class="fa fa-eye "></i>
                        </a>
                        <a href="{{ route('penjualan.edit', $item->referensi) }}" class="text-dark fw-bold text-sm px-2"data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Transaksi">
                            <i class="fa fa-pen-to-square"></i>
                        </a>
                        <a href="#" class="text-dark fw-bold text-sm px-2" data-bs-toggle="modal" data-bs-target="#cancelConfirmationModal" data-invoice-number="{{ $item->referensi }}" title="Batalkan Transaksi">
                            <i class="fa fa-ban"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-3">
                        <p class=" text-dark text-sm fw-bold mb-0">Belum ada data penjualan.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3 px-3">
    {{ $penjualan->links() }}
</div>
