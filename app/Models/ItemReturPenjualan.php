<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemReturPenjualan extends Model
{
    use HasFactory;

    protected $table = 'item_retur_penjualans';

    protected $guarded = ['id'];

    /**
     * Relasi ke data master retur.
     */
    public function returPenjualan(): BelongsTo
    {
        return $this->belongsTo(ReturPenjualan::class);
    }

    /**
     * Relasi ke item penjualan asal.
     */
    public function itemPenjualan(): BelongsTo
    {
        return $this->belongsTo(ItemPenjualan::class);
    }

    /**
     * Relasi ke produk yang diretur.
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }
}
