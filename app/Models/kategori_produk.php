<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\produk;
use Illuminate\Database\Eloquent\Relations\HasMany;

class kategori_produk extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function produk(): HasMany
    {
      return $this->hasMany(Produk::class);
    }


}
