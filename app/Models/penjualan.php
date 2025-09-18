<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penjualan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'subtotal' => 'float',
        'diskon' => 'float',
        'pajak' => 'float',
        'total_akhir' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected function total(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp. ' . number_format($this->attributes['total_akhir'], 2, ',', '.')
        );
    }

    public function getRouteKeyName()
    {
        return 'referensi';
    }

    /**
     * Get all of the items for the Penjualan
     */
    public function items(): HasMany
    {
        return $this->hasMany(ItemPenjualan::class);
    }

    /**
     * Get the user that owns the Penjualan
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the pelanggan that owns the Penjualan
     */
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class)->withDefault([
            'nama' => 'Pelanggan Umum',
        ]);
    }
}
