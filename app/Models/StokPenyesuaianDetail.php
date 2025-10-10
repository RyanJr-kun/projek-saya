<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class StokPenyesuaianDetail extends Model
{
    /**
     * Nama tabel di database, sesuai dengan file migrasi.
     */
    protected $table = 'stok_penyesuaian_details';

    protected $guarded = ['id'];

    /**
     * Relasi ke data master penyesuaian stok.
     */
    public function stokPenyesuaian(): BelongsTo
    {
        return $this->belongsTo(StokPenyesuaian::class);
    }

    /**
     * Relasi ke produk yang disesuaikan.
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }

    /**
     * Accessor untuk memformat tipe penyesuaian dengan badge HTML.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function tipeFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->tipe === 'IN'
                ? '<span class="badge badge-sm badge-success">Masuk</span>'
                : '<span class="badge badge-sm badge-danger">Keluar</span>',
        );
    }

    /**
     * Accessor untuk memformat jumlah dengan tanda + atau - dan warna.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function jumlahFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->tipe === 'IN'
                ? '<span class="text-success fw-bold">+' . $this->jumlah . '</span>'
                : '<span class="text-danger fw-bold">-' . $this->jumlah . '</span>',
        );
    }
}
