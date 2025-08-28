<?php

namespace App\Models;

use App\Models\User;
use App\Models\KategoriPengeluaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengeluaran extends Model
{
    protected $guarded = ['id'];
    protected $with = ['kategori_pengeluaran', 'user'];

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

    public function kategori_pengeluaran(): BelongsTo
    {
        return $this->belongsTo(KategoriPengeluaran::class);
    }
}
