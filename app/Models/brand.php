<?php

namespace App\Models;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function produk(): HasMany
    {
      return $this->hasMany(Produk::class);
    }
}
