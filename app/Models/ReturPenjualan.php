<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReturPenjualan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_retur' => 'date',
    ];

    /**
     * Relasi ke detail item yang diretur.
     */
    public function items(): HasMany
    {
        return $this->hasMany(ItemReturPenjualan::class);
    }

    /**
     * Relasi ke invoice penjualan asal.
     */
    public function penjualan(): BelongsTo
    {
        return $this->belongsTo(Penjualan::class);
    }

    /**
     * Relasi ke user yang membuat retur.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
