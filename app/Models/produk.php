<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    public function kategori_produk() { return $this->belongsTo(KategoriProduk::class); }
    public function brand() { return $this->belongsTo(Brand::class); }
    public function unit() { return $this->belongsTo(Unit::class); }
    public function garansi() { return $this->belongsTo(Garansi::class); }
    public function pajak() { return $this->belongsTo(Pajak::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function itemPenjualans() { return $this->hasMany(ItemPenjualan::class); }
    public function pembelianDetails() { return $this->hasMany(PembelianDetail::class); }
}
