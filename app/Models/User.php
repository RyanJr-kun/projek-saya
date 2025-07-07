<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use App\Models\Produk;
use App\Models\Pemasukan;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Pengeluaran;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = ['id'];
    protected $with =['role'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function produk(): HasMany
    {
      return $this->hasMany(Produk::class);
    }

    public function penjualan(): HasMany
    {
      return $this->hasMany(Penjualan::class);
    }

    public function pembelian(): HasMany
    {
      return $this->hasMany(Pembelian::class);
    }

    public function Pemasukan(): HasMany
    {
      return $this->hasMany(Pemasukan::class);
    }

    public function pengeluaran(): HasMany
    {
      return $this->hasMany(Pengeluaran::class);
    }

    public function role(): BelongsTo
    {
      return $this->belongsTo(Role::class);
    }
}
