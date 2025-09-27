<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_promo',
        'kode_promo',
        'tipe_diskon',
        'nilai_diskon',
        'min_pembelian',
        'max_diskon',
        'tanggal_mulai',
        'tanggal_berakhir',
        'status',
        'deskripsi',
        'user_id',
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_berakhir' => 'datetime',
        'status' => 'boolean',
    ];

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
