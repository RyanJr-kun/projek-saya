<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Produk extends Model
{
    use HasFactory, Sluggable;

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

    public function promos() { return $this->belongsToMany(Promo::class, 'promo_produk'); }
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

    public function getActivePromoAttribute()
    {
        // Cari promo spesifik untuk produk ini terlebih dahulu
        $promo = $this->promos()
            ->where('status', true)
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_berakhir', '>=', now())
            ->first();

        // Jika tidak ada promo spesifik, cari promo global (yang tidak terikat produk manapun)
        if (!$promo) {
            $promo = Promo::where('status', true)
                ->where('tanggal_mulai', '<=', now())
                ->where('tanggal_berakhir', '>=', now())
                ->whereDoesntHave('produks') // Promo yang tidak punya relasi produk
                ->first();
        }

        return $promo;
    }
    
    public function getHargaDiskonAttribute()
    {
        if (!$this->active_promo) {
            return null;
        }

        $promo = $this->active_promo;
        $hargaAsli = $this->harga_jual;

        if ($promo->tipe_diskon == 'percentage') {
            $diskon = ($hargaAsli * $promo->nilai_diskon) / 100;
            if ($promo->max_diskon && $diskon > $promo->max_diskon) {
                $diskon = $promo->max_diskon;
            }
            return $hargaAsli - $diskon;
        } elseif ($promo->tipe_diskon == 'fixed') {
            return $hargaAsli - $promo->nilai_diskon;
        }

        return null;
    }
}
