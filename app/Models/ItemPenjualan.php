<?php

namespace App\Models;

use App\Models\Produk;
use App\Models\Penjualan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemPenjualan extends Model
{
    protected $guarded = ['id'];

    /**
     * Relasi "belongsTo": Item ini milik satu Penjualan (faktur).
     */
    public function penjualan(): BelongsTo
    {
        return $this->belongsTo(Penjualan::class);
    }

    /**
     * Relasi "belongsTo": Item ini mengacu pada satu Produk.
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }

}
