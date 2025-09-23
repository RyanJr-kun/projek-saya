<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriTransaksi extends Model
{
    use Sluggable;
    protected $guarded = ['id'];
    public function pemasukans(): HasMany { return $this->hasMany(Pemasukan::class); }
    public function pengeluarans(): HasMany { return $this->hasMany(Pengeluaran::class); }
    public function getRouteKeyName(): string { return 'slug'; }
    public function sluggable(): array { return ['slug' => [ 'source' => 'nama' ] ]; }
}
