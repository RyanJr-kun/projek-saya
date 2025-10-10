<?php

namespace App\Models;

use App\Models\User;
use App\Models\Pemasok;
use App\Models\PembelianDetail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pembelian extends Model
{
    protected $guarded = ['id'];
    public function getRouteKeyName() { return 'referensi'; }
    
    public function pemasok(): BelongsTo { return $this->belongsTo(Pemasok::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function details(): HasMany { return $this->hasMany(PembelianDetail::class); }
}
