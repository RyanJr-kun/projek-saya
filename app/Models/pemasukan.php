<?php

namespace App\Models;

use App\Models\User;
use App\Models\KategoriPemasukan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemasukan extends Model
{
    protected $guarded = ['id'];
    protected $with = ['kategori_pemasukan', 'user'];

    protected function hargaFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp. ' . number_format($this->attributes['jumlah'], 2, ',', '.')
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kategori_pemasukan(): BelongsTo
    {
        return $this->belongsTo(KategoriPemasukan::class);
    }
}
