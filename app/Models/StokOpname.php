<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokOpname extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    protected $casts = [
        'tanggal_opname' => 'datetime', // Ini akan mengubah string tanggal menjadi objek Carbon
    ];


    /**
     * Mendapatkan semua detail untuk StokOpname.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(StokOpnameDetail::class);
    }

    /**
     * Mendapatkan user yang melakukan StokOpname.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
