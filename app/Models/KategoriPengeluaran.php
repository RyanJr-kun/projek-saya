<?php

namespace App\Models;

use App\Models\Pengeluaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;

class KategoriPengeluaran extends Model
{
    use HasFactory, Sluggable;
    protected $guarded = ['id'];

    public function pengeluarans(): HasMany
    {
      return $this->hasMany(Pengeluaran::class);
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
