<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PergerakanInventaris extends Model
{
    protected $table = 'pergerakan_inventaris';

    protected $fillable = [
        'produk_id',
        'referensi_id',
        'referensi_type',
        'tipe_gerakan',
        'jumlah_masuk',
        'jumlah_keluar',
        'keterangan',
        'tanggal',
    ];

    /**
     * Mendapatkan model induk dari referensi (polymorphic).
     */
    public function referensiSource(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'referensi_type', 'referensi_id');
    }

    /**
     * Accessor untuk mendapatkan nama route berdasarkan tipe gerakan.
     */
    protected function routeName(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->tipe_gerakan) {
                'Pembelian' => 'pembelian.show',
                'Penjualan' => 'penjualan.show',
                'Stok Opname' => 'stok-opname.show',
                'Penyesuaian' => 'stok-penyesuaian.show',
                default => null,
            },
        );
    }

    /**
     * Accessor untuk mendapatkan teks referensi yang akan ditampilkan.
     */
    protected function referensi(): Attribute
    {
        return Attribute::make(
            get: function () {
                $source = $this->referensiSource;
                if (!$source) return $this->keterangan ?: '-';

                return $source->referensi ?? $source->id;
            }
        );
    }
}
