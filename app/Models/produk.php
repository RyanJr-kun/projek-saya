<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class produk extends model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function kategori_produk(): BelongsTo
    {
        return $this->belongsTo(kategori_produk::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
