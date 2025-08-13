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
use Cviebrock\EloquentSluggable\Sluggable;

class Produk extends model
{
    use Sluggable;
    protected $guarded = ['id'];
    protected $with = ['kategori_produk', 'user', 'brand', 'unit', 'garansi'];

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

    /**
    * Get the route key for the model.
    *
    * @return string
    */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
     public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama_produk'
            ]
        ];
    }

}
