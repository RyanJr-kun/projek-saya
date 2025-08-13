<?php

namespace App\Models;

use App\Models\Pemasukan;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriPemasukan extends Model
{
    use HasFactory, Sluggable;
    protected $guarded = ['id'];

    public function pemasukans(): HasMany
    {
      return $this->hasMany(Pemasukan::class);
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
