<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pajak extends Model
{
    protected $guarded = ['id'];

    public function produk(): HasMany
    {
      return $this->hasMany(Produk::class);
    }

}
