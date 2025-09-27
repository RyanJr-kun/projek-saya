<x-layout>
    @section('breadcrumb')
        @php
            $breadcrumbItems = [
                ['name' => 'Penjualan', 'url' => route('penjualan.index')],
                ['name' => 'Daftar Retur', 'url' => route('retur-penjualan.index')],
                ['name' => 'Buat Retur Baru', 'url' => route('retur-penjualan.create')],
            ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid p-3">
        {{-- Card 1: Pencarian Invoice --}}
        <div class="card rounded-2 mb-4">
            <div class="card-header pb-0 px-3 pt-2">
                <h6 class="mb-0">Cari Invoice Penjualan</h6>
                <p class="text-sm mb-0">Masukkan nomor referensi invoice yang akan diretur.</p>
            </div>
            <div class="card-body pt-2">
                <form action="{{ route('retur-penjualan.create') }}" method="GET">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" name="referensi" class="form-control" placeholder="Contoh: INV-20230101-0001" value="{{ request('referensi') }}" required>
                                <button class="btn btn-outline-info mb-0" type="submit">Cari</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if ($penjualan)
            {{-- Card 2: Form Retur --}}
            <div class="card rounded-2">
                <div class="card-header pb-0 px-3 pt-2">
                    <h6 class="mb-0">Form Retur untuk Invoice: <span class="text-info">{{ $penjualan->referensi }}</span></h6>
                    <p class="text-sm mb-0">Pelanggan: {{ $penjualan->pelanggan->nama ?? 'Pelanggan Umum' }}</p>
                </div>
                <div class="card-body pt-2">
                    <form action="{{ route('retur-penjualan.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="penjualan_id" value="{{ $penjualan->id }}">

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="tanggal_retur" class="form-label">Tanggal Retur</label>
                                <input type="date" class="form-control" id="tanggal_retur" name="tanggal_retur" value="{{ now()->toDateString() }}" required>
                            </div>
                        </div>

                        <h6 class="mt-3">Pilih Item yang Akan Diretur</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered align-items-center">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 5%;"><input type="checkbox" id="check-all-items"></th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Produk</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Harga Satuan</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Jumlah Beli</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Jumlah Retur</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Nomor Seri (jika ada)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualan->items as $index => $item)
                                        <tr class="item-row" data-wajib-seri="{{ $item->produk->wajib_seri ? 'true' : 'false' }}">
                                            <td class="text-center">
                                                <input type="checkbox" class="form-check-input item-checkbox" name="items[{{ $index }}][item_penjualan_id]" value="{{ $item->id }}">
                                                <input type="hidden" name="items[{{ $index }}][produk_id]" value="{{ $item->produk_id }}">
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $item->produk->nama_produk }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ 'Rp ' . number_format($item->harga_jual, 0, ',', '.') }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $item->jumlah }}</p>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm jumlah-retur" name="items[{{ $index }}][jumlah_retur]" min="1" max="{{ $item->jumlah }}" value="1" disabled>
                                            </td>
                                            <td>
                                                @if ($item->produk->wajib_seri)
                                                    <div class="serial-number-selection">
                                                        @foreach ($item->serialNumbers as $sn)
                                                            <div class="form-check">
                                                                <input class="form-check-input sn-checkbox" type="checkbox" name="items[{{ $index }}][serial_numbers][]" value="{{ $sn->nomor_seri }}" id="sn_{{ $sn->id }}" disabled>
                                                                <label class="form-check-label" for="sn_{{ $sn->id }}">{{ $sn->nomor_seri }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="text-xs text-muted mb-0">-</p>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="catatan" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="3" placeholder="Alasan retur atau keterangan lainnya..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-info">Proses Retur</button>
                    </form>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkAll = document.getElementById('check-all-items');
                const itemRows = document.querySelectorAll('.item-row');

                // Fungsi untuk mengaktifkan/menonaktifkan input pada baris
                function toggleRowInputs(row, isEnabled) {
                    row.querySelector('.jumlah-retur').disabled = !isEnabled;
                    row.querySelectorAll('.sn-checkbox').forEach(sn => sn.disabled = !isEnabled);
                }

                // Event untuk checkbox per item
                itemRows.forEach(row => {
                    const checkbox = row.querySelector('.item-checkbox');
                    checkbox.addEventListener('change', function() {
                        toggleRowInputs(row, this.checked);
                    });
                });

                // Event untuk checkbox "Check All"
                if (checkAll) {
                    checkAll.addEventListener('change', function() {
                        itemRows.forEach(row => {
                            const checkbox = row.querySelector('.item-checkbox');
                            checkbox.checked = this.checked;
                            toggleRowInputs(row, this.checked);
                        });
                    });
                }

                // Validasi jumlah retur vs jumlah SN yang dipilih
                document.querySelector('form').addEventListener('submit', function(e) {
                    let isValid = true;
                    itemRows.forEach(row => {
                        const itemCheckbox = row.querySelector('.item-checkbox');
                        if (!itemCheckbox.checked) return; // Lewati jika item tidak dipilih

                        const isWajibSeri = row.dataset.wajibSeri === 'true';
                        if (isWajibSeri) {
                            const jumlahRetur = parseInt(row.querySelector('.jumlah-retur').value);
                            const snCheckedCount = row.querySelectorAll('.sn-checkbox:checked').length;

                            if (jumlahRetur !== snCheckedCount) {
                                alert('Jumlah retur harus sama dengan jumlah nomor seri yang dipilih untuk produk: ' + row.querySelector('td:nth-child(2) p').textContent.trim());
                                e.preventDefault();
                                isValid = false;
                            }
                        }
                    });
                    return isValid;
                });
            });
        </script>
    @endpush
</x-layout>
