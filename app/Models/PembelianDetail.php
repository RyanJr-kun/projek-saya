<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembelianDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];
    public function pembelian(): BelongsTo { return $this->belongsTo(Pembelian::class); }
    public function produk(): BelongsTo { return $this->belongsTo(Produk::class); }
    public function pajak(): BelongsTo { return $this->belongsTo(Pajak::class); }
}
