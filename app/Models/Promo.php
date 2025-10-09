<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_berakhir' => 'datetime',
        'status' => 'boolean',
    ];

    public function produks()
    {
        return $this->belongsToMany(Produk::class, 'promo_produk');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk menampilkan status dalam format yang lebih mudah dibaca
    public function getStatusTextAttribute()
    {
        return $this->status ? 'Aktif' : 'Tidak Aktif';
    }
}
