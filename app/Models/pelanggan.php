<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class pelanggan extends Model
{
    public function penjualan(): HasMany
    {
        return $this->hasMany(Penjualan::class);
    }
}
