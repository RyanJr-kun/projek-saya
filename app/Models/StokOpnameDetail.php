<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokOpnameDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Mendapatkan data master stok opname.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stokOpname()
    {
        return $this->belongsTo(StokOpname::class);
    }

    /**
     * Mendapatkan data produk terkait.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
