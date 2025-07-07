<?php

namespace App\Models;

use App\Models\User;
use App\Models\Pemasok;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembelian extends Model
{
    public function pemasok(): BelongsTo
    {
        return $this->belongsTo(Pemasok::class);
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
