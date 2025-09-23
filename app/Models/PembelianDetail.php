<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembelianDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    //  protected function harga_beli(): Attribute
    // {
    //     return Attribute::make( get: fn () => 'Rp. ' . number_format($this->attributes['harga_beli'], 2, ',', '.'));
    // }
    // protected function subtotal(): Attribute
    // {
    //     return Attribute::make( get: fn () => 'Rp. ' . number_format($this->attributes['subtotal'], 2, ',', '.'));
    // }
    // protected function diskon(): Attribute
    // {
    //     return Attribute::make( get: fn () => 'Rp. ' . number_format($this->attributes['diskon'], 2, ',', '.'));
    // }
    public function pembelian(): BelongsTo { return $this->belongsTo(Pembelian::class); }
    public function produk(): BelongsTo { return $this->belongsTo(Produk::class); }
}
