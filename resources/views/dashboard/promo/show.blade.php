<x-layout>
    @section('breadcrumb')
        @php
            $breadcrumbItems = [
                ['name' => 'Page', 'url' => '#'],
                ['name' => 'Manajemen Promo & Diskon', 'url' => route('promo.index')],
                ['name' => 'Detail Promo', 'url' => '#'],
            ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid p-3">
        <div class="card rounded-2">
            <div class="card-header pb-0 px-3 pt-2 mb-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Detail Promo: {{ $promo->nama_promo }}</h6>
                <a href="{{ route('promo.index') }}" class="btn btn-sm btn-outline-secondary mb-0">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-sm mb-1"><strong>Nama Promo:</strong> {{ $promo->nama_promo }}</p>
                        <p class="text-sm mb-1"><strong>Kode Promo:</strong> {{ $promo->kode_promo ?? '-' }}</p>
                        <p class="text-sm mb-1"><strong>Tipe Diskon:</strong>
                            @if ($promo->tipe_diskon == 'percentage')
                                Persentase
                            @else
                                Jumlah Tetap
                            @endif
                        </p>
                        <p class="text-sm mb-1"><strong>Nilai Diskon:</strong>
                            @if ($promo->tipe_diskon == 'percentage')
                                {{ $promo->nilai_diskon }}%
                            @else
                                @money($promo->nilai_diskon)
                            @endif
                        </p>
                        <p class="text-sm mb-1"><strong>Minimum Pembelian:</strong> @money($promo->min_pembelian)</p>
                        <p class="text-sm mb-1"><strong>Maksimal Diskon:</strong>
                            @if ($promo->max_diskon)
                                @money($promo->max_diskon)
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-sm mb-1"><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($promo->tanggal_mulai)->translatedFormat('d F Y, H:i') }}</p>
                        <p class="text-sm mb-1"><strong>Tanggal Berakhir:</strong> {{ \Carbon\Carbon::parse($promo->tanggal_berakhir)->translatedFormat('d F Y, H:i') }}</p>
                        <p class="text-sm mb-1"><strong>Status:</strong>
                            @if ($promo->status)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">Tidak Aktif</span>
                            @endif
                        </p>
                        <p class="text-sm mb-1"><strong>Dibuat Oleh:</strong> {{ $promo->user->nama ?? 'User Dihapus' }}</p>
                        <p class="text-sm mb-1"><strong>Tanggal Dibuat:</strong> {{ \Carbon\Carbon::parse($promo->created_at)->translatedFormat('d F Y, H:i') }}</p>
                        <p class="text-sm mb-1"><strong>Terakhir Diperbarui:</strong> {{ \Carbon\Carbon::parse($promo->updated_at)->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <p class="text-sm mb-1"><strong>Deskripsi:</strong></p>
                        <div class="p-3 border rounded text-sm">
                            {!! $promo->deskripsi ?? 'Tidak ada deskripsi.' !!}
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('promo.edit', $promo->id) }}" class="btn btn-info me-2">
                        <i class="bi bi-pencil-square me-1"></i> Edit Promo
                    </a>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" data-promo-id="{{ $promo->id }}" data-promo-name="{{ $promo->nama_promo }}">
                        <i class="bi bi-trash me-1"></i> Hapus Promo
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-layout>
