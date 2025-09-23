<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SerialNumber extends Model
{
    protected $guarded = ['id'];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }

    public function penjualan(): BelongsTo
    {
        return $this->belongsTo(Penjualan::class);
    }
}
