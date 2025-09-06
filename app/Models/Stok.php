<?php

namespace App\Models;

use App\Models\KategoriProduk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stok extends Model
{
    protected $guarded = ['id'];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriProduk::class);
    }

    
}
