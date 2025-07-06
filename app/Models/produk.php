<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class produk extends model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['kategori_produk', 'user'];

    public function kategori_produk(): BelongsTo
    {
        return $this->belongsTo(KategoriProduk::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
