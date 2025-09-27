{{-- resources/views/dashboard/promo/_form.blade.php --}}
@props(['promo' => null])

<div class="row g-3">
    <div class="col-md-6">
        <label for="nama_promo" class="form-label">Nama Promo <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('nama_promo') is-invalid @enderror" id="nama_promo" name="nama_promo" value="{{ old('nama_promo', $promo->nama_promo ?? '') }}" required>
        @error('nama_promo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="kode_promo" class="form-label">Kode Promo (Opsional)</label>
        <input type="text" class="form-control @error('kode_promo') is-invalid @enderror" id="kode_promo" name="kode_promo" value="{{ old('kode_promo', $promo->kode_promo ?? '') }}">
        @error('kode_promo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="tipe_diskon" class="form-label">Tipe Diskon <span class="text-danger">*</span></label>
        <select class="form-select @error('tipe_diskon') is-invalid @enderror" id="tipe_diskon" name="tipe_diskon" required>
            <option value="percentage" @selected(old('tipe_diskon', $promo->tipe_diskon ?? '') == 'percentage')>Persentase (%)</option>
            <option value="fixed" @selected(old('tipe_diskon', $promo->tipe_diskon ?? '') == 'fixed')>Jumlah Tetap (Rp)</option>
        </select>
        @error('tipe_diskon')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="nilai_diskon" class="form-label">Nilai Diskon <span class="text-danger">*</span></label>
        <input type="number" step="0.01" class="form-control @error('nilai_diskon') is-invalid @enderror" id="nilai_diskon" name="nilai_diskon" value="{{ old('nilai_diskon', $promo->nilai_diskon ?? '') }}" required min="0">
        @error('nilai_diskon')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="min_pembelian" class="form-label">Minimum Pembelian (Rp)</label>
        <input type="number" step="0.01" class="form-control @error('min_pembelian') is-invalid @enderror" id="min_pembelian" name="min_pembelian" value="{{ old('min_pembelian', $promo->min_pembelian ?? 0) }}" min="0">
        @error('min_pembelian')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="max_diskon" class="form-label">Maksimal Diskon (Rp) - untuk persentase</label>
        <input type="number" step="0.01" class="form-control @error('max_diskon') is-invalid @enderror" id="max_diskon" name="max_diskon" value="{{ old('max_diskon', $promo->max_diskon ?? '') }}" min="0">
        @error('max_diskon')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
        <input type="datetime-local" class="form-control @error('tanggal_mulai') is-invalid @enderror" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', ($promo->tanggal_mulai ?? now())->format('Y-m-d\TH:i')) }}" required>
        @error('tanggal_mulai')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir <span class="text-danger">*</span></label>
        <input type="datetime-local" class="form-control @error('tanggal_berakhir') is-invalid @enderror" id="tanggal_berakhir" name="tanggal_berakhir" value="{{ old('tanggal_berakhir', ($promo->tanggal_berakhir ?? now()->addMonth())->format('Y-m-d\TH:i')) }}" required>
        @error('tanggal_berakhir')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-12">
        <label for="deskripsi" class="form-label">Deskripsi (Opsional)</label>
        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $promo->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-12 form-check form-switch form-check-reverse mt-3">
        <label class="form-check-label" for="status">Status Aktif</label>
        <input class="form-check-input" type="checkbox" id="status" name="status" value="1" @checked(old('status', $promo->status ?? true))>
    </div>
</div>
