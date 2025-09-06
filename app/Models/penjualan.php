<?php

namespace App\Models;

use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penjualan extends Model
{
    protected $guarded = ['id'];
    protected $with = ['pelanggan', 'user','items'];

    // protected function hargaFormatted(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn () => 'Rp. ' . number_format($this->attributes['harga'], 2, ',', '.')
    //     );
    // }

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function items()
    {
        return $this->hasMany(ItemPenjualan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
