<?php

namespace App\Models;

use App\Models\User;
use App\Models\Pemasok;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembelian extends Model
{
    protected $guarded = ['id'];
    
    public function pemasoks(): BelongsTo
    {
        return $this->belongsTo(Pemasok::class);
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
