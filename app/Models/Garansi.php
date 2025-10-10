<?php

namespace App\Models;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Cviebrock\EloquentSluggable\Sluggable;

class Garansi extends Model
{
    use Sluggable;
    protected $guarded = ['id'];

    public function produks(): HasMany
    {
      return $this->hasMany(Produk::class);
    }

    public function getFormattedDurationAttribute(): string
    {
        $totalMonths = $this->durasi;

        if (!$totalMonths || $totalMonths <= 0) {
            return 'N/A';
        }

        // Hitung jumlah tahun dengan pembulatan ke bawah
        $years = floor($totalMonths / 12);

        // Hitung sisa bulan menggunakan operator modulo
        $months = $totalMonths % 12;

        $parts = [];
        // Jika ada tahun, tambahkan ke array
        if ($years > 0) {
            $parts[] = $years . ' Tahun';
        }
        // Jika ada sisa bulan, tambahkan ke array
        if ($months > 0) {
            $parts[] = $months . ' Bulan';
        }

        // Gabungkan bagian-bagian tersebut dengan spasi
        return implode(' ', $parts);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama'
            ]
        ];
    }
}
