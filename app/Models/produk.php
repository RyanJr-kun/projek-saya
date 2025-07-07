<?php

namespace App\Models;

use App\Models\Unit;
use App\Models\User;
use App\Models\Brand;
use App\Models\Garansi;
use App\Models\KategoriProduk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class produk extends model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['kategori_produk', 'user', 'brand', 'unit', 'garansi'];
    // 'brand', 'units', 'garansi', ''

    protected function hargaFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp. ' . number_format($this->attributes['harga'], 2, ',', '.')
        );
    }


    public function kategori_produk(): BelongsTo
    {
        return $this->belongsTo(KategoriProduk::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function garansi(): BelongsTo
    {
        return $this->belongsTo(Garansi::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

}
