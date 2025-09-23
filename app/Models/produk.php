<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Produk extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    protected $guarded = ['id'];
    protected $with = ['kategori_produk', 'user', 'brand', 'unit', 'garansi'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama_produk'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Accessor untuk format harga
    protected function hargaFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp ' . number_format($this->harga_jual, 0, ',', '.'),
        );
    }

    public function kategori_produk(): BelongsTo { return $this->belongsTo(KategoriProduk::class); }
    public function brand() : BelongsTo { return $this->belongsTo(Brand::class); }
    public function unit() : BelongsTo { return $this->belongsTo(Unit::class); }
    public function garansi() : BelongsTo { return $this->belongsTo(Garansi::class); }
    public function pajak() : BelongsTo { return $this->belongsTo(Pajak::class); }
    public function user() : BelongsTo { return $this->belongsTo(User::class); }
    public function itemPenjualans() : HasMany { return $this->hasMany(ItemPenjualan::class); }
    public function pembelianDetails() : HasMany { return $this->hasMany(PembelianDetail::class); }
    public function serialNumbers(): HasMany { return $this->hasMany(SerialNumber::class); }

    public function latestPurchaseDetail() { return $this->hasOne(\App\Models\PembelianDetail::class)->latestOfMany(); }
}
