<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pajak extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function produk(): HasMany
    {
      return $this->hasMany(Produk::class);
    }

}
